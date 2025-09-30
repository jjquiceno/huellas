<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login.php'; // empleado

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Método no permitido');

  $empleado_id = (int)($_SESSION['identificacion'] ?? 0);
  if (!$empleado_id) throw new Exception('No autorizado');

  $employee_coupon_id = (int)($_POST['employee_coupon_id'] ?? 0);
  $coupon_id = (int)($_POST['coupon_id'] ?? 0);
  if (!$employee_coupon_id || !$coupon_id) throw new Exception('Datos insuficientes');

  // Validar que la asignación existe y pertenece al empleado
  $stmt = $conexion->prepare("SELECT ec.id, ec.status, ec.expires_at, c.active, c.start_at, c.end_at
                               FROM employee_coupons ec
                               JOIN coupons c ON c.id = ec.coupon_id
                               WHERE ec.id = ? AND ec.coupon_id = ? AND ec.empleado_id = ?");
  $stmt->bind_param('iii', $employee_coupon_id, $coupon_id, $empleado_id);
  $stmt->execute();
  $row = $stmt->get_result()->fetch_assoc();
  if (!$row) throw new Exception('Cupón no asignado al empleado');
  if ($row['status'] === 'redimido') throw new Exception('El cupón ya fue redimido');

  $now = date('Y-m-d');
  if (!(int)$row['active']) throw new Exception('Cupón inactivo');
  if (!empty($row['start_at']) && $now < $row['start_at']) throw new Exception('Cupón aún no vigente');
  if (!empty($row['end_at']) && $now > $row['end_at']) throw new Exception('Cupón vencido');
  if (!empty($row['expires_at']) && $now > $row['expires_at']) throw new Exception('Asignación vencida');

  // Crear tabla si no existe (idempotente)
  $conexion->query("CREATE TABLE IF NOT EXISTS redemption_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_coupon_id INT NOT NULL,
    coupon_id INT NOT NULL,
    empleado_id INT NOT NULL,
    jefe_id INT NULL,
    status ENUM('pendiente','aprobada','rechazada') NOT NULL DEFAULT 'pendiente',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_at DATETIME NULL,
    processed_by INT NULL,
    note TEXT NULL,
    INDEX idx_status (status),
    INDEX idx_empleado (empleado_id),
    INDEX idx_jefe (jefe_id),
    CONSTRAINT fk_rr_emp_coupon FOREIGN KEY (employee_coupon_id) REFERENCES employee_coupons(id) ON DELETE CASCADE,
    CONSTRAINT fk_rr_coupon FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  // Verificar si ya hay una solicitud pendiente para esta asignación
  $chk = $conexion->prepare("SELECT id FROM redemption_requests WHERE employee_coupon_id = ? AND status = 'pendiente' LIMIT 1");
  $chk->bind_param('i', $employee_coupon_id);
  $chk->execute();
  $has = $chk->get_result()->fetch_assoc();
  if ($has) throw new Exception('Ya existe una solicitud pendiente para este cupón');

  // Obtener jefe asociado al cupón (creador del cupón)
  $getJefe = $conexion->prepare("SELECT created_by FROM coupons WHERE id = ?");
  $getJefe->bind_param('i', $coupon_id);
  $getJefe->execute();
  $jefeRow = $getJefe->get_result()->fetch_assoc();
  $jefe_asignado = $jefeRow ? (int)$jefeRow['created_by'] : null;

  // Insertar solicitud con jefe asignado (si se conoce)
  if ($jefe_asignado) {
    $ins = $conexion->prepare("INSERT INTO redemption_requests (employee_coupon_id, coupon_id, empleado_id, jefe_id) VALUES (?, ?, ?, ?)");
    $ins->bind_param('iiii', $employee_coupon_id, $coupon_id, $empleado_id, $jefe_asignado);
  } else {
    $ins = $conexion->prepare("INSERT INTO redemption_requests (employee_coupon_id, coupon_id, empleado_id) VALUES (?, ?, ?)");
    $ins->bind_param('iii', $employee_coupon_id, $coupon_id, $empleado_id);
  }
  if (!$ins->execute()) throw new Exception('No se pudo crear la solicitud');

  echo json_encode(['success' => true, 'request_id' => $ins->insert_id]);
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

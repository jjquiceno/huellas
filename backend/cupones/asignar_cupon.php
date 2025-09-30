<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login_jefe.php';

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Método no permitido');

  $coupon_id = (int)($_POST['coupon_id'] ?? 0);
  $empleado_id = (int)($_POST['empleado_id'] ?? 0);
  $expires_at = $_POST['expires_at'] ?? null;

  if (!$coupon_id || !$empleado_id) throw new Exception('Datos insuficientes');

  $stmt = $conexion->prepare("INSERT INTO employee_coupons (coupon_id, empleado_id, expires_at, status) VALUES (?, ?, ?, 'asignado')
    ON DUPLICATE KEY UPDATE expires_at = VALUES(expires_at)");
  $stmt->bind_param("iis", $coupon_id, $empleado_id, $expires_at);

  if (!$stmt->execute()) throw new Exception('Error al asignar cupón');

  // Crear notificación al empleado (no interrumpe si falla)
  // Crear tabla si no existe
  $conexion->query("CREATE TABLE IF NOT EXISTS employee_notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empleado_id INT NOT NULL,
    type VARCHAR(64) NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NULL,
    link VARCHAR(128) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at DATETIME NULL,
    INDEX idx_emp (empleado_id),
    INDEX idx_read (read_at)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

  // Obtener datos del cupón para el mensaje
  if ($cdata = $conexion->prepare("SELECT title, description FROM coupons WHERE id = ?")) {
    $cdata->bind_param('i', $coupon_id);
    if ($cdata->execute()) {
      $cd = $cdata->get_result()->fetch_assoc();
      $cTitle = $cd['title'] ?? ('Cupón #' . $coupon_id);
      $cDesc  = $cd['description'] ?? null;

      if ($insN = $conexion->prepare("INSERT INTO employee_notifications (empleado_id, type, title, body, link) VALUES (?, 'cupon_asignado', ?, ?, 'cuponera')")) {
        $titleMsg = 'Se te asignó un cupón: ' . $cTitle;
        $insN->bind_param('iss', $empleado_id, $titleMsg, $cDesc);
        $insN->execute(); // ignorar errores
      }
    }
  }

  echo json_encode(['success' => true]);
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
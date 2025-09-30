<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login.php'; // empleado

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Método no permitido');

  $empleado_id = (int)($_SESSION['identificacion'] ?? 0);
  if (!$empleado_id) throw new Exception('No autorizado');

  // Crear tabla si no existe (idempotente)
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

  // Si vienen ids específicos, marcarlas, si no, marcar todas del usuario
  $ids = isset($_POST['ids']) ? $_POST['ids'] : null;
  if ($ids) {
    if (is_string($ids)) {
      // CSV a array
      $ids = array_filter(array_map('intval', explode(',', $ids)));
    } else if (is_array($ids)) {
      $ids = array_map('intval', $ids);
    } else {
      $ids = [];
    }
  }

  if ($ids && count($ids) > 0) {
    // Construir placeholders
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids) + 1); // ids + empleado_id
    $params = $ids;
    $params[] = $empleado_id;

    $sql = "UPDATE employee_notifications SET read_at = NOW() WHERE id IN ($placeholders) AND empleado_id = ?";
    $stmt = $conexion->prepare($sql);

    // bind_param dinámico
    $bind_names = [];
    $bind_names[] = $types;
    foreach ($params as $key => $value) {
      $bind_name = 'bind' . $key;
      $$bind_name = $value;
      $bind_names[] = &$$bind_name;
    }
    call_user_func_array([$stmt, 'bind_param'], $bind_names);
    $stmt->execute();
  } else {
    $stmt = $conexion->prepare("UPDATE employee_notifications SET read_at = NOW() WHERE empleado_id = ? AND read_at IS NULL");
    $stmt->bind_param('i', $empleado_id);
    $stmt->execute();
  }

  echo json_encode(['success' => true]);
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

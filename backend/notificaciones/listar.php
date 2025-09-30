<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login.php'; // empleado

try {
  $empleado_id = (int)($_SESSION['identificacion'] ?? 0);
  if (!$empleado_id) throw new Exception('No autorizado');

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

  $limit = isset($_GET['limit']) ? max(1, min(200, (int)$_GET['limit'])) : 50;

  $sql = "SELECT id, type, title, body, link, created_at, read_at
          FROM employee_notifications
          WHERE empleado_id = ?
          ORDER BY (read_at IS NULL) DESC, created_at DESC
          LIMIT ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param('ii', $empleado_id, $limit);
  $stmt->execute();
  $res = $stmt->get_result();

  $out = [];
  while ($row = $res->fetch_assoc()) {
    $out[] = [
      'id' => (int)$row['id'],
      'type' => $row['type'],
      'title' => $row['title'],
      'body' => $row['body'],
      'link' => $row['link'],
      'created_at' => $row['created_at'],
      'read' => $row['read_at'] !== null
    ];
  }

  echo json_encode(['success' => true, 'data' => $out]);
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

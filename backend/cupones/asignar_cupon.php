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

  echo json_encode(['success' => true]);
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
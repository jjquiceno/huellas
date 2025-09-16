<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login_jefe.php';

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Método no permitido');

  $title = trim($_POST['title'] ?? '');
  $description = $_POST['description'] ?? null;
  $start_at = $_POST['start_at'] ?? null;
  $end_at = $_POST['end_at'] ?? null;
  $max_global = isset($_POST['max_global_redemptions']) ? (int)$_POST['max_global_redemptions'] : null;
  $per_user = isset($_POST['per_user_limit']) ? (int)$_POST['per_user_limit'] : null;
  $active = isset($_POST['active']) ? (int)$_POST['active'] : 1;
  $created_by = (int)$_SESSION['user_id'];

  if ($title === '') throw new Exception('El título es requerido');

  $stmt = $conexion->prepare("INSERT INTO coupons (title, description, start_at, end_at, max_global_redemptions, per_user_limit, created_by, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssiiii",
    $title,
    $description,
    $start_at,
    $end_at,
    $max_global,
    $per_user,
    $created_by,
    $active
  );

  if (!$stmt->execute()) throw new Exception('Error al crear el cupón');

  echo json_encode(['success' => true, 'coupon_id' => $stmt->insert_id]);
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
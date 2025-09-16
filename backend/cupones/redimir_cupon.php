<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login_jefe.php';

$conexion->begin_transaction();
try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Método no permitido');

  $coupon_id = (int)($_POST['coupon_id'] ?? 0);
  $empleado_id = (int)($_POST['empleado_id'] ?? 0);
  $jefe_id = (int)$_SESSION['user_id'];

  if (!$coupon_id || !$empleado_id) throw new Exception('Datos insuficientes');

  // Validar cupón
  $res = $conexion->prepare("SELECT id, active, start_at, end_at, max_global_redemptions, per_user_limit FROM coupons WHERE id = ?");
  $res->bind_param("i", $coupon_id);
  $res->execute();
  $cup = $res->get_result()->fetch_assoc();
  if (!$cup || !$cup['active']) throw new Exception('Cupón inactivo o inexistente');

  $now = date('Y-m-d');
  if ($cup['start_at'] && $now < $cup['start_at']) throw new Exception('Cupón aún no vigente');
  if ($cup['end_at'] && $now > $cup['end_at']) throw new Exception('Cupón vencido');

  // Traer asignación con lock
  $res2 = $conexion->prepare("SELECT id, status, expires_at FROM employee_coupons WHERE coupon_id = ? AND empleado_id = ? FOR UPDATE");
  $res2->bind_param("ii", $coupon_id, $empleado_id);
  $res2->execute();
  $empC = $res2->get_result()->fetch_assoc();
  if (!$empC) throw new Exception('Cupón no asignado a este empleado');
  if ($empC['status'] === 'redimido') throw new Exception('Cupón ya redimido');
  if ($empC['expires_at'] && $now > $empC['expires_at']) throw new Exception('Asignación vencida');

  // Límites
  if ($cup['max_global_redemptions'] !== null) {
    $q = $conexion->prepare("SELECT COUNT(*) c FROM coupon_redemptions r JOIN employee_coupons ec ON ec.id = r.employee_coupon_id WHERE ec.coupon_id = ?");
    $q->bind_param("i", $coupon_id);
    $q->execute();
    $cGlobal = (int)$q->get_result()->fetch_assoc()['c'];
    if ($cGlobal >= (int)$cup['max_global_redemptions']) throw new Exception('Límite global alcanzado');
  }

  if ($cup['per_user_limit'] !== null) {
    $q2 = $conexion->prepare("SELECT COUNT(*) c FROM coupon_redemptions r JOIN employee_coupons ec ON ec.id = r.employee_coupon_id WHERE ec.coupon_id = ? AND ec.empleado_id = ?");
    $q2->bind_param("ii", $coupon_id, $empleado_id);
    $q2->execute();
    $cUser = (int)$q2->get_result()->fetch_assoc()['c'];
    if ($cUser >= (int)$cup['per_user_limit']) throw new Exception('Límite por usuario alcanzado');
  }

  // Redimir: actualizar estado y log
  $upd = $conexion->prepare("UPDATE employee_coupons SET status='redimido', redeemed_at=NOW(), redeemed_by=? WHERE id=?");
  $upd->bind_param("is", $jefe_id, $empC['id']);
  if (!$upd->execute()) throw new Exception('Error al actualizar estado');

  $ins = $conexion->prepare("INSERT INTO coupon_redemptions (employee_coupon_id, redeemed_by) VALUES (?, ?)");
  $ins->bind_param("ii", $empC['id'], $jefe_id);
  if (!$ins->execute()) throw new Exception('Error al registrar redención');

  $conexion->commit();
  echo json_encode(['success' => true, 'employee_coupon_id' => $empC['id']]);
} catch (Exception $e) {
  $conexion->rollback();
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
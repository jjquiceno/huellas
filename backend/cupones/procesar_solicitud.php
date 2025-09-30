<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login_jefe.php';

$conexion->begin_transaction();
try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception('Método no permitido');

  $jefe_id = (int)($_SESSION['user_id'] ?? 0);
  if (!$jefe_id) throw new Exception('No autorizado');

  $request_id = (int)($_POST['request_id'] ?? 0);
  $accion = strtolower(trim($_POST['accion'] ?? ''));
  $note = isset($_POST['note']) ? trim($_POST['note']) : null;
  if (!$request_id || !in_array($accion, ['aprobar','rechazar'])) throw new Exception('Datos insuficientes');

  // Traer solicitud y validar que esté pendiente y que este jefe pueda gestionarla
  $q = $conexion->prepare("SELECT rr.id, rr.status, rr.employee_coupon_id, rr.coupon_id, rr.empleado_id,
                                  c.active, c.start_at, c.end_at, c.max_global_redemptions, c.per_user_limit, c.created_by
                            FROM redemption_requests rr
                            JOIN coupons c ON c.id = rr.coupon_id
                            WHERE rr.id = ? FOR UPDATE");
  $q->bind_param('i', $request_id);
  $q->execute();
  $rr = $q->get_result()->fetch_assoc();
  if (!$rr) throw new Exception('Solicitud no encontrada');
  if ($rr['status'] !== 'pendiente') throw new Exception('La solicitud ya fue procesada');
  if ((int)$rr['created_by'] !== $jefe_id) {
    // Si no es creador, verificar si rr.jefe_id = este jefe
    $q2 = $conexion->prepare("SELECT jefe_id FROM redemption_requests WHERE id = ?");
    $q2->bind_param('i', $request_id);
    $q2->execute();
    $row2 = $q2->get_result()->fetch_assoc();
    if (!$row2 || ((int)$row2['jefe_id'] !== 0 && (int)$row2['jefe_id'] !== $jefe_id)) {
      throw new Exception('No tiene permiso para esta solicitud');
    }
  }

  if ($accion === 'rechazar') {
    $upd = $conexion->prepare("UPDATE redemption_requests SET status='rechazada', processed_at=NOW(), processed_by=?, note=? WHERE id=?");
    $upd->bind_param('isi', $jefe_id, $note, $request_id);
    if (!$upd->execute()) throw new Exception('No se pudo actualizar la solicitud');
    $conexion->commit();
    echo json_encode(['success' => true, 'status' => 'rechazada']);
    exit;
  }

  // Aprobar: realizar redención con validaciones similares a redimir_cupon.php
  $coupon_id = (int)$rr['coupon_id'];
  $empleado_id = (int)$rr['empleado_id'];
  $employee_coupon_id = (int)$rr['employee_coupon_id'];

  // Validaciones de cupón
  if (!(int)$rr['active']) throw new Exception('Cupón inactivo o inexistente');
  $now = date('Y-m-d');
  if (!empty($rr['start_at']) && $now < $rr['start_at']) throw new Exception('Cupón aún no vigente');
  if (!empty($rr['end_at']) && $now > $rr['end_at']) throw new Exception('Cupón vencido');

  // Traer asignación con lock
  $res2 = $conexion->prepare("SELECT id, status, expires_at FROM employee_coupons WHERE id = ? AND coupon_id = ? AND empleado_id = ? FOR UPDATE");
  $res2->bind_param('iii', $employee_coupon_id, $coupon_id, $empleado_id);
  $res2->execute();
  $empC = $res2->get_result()->fetch_assoc();
  if (!$empC) throw new Exception('Cupón no asignado a este empleado');
  if ($empC['status'] === 'redimido') throw new Exception('Cupón ya redimido');
  if (!empty($empC['expires_at']) && $now > $empC['expires_at']) throw new Exception('Asignación vencida');

  // Límites globales y por usuario
  if (!is_null($rr['max_global_redemptions'])) {
    $qg = $conexion->prepare("SELECT COUNT(*) c FROM coupon_redemptions r JOIN employee_coupons ec ON ec.id = r.employee_coupon_id WHERE ec.coupon_id = ?");
    $qg->bind_param('i', $coupon_id);
    $qg->execute();
    $cGlobal = (int)$qg->get_result()->fetch_assoc()['c'];
    if ($cGlobal >= (int)$rr['max_global_redemptions']) throw new Exception('Límite global alcanzado');
  }

  if (!is_null($rr['per_user_limit'])) {
    $qu = $conexion->prepare("SELECT COUNT(*) c FROM coupon_redemptions r JOIN employee_coupons ec ON ec.id = r.employee_coupon_id WHERE ec.coupon_id = ? AND ec.empleado_id = ?");
    $qu->bind_param('ii', $coupon_id, $empleado_id);
    $qu->execute();
    $cUser = (int)$qu->get_result()->fetch_assoc()['c'];
    if ($cUser >= (int)$rr['per_user_limit']) throw new Exception('Límite por usuario alcanzado');
  }

  // Redimir
  $updEmp = $conexion->prepare("UPDATE employee_coupons SET status='redimido', redeemed_at=NOW(), redeemed_by=? WHERE id=?");
  $updEmp->bind_param('ii', $jefe_id, $employee_coupon_id);
  if (!$updEmp->execute()) throw new Exception('Error al actualizar estado');

  $insRed = $conexion->prepare("INSERT INTO coupon_redemptions (employee_coupon_id, redeemed_by) VALUES (?, ?)");
  $insRed->bind_param('ii', $employee_coupon_id, $jefe_id);
  if (!$insRed->execute()) throw new Exception('Error al registrar redención');

  // Marcar solicitud como aprobada
  $updReq = $conexion->prepare("UPDATE redemption_requests SET status='aprobada', processed_at=NOW(), processed_by=?, note=? WHERE id=?");
  $updReq->bind_param('isi', $jefe_id, $note, $request_id);
  if (!$updReq->execute()) throw new Exception('No se pudo actualizar la solicitud');

  $conexion->commit();
  echo json_encode(['success' => true, 'status' => 'aprobada']);
} catch (Exception $e) {
  $conexion->rollback();
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

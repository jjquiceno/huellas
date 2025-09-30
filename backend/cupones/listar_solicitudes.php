<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login_jefe.php';

try {
  $jefe_id = (int)($_SESSION['user_id'] ?? 0);
  if (!$jefe_id) throw new Exception('No autorizado');

  // Listar solicitudes pendientes asignadas a este jefe (por campo jefe_id o por ser creador del cupón)
  $sql = "SELECT 
            rr.id as request_id,
            rr.employee_coupon_id,
            rr.coupon_id,
            rr.empleado_id,
            rr.status,
            rr.requested_at,
            c.title as coupon_title,
            c.description as coupon_description,
            e.nombre as empleado_nombre,
            e.nombre_usuario as empleado_usuario
          FROM redemption_requests rr
          JOIN coupons c ON c.id = rr.coupon_id
          LEFT JOIN empleados e ON e.identificacion = rr.empleado_id
          WHERE rr.status = 'pendiente' AND (rr.jefe_id = ? OR c.created_by = ?)
          ORDER BY rr.requested_at DESC";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param('ii', $jefe_id, $jefe_id);
  $stmt->execute();
  $res = $stmt->get_result();

  $out = [];
  while ($row = $res->fetch_assoc()) {
    $out[] = [
      'request_id' => (int)$row['request_id'],
      'employee_coupon_id' => (int)$row['employee_coupon_id'],
      'coupon_id' => (int)$row['coupon_id'],
      'empleado_id' => (int)$row['empleado_id'],
      'status' => $row['status'],
      'requested_at' => $row['requested_at'],
      'coupon_title' => $row['coupon_title'],
      'coupon_description' => $row['coupon_description'],
      'empleado_nombre' => $row['empleado_nombre'] ?? null,
      'empleado_usuario' => $row['empleado_usuario'] ?? null
    ];
  }

  echo json_encode(['success' => true, 'data' => $out]);
} catch (Exception $e) {
  http_response_code(400);
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

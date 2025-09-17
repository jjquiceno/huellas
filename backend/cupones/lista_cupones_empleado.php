<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login.php'; // empleado logueado

try {
    $empleado_id = (int)($_SESSION['identificacion'] ?? 0);
    if (!$empleado_id) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'No autorizado']);
        exit;
    }

    // Traer cupones asignados al empleado junto a la definición del cupón
    $sql = "SELECT 
                ec.id AS employee_coupon_id,
                ec.coupon_id,
                ec.status,
                ec.assigned_at,
                ec.expires_at,
                ec.redeemed_at,

                c.title,
                c.description,
                c.start_at,
                c.end_at,
                c.active,
                c.per_user_limit,
                c.max_global_redemptions
            FROM employee_coupons ec
            JOIN coupons c ON c.id = ec.coupon_id
            WHERE ec.empleado_id = ?
            ORDER BY ec.assigned_at DESC";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $empleado_id);
    $stmt->execute();
    $res = $stmt->get_result();

    $out = [];
    $now = new DateTime('now');

    while ($row = $res->fetch_assoc()) {
    // Contar redenciones globales del cupón (resiliente)
    try {
      $qGlobal = $conexion->prepare("SELECT COUNT(*) c
        FROM coupon_redemptions r
        JOIN employee_coupons ec2 ON ec2.id = r.employee_coupon_id
        WHERE ec2.coupon_id = ?");
      $qGlobal->bind_param("i", $row['coupon_id']);
      $qGlobal->execute();
      $globalCount = (int)$qGlobal->get_result()->fetch_assoc()['c'];
    } catch (Exception $e2) {
      // Si la tabla de redenciones aún no existe o falla la consulta, asumir 0 para no romper la API
      $globalCount = 0;
    }

    // Contar redenciones del empleado para esta asignación (resiliente)
    try {
      $qUser = $conexion->prepare("SELECT COUNT(*) c
        FROM coupon_redemptions
        WHERE employee_coupon_id = ?");
      $qUser->bind_param("i", $row['employee_coupon_id']);
      $qUser->execute();
      $userCount = (int)$qUser->get_result()->fetch_assoc()['c'];
    } catch (Exception $e3) {
      $userCount = 0;
    }

    // Reglas de canje
    $active = (int)$row['active'] === 1;
    $startOk = empty($row['start_at']) ? true : ($now >= new DateTime($row['start_at']));
    $endOk   = empty($row['end_at'])   ? true : ($now <= new DateTime($row['end_at']));
    $notExpiredAssign = empty($row['expires_at']) ? true : ($now <= new DateTime($row['expires_at']));
    $notRedeemed = ($row['status'] !== 'redimido');

    $globalLimitOk = is_null($row['max_global_redemptions']) ? true : ($globalCount < (int)$row['max_global_redemptions']);
    $perUserLimitOk = is_null($row['per_user_limit']) ? true : ($userCount < (int)$row['per_user_limit']);

    $redeemable = $active && $startOk && $endOk && $notExpiredAssign && $notRedeemed && $globalLimitOk && $perUserLimitOk;

    $out[] = [
      'employee_coupon_id'     => (int)$row['employee_coupon_id'],
      'coupon_id'              => (int)$row['coupon_id'],
      'status'                 => $row['status'],
      'assigned_at'            => $row['assigned_at'],
      'expires_at'             => $row['expires_at'],
      'redeemed_at'            => $row['redeemed_at'],

      'title'                  => $row['title'],
      'description'            => $row['description'],
      'start_at'               => $row['start_at'],
      'end_at'                 => $row['end_at'],
      'active'                 => (int)$row['active'],
      'per_user_limit'         => is_null($row['per_user_limit']) ? null : (int)$row['per_user_limit'],
      'max_global_redemptions' => is_null($row['max_global_redemptions']) ? null : (int)$row['max_global_redemptions'],

      'global_redemptions'     => $globalCount,
      'user_redemptions'       => $userCount,
      'redeemable'             => $redeemable
    ];
  }

  echo json_encode($out);
} catch (Exception $e) {
  http_response_code(500);
  // Incluir el mensaje de error para depuración. Si no deseas exponerlo en prod, cámbialo por un log en servidor.
  echo json_encode(['success' => false, 'message' => 'Error al listar cupones del empleado', 'error' => $e->getMessage()]);
}
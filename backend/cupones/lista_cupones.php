<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login_jefe.php';

$only_active = isset($_GET['active']) ? (int)$_GET['active'] : null;

$sql = "SELECT * FROM coupons";
if ($only_active !== null) $sql .= " WHERE active = ".$only_active;
$sql .= " ORDER BY created_at DESC";

$res = $conexion->query($sql);
$out = [];
while ($row = $res->fetch_assoc()) $out[] = $row;

echo json_encode($out);
<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../../helpers/require_login_admin.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'JSON inválido', 'error' => json_last_error_msg()]);
    exit;
}

$id_jefe = trim($data['id_jefe'] ?? '');
$nuevo_nombre_usuario = trim($data['nuevo_nombre_usuario'] ?? '');
$correo = trim($data['correo'] ?? '');

if ($id_jefe === '' || $nuevo_nombre_usuario === '' || $correo === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Campos requeridos: id_jefe, nuevo_nombre_usuario, correo']);
    exit;
}

try {
    // verificar existencia
    $stmt = $conexion->prepare('SELECT id_jefe FROM jefes WHERE id_jefe = ?');
    $stmt->bind_param('s', $id_jefe);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Líder no encontrado']);
        exit;
    }
    $stmt->close();

    // verificar duplicados de username/email en otros jefes
    $stmt = $conexion->prepare('SELECT 1 FROM jefes WHERE (nombre_usuario = ? OR correo = ?) AND id_jefe <> ?');
    $stmt->bind_param('sss', $nuevo_nombre_usuario, $correo, $id_jefe);
    $stmt->execute();
    $dup = $stmt->get_result();
    if ($dup->num_rows > 0) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'El nombre de usuario o correo ya están en uso por otro líder']);
        exit;
    }
    $stmt->close();

    // actualizar
    $stmt = $conexion->prepare('UPDATE jefes SET nombre_usuario = ?, correo = ? WHERE id_jefe = ?');
    $stmt->bind_param('sss', $nuevo_nombre_usuario, $correo, $id_jefe);
    if (!$stmt->execute()) {
        throw new Exception('Error al actualizar: ' . $stmt->error);
    }

    echo json_encode(['success' => true, 'message' => 'Líder actualizado correctamente']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($stmt) && $stmt) { $stmt->close(); }
    $conexion->close();
}

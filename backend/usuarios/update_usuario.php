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

$current_username = trim($data['nombre_usuario'] ?? '');
$new_username = trim($data['nuevo_nombre_usuario'] ?? '');
$new_email = trim($data['email'] ?? '');

if ($current_username === '' || $new_username === '' || $new_email === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Campos requeridos: nombre_usuario, nuevo_nombre_usuario, email']);
    exit;
}

try {
    // Verificar que el usuario actual exista
    $stmt = $conexion->prepare('SELECT nombre_usuario, email FROM usuarios WHERE nombre_usuario = ?');
    $stmt->bind_param('s', $current_username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        exit;
    }
    $stmt->close();

    // Verificar que el nuevo nombre de usuario o email no estén en uso por otro
    $stmt = $conexion->prepare('SELECT 1 FROM usuarios WHERE (nombre_usuario = ? OR email = ?) AND nombre_usuario <> ?');
    $stmt->bind_param('sss', $new_username, $new_email, $current_username);
    $stmt->execute();
    $dup = $stmt->get_result();
    if ($dup->num_rows > 0) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'El nombre de usuario o correo ya están en uso por otro usuario']);
        exit;
    }
    $stmt->close();

    // Actualizar datos
    $stmt = $conexion->prepare('UPDATE usuarios SET nombre_usuario = ?, email = ? WHERE nombre_usuario = ?');
    $stmt->bind_param('sss', $new_username, $new_email, $current_username);
    if (!$stmt->execute()) {
        throw new Exception('Error al actualizar: ' . $stmt->error);
    }

    echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($stmt) && $stmt) { $stmt->close(); }
    $conexion->close();
}

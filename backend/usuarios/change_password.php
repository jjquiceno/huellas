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

$username = trim($data['nombre_usuario'] ?? '');
$new_password = (string)($data['new_password'] ?? '');

if ($username === '' || $new_password === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Campos requeridos: nombre_usuario, new_password']);
    exit;
}

if (strlen($new_password) < 8) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres']);
    exit;
}

try {
    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conexion->prepare('UPDATE usuarios SET contraseña = ? WHERE nombre_usuario = ?');
    $stmt->bind_param('ss', $hash, $username);
    if (!$stmt->execute()) {
        throw new Exception('Error al actualizar la contraseña: ' . $stmt->error);
    }
    if ($stmt->affected_rows === 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        exit;
    }
    echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($stmt) && $stmt) { $stmt->close(); }
    $conexion->close();
}

<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../../helpers/require_login_admin.php';

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener el ID del usuario a eliminar
$data = json_decode(file_get_contents('php://input'), true);
$usuarioId = $data['nombre_usuario'] ?? null;

if (!$usuarioId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nombre de usuario no proporcionado']);
    exit;
}

try {
    // Preparar la consulta para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuarioId);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el usuario']);
        }
    } else {
        throw new Exception('Error al ejecutar la consulta');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario: ' . $e->getMessage()]);
} finally {
    if (isset($stmt)) $stmt->close();
    $conexion->close();
}
?>

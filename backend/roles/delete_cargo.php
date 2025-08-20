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
$cargo_id = $data['cargo_id'] ?? null;

if (!$cargo_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID del cargo no proporcionado']);
    exit;
}

try {
    // Preparar la consulta para eliminar el usuario
    $sql = "DELETE FROM cargos WHERE cargo_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $cargo_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Cargo eliminado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró el cargo']);
        }
    } else {
        throw new Exception('Error al ejecutar la consulta');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el cargo: ' . $e->getMessage()]);
} finally {
    if (isset($stmt)) $stmt->close();
    $conexion->close();
}
?>

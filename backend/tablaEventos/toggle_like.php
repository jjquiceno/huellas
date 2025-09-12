<?php
header('Content-Type: application/json');
require_once '../../config.php';
require_once '../../helpers/require_login.php';

$response = ['success' => false, 'message' => ''];

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

try {
    // Obtener datos JSON
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['evento_id']) || !is_numeric($input['evento_id'])) {
        throw new Exception('ID de evento inválido');
    }
    
    $evento_id = (int)$input['evento_id'];
    $empleado_id = $_SESSION['user_id'];
    
    // Verificar si ya existe un like del usuario para este evento
    $stmt = $conexion->prepare("SELECT id FROM eventos_likes WHERE evento_id = ? AND empleado_id = ?");
    $stmt->bind_param("ii", $evento_id, $empleado_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Ya existe el like, eliminarlo
        $stmt = $conexion->prepare("DELETE FROM eventos_likes WHERE evento_id = ? AND empleado_id = ?");
        $stmt->bind_param("ii", $evento_id, $empleado_id);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Like eliminado';
            $response['action'] = 'removed';
        } else {
            throw new Exception('Error al eliminar el like');
        }
    } else {
        // No existe el like, agregarlo
        $stmt = $conexion->prepare("INSERT INTO eventos_likes (evento_id, empleado_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $evento_id, $empleado_id);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Like agregado';
            $response['action'] = 'added';
        } else {
            throw new Exception('Error al agregar el like');
        }
    }
    
    // Obtener el nuevo conteo de likes
    $stmt = $conexion->prepare("SELECT COUNT(*) as total_likes FROM eventos_likes WHERE evento_id = ?");
    $stmt->bind_param("i", $evento_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $response['total_likes'] = (int)$row['total_likes'];
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>

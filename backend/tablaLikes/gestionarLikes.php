<?php
header('Content-Type: application/json');
require_once '../../config.php';
require_once '../../helpers/require_login.php';

$response = ['success' => false, 'message' => ''];

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'No autorizado';
    echo json_encode($response);
    exit;
}

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

// Obtener datos de la solicitud
$evento_id = filter_input(INPUT_POST, 'evento_id', FILTER_VALIDATE_INT);
$accion = filter_input(INPUT_POST, 'accion', FILTER_SANITIZE_STRING);
$usuario_id = $_SESSION['user_id'];

// Validar datos
if (!$evento_id || !in_array($accion, ['dar_like', 'quitar_like'])) {
    $response['message'] = 'Datos inválidos';
    echo json_encode($response);
    exit;
}

try {
    if ($accion === 'dar_like') {
        // Verificar si ya dio like
        $stmt = $conexion->prepare("SELECT id FROM eventos_likes WHERE evento_id = ? AND empleado_id = ?");
        $stmt->bind_param("ii", $evento_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            // Dar like
            $stmt = $conexion->prepare("INSERT INTO eventos_likes (evento_id, empleado_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $evento_id, $usuario_id);
            $stmt->execute();
        }
    } else {
        // Quitar like
        $stmt = $conexion->prepare("DELETE FROM eventos_likes WHERE evento_id = ? AND empleado_id = ?");
        $stmt->bind_param("ii", $evento_id, $usuario_id);
        $stmt->execute();
    }
    
    // Obtener el nuevo conteo de likes
    $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM eventos_likes WHERE evento_id = ?");
    $stmt->bind_param("i", $evento_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->fetch_assoc()['total'];
    
    $response['success'] = true;
    $response['total_likes'] = $total;
    
} catch (Exception $e) {
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

echo json_encode($response);
?>
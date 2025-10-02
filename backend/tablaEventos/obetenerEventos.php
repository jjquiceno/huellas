<?php
header('Content-Type: application/json');
require_once '../../../config.php';
require_once '../../../helpers/require_login.php';

$response = [];
$usuario_id = $_SESSION['user_id'];

try {
    // Consulta para obtener los eventos con información de likes
    $query = "SELECT 
                e.*,
                COUNT(el.id) as likes,
                SUM(CASE WHEN el.empleado_id = ? THEN 1 ELSE 0 END) as me_gusta
              FROM eventos e
              LEFT JOIN eventos_likes el ON e.id = el.evento_id
              GROUP BY e.id
              ORDER BY e.fecha_evento DESC, e.fecha_creacion DESC";
    
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $eventos = [];
    while ($fila = $result->fetch_assoc()) {
        $eventos[] = [
            'id' => $fila['id'],
            'titulo' => $fila['titulo'],
            'descripcion' => $fila['descripcion'],
            'fecha_evento' => $fila['fecha_evento'],
            'imagen_url' => $fila['imagen_url'],
            'likes' => (int)$fila['likes'],
            'me_gusta' => (bool)$fila['me_gusta']
        ];
    }
    
    echo json_encode($eventos);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al cargar los eventos']);
}
?>
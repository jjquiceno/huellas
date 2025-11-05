<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login_jefe.php';

try {
    $query = "SELECT e.*, COUNT(el.id) AS likes FROM eventos e LEFT JOIN eventos_likes el ON e.id = el.evento_id GROUP BY e.id ORDER BY e.fecha_evento DESC, e.fecha_creacion DESC";
    $res = $conexion->query($query);
    $eventos = [];
    while ($fila = $res->fetch_assoc()) {
        $eventos[] = [
            'id' => (int)$fila['id'],
            'titulo' => $fila['titulo'],
            'descripcion' => $fila['descripcion'],
            'fecha_evento' => $fila['fecha_evento'],
            'imagen_url' => $fila['imagen_url'],
            'likes' => (int)$fila['likes']
        ];
    }
    echo json_encode($eventos);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'message'=>'Error al cargar los eventos']);
}

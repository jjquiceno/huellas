<?php
header('Content-Type: application/json');
require_once '../../config.php';
require_once '../../helpers/require_login_jefe.php';

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

$evento_id = isset($data['id']) ? (int)$data['id'] : 0;
if ($evento_id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID de evento inválido']);
    exit;
}

try {
    // Obtener info del evento (para borrar imagen)
    $stmt = $conexion->prepare('SELECT imagen_url FROM eventos WHERE id = ?');
    $stmt->bind_param('i', $evento_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Evento no encontrado']);
        exit;
    }
    $row = $res->fetch_assoc();
    $stmt->close();

    // Borrar likes asociados (si existe la tabla)
    @$conexion->query('DELETE FROM eventos_likes WHERE evento_id = ' . (int)$evento_id);

    // Borrar evento
    $stmt = $conexion->prepare('DELETE FROM eventos WHERE id = ?');
    $stmt->bind_param('i', $evento_id);
    if (!$stmt->execute()) {
        throw new Exception('Error al eliminar el evento: ' . $stmt->error);
    }
    $stmt->close();

    // Borrar imagen física
    if (!empty($row['imagen_url'])) {
        $ruta = '../../uploads/eventos/' . $row['imagen_url'];
        $abs = realpath(__DIR__ . '/' . $ruta);
        if ($abs && file_exists($abs)) {
            @unlink($abs);
        } else {
            // intentar ruta relativa desde backend/tablaEventos
            $fallback = __DIR__ . '/../../uploads/eventos/' . $row['imagen_url'];
            if (file_exists($fallback)) {
                @unlink($fallback);
            }
        }
    }

    echo json_encode(['success' => true, 'message' => 'Evento eliminado correctamente']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    if (isset($stmt) && $stmt) { $stmt->close(); }
    $conexion->close();
}

<?php
// Desactivar la caché
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Content-Type: application/json');

// Habilitar el reporte de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Usar la ruta absoluta al archivo de conexión
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../../helpers/require_login_admin.php';

// Función para enviar respuesta JSON
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Verificar conexión
    if ($conexion->connect_error) {
        throw new Exception('Error de conexión: ' . $conexion->connect_error);
    }

    // Verificar si la tabla existe
    $tableCheck = $conexion->query("SHOW TABLES LIKE 'cargos'");
    if ($tableCheck->num_rows === 0) {
        throw new Exception('La tabla "cargos" no existe en la base de datos');
    }

    $sql = "SELECT cargo_id, cargo FROM cargos ORDER BY cargo";
    $result = $conexion->query($sql);
    
    if ($result === false) {
        throw new Exception('Error en la consulta: ' . $conexion->error);
    }
    
    $cargos = [];
    while ($row = $result->fetch_assoc()) {
        $cargos[] = [
            'cargo_id' => (int)$row['cargo_id'],
            'cargo' => $row['cargo']
        ];
    }
    
    if (empty($cargos)) {
        // Devolver un array vacío en lugar de un error si no hay cargos
        sendResponse([], 200);
    }
    
    sendResponse($cargos);
    
} catch (Exception $e) {
    error_log('Error en get_cargos.php: ' . $e->getMessage());
    sendResponse([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], 500);
} finally {
    if (isset($result) && $result instanceof mysqli_result) {
        $result->free();
    }
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>

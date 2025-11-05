<?php
// Enable error reporting and display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../php_errors.log');

// Set headers for JSON response
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

// Log the raw input for debugging
$input = file_get_contents('php://input');
if ($input === false) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'No se recibieron datos en la solicitud',
        'input' => $input
    ]);
    exit;
}

// Decode JSON input
$data = json_decode($input, true);

// Check for JSON decode errors
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Error en el formato de los datos: ' . json_last_error_msg(),
        'input' => $input
    ]);
    exit;
}

// Log the received data
error_log('Received update request: ' . print_r($data, true));

// Include required files
require_once __DIR__ . '/../conexion.php';
require_once __DIR__ . '/../../helpers/require_login_admin.php';

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Get cargo ID to update (cast to int)
$cargo_id = isset($data['cargo_id']) ? (int)$data['cargo_id'] : null;

if (!$cargo_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID del cargo no proporcionado']);
    exit;
}

// Validate required fields
$requiredFields = [
    'cargo_id', 'cargo', 'funciones'
];

$missingFields = [];
foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || $data[$field] === '') {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Los siguientes campos son requeridos: ' . implode(', ', $missingFields)]);
    exit;
}

// Log the data being processed
error_log('Processing update for cargo ID: ' . $cargo_id);
error_log('Data to update: ' . print_r($data, true));

// Preparar la consulta de actualización
$sql = "UPDATE cargos SET 
        cargo = ?, 
        funciones = ?
        WHERE cargo_id = ?";

error_log('Preparing SQL: ' . $sql);
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    $error = $conexion->error;
    error_log('Error preparing statement: ' . $error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $error]);
    $conexion->close();
    exit;
}

try {
    // Log the parameter types and values
    $types = "ssi";
    $params = [
        $data['cargo'],
        $data['funciones'],
        $cargo_id
    ];
    
    error_log('Binding parameters - Types: ' . $types);
    error_log('Parameter values: ' . print_r($params, true));
    
    $stmt->bind_param($types, ...$params);
    
    // Execute the statement
    $result = $stmt->execute();
    
    if ($result) {
        $response = [
            'success' => true, 
            'message' => 'Cargo actualizado correctamente',
            'affected_rows' => $stmt->affected_rows
        ];
        error_log('Update successful: ' . print_r($response, true));
        echo json_encode($response);
    } else {
        $error = $stmt->error;
        error_log('Error executing statement: ' . $error);
        throw new Exception('Error al actualizar el cargo en la base de datos: ' . $error);
    }
} catch (Exception $e) {
    http_response_code(500);
    $errorResponse = [
        'success' => false, 
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ];
    error_log('Error in update_cargo: ' . print_r($errorResponse, true));
    echo json_encode($errorResponse);
} finally {
    if (isset($stmt)) $stmt->close();
    $conexion->close();
}
?>

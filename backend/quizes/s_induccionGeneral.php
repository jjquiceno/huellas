<?php
header('Content-Type: application/json; charset=UTF-8');
// Opcional: en producción, asegúrate de no mostrar errores
// ini_set('display_errors', 0);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login.php';

$response = [
    'success'   => false,
    'message'   => '',
    'completed' => false,
    'value'     => null,
];

try {
    // Solo permitimos GET para consultar el estado
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        $response['message'] = 'Método no permitido';
        echo json_encode($response);
        exit;
    }

    if (!isset($_SESSION['identificacion'])) {
        throw new Exception('No se encontró la identificación del usuario en la sesión');
    }

    // Consultar el estado de la inducción en empleados
    $stmt = $conexion->prepare('SELECT induccionGeneral FROM empleados WHERE identificacion = ? LIMIT 1');
    if (!$stmt) {
        throw new Exception('Error preparando la consulta: ' . $conexion->error);
    }

    $identificacion = (int) $_SESSION['identificacion'];
    $stmt->bind_param('i', $identificacion);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        throw new Exception('Empleado no encontrado');
    }

    $row = $result->fetch_assoc();
    $value = $row['induccionGeneral'];

    // Normalizar a booleano (soporta ENUM/VARCHAR 'si'/'no' o TINYINT 0/1)
    $completed = false;
    if (is_string($value)) {
        $val = strtolower(trim($value));
        $completed = ($val === 'si' || $val === '1' || $val === 'true');
    } else {
        $completed = ((int) $value === 1);
    }

    $response['success'] = true;
    $response['completed'] = $completed;
    $response['value'] = $value;

    echo json_encode($response);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    echo json_encode($response);
    exit;
}

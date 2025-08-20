<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/../../../helpers/require_login_admin.php';

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener los datos del empleado a actualizar
$data = json_decode(file_get_contents('php://input'), true);
$identificacion = $data['identificacion'] ?? null;

if (!$identificacion) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID del empleado no proporcionado']);
    exit;
}

try {
    // Validar datos requeridos
    $requiredFields = [
        'tipo_identificacion_id', 'nombre', 'fecha_nacimiento', 
        'fecha_ingreso', 'nombre_usuario', 'cargo_id', 
        'tipo_contrato_id', 'duracion_contrato', 'salario'
    ];
    
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || $data[$field] === '') {
            throw new Exception("El campo $field es requerido");
        }
    }

    // Preparar la consulta de actualización
    $sql = "UPDATE empleados SET 
            tipo_identificacion_id = ?, 
            nombre = ?, 
            fecha_nacimiento = ?, 
            fecha_ingreso = ?, 
            nombre_usuario = ?, 
            cargo_id = ?, 
            tipo_contrato_id = ?, 
            duracion_contrato = ?, 
            salario = ? 
            WHERE identificacion = ?";

    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        throw new Exception('Error al preparar la consulta: ' . $conexion->error);
    }

    $stmt->bind_param(
        "isssssiids",
        $data['tipo_identificacion_id'],
        $data['nombre'],
        $data['fecha_nacimiento'],
        $data['fecha_ingreso'],
        $data['nombre_usuario'],
        $data['cargo_id'],
        $data['tipo_contrato_id'],
        $data['duracion_contrato'],
        $data['salario'],
        $identificacion
    );

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true, 
            'message' => 'Empleado actualizado correctamente'
        ]);
    } else {
        throw new Exception('Error al actualizar el empleado: ' . $stmt->error);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    $conexion->close();
}
?>

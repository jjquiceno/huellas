<?php
    header('Content-Type: application/json');
    require_once __DIR__ . '/../conexion.php'; 

    require_once __DIR__ . '/../../helpers/Validator.php';
    
    // Función para responder en JSON
    function sendResponse($success, $message = '') {
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }

    // Validar y limpiar datos
    // $cargo = Validator::sanitizeUsername(username: $_POST['cargo'] ?? '');
    $cargo = $_POST['cargo'] ?? '';
    $funciones = $_POST['funciones'] ?? '';

    // Verificar si ya existe un usuario con estos datos
    $check_sql = "SELECT * FROM cargos WHERE cargo = ?";
    if ($check_stmt = $conexion->prepare($check_sql)) {
        $check_stmt->bind_param("s", $cargo);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $check_stmt->close();
            sendResponse(false, 'Este cargo ya existe');
        }
        $check_stmt->close();
    }

    if (!$cargo || !$funciones) {
        sendResponse(false, 'Todos los campos son obligatorios');
    }

    $sql = "INSERT INTO cargos (cargo, funciones) VALUES (?, ?)";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular parámetros
        $stmt->bind_param("ss", $cargo, $funciones);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close();
            sendResponse(true, 'cargo creado exitosamente');
        } else {
            $error = $stmt->error;
            $stmt->close();
            sendResponse(false, 'Error al crear el cargo: ' . $error);
        }
    } else {
        sendResponse(false, 'Error al preparar la consulta: ' . $conexion->error);
    }

    $conexion->close();
?>

    
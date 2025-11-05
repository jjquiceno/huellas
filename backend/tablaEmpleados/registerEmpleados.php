<?php
    header('Content-Type: application/json');
    require_once __DIR__ . "/../conexion.php"; 

    require_once __DIR__ . "/../../helpers/Validator.php";
    
    // Función para responder en JSON
    function sendResponse($success, $message = '') {
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }

    // Obtener datos originales
    $identificacion = $_POST['identificacion'] ?? '';
    $tipo_identificacion_id = $_POST['tipo_identificacion_id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? '';
    $celular = $_POST['celular'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $eps = $_POST['eps'] ?? '';
    $afp = $_POST['afp'] ?? '';
    $arl = $_POST['arl'] ?? '';
    $caja = $_POST['caja'] ?? '';
    $nombre_usuario = Validator::sanitizeUsername($_POST['nombre_usuario'] ?? '');
    $cargo_id = $_POST['cargo_id'] ?? '';
    $tipo_contrato_id = $_POST['tipo_contrato_id'] ?? '';
    $duracion_contrato = $_POST['duracion_contrato'] ?? '';
    $salario = $_POST['salario'] ?? '';

    // Validar datos
    if (!Validator::validateIdentificacion($identificacion)) {
        sendResponse(false, 'La identificacion debe tener al menos 8 caracteres y no puede tener caracteres especiales');
    }
    if(!Validator::validateTipoIdentificacion($tipo_identificacion_id)){
        sendResponse(false, 'El tipo de identificacion es requerido');
    }
    if(!Validator::validateNombre($nombre)){
        sendResponse(false, 'El nombre es requerido');
    }
    if(!Validator::validateFechaNacimiento($fecha_nacimiento)){
        sendResponse(false, 'La fecha de nacimiento es requerida');
    }
    if(!Validator::validateFechaIngreso($fecha_ingreso)){
        sendResponse(false, 'La fecha de ingreso es requerida');
    }
    // if(!Validator::validateNombreUsuario($nombre_usuario)){
    //     sendResponse(false, 'El nombre de usuario es requerido');
    // }
    if(!Validator::validateTipoContrato($tipo_contrato_id)){
        sendResponse(false, 'El tipo de contrato es requerido');
    }
    if(!Validator::validateSalario($salario)){
        sendResponse(false, 'El salario es requerido');
    } 

    // Verificar si ya existe un empleado con estos datos
    $check_sql = "SELECT * FROM empleados WHERE identificacion = ? OR nombre_usuario = ?";
    if ($check_stmt = $conexion->prepare($check_sql)) {
        $check_stmt->bind_param("ss", $identificacion, $nombre_usuario);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $check_stmt->close();
            sendResponse(false, 'Error: Ya existe un empleado con esta identificación o nombre de usuario');
        }
        $check_stmt->close();
    }

    if (!$identificacion || !$tipo_identificacion_id || !$nombre || !$fecha_nacimiento || !$fecha_ingreso || !$celular || !$direccion || !$eps || !$afp || !$arl || !$caja || !$nombre_usuario || !$cargo_id || !$tipo_contrato_id || !$salario) {
        sendResponse(false, 'Todos los campos son obligatorios');
    }

    $sql = "INSERT INTO empleados (identificacion, tipo_identificacion_id, nombre, fecha_nacimiento, fecha_ingreso, celular, direccion, eps, afp, arl, caja, nombre_usuario, cargo_id, tipo_contrato_id, duracion_contrato, salario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conexion->prepare($sql)) {
        // Casts y tipos
        $duracion_val = ($duracion_contrato === '' ? null : (int)$duracion_contrato);
        $salario_val = (float)$salario;
        // Vincular parámetros (16 tipos): 14 strings, 1 int (duracion), 1 double (salario)
        $stmt->bind_param(
            "ssssssssssssssid",
            $identificacion,
            $tipo_identificacion_id,
            $nombre,
            $fecha_nacimiento,
            $fecha_ingreso,
            $celular,
            $direccion,
            $eps,
            $afp,
            $arl,
            $caja,
            $nombre_usuario,
            $cargo_id,
            $tipo_contrato_id,
            $duracion_val,
            $salario_val
        );
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close();
            sendResponse(true, 'Empleado registrado exitosamente');
        } else {
            $error = $stmt->error;
            $stmt->close();
            sendResponse(false, 'Error al registrar el empleado: ' . $error);
        }
    } else {
        sendResponse(false, 'Error al preparar la consulta: ' . $conexion->error);
    }

    $conexion->close();
?>
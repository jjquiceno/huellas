<?php
    include "../conexion.php"; 

    require_once '../../helpers/Validator.php';
    
    // Obtener datos originales
    $identificacion = $_POST['identificacion'] ?? '';
    $tipo_identificacion_id = $_POST['tipo_identificacion_id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? '';
    $nombre_usuario = Validator::sanitizeUsername($_POST['nombre_usuario'] ?? '');
    $cargo_id = $_POST['cargo_id'] ?? '';
    $tipo_contrato_id = $_POST['tipo_contrato_id'] ?? '';
    $duracion_contrato = $_POST['duracion_contrato'] ?? '';
    $salario = $_POST['salario'] ?? '';

    // Validar datos
    if (!Validator::validateIdentificacion($identificacion)) {
        echo "
            <script>
                alert('La identificacion debe tener al menos 8 caracteres y no puede tener caracteres especiales');
                window.history.back();
            </script>";
        exit;
    }
    if(!Validator::validateTipoIdentificacion($tipo_identificacion_id)){
        echo "
            <script>
                alert('El tipo de identificacion es requerido');
                window.history.back();
            </script>";
        exit;
    }
    if(!Validator::validateNombre($nombre)){
        echo "
            <script>
                alert('El nombre es requerido');
                window.history.back();
            </script>";
        exit;
    }
    if(!Validator::validateFechaNacimiento($fecha_nacimiento)){
        echo "
            <script>
                alert('La fecha de nacimiento es requerida');
                window.history.back();
            </script>";
        exit;
    }
    if(!Validator::validateFechaIngreso($fecha_ingreso)){
        echo "
            <script>
                alert('La fecha de ingreso es requerida');
                window.history.back();
            </script>";
        exit;
    }
    if(!Validator::validateCargo($cargo_id)){
        echo "
            <script>
                alert('El tipo de contrato es requerido');
                window.history.back();
            </script>";
        exit;
    }
    if(!Validator::validateTipoContrato($tipo_contrato_id)){
        echo "
            <script>
                alert('El tipo de contrato es requerido');
                window.history.back();
            </script>";
        exit;
    }
    if(!Validator::validateSalario($salario)){
        echo "
            <script>
                alert('El salario es requerido o debe ser mayor a 0');
                window.history.back();
            </script>";
        exit;
    } 

    // Verificar si ya existe un usuario con estos datos
    $check_sql = "SELECT * FROM empleados WHERE identificacion = ? OR nombre_usuario = ?";
    if ($check_stmt = $conexion->prepare($check_sql)) {
        $check_stmt->bind_param("is", $identificacion, $nombre_usuario);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "
            <script>
                alert('Error: User already exists with this document or username');
                window.history.back();
            </script>";
            $check_stmt->close();
            exit;
        }
        $check_stmt->close();
    }

    if (!$identificacion || !$tipo_identificacion_id || !$nombre || !$fecha_nacimiento || !$fecha_ingreso || !$nombre_usuario || !$cargo_id || !$tipo_contrato_id || !$salario) {
        echo "
        <script>
            alert('All fields are required');
            window.history.back();
        </script>";
    } else {
        $sql = "INSERT INTO empleados (identificacion, tipo_identificacion_id, nombre, fecha_nacimiento, fecha_ingreso, nombre_usuario, cargo_id, tipo_contrato_id, duracion_contrato, salario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conexion->prepare($sql)) {
            // Vincular parámetros
            $stmt->bind_param("issssssssi", $identificacion, $tipo_identificacion_id, $nombre, $fecha_nacimiento, $fecha_ingreso, $nombre_usuario, $cargo_id, $tipo_contrato_id, $duracion_contrato, $salario);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "
                <script>
                    alert('New record created successfully');
                    window.location.href = '../../public_html/frontend/templates/induccionacces.php';
                </script>";
            } else {
                echo "
                <script>
                    alert('Error creating user: ' . $stmt->error . '\nQuery: ' . $sql);
                </script>"; 
            }
            $stmt->close();
        } else {
            echo "
            <script>
                alert('Error preparing statement: ' . $conexion->error);
                window.history.back();
            </script>";
        }
    }

    $conexion->close();
?>

    
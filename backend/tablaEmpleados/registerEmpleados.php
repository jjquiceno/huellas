<?php
    include "../conexion.php"; 

    require_once '../../helpers/Validator.php';
    
    // Validar y limpiar datos
    $identificacion = Validator::validateIdentificacion($_POST['identificacion'] ?? '');
    $tipo_identificacion_id = Validator::validateTipoIdentificacion($_POST['tipo_identificacion_id'] ?? '');
    $nombre = Validator::validateNombre($_POST['nombre'] ?? '');
    $fecha_nacimiento = Validator::validateFechaNacimiento($_POST['fecha_nacimiento'] ?? '');
    $nombre_usuario = Validator::sanitizeUsername($_POST['nombre_usuario'] ?? '');
    $cargo_id = Validator::validateCargo($_POST['cargo_id'] ?? '');
    $tipo_contrato_id = Validator::validateTipoContrato($_POST['tipo_contrato_id'] ?? '');
    $salario = Validator::validateSalario($_POST['salario'] ?? '');

    // validar identificacion
    if($identificacion === false) {
        echo "
            <script>
                alert('La identificacion debe tener al menos 8 caracteres y no puede tener caracteres especiales');
                window.history.back();
            </script>";
        exit;
    }

    // validar tipo de identificacion
    if($tipo_identificacion_id === false){
        echo "
            <script>
                alert('El tipo de identificacion es requerido');
                window.history.back();
            </script>";
        exit;
    }

    // validar nombre
    if($nombre === false){
        echo "
            <script>
                alert('El nombre es requerido');
                window.history.back();
            </script>";
        exit;
    }

    // validar fecha de nacimiento
    if($fecha_nacimiento === false){
        echo "
            <script>
                alert('La fecha de nacimiento es requerida');
                window.history.back();
            </script>";
        exit;
    }

    //validar cargo 
    if($tipo_contrato_id === false){
        echo "
            <script>
                alert('El tipo de contrato es requerido');
                window.history.back();
            </script>";
        exit;
    }
   
    // validar tipo de contrato 
    if($tipo_contrato_id === false){
        echo "
            <script>
                alert('El tipo de contrato es requerido');
                window.history.back();
            </script>";
        exit;
    }
    
    // validar salario 
    if($salario === false){
        echo "
            <script>
                alert('El salario es requerido o debe ser mayor a 0');
                window.history.back();
            </script>";
        exit;
    } 

    // Verificar si ya existe un usuario con estos datos
    $check_sql = "SELECT * FROM empleados WHERE identificacion = ? OR tipo_identificacion_id = ? OR nombre = ? OR fecha_nacimiento = ? OR nombre_usuario = ? OR cargo_id = ? OR tipo_contrato_id = ? OR salario = ?";
    if ($check_stmt = $conexion->prepare($check_sql)) {
        $check_stmt->bind_param("issssssi", $identificacion, $tipo_identificacion_id, $nombre, $fecha_nacimiento, $nombre_usuario, $cargo_id, $tipo_contrato_id, $salario);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "
            <script>
                alert('Error: User already exists with this document, username or email');
                window.history.back();
            </script>";
            $check_stmt->close();
            exit;
        }
        $check_stmt->close();
    }

    if (!$identificacion || !$tipo_identificacion_id || !$nombre || !$fecha_nacimiento || !$nombre_usuario || !$cargo_id || !$tipo_contrato_id || !$salario) {
        echo "
        <script>
            alert('All fields are required');
            window.history.back();
        </script>";
    } else {
        $sql = "INSERT INTO empleados (identificacion, tipo_identificacion_id, nombre, fecha_nacimiento, nombre_usuario, cargo_id, tipo_contrato_id, salario) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conexion->prepare($sql)) {
            // Vincular parámetros
            $stmt->bind_param("issssssi", $identificacion, $tipo_identificacion_id, $nombre, $fecha_nacimiento, $nombre_usuario, $cargo_id, $tipo_contrato_id, $salario);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "
                <script>
                    alert('New record created successfully');
                    window.location.href = '../public_html/frontend/templatesIntranet/registerEmpleado.php';
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

    
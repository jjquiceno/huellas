<?php
    include "../conexion.php"; 

    require_once '../../helpers/Validator.php';
    
    // Validar y limpiar datos
    $nombre_usuario = Validator::sanitizeUsername($_POST['nombre_usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $correo = filter_var($_POST['correo'] ?? '', FILTER_SANITIZE_EMAIL);
    $nombre = $_POST['nombre'] ?? '';
    $identificacion = $_POST['identificacion'] ?? '';

    // Validar datos
    if (!Validator::validatePassword($contrasena)) {
        echo "
            <script>
                alert('La contraseña debe tener al menos 8 caracteres');
                window.history.back();
            </script>";
        exit;
    }
    if (!Validator::validateIdentificacion($identificacion)) {
        echo "
            <script>
                alert('La identificacion debe tener al menos 8 caracteres y no puede tener caracteres especiales');
                window.history.back();
            </script>";
        exit;
    }
    if (!Validator::validateNombre($nombre)) {
        echo "
            <script>
                alert('El nombre es requerido');
                window.history.back();
            </script>";
        exit;
    }
    if (!Validator::validateEmail($correo)) {
        echo "
            <script>
                alert('Email inválido');
                window.history.back();
            </script>";
        exit;
    }

    // Generar un id_admon aleatorio y único
    function generarIdUnico($conexion) {
        do {
            // Puedes ajustar la longitud y el formato si lo deseas
            $id_jefe = bin2hex(random_bytes(6)); // 12 caracteres hexadecimales
            $check_id_sql = "SELECT 1 FROM jefes WHERE id_jefe = ?";
            $check_id_stmt = $conexion->prepare($check_id_sql);
            $check_id_stmt->bind_param("s", $id_jefe);
            $check_id_stmt->execute();
            $check_id_stmt->store_result();
            $existe = $check_id_stmt->num_rows > 0;
            $check_id_stmt->close();
        } while ($existe);
        return $id_jefe;
    }
    $id_jefe = generarIdUnico($conexion);

    // Verificar si ya existe un usuario con estos datos
    $check_sql = "SELECT * FROM jefes WHERE identificacion = ? OR nombre = ? OR correo = ? OR nombre_usuario = ? OR contrasena = ?";
    if ($check_stmt = $conexion->prepare($check_sql)) {
        $check_stmt->bind_param("sssss", $identificacion, $nombre, $correo, $nombre_usuario, $contrasena);
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

    if (!$nombre_usuario || !$correo || !$contrasena || !$nombre || !$identificacion || !$correo) {
        echo "
        <script>
            alert('All fields are required');
            window.history.back();
        </script>";
    } else {
        $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO jefes (id_jefe, identificacion, nombre, correo, nombre_usuario, contrasena) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $conexion->prepare($sql)) {
            // Vincular parámetros
            $stmt->bind_param("sissss", $id_jefe, $identificacion, $nombre, $correo, $nombre_usuario, $hashed_password);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "
                <script>
                    alert('New record created successfully');
                    // window.location.href = '../public_html/frontend/templatesJefes/registerJefe.php';
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
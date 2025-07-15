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
            $id_admon = bin2hex(random_bytes(6)); // 12 caracteres hexadecimales
            $check_id_sql = "SELECT 1 FROM admons WHERE id_admon = ?";
            $check_id_stmt = $conexion->prepare($check_id_sql);
            $check_id_stmt->bind_param("s", $id_admon);
            $check_id_stmt->execute();
            $check_id_stmt->store_result();
            $existe = $check_id_stmt->num_rows > 0;
            $check_id_stmt->close();
        } while ($existe);
        return $id_admon;
    }
    $id_admon = generarIdUnico($conexion);

    // Verificar si ya existe un usuario con estos datos
    $check_sql = "SELECT * FROM admons WHERE nombre_usuario = ? OR correo = ? OR contrasena = ? OR nombre = ? OR identificacion = ?";
    if ($check_stmt = $conexion->prepare($check_sql)) {
        $check_stmt->bind_param("sssss", $nombre_usuario, $correo, $contrasena, $nombre, $identificacion);
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
        $sql = "INSERT INTO admons (id_admon, nombre_usuario, correo, contrasena, nombre, identificacion) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $conexion->prepare($sql)) {
            // Vincular parámetros
            $stmt->bind_param("ssssss", $id_admon, $nombre_usuario, $correo, $hashed_password, $nombre, $identificacion);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "
                <script>
                    alert('New record created successfully');
                    window.location.href = '../public_html/frontend/templatesAdmons/registeradmin.php';
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

    
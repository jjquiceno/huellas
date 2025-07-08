<?php
    include "conexion.php"; 

    require_once '../helpers/Validator.php';
    
    // Validar y limpiar datos
    $username = Validator::sanitizeUsername($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

    // Validar contraseña
    if (!Validator::validatePassword($password)) {
        echo "
            <script>
                alert('La contraseña debe tener al menos 8 caracteres');
                window.history.back();
            </script>";
        exit;
    }

    // Validar email
    if (!Validator::validateEmail($email)) {
        echo "
            <script>
                alert('Email inválido');
                window.history.back();
            </script>";
        exit;
    }

    // Verificar si ya existe un usuario con estos datos
    $check_sql = "SELECT * FROM usuarios WHERE nombre_usuario = ? OR email = ? OR contraseña = ?";
    if ($check_stmt = $conexion->prepare($check_sql)) {
        $check_stmt->bind_param("sss", $username, $email, $password);
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

    if (!$username || !$email || !$password) {
        echo "
        <script>
            alert('All fields are required');
            window.history.back();
        </script>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre_usuario, email, contraseña) VALUES (?, ?, ?)";
        if ($stmt = $conexion->prepare($sql)) {
            // Vincular parámetros
            $stmt->bind_param("sss", $username, $email, $hashed_password);
            
            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "
                <script>
                    alert('New record created successfully');
                    window.location.href = '../public_html/frontend/templates/induccionacces.php';
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

    
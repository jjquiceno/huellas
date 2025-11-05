<?php
    include "conexion.php";

    require_once __DIR__ . '/../auth.php';
    require_once __DIR__ . '/../helpers/Validator.php';

    if ( $_SERVER["REQUEST_METHOD"] !== "POST" ) {
        header('HTTP/1.1 405 METHOD NOT ALLOWED');
        exit;
    }

    $auth = new Auth($conexion);

    // validar y limpiar los datos
    $nombre_usuario = Validator::sanitizeUsername($_POST["username"] ?? '');
    $password = $_POST['password'] ?? '';

    // verificar contraseña
    if (!Validator::validatePassword($password)) {
        echo "
            <script>
                alert('La contraseña debe tener al menos 8 caracteres');
                window.history.back();
            </script>
        ";
        exit; 
    }
    
    if ($auth->login($nombre_usuario, $password)) {
        header('Location: ../../frontend/templatesIntranet/succes.php');
        exit;
    } else {
        echo "
            <script>
                alert('Credenciales incorrectas');
                window.history.back();
            </script>
        ";
    }

    $conexion->close();
    exit;
?>
<?php
    include "../conexion.php";

    require_once "../../auth_jefes.php";
    require_once "../../helpers/Validator.php";

    if ( $_SERVER["REQUEST_METHOD"] !== "POST" ) {
        header('HTTP/1.1 405 METHOD NOT ALLOWED');
        exit;
    }

    $auth = new AuthJefes($conexion);

    // validar y limpiar los datos
    $nombre_usuario = $_POST["nombre_usuario"] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // verificar contraseña
    if (!Validator::validatePassword($contrasena)) {
        echo "
            <script>
                alert('La contraseña debe tener al menos 8 caracteres');
                window.history.back();
            </script>
        ";
        exit; 
    }
    
    if ($auth->loginJefes($nombre_usuario, $contrasena)) {
        header('Location: ../../public_html/frontend/templatesJefes/succes.php');
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
<?php
    require_once __DIR__.'/../config.php';
    require_once __DIR__.'/../auth_admons.php';

    // Crear instancia de Auth
    $auth = new AuthAdmons($conexion);

    // Verificar sesión
    if (!$auth->isLoggedInAdmons() || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        // Opcional: puedes destruir la sesión para mayor seguridad
        session_destroy();
        header("Location: ../templates/notAllowed.html");
        exit;
    }

    // Obtener información del usuario
    $user_id = $auth->getUserIdAdmons();

    // Cabeceras de seguridad
    header('X-Frame-Options: DENY');
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';");
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
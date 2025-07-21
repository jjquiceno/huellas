<?php
    require_once __DIR__.'/../config.php';
    require_once __DIR__.'/../auth.php';

    // Crear instancia de Auth
    $auth = new Auth($conexion);

    // Verificar sesión
    if (!$auth->isLoggedIn()) {
        header("Location: ../templates/notAllowed.html"); 
        exit;
    }

    // Obtener información del usuario
    $user_id = $auth->getUserId();

    // Cabeceras de seguridad
    header('X-Frame-Options: DENY');
    // header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';");
    // header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;");
    header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; font-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;");
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
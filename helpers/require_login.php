<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../auth.php';

// Crear instancia de Auth
$auth = new Auth($conexion);

// Verificar sesión
if (!$auth->isLoggedIn()) {
    header("Location: ../templates/induccionacces.php");
    exit;
}

// Obtener información del usuario
$user_id = $auth->getUserId();

// Cabeceras de seguridad
header('X-Frame-Options: DENY');
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';");
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
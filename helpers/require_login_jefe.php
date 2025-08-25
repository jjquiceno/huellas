<?php
    require_once __DIR__.'/../config.php';
    require_once __DIR__.'/../auth_jefes.php';

    $auth = new AuthJefes($conexion);

    // Verificar si la solicitud es una llamada AJAX
    $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

    if (!$auth->isLoggedInJefes() || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'jefe') {
        session_destroy();
        
        if ($is_ajax) {
            // Si es una solicitud AJAX, enviar una respuesta JSON de error
            http_response_code(401); // 401 Unauthorized
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Acceso no autorizado.']);
            exit;
        } else {
            // Si es una solicitud normal, redirigir a la página de error
            header("Location: ../templates/notAllowed.html");
            exit;
        }
    }

    $user_id = $auth->getUserIdJefes();

    // Cabeceras de seguridad (se envían solo si la autenticación es exitosa)
    header('X-Frame-Options: DENY');
    header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; font-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net;");
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
?>

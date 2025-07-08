<?php 
// configuracion de seguridad
ini_set('sesion.cookie_httponly', 1);
ini_set('sesion.use_only_cookies', 1);
ini_set('sesion.cookie_secure', 1);

ini_set('sesion.gc-maxlifetime', 1440);
ini_set('sesion.gc_divisor', 1);
ini_set('sesion.gc_probability', 1);

session_set_cookie_params([
    'lifetime' => 1440,
    'path' => '/',
    'domain' => '',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();

// validar si la sesion es nueva
if(isset($_COOKIE[session_name()]) && !isset($_SESSION['session_validated']) ){
    session_regenerate_id();
    $_SESSION['session_validated'] = true;
}

// función para verificar sesión 
function checkSession(){
    if(!isset($_SESSION['logedin']) || $_SESSION['logedin'] !== true){
        header('Location: public_html/frontend/templates/induccionacces.php');
        exit;
    }
}

// Funcion para verificar si es una solicitud AJAX
function isAjaxRequest(){
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}
?>
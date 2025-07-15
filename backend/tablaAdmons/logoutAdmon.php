<?php 
require_once '../../config.php';
require_once '../../auth_admons.php';

if (isAjaxRequest()) {
    header('content-type: application/json');
    session_destroy();
    echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente']);
    exit;
}

$auth = new AuthAdmons($conexion);
$auth->logoutAdmons();

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

header("Location: ../../public_html/frontend/templatesAdmons/adminLogin.php");
exit;
?>
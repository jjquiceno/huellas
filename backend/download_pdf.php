<?php
session_start();
require_once __DIR__ . '/fpdf/fpdf.php';
require_once __DIR__ . '/conexion.php'; // Ajusta si tu archivo de conexión tiene otro nombre

// Verifica si el usuario está logueado
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Debes iniciar sesión para descargar el PDF'); window.location.href='../public_html/frontend/templates/login.php';</script>";
    exit;
}

$user_name = $_SESSION['username'];

// Obtén los datos del usuario
$sql = "SELECT nombre_usuario, email FROM usuarios WHERE nombre_usuario = ?";
if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param('s', $user_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Error en la consulta de usuario');
}

if (!$user) {
    die('Usuario no encontrado');
}

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Datos del Usuario',0,1,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,10,'Nombre de usuario: ' . $user['nombre_usuario']);
$pdf->Ln(8);
$pdf->Cell(40,10,'Email: ' . $user['email']);

// Descargar el PDF
$pdf->Output('D', 'mis_datos.pdf');
exit;
?>

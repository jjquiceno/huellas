<?php
session_start();
require_once __DIR__ . '/fpdf/fpdf.php';
require_once __DIR__ . '/fpdi/src/autoload.php';
require_once __DIR__ . '/conexion.php'; // Ajusta si tu archivo de conexión tiene otro nombre

use setasign\Fpdi\Fpdi;

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

// Crear el PDF usando FPDI y la plantilla base
$pdf = new Fpdi();
$pdf->AddPage();

// Cargar el PDF base
$pdf->setSourceFile(__DIR__ . '/certificado1.pdf');
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0, 210); // 210mm = ancho A4

// Escribir los datos del usuario sobre la plantilla
$pdf->SetFont('Times','',12);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(9, 102); // Ajusta la posición según tu plantilla
$pdf->Cell(90,10,'CERTIFICA que el señor(a) ' . $user['nombre_usuario'] . ' con cedula número 1033180348,  labora con nosotros desde el 3 de febrero del 2025, con un contrato Término Fijo y devenga un salario mensual de $1,423,500 desempeñando el cargo de  CUIDADOR' );
$pdf->SetXY(60, 110);
$pdf->Cell(90,10,'Email: ' . $user['email']);

// Descargar el PDF
$pdf->Output('D', 'mis_datos.pdf');
exit;
?>

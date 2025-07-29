<?php
session_start();
require_once __DIR__ . '/../fpdf/fpdf.php';
require_once __DIR__ . '/../fpdi/src/autoload.php';
require_once __DIR__ . '/../conexion.php';

use setasign\Fpdi\Fpdi;
class CustomPDF extends Fpdi {
    function Header() {
        // Imagen de fondo que cubre toda la hoja A4
        $this->Image(__DIR__ . '/fondoF.jpg', 0, 0, 210, 297);
    }
}

// Verifica si el usuario está logueado
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Debes iniciar sesión para descargar el PDF'); window.location.href='../../public_html/frontend/templates/login.php';</script>";
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

// obtener los datos de la tabla empleado
$sql = 'SELECT identificacion, tipo_identificacion_id, nombre, fecha_nacimiento, fecha_ingreso, nombre_usuario, cargo_id, salario FROM empleados WHERE nombre_usuario = ?';
if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param('s', $user_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Error en la consulta de usuario');
}
if (!$empleado) {
    die('Usuario no encontrado');
}

// obtener los datos de cargo
$sql = 'SELECT * FROM cargos WHERE cargo_id = ?';
if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param('i', $empleado['cargo_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $cargo = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Error en la consulta de usuario');
}
if (!$cargo) {
    die('Usuario no encontrado');
}

// Crear el PDF usando FPDI y la plantilla base
$pdf = new CustomPDF();
$pdf->SetMargins(23, 50, 23);
$pdf->SetAutoPageBreak(true, 50); 
$pdf->AddPage();

// Escribir los datos del usuario sobre la plantilla
$pdf->SetFont('Times','',12);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(9, 108); // Ajusta la posición según tu plantilla
$pdf->MultiCell(190, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'CERTIFICA que el señor(a) ' . $empleado['nombre'] . 
    ' con cédula número ' . $empleado['identificacion'] . 
    ' labora con nosotros desde el ' . $empleado['fecha_ingreso'] . ' con un contrato Término Fijo y devenga un salario mensual de $' . $empleado['salario'] . ' desempeñando el cargo de ' . 
    $cargo['cargo']
));
$pdf->SetXY(9, 140); // Ajusta la posición según tu plantilla
$pdf->MultiCell(190, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'Si requiere alguna información adicional puede comunicarse al correo electrónico nomina@fundacionhuellasdelayer.com'
));
$pdf->SetXY(9, 170); // Ajusta la posición según tu plantilla
$pdf->MultiCell(190, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'Esta constancia se expide en la ciudad de Envigado el día ' . date('d/m/Y')
));


// Descargar el PDF
$pdf->Output('D', 'certificado-laboral.pdf');
exit;
?>

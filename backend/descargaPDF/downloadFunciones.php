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

// Verificacion y obtencion de datos del usuario
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Debes iniciar sesión para descargar el PDF'); window.location.href='../../public_html/frontend/templates/login.php';</script>";
    exit;
}
$user_name = $_SESSION['username'];
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

// Crear el PDF usando FPDI y la imagen de fondo
$pdf = new CustomPDF();
$pdf->SetMargins(23, 50, 23);
$pdf->SetAutoPageBreak(true, 50); 
$pdf->AddPage();

// Escribir los datos del usuario sobre la imagen de fondo
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(60, 50); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'LA FUNDACIÓN HUELLAS DEL AYER'
));
$pdf->SetXY(78.75, 60); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'NIT: 900.427.606-1'
));
$pdf->SetFont('Arial','',12);
$pdf->SetXY(23, 80); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'CERTIFICA que el señor(a) ' . $empleado['nombre'] . 
    ' con cédula número ' . $empleado['identificacion'] . 
    ' labora con nosotros desde el ' . $empleado['fecha_ingreso'] . ' con un contrato Término Fijo y devenga un salario mensual de $' . $empleado['salario'] . ' desempeñando el cargo de ' . 
    $cargo['cargo']
));
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(23, 100); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'FUNCIONES'
));
$pdf->SetFont('Arial','',12);
$pdf->SetXY(23, 110); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    $cargo['funciones'] . ''
));
$pdf->SetXY(23, 170); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'Si requiere alguna información adicional puede comunicarse al correo electrónico nomina@fundacionhuellasdelayer.com'
));
$pdf->SetXY(23, 185); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'Esta constancia se expide en la ciudad de Envigado el día ' . date('d/m/Y')
));
$pdf->SetXY(23, 195); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'Cordialmente,'
));
$pdf->Image(__DIR__ . '/firma1.jpg', 23, 202, 80); 
$pdf->SetXY(23, 225); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'EVELYN DAYANA BLANCO PARADA'
));
$pdf->SetXY(23, 230); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'TEL: 3113810363'
));
$pdf->SetXY(23, 235); 
$pdf->MultiCell(160, 5, iconv('UTF-8', 'windows-1252//TRANSLIT',
    'Coordinadora operativa programa cuidadoras de Envigado.'
));

// Descargar el PDF
$pdf->Output('D', __DIR__ . '/certificado-funciones.pdf');
exit;
?>

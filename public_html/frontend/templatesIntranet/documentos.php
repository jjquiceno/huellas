<?php
require_once '../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>hola desde documentos</h1>
    <div class="welcome-message">
        <p><a href="../templatesAdmons/register.php">ir al register</a></p>
        <p><a href="../templatesAdmonsregisterEmpleado.php">ir al register empleado</a></p>
        <!-- <p><a href="../../../backend/logout.php" class="logout-btn">Cerrar sesión</a></p> -->
        <?php
            if($_SESSION['tipo_contrato_id'] == 'CTV145'){
                echo '
                    <p><a href="../../../backend/descargaPDF/download_pdf.php" class="">CERTIFICADO SIN FUNCIONES</a></p>
                    <p><a href="../../../backend/descargaPDF/downloadFunciones.php" class="">CERTIFICADO CON FUNCIONES</a></p>
                ';
            }else if($_SESSION['tipo_contrato_id'] == 'CPS789'){
                echo '
                    <p><a href="../../../backend/descargaPDF/download_prestacion.php" class="">CERTIFICADO PRESTACION DE SERVICIOS</a></p>
                ';
            }
        ?>
    </div>
</body>
</html>
<?php
$conexion->close();
?>

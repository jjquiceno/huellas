<?php
// require_once '../../../config.php';
// require_once '../../../auth.php';
// $auth = new Auth($conexion);
// if (!$auth->isLoggedIn()) {
//     header("Location: ../templatesinduccionacces.php");
//     exit;
// }
// $user_id = $auth->getUserId();
require_once '../../../helpers/require_login.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';">
    <title>Página de Éxito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #4CAF50;
        }
        .welcome-message {
            margin: 20px 0;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #45a049;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="welcome-message">
        <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <p>Has iniciado sesión exitosamente.</p>
        <p>Tipo de contrato: <?php echo htmlspecialchars($_SESSION['tipo_contrato']); ?></p>
        <p>Término del contrato: <?php echo htmlspecialchars($_SESSION['termino_contrato']); ?></p>
        <p>Duración del contrato: <?php echo htmlspecialchars($_SESSION['duracion_contrato']); ?></p> 
        <p>Salario: <?php echo htmlspecialchars($_SESSION['salario']); ?></p>
        <p>Tipo de contrato ID: <?php echo htmlspecialchars($_SESSION['tipo_contrato_id']); ?></p>
        <p><a href="../templatesAdmons/register.php">ir al register</a></p>
        <p><a href="../templatesAdmonsregisterEmpleado.php">ir al register empleado</a></p>
        <!-- <p><a href="../../../backend/descargaPDF/download_pdf.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">CERTIFICADO SIN FUNCIONES</a></p>
        <p><a href="../../../backend/descargaPDF/downloadFunciones.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">CERTIFICADO CON FUNCIONES</a></p> -->
        <p><a href="../../../backend/logout.php" class="logout-btn">Cerrar sesión</a></p>
        <?php
            if($_SESSION['tipo_contrato_id'] == 'CTV145'){
                
                echo '
                    <p><a href="../../../backend/descargaPDF/download_pdf.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">CERTIFICADO SIN FUNCIONES</a></p>
                    <p><a href="../../../backend/descargaPDF/downloadFunciones.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">CERTIFICADO CON FUNCIONES</a></p>
                ';
            }else if($_SESSION['tipo_contrato_id'] == 'CPS789'){
                echo '
                    <p><a href="../../../backend/descargaPDF/download_prestacion.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">CERTIFICADO PRESTACION DE SERVICIOS</a></p>
                ';
            }
        ?>
    </div>
</body>
</html>
<?php
// Cerrar conexión
$conexion->close();
?>

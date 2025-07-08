<?php
require_once '../../../config.php';
require_once '../../../auth.php';

// Crear instancia de Auth
$auth = new Auth($conexion);

// Verificar sesión
if (!$auth->isLoggedIn()) {
    header("Location: induccionacces.php");
    exit;
}

// Obtener información del usuario
$user_id = $auth->getUserId();
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
        <p><a href="../../../backend/download_pdf.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">Descargar mis datos en PDF</a></p>
        <p><a href="../../../backend/logout.php" class="logout-btn">Cerrar sesión</a></p>
    </div>
</body>
</html>
<?php
// Cerrar conexión
$conexion->close();
?>

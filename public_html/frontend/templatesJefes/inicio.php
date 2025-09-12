<?php
require_once '../../../helpers/require_login_jefe.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1 class="regular x2">Bienvenido de vuelta <span class="bold" style="letter-spacing: 2px"><?php echo $_SESSION['username']; ?></span></h1>
</body>
</html>
<?php
$conexion->close();
?>

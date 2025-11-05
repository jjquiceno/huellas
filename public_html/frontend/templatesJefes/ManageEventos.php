<?php
require_once '../../../helpers/require_login_jefe.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/intranetHome.css">
    <link rel="stylesheet" href="../css/admonsHome.css">
    <title>Gestionar Eventos</title>
</head>
<body>
    <section class="dashboard">
        <div class="main-container">
            <div class="containerTables">
                <h2 class="bold textFi">Mis eventos publicados</h2>
                <div id="eventsContainer">
                    <div class="loading">Cargando eventos...</div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" defer></script>
    <script src="../js/jefes/manageEventos.js?v=20251014" defer></script>
</body>
</html>
<?php
$conexion->close();
?>

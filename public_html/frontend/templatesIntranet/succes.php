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
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';"> -->
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/intranetHome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Página de Éxito</title>
</head>
<body>
    <!-- <div class="welcome-message">
        <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <p>Has iniciado sesión exitosamente.</p>
        <p>Tipo de contrato: <?php echo htmlspecialchars($_SESSION['tipo_contrato']); ?></p>
        <p>Término del contrato: <?php echo htmlspecialchars($_SESSION['termino_contrato']); ?></p>
        <p>Duración del contrato: <?php echo htmlspecialchars($_SESSION['duracion_contrato']); ?></p> 
        <p>Salario: <?php echo htmlspecialchars($_SESSION['salario']); ?></p>
        <p>Tipo de contrato ID: <?php echo htmlspecialchars($_SESSION['tipo_contrato_id']); ?></p>
        <p><a href="../templatesAdmons/register.php">ir al register</a></p>
        <p><a href="../templatesAdmonsregisterEmpleado.php">ir al register empleado</a></p>
        <p><a href="../../../backend/logout.php" class="logout-btn">Cerrar sesión</a></p>
        <?php
            // if($_SESSION['tipo_contrato_id'] == 'CTV145'){

            //     echo '
            //         <p><a href="../../../backend/descargaPDF/download_pdf.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">CERTIFICADO SIN FUNCIONES</a></p>
            //         <p><a href="../../../backend/descargaPDF/downloadFunciones.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">CERTIFICADO CON FUNCIONES</a></p>
            //     ';
            // }else if($_SESSION['tipo_contrato_id'] == 'CPS789'){
            //     echo '
            //         <p><a href="../../../backend/descargaPDF/download_prestacion.php" class="logout-btn" style="background-color: #2196F3; margin-bottom: 10px;">CERTIFICADO PRESTACION DE SERVICIOS</a></p>
            //     ';
            // }
        ?>
    </div> -->
    <section class="dashboard">
        <div class="menu">
            <div class="menu-int">
                <div class="menuToggle">
                    <i class="fa-solid fa-xmark fa-2xl equis"></i>
                    <i class="fa-solid fa-bars fa-2xl lineas"></i>
                </div>
                <div class="separador"></div>
                <div class="boxItems">
                    <div class="menuItems_box">
                        <p class="ppp" referencia="induccion">
                            <i class="fa-solid fa-landmark"></i>
                            <span class="BLACK regular menu-item">Inducción</span>
                        </p>
                        <p class="ppp" referencia="documentos">
                            <i class="fa-regular fa-file"></i>
                            <span class="BLACK regular menu-item">Documentos<br>del empleado</span>
                        </p>
                        <p class="ppp" referencia="documentosReglamentarios">
                            <i class="fa-solid fa-book"></i>
                            <span class="BLACK regular menu-item">Documentos<br>reglamentarios</span>
                        </p>
                        <p class="ppp" referencia="novedades">
                            <i class="fa-regular fa-newspaper"></i>
                            <span class="BLACK regular menu-item">Novedades<br>en Huellas</span>
                        </p>
                        <p class="ppp" referencia="celebremos">
                            <i class="fa-solid fa-star"></i>
                            <span class="BLACK regular menu-item">Celebremos<br>tu día</span>
                        </p>
                    </div>
                    <div class="menuItems_box">
                        <div class="separador"></div>
                        <p class="ppp" referencia="ajustesPerfil">
                            <i class="fa-solid fa-user"></i>
                            <span class="BLACK regular menu-item">Ajustes<br>del perfil</span>
                        </p>
                        <p class="ppp" referencia="notificaciones">
                            <i class="fa-solid fa-bell"></i>
                            <span class="BLACK regular menu-item">Notificaciones</span>
                        </p>
                        <p class="ppp">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <a href="../../../backend/logout.php" class="BLACK regular menu-item">Cerrar sesión</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-container">
            <div class="main-header">
                
            </div>
            <div class="main-content-fetch">

            </div>
        </div>
    </section>
    <script>
        const menu = document.querySelector('.menu')
        const menuToggle = document.querySelector('.menuToggle')
        const menuItems = document.querySelectorAll('.menu-item')
        const equis = document.querySelector('.equis')
        const lineas = document.querySelector('.lineas')
        const ppp = document.querySelectorAll('.ppp')

        ppp.forEach(itemP => {
            itemP.addEventListener('click', () => {
                ppp.forEach(itemP => {
                    itemP.classList.remove('selected')
                })
                itemP.classList.add('selected')
                const referencia = itemP.getAttribute('referencia')
                fetch(`${referencia}.php`)
                    .then(response => response.text())
                    .then(data => {
                        document.querySelector('.main-content-fetch').innerHTML = data
                    })
            })
        })
        equis.style.opacity = '1'
        lineas.style.opacity = '0'

        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('active')
            if(menu.classList.contains('active')){
                equis.style.opacity = '0'
                lineas.style.opacity = '1'
            }else{
                equis.style.opacity = '1'
                lineas.style.opacity = '0' 
            }
            menuItems.forEach(item => {
                item.classList.toggle('disapear')
            })
            setTimeout(() => {
                menuItems.forEach(item => {
                    item.classList.toggle('dis')
                })
            }, 300);
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init()
    </script>
</body>
</html>
<?php
$conexion->close();
?>

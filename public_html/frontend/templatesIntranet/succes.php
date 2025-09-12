<?php
require_once '../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/intranetHome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Página de Éxito</title>
</head>
<body>
    <section class="dashboard">
        <div class="menu">
            <div class="menu-int">
                <div class="menuToggle" data-aos="fade-down">
                    <i class="fa-solid fa-xmark fa-2xl equis"></i>
                    <i class="fa-solid fa-bars fa-2xl lineas"></i>
                </div>
                <div class="separador"></div>
                <div class="boxItems">
                    <div class="menuItems_box">
                        <p class="ppp" referencia="inicio" data-aos="fade-down" data-aos-delay="100">
                            <i class="fa-solid fa-house"></i>
                            <span class="BLACK regular menu-item">Inicio</span>
                        </p>
                        <p class="ppp" referencia="induccion" data-aos="fade-down" data-aos-delay="200">
                            <i class="fa-solid fa-landmark"></i>
                            <span class="BLACK regular menu-item">Inducción</span>
                        </p>
                        <p class="ppp" referencia="documentos" data-aos="fade-down" data-aos-delay="300">
                            <i class="fa-solid fa-file"></i>
                            <span class="BLACK regular menu-item">Documentos<br>del empleado</span>
                        </p>
                        <p class="ppp" referencia="documentosReg" data-aos="fade-down" data-aos-delay="400">
                            <i class="fa-solid fa-book"></i>
                            <span class="BLACK regular menu-item">Documentos<br>reglamentarios</span>
                        </p>
                        <p class="ppp" referencia="novedades" data-aos="fade-down" data-aos-delay="500">
                            <i class="fa-solid fa-newspaper"></i>
                            <span class="BLACK regular menu-item">Novedades<br>en Huellas</span>
                        </p>
                        <p class="ppp" referencia="cuponera" data-aos="fade-down" data-aos-delay="600">
                            <i class="fa-solid fa-ticket"></i>
                            <span class="BLACK regular menu-item">Cuponera</span>
                        </p>
                    </div>
                    <div class="menuItems_box">
                        <div class="separador"></div>
                        <!-- <p class="ppp" referencia="ajustesPerfil">
                            <i class="fa-solid fa-user"></i>
                            <span class="BLACK regular menu-item">Ajustes<br>del perfil</span>
                        </p> -->
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
                <div class="container-searchBar" data-aos="fade-down" data-aos-delay="100">
                    <div class="info-message" data-validate = "La identificacion es requerida">
                        <input class="caja_text regular" type="text" name="buscador" required>
                        <label class="label lightI" for="buscador"><i class="fa-solid fa-magnifying-glass fa-lg"></i></label>
                    </div>
                </div>
                <div class="container-user">
                    <div class="legend">
                        <i class="fa-solid fa-circle-user fa-2xl" style="color: #f2ca00;" data-aos="fade-down" data-aos-delay="200"></i>
                    </div>
                    <div class="user-info">
                        <div class="user">
                            <span class="BLACK regular" data-aos="fade-down" data-aos-delay="300"><?php echo $_SESSION['username']; ?></span>
                        </div>
                        <div class="user">
                            <span class="BLACK regular" data-aos="fade-down" data-aos-delay="400"><?php echo isset($_SESSION['cargo']) ? htmlspecialchars($_SESSION['cargo']) : 'Cargo no especificado'; ?></span>
                        </div>
                    </div>
                    <div class="arrow">
                        <i class="fa-solid fa-angle-down fa-xl arrow-icon"></i>
                    </div>
                    <div class="user-absolute">
                        <div>
                            <p class="ppp" referencia="userProfile">
                                <i class="fa-solid fa-user"></i>
                                <span class="BLACK regular menu-item">Mi perfil</span>
                            </p>
                            <p class="ppp" referencia="ajustesPerfil">
                                <i class="fa-solid fa-user"></i>
                                <span class="BLACK regular menu-item ppp" referencia="ajustesPerfil">Ajustes</span>
                            </p>
                            <div class="separador-op"></div>
                            <p class="ppp">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <a href="../../../backend/logout.php" class="BLACK regular menu-item">Cerrar sesión</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="logoH">
                    <img style="width: 5vw;" src="../img/logos/LOGO HUELLAS.png" alt="logo">
                </div>
            </div>
            <div class="main-content-fetch">

            </div>
        </div>
    </section>
    <script src="../js/empleados/succes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init()
    </script>
</body>
</html>
<?php
$conexion->close();
?>

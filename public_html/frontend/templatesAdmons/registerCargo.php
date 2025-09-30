<?php
require_once __DIR__. '/../../../helpers/require_login_admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';"> -->
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/intranetHome.css">
    <link rel="stylesheet" href="../css/admonsHome.css">
    <!-- <link rel="stylesheet" href="../css/induccionacces.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Página de Éxito</title>
</head>
<body>
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
                        <a href="succes.php" class="ppp2">
                            <i class="fa-solid fa-house"></i>
                            <span class="BLACK regular menu-item">Registrar un empleado nuevo</span>
                        </a>
                        <a href="registerJefe.php" class="ppp2">
                            <i class="fa-solid fa-house"></i>
                            <span class="BLACK regular menu-item">Registrar un líder nuevo</span>
                        </a>
                        <a href="registerCargo.php" class="ppp2">
                            <i class="fa-solid fa-house"></i>
                            <span class="BLACK regular menu-item">Registrar un cargo nuevo</span>
                        </a>
                        <a href="empleadosCRUD.php" class="ppp2">
                            <i class="fa-solid fa-database"></i>
                            <span class="BLACK regular menu-item">ver tabla de empleados</span>
                        </a>
                        <a href="rolesCRUD.php" class="ppp2">
                            <i class="fa-solid fa-database"></i>
                            <span class="BLACK regular menu-item">ver tabla de roles</span>
                        </a>
                        <a href="usuariosCRUD.php" class="ppp2">
                            <i class="fa-solid fa-database"></i>
                            <span class="BLACK regular menu-item">ver tabla de usuarios</span>
                        </a>
                        <a href="lideresCRUD.php" class="ppp2">
                            <i class="fa-solid fa-database"></i>
                            <span class="BLACK regular menu-item">ver tabla de líderes</span>
                        </a>
                    </div>
                    <div class="menuItems_box">
                        <div class="separador"></div>
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
                <div class="container-user">
                    <div class="legend">
                        <i class="fa-solid fa-circle-user fa-2xl" style="color: #f2ca00;"></i>
                    </div>
                    <div class="user-info">
                        <div class="user">
                            <span class="BLACK regular"><?php echo $_SESSION['username']; ?></span>
                        </div>
                        <div class="user">
                            <span class="BLACK regular"><?php echo $_SESSION['rol']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="logoH">
                    <img style="width: 5vw;" src="../img/logos/LOGO HUELLAS.png" alt="logo">
                </div>
            </div>
            <div class="main-content-fetch">
                <div class="form-container">
                    <form id="registerCargo" class="form_form">
                        <div class="titule">
                            <h3 class="bold" style="width: fit-content; margin: auto;">REGISTRA UN CARGO</h3>
                        </div>
                        <div class="info-message" data-validate="El password es necesario">
                            <input class="caja_text regular" type="text" name="cargo" id="cargo" required>
                            <label class="label lightI" for="cargo">cargo</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="El correo es necesario">
                            <input class="caja_text regular" type="text" name="funciones" id="funciones" required>
                            <label class="label lightI" for="funciones">funciones</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="e-b ">
                            <button type="submit" class="enviar bold">enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/administradores/succesAdmonsCRUDS.js"></script>
    <script src="../js/administradores/registerCargo.js"></script>
</body>
</html>
<?php
$conexion->close();
?>



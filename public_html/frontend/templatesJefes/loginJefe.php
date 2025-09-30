<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario de ingreso a la inducción de la Fundación Huellas del Ayer. Si vas a trabajar con nosotros, completa tu inducción aquí.">
    <meta name="keywords" content="inducción, ingreso, Fundación Huellas del Ayer, trabajar, empleados, formulario, acceso, bienestar">
    <meta name="author" content="Fundación Huellas del Ayer">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#f2ca007c">
    <meta property="og:title" content="Acceso a Inducción - Fundación Huellas del Ayer">
    <meta property="og:description" content="Si vas a trabajar con nosotros, completa tu ingreso a la inducción en este formulario. Fundación Huellas del Ayer.">
    <meta property="og:image" content="https://www.fundacionhuellasdelayer.com/frontend/img/logos/LOGO%20HUELLAS.png">
    <meta property="og:url" content="https://www.fundacionhuellasdelayer.com/frontend/templates/induccionacces.php">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Fundación Huellas del Ayer">
    <meta property="og:locale" content="es_CO">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="Logo de la Fundación Huellas del Ayer">
    <meta property="og:image:secure_url" content="https://www.fundacionhuellasdelayer.com/frontend/img/logos/LOGO%20HUELLAS.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Acceso a Inducción - Fundación Huellas del Ayer">
    <meta name="twitter:description" content="Completa el formulario para ingresar a tu inducción como parte del equipo de la Fundación Huellas del Ayer.">
    <meta name="twitter:image" content="https://www.fundacionhuellasdelayer.com/frontend/img/logos/LOGO%20HUELLAS.png">
    <meta name="twitter:image:alt" content="Logo de la Fundación Huellas del Ayer">
    <link rel="icon" href="../img/logos/LOGO HUELLAS.png">
    <title>ACCESO - ADMINISTRADORES</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/induccionacces.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <section class="container" style="position: relative;">
        <div class="botonfloat">
            <a href="../templates/loginOptions.html" class="regular x1-5">Regresar</a>
        </div>
        <div class="append-content">
            <div class="form-padre">
                <div class="form-padre-info">
                    <div>
                        <div class="separador-corto"></div>
                        <br>
                        <div class="separador"></div>
                        <br>
                        <p class="bold x3 WHITE" style="text-align: center;">¡INGRESA COMO LÍDER!</p>
                        <br>
                        <div class="separador"></div>
                        <br>
                        <div class="separador-corto"></div>
                    </div>
                </div>
                <div class="form">
                    <form method="post" class="form_form" action="../../../backend/tablaJefes/loginJefe.php">
                        <div class="titule">
                            <h3 class="bold WHITE" style="width: fit-content; margin: auto;">INGRESA</h3>
                        </div>
                        <div class="info-message" data-validate = "El nombre es requerido">
                            <input class="caja_text regular" type="text" name="nombre_usuario" required>
                            <label class="label lightI" for="nombre">usuario</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="El corrreo es necesario">
                            <input class="caja_text regular" type="password" name="contrasena" required>
                            <label class="label lightI" for="contrasena">contraseña</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="e-b">
                            <input type="submit" value="enviar" name="enviar" class="enviar bold">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init()
    </script>
</body>
</html>
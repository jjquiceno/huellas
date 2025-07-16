<?php
require_once __DIR__. '/../../../helpers/require_login_admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="../img/logos/LOGO HUELLAS.png">
    <title>REGISTRAR USUARIOS</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/induccionacces.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <section class="container">
        <div class="home">
            <div class="home-texts">
                <div class="separador-corto"></div>
                <br>
                <p class="black x2">REGISTRAR USUARIOS</p>
                <br>
                <div class="separador"></div>
                <br>
                <P class="regular x1-5">INGRESA LOS DATOS DEL USUARIO</P>
                <br>
                <div class="separador-corto"></div>
            </div>
        </div>
        
        <div class="append-content" style="height: fit-content;">
            <div class="form-padre" style="width: 100%; height: fit-content; padding: 7vh 0;">
                <div class="form" style="width: 100%;">
                    <form method="post" class="form_form" action="../../../backend/register.php">
                        <div class="titule">
                            <h3 class="bold WHITE" style="width: fit-content; margin: auto;">REGISTRA UN USUARIO</h3>
                        </div>
                        <div class="info-message" data-validate = "El nombre es requerido">
                            <input class="caja_text regular" type="text" name="username" id="username" required>
                            <label class="label lightI" for="username">Nombre de usuario</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="El password es necesario">
                            <input class="caja_text regular" type="text" name="password" id="password" required>
                            <label class="label lightI" for="password">contraseña</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="El correo es necesario">
                            <input class="caja_text regular" type="text" name="email" id="email" required>
                            <label class="label lightI" for="email">correo</label>
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

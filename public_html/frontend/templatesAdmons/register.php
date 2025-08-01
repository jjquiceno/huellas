<?php
require_once __DIR__. '/../../../helpers/require_login_admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<body>  
    <div class="form-container">
        <form method="post" class="form_form" action="../../../backend/register.php">
            <div class="titule">
                <h3 class="bold" style="width: fit-content; margin: auto;">REGISTRA UN USUARIO</h3>
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
</body>
</html>
<?php
$conexion->close();
?>


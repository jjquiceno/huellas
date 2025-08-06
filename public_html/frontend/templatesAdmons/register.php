<?php
require_once __DIR__. '/../../../helpers/require_login_admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<body>  
    <div class="form-container">
        <form id="registerForm" class="form_form">
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
            <div class="e-b ">
                <button type="submit" class="enviar bold">enviar</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
$conexion->close();
?>
<!-- <script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
        const response = await fetch('../../../backend/register.php', {
            method: 'POST',
            body: formData
        });
        const resultText = await response.text();
        // Ejecuta el alert del backend si lo hay
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = resultText;
        const alertScript = tempDiv.querySelector('script');
        if (alertScript) {
            eval(alertScript.textContent);
        }
        // Si el registro fue exitoso, carga la página de empleados
        if (resultText.includes('New record created successfully')) {
            fetch('registerEmpleado.php')
                .then(res => res.text())
                .then(data => {
                    document.querySelector('.main-content-fetch').innerHTML = data;
                    // Si necesitas cargar JS adicional, hazlo aquí
                });
        }
    } catch (error) {
        alert('Error al enviar el formulario');
    }
});
</script> -->


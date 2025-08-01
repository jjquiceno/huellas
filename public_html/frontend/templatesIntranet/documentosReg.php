<?php
require_once '../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <div class="tittleFetch" data-aos="fade-down" data-aos-delay="100">
        <h1 class="regular x2">Consulta nuestros documentos Reglamentarios</h1>
        <div class="separador-black"></div>
        <p class="light x1-5">Consulta nuestras politicas y nuestro reglamento interno del trabajo</p>
    </div>
    <div class="containerReg" data-aos="fade-down" data-aos-delay="200">
        <div class="btns">
            <div class="btn-document" data-log="REGLAMENTOINTERNO">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Reglamento Interno del trabajo</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="separador-black"></div>
            <div class="btn-document" data-log="001">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de Alcohol y Drogas</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="002">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de Seguridad y Salud en el trabajo</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="003">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de Desconexión Laboral</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="004">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica contra el acoso laboral</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="005">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de prevención y atención al acoso sexual</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="006">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de Bienestar</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="007">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de vacaciones</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="008">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de permisos, ausencias y licencias</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="009">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de comunicacion interna</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="010">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Poltitica de seguridad de la informacion</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="011">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica de igualdad y diversidad</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
            <div class="btn-document" data-log="012">
                <i class="fa-solid fa-file-invoice fa-2xl"></i>
                <p class="black x1">Politica ambiental</p>
                <i class="fa-solid fa-angle-left angleD fa-lg"></i>
            </div>
        </div>
        <div class="visor">
            <iframe 
                class="pdf-viewer"
                src=""  
            ></iframe>
        </div>
    </div>
</body>
</html>
<?php
$conexion->close();
?>

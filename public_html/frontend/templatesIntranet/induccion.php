<?php
require_once '../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="tittleFetch" data-aos="fade-down" data-aos-delay="100">
        <h1 class="regular x2">Que quieres aprender hoy?</h1>
        <div class="separador-black"></div>
        <p class="light x1-5">haz tu induccion</p>
    </div>
    <div class="container-int relativeC">
        <div class="certificados-box">
            <div class="separador-izquierdo-black"></div>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <div class="botones" style="display: flex; flex-direction: column; align-items: center;">
                        <a class="download-btn" href="formato-induccion/induccion-general.php">
                            <i class="fa-solid fa-book-tanakh"></i>
                            <p class="regular x1">Induccion General</p>
                        </a>
                        <br>
                        <a class="download-btn" href="">
                            <i class="fa-solid fa-book-tanakh"></i>
                            <p class="regular x1">Induccion algo</p>
                        </a>
                        <br>
                        <a class="download-btn" href="">
                            <i class="fa-solid fa-book-tanakh"></i>
                            <p class="regular x1">Induccion al cargo</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conexion->close();
?>

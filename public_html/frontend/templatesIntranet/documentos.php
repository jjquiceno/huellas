<?php
require_once '../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <div class="tittleFetch">
        <h1 class="regular x2">Bienvenido <span class="black" style="letter-spacing: 2px"><?php echo $_SESSION['username']; ?></span></h1>
        <div class="separador-black"></div>
        <p class="light x1-5">Consulta tus documentos laborales</p>
    </div>
    <div class="container">
        <div class="container-int">
            <p class="light">Aqui puedes consultar, visualizar y descargar tus certificados laborales tanto como prestador de servicios o como vinculado, asi mismo puedes descargar tus colillas de pago y mantenerte al dia.</p>
        </div>
        <div class="container-int relativeC">
            <div class="certificados-box">
                <p class="bold x1-5">CERTIFICADOS LABORALES</p>
                <div class="separador-izquierdo-black"></div>
                <?php 
                    if($_SESSION['tipo_contrato_id'] == 'CTV145'){
                        echo '
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <p class="regular x1" style="width: 80%; text-align: center;">Descarga tus certificados laborales como vinculado</p>
                            <br>
                            <div class="botones" style="display: flex; flex-direction: column; align-items: center;">
                                <a class="download-btn" href="../../../backend/descargaPDF/download_pdf.php">
                                    <i class="fa-solid fa-file-pdf fa-xl"></i>
                                    <p class="regular x1">Descargar sin funciones</p>
                                </a>
                                <br>
                                <a class="download-btn" href="../../../backend/descargaPDF/downloadFunciones.php">
                                    <i class="fa-solid fa-file-pdf fa-xl"></i>
                                    <p class="regular x1">Descargar con funciones</p>
                                </a>
                            </div>
                        </div>
                        ';
                    }else if($_SESSION['tipo_contrato_id'] == 'CPS789'){ 
                        echo '
                        <div style="border: solid black; display: flex; flex-direction: column; align-items: center;">
                            <p class="regular x1" style="width: 80%; text-align: center;">Descarga tus certificados laborales como prestador de servicios</p>
                            <br>
                            <div class="botones" style="display: flex; flex-direction: column; align-items: center;">
                                <a class="download-btn" href="../../../backend/descargaPDF/download_prestacion.php">
                                    <i class="fa-solid fa-file-pdf fa-xl"></i>
                                    <p class="regular x1">Descargar sin actividades</p>
                                </a>
                                <br>
                                <a class="download-btn" href="../../../backend/descargaPDF/download_prestacion.php">
                                    <i class="fa-solid fa-file-pdf fa-xl"></i>
                                    <p class="regular x1">Descargar con actividades</p>
                                </a>
                            </div>
                        </div>
                        
                        ';
                    }
                ?>
            </div>
            <!-- <div class="colillas-box">
                <p class="bold x1-5">COLILLAS DE PAGO</p>
                <div class="separador-izquierdo-black"></div>
                <p class="regular x1" style="width: 80%; text-align: center;">Descarga tus colillas de pago</p>
                <br>
                <div class="download-btn colillas-btn">
                    <i class="fa-solid fa-file-pdf fa-xl"></i>
                    <p class="regular x1">Descargar</p>
                </div>
            </div> -->
        </div>
        
    </div>
    <!-- <div class="formColillasContainer">
        <div class="formColillas">
            <div class="formCheader">
                <div>
                    <i class="fa-solid fa-xmark fa-2xl closeCform"></i>
                </div>
                <div>
                    <p class="bold x1-5">FORMULARIO DE COLILLA</p>
                </div>
                <div style="width: 10%;">

                </div>
            </div>
            <div class="formCform">
                <form class="formF" action="../../../backend/descargaPDF/download_colilla.php">
                    <div>
                        <label for=""></label>
                        <input type="text">
                    </div>
                    <div>
                        <label for=""></label>
                        <input type="text">
                    </div>
                    <div>
                        <label for=""></label>
                        <input type="text">
                    </div>
                    <div>
                        <label for=""></label>
                        <input type="text">
                    </div>
                    <button type="submit">Descargar</button>
                </form>
            </div>
        </div>
    </div>   -->
    <!-- <script src="../js/cform.js"></script> -->
</body>
</html>
<?php
$conexion->close();
?>

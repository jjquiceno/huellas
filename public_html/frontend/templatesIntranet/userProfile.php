<?php
require_once '../../../helpers/require_login.php';
?>
<div class="perfil-container">
    <div class="perfil-header">
        <div class="perfil-info">
            <div class="avatar">
                <i class="fa-solid fa-circle-user fa-4x" style="color: #f2ca00;"></i>
                <div class="tipo_perfil bold"><?php echo htmlspecialchars($_SESSION['rol']); ?></div>
            </div>
            <br>
            <div class="info-usuario">
                <div class="info-item">
                    <h3>Nombre completo</h3>
                    <p><?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
                </div>
                <div class="info-item">
                    <h3>Nombre usuario</h3>
                    <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
                </div>
                <div class="info-item">
                    <h3>Correo</h3>
                    <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                </div>       
                <div class="info-item">
                    <h3>Cargo</h3>
                    <p><?php echo htmlspecialchars($_SESSION['cargo']); ?></p>
                </div>
                <div class="info-item">
                    <h3>Tipo de contrato</h3>
                    <p><?php echo htmlspecialchars($_SESSION['tipo_contrato']); ?></p>
                </div>
                <?php if(isset($_SESSION['termino_contrato'])): ?>
                    <div class="info-item">
                        <h3>Término del contrato</h3>
                        <p><?php echo htmlspecialchars($_SESSION['termino_contrato']); ?></p>
                    </div>
                <?php endif; ?>
                <div class="info-item">
                    <h3>Fecha de nacimiento</h3>
                    <p><?php echo htmlspecialchars($_SESSION['fecha_nacimiento']); ?></p>
                </div>
                <div class="info-item">
                    <h3>Fecha de inicio</h3>
                    <p><?php echo htmlspecialchars($_SESSION['fecha_ingreso']); ?></p>
                </div>
                <div class="info-item">
                    <h3>Identificación</h3>
                    <p><?php echo htmlspecialchars($_SESSION['identificacion']); ?></p>
                </div>
                <div class="info-item">
                    <h3>Salario</h3>
                    <p><?php echo htmlspecialchars($_SESSION['salario']); ?></p>
                </div>
            </div>
        </div>
        
        <div class="certificados-section">
            <br>
            <h3 class="regular x15">Certificados Disponibles</h3>
        
            <div class="certificados-buttons">
                <?php
                if($_SESSION['tipo_contrato_id'] == 'CTV145'){
                    echo '
                        <a href="../../../backend/descargaPDF/download_pdf.php" class="download-btn regular">
                            <i class="fa-solid fa-file-pdf"></i>
                            Certificado sin funciones
                        </a>
                        <br>
                        <a href="../../../backend/descargaPDF/downloadFunciones.php" class="download-btn regular">
                            <i class="fa-solid fa-file-pdf"></i>
                            Certificado con funciones
                        </a>
                    ';
                } else if($_SESSION['tipo_contrato_id'] == 'CPS789'){
                    echo '
                        <a href="../../../backend/descargaPDF/download_prestacion.php" class="download-btn regular">
                            <i class="fa-solid fa-file-pdf"></i>
                            Certificado prestación de servicios
                        </a>
                    ';
                }
                ?>
            </div>
        </div>
        <div class="certificado-induccion">
            <br>
            <h3 class="regular x15">Certificados de inducción</h3>
            <?php
            if($_SESSION['induccionGeneral'] == 'si'){
                echo '
                    <a href="../../../backend/descargaPDF/downloadCertificadoGeneral.php" class="download-btn regular">
                        <i class="fa-solid fa-file-pdf"></i>
                        Certificado de inducción General
                    </a>
                    ' . $_SESSION['induccionGeneral'] . '
                    
                ';
            } else {
                echo '
                    <p class="regular x15">Aún no tienes certificado de inducción General, realizalo cuanto antes</p>
                    <a href="formato-induccion/induccion-general.php" class="download-btn regular">
                        <i class="fa-solid fa-file-pdf"></i>
                        Realizar inducción General
                    </a>
                ';
            }
            ?>
        </div>
    </div>
</div>
<?php
$conexion->close();
?>
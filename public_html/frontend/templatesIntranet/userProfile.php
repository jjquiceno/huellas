<?php
require_once '../../../helpers/require_login.php';
?>
<div class="perfil-container">
    <div class="perfil-header">
        <div class="perfil-info">
            <div class="avatar">
                <i class="fa-solid fa-circle-user fa-4x" style="color: #f2ca00;"></i>
            </div>
            <div class="info-usuario">
                <h2 class="regular x2"><?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                <p class="regular"><?php echo htmlspecialchars($_SESSION['cargo']); ?></p>
                <p class="regular">Tipo de contrato: <?php echo htmlspecialchars($_SESSION['tipo_contrato']); ?></p>
                <?php if(isset($_SESSION['termino_contrato'])): ?>
                    <p class="regular">Término del contrato: <?php echo htmlspecialchars($_SESSION['termino_contrato']); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="certificados-section">
            <h3 class="regular x15">Certificados Disponibles</h3>
            <div class="certificados-buttons">
                <?php
                if($_SESSION['tipo_contrato_id'] == 'CTV145'){
                    echo '
                        <a href="../../../backend/descargaPDF/download_pdf.php" class="btn-certificado">
                            <i class="fa-solid fa-file-pdf"></i>
                            Certificado sin funciones
                        </a>
                        <a href="../../../backend/descargaPDF/downloadFunciones.php" class="btn-certificado">
                            <i class="fa-solid fa-file-pdf"></i>
                            Certificado con funciones
                        </a>
                    ';
                } else if($_SESSION['tipo_contrato_id'] == 'CPS789'){
                    echo '
                        <a href="../../../backend/descargaPDF/download_prestacion.php" class="btn-certificado">
                            <i class="fa-solid fa-file-pdf"></i>
                            Certificado prestación de servicios
                        </a>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$conexion->close();
?>
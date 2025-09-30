<?php
require_once '../../../helpers/require_login.php';
require_once '../../../helpers/youtube_to_embed.php';
?>
<div class="cursos-container">
    <h1>Cursos y videos</h1>
    <div class="separador-black"></div>
    <p>Realizar una pausa activa</p>
    <iframe width="560" height="315" src="<?php echo htmlspecialchars($embedSrc, ENT_QUOTES, 'UTF-8'); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</div>
<?php
$conexion->close();
?>
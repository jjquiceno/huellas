<?php
require_once '../../../helpers/require_login_jefe.php';
?>
<div class="inicio-wrapper">
    <h1 class="regular x2">Bienvenido de vuelta <span class="bold" style="letter-spacing: 2px"><?php echo $_SESSION['username']; ?></span></h1>
    <p class="regular x1-5" style="padding: 10px; border-radius: 10px; width: fit-content; background-color:rgba(242, 202, 0, 0.16);">¿Qué deseas hacer hoy?</p>

    <!-- Accesos rápidos -->
    <div class="tittleFetch" style="margin-top:20px;">
        <h2 class="regular x2">Empieza el día con una sonrisa</h2>
    </div>

    <!-- Resumen -->
    <div class="tittleFetch" style="margin-top:20px;">
        <h2 class="regular x2">Resumen</h2>
    </div>

    <div class="container" style="width:100%;">
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:20px;width:100%;">
            <!-- Notificaciones -->
            <section id="inicio-notificaciones" style="background:#fffbe7;border-radius:15px;padding:1rem;box-shadow:0 2px 10px #f2ca0033;">
                <h3 class="bold">Últimas notificaciones</h3>
                <div class="lista" style="display:flex;flex-direction:column;gap:8px;margin-top:8px;">
                    <div class="regular">Cargando notificaciones...</div>
                </div>
                <div style="margin-top:8px;">
                    <a class="btn-document" href="notificaciones.php"><i class="fa-solid fa-bell"></i> Ver todas</a>
                </div>
            </section>

            <!-- Novedades -->
            <section id="inicio-novedades" style="background:#fffbe7;border-radius:15px;padding:1rem;box-shadow:0 2px 10px #f2ca0033;">
                <h3 class="bold">Novedades recientes</h3>
                <div class="lista-eventos" style="margin-top:8px;">
                    <div class="cargando">Cargando novedades...</div>
                </div>
                <div style="margin-top:8px;">
                    <a class="btn-document" href="novedades.php"><i class="fa-solid fa-newspaper"></i> Ver todas</a>
                </div>
            </section>

            <!-- Cupones -->
            <section id="inicio-cupones-resumen" style="background:#fffbe7;border-radius:15px;padding:1rem;box-shadow:0 2px 10px #f2ca0033;">
                <h3 class="bold">Cupones</h3>
                <div class="regular" id="cupones-resumen-datos" style="margin-top:8px;">Cargando cupones...</div>
                <div style="margin-top:8px;">
                    <a class="btn-document" href="cuponera.php"><i class="fa-solid fa-ticket"></i> Ir a cuponera</a>
                </div>
            </section>
        </div>
    </div>
</div>
<?php
$conexion->close();
?>

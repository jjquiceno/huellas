<?php
require_once '../../../helpers/require_login_jefe.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="cuponera-container">
        <h2 class="regular x2">Gestión de Cupones</h2>

        <section id="listado">
            <div style="display:flex;gap:10px;align-items:center">
                <button id="btnRefrescar" class="btn">Refrescar</button>
                <label><input type="checkbox" id="soloActivos" checked> Solo activos</label>
            </div>
            <div id="listaCupones" class="grid"></div>
        </section>

        <section id="crear">
            <h3>Crear cupón</h3>
            <form id="formCrear">
                <input name="title" placeholder="Título" required />
                <textarea name="description" placeholder="Descripción"></textarea>
                <input type="date" name="start_at" />
                <input type="date" name="end_at" />
                <input type="number" name="max_global_redemptions" placeholder="Máx. global (vacío = ilimitado)" />
                <input type="number" name="per_user_limit" placeholder="Límite por usuario (vacío = ilimitado)" />
                <label><input type="checkbox" name="active" checked /> Activo</label>
                <button type="submit" class="btn">Crear</button>
                <span id="msgCrear"></span>
            </form>
        </section>

        <section id="asignar">
            <h3>Asignar a empleado</h3>
            <form id="formAsignar">
                <input type="number" name="coupon_id" placeholder="ID cupón" required />
                <input type="number" name="empleado_id" placeholder="ID empleado" required />
                <input type="date" name="expires_at" />
                <button type="submit" class="btn">Asignar</button>
                <span id="msgAsignar"></span>
            </form>
        </section>

        <section id="redimir">
            <h3>Redimir</h3>
            <form id="formRedimir">
                <input type="number" name="coupon_id" placeholder="ID cupón" required />
                <input type="number" name="empleado_id" placeholder="ID empleado" required />
                <button type="submit" class="btn">Redimir</button>
                <span id="msgRedimir"></span>
            </form>
        </section>
    </div>
</body>
</html>
<?php
$conexion->close();
?>

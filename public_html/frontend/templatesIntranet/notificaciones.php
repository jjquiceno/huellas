<?php
require_once '../../../helpers/require_login.php';
?>
<div class="cuponera-container">
    <h2 class="regular x2">Notificaciones</h2>
    <div id="notifEmpMsg" class="regular" style="margin:8px 0;color:#555"></div>
    <div style="display:flex;gap:10px;align-items:center;margin-bottom:10px">
        <button id="btnRefrescarNotisEmp" class="btn">Refrescar</button>
        <button id="btnMarcarTodasEmp" class="btn">Marcar todas como leídas</button>
    </div>
    <div id="listaNotisEmp" class="grid"></div>
</div>
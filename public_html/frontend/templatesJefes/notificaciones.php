<?php
require_once '../../../helpers/require_login_jefe.php';
?>
<div class="cuponera-container">
  <h2 class="regular x2">Solicitudes de redención</h2>
  <div id="notifMsg" class="regular" style="margin:8px 0;color:#555"></div>
  <div style="display:flex;gap:10px;align-items:center;margin-bottom:10px">
    <button id="btnRefrescarSolicitudes" class="btn">Refrescar</button>
  </div>
  <div id="listaSolicitudes" class="grid"></div>
</div>

<?php
require_once '../../../helpers/require_login.php';
?>
<!-- <div class="cuponera-container">
    <h2 class="regular x2">Cuponera de Beneficios</h2>
    
    <div class="lista-cupones">
        <div class="cupon-card">
            <div class="cupon-encabezado">
                <div class="descuento">Día de la familia</div>
                <div class="validez">Válido hasta: 30/11/2023</div>
            </div>
            <div class="cupon-contenido">
                <h3 class="cupon-titulo">Día de la familia</h3>
                <p class="cupon-descripcion">Pasa un dia con tus seres queridos</p>
                <div class="cupon-empresa">Dia completo de descanso</div>
                <button class="btn-cupon" disabled>Redimir cupón</button>
            </div>
        </div>
        <div class="cupon-card destacado">
            <div class="cupon-encabezado">
                <div class="descuento">Cumpleaños</div>
                <div class="validez">Válido hasta: 15/12/2023</div>
            </div>
            <div class="cupon-contenido">
                <h3 class="cupon-titulo">Cumpleaños</h3>
                <p class="cupon-descripcion">Pasa un dia con tus seres queridos</p>
                <div class="cupon-empresa">Medio dia de descanso</div>
                <button class="btn-cupon" disabled>Redimir cupón</button>
            </div>
        </div>
        <div class="cupon-card">
            <div class="cupon-encabezado">
                <div class="descuento">Amor y Amistad</div>
                <div class="validez">Válido hasta: 31/12/2023</div>
            </div>
            <div class="cupon-contenido">
                <h3 class="cupon-titulo">Amor y Amistad</h3>
                <p class="cupon-descripcion">Pasa un dia con tus seres queridos</p>
                <div class="cupon-empresa">Medio dia de descanso</div>
                <button class="btn-cupon">Redimir cupón</button>
            </div>
        </div>
    </div>
</div> -->
<div class="cuponera-emp-container">
    <h2 class="regular x2">Mis cupones</h2>
    <div id="listaCuponesEmp" class="grid-cupones-emp">
        <!-- <div class="cargando">Cargando cupones...</div> -->
    </div>
    <p class="nota">Para redimir, acércate con tu jefe. Si un cupón no está disponible, verás el motivo (vigencia, límite, etc.).</p>
</div>


<style>
.cuponera-emp-container { max-width: 1100px; margin: 20px auto; padding: 16px; }
.grid-cupones-emp { display: grid; gap: 16px; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); }
.cup-card { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 14px; box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
.cup-h { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
.cup-title { color: #222; font-size: 1.05rem; }
.cup-body { color: #444; display: grid; gap: 6px; margin-bottom: 10px; }
.badge { display: inline-block; padding: 4px 8px; border-radius: 10px; font-size: .85rem; }
.badge.ok { background: #ecfdf5; color: #065f46; border: 1px solid #34d399; }
.badge.warn { background: #fff7ed; color: #9a3412; border: 1px solid #fdba74; }
.motivos { font-size: .9rem; color: #7a4500; }
.cup-foot .btn { background: #f2ca00; color: #222; border: none; border-radius: 8px; padding: 8px 12px; cursor: pointer; font-weight: 600; }
.cup-foot .btn:disabled { opacity: .6; cursor: not-allowed; }
@media (max-width: 768px) { .grid-cupones-emp { grid-template-columns: 1fr; } }
/* .cuponera-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.filtros-cuponera {
    display: flex;
    gap: 20px;
    margin: 20px 0;
    flex-wrap: wrap;
}

.filtro-categoria, .filtro-orden {
    flex: 1;
    min-width: 250px;
}

select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-top: 5px;
}

.lista-cupones {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.cupon-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: relative;
    transition: transform 0.3s ease;
}

.cupon-card:hover {
    transform: translateY(-5px);
}

.cupon-card.destacado {
    border: 2px solid #f39c12;
}

.etiqueta-destacado {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #f39c12;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.8em;
    z-index: 1;
}

.cupon-encabezado {
    background:rgba(242, 202, 0, 0.62);
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.descuento {
    font-size: 1.5em;
    font-weight: bold;
}

.validez {
    font-size: 0.9em;
    opacity: 0.9;
}

.cupon-imagen img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.cupon-contenido {
    padding: 15px;
}

.cupon-titulo {
    margin: 0 0 10px 0;
    color: #2c3e50;
    font-size: 1.2em;
}

.cupon-descripcion {
    color: #7f8c8d;
    font-size: 0.9em;
    margin-bottom: 15px;
    line-height: 1.4;
}

.cupon-empresa {
    color: #3498db;
    font-weight: bold;
    margin-bottom: 15px;
    font-size: 0.9em;
}

.btn-cupon {
    width: 100%;
    padding: 10px;
    background-color: #2ecc71;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}
.btnNo{
    cursor: not-allowed;
}

.btn-cupon:disabled {
    background-color: #95a5a6;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .lista-cupones {
        grid-template-columns: 1fr;
    }
    
    .filtros-cuponera {
        flex-direction: column;
        gap: 10px;
    }
} */
</style>
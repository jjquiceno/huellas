<?php
require_once '../../../helpers/require_login.php';
?>
<div class="cuponera-container">
    <h2 class="regular x2">Cuponera de Beneficios</h2>
    
    <!-- <div class="filtros-cuponera">
        <div class="filtro-categoria">
            <label for="categoria" class="regular">Categoría:</label>
            <select id="categoria" class="regular" disabled>
                <option value="">Todas las categorías</option>
                <option value="comida">Comida</option>
                <option value="belleza">Belleza</option>
                <option value="moda">Moda</option>
                <option value="tecnologia">Tecnología</option>
                <option value="entretenimiento">Entretenimiento</option>
            </select>
        </div>
        
        <div class="filtro-orden">
            <label for="ordenar" class="regular">Ordenar por:</label>
            <select id="ordenar" class="regular" disabled>
                <option value="recientes">Más recientes</option>
                <option value="populares">Más populares</option>
                <option value="descuento">Mayor descuento</option>
            </select>
        </div>
    </div> -->
    
    <div class="lista-cupones">
        <!-- Cupón 1 -->
        <div class="cupon-card">
            <div class="cupon-encabezado">
                <div class="descuento">Día de la familia</div>
                <div class="validez">Válido hasta: 30/11/2023</div>
            </div>
            <!-- <div class="cupon-imagen">
                <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Frevistavive.com%2Fque-es-la-familia%2F&psig=AOvVaw3viPz7wWpZ-vVy93MgBj2M&ust=1756821789772000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCPieq6rdt48DFQAAAAAdAAAAABAE" alt="Restaurante Ejemplo">
            </div> -->
            <div class="cupon-contenido">
                <h3 class="cupon-titulo">Día de la familia</h3>
                <p class="cupon-descripcion">Pasa un dia con tus seres queridos</p>
                <div class="cupon-empresa">Dia completo de descanso</div>
                <button class="btn-cupon" disabled>Redimir cupón</button>
            </div>
        </div>
        
        <!-- Cupón 2 -->
        <div class="cupon-card destacado">
            <!-- <div class="etiqueta-destacado">¡Nuevo!</div> -->
            <div class="cupon-encabezado">
                <div class="descuento">Cumpleaños</div>
                <div class="validez">Válido hasta: 15/12/2023</div>
            </div>
            <!-- <div class="cupon-imagen">
                <img src="https://via.placeholder.com/300x150?text=Cine+Ejemplo" alt="Cine Ejemplo">
            </div> -->
            <div class="cupon-contenido">
                <h3 class="cupon-titulo">Cumpleaños</h3>
                <p class="cupon-descripcion">Pasa un dia con tus seres queridos</p>
                <div class="cupon-empresa">Medio dia de descanso</div>
                <button class="btn-cupon" disabled>Redimir cupón</button>
            </div>
        </div>
        
        <!-- Cupón 3 -->
        <div class="cupon-card">
            <div class="cupon-encabezado">
                <div class="descuento">Amor y Amistad</div>
                <div class="validez">Válido hasta: 31/12/2023</div>
            </div>
            <!-- <div class="cupon-imagen">
                <img src="https://via.placeholder.com/300x150?text=Tienda+Ejemplo" alt="Tienda de Ropa">
            </div> -->
            <div class="cupon-contenido">
                <h3 class="cupon-titulo">Amor y Amistad</h3>
                <p class="cupon-descripcion">Pasa un dia con tus seres queridos</p>
                <div class="cupon-empresa">Medio dia de descanso</div>
                <button class="btn-cupon">Redimir cupón</button>
            </div>
        </div>
    </div>
</div>

<style>
.cuponera-container {
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

/* Estilos responsivos */
@media (max-width: 768px) {
    .lista-cupones {
        grid-template-columns: 1fr;
    }
    
    .filtros-cuponera {
        flex-direction: column;
        gap: 10px;
    }
}
</style>
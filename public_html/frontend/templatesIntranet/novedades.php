<?php
require_once '../../../helpers/require_login.php';
?>
<div class="novedades-container">
    <h2 class="regular x2">Novedades en Huellas</h2>
    <div id="lista-eventos" class="lista-eventos">
        <!-- Los eventos se cargarán aquí dinámicamente -->
        <div class="cargando">
            <i class="fa-solid fa-spinner fa-spin"></i>
            Cargando novedades...
        </div>
    </div>
</div>

<script>
// Cargar eventos cuando se carga la página de novedades
document.addEventListener('DOMContentLoaded', function() {
    cargarEventosNovedades();
});

function cargarEventosNovedades() {
    const listaEventos = document.getElementById('lista-eventos');
    
    fetch('/HUELLASdelAYER/api/obtener_eventos.php')
        .then(async (response) => {
            if (!response.ok) {
                const text = await response.text();
                throw new Error(`HTTP ${response.status}: ${text.substring(0, 120)}`);
            }
            return response.json();
        })
        .then(eventos => {
            if (eventos.length === 0) {
                listaEventos.innerHTML = `
                    <div class="sin-eventos">
                        <i class="fa-solid fa-calendar-xmark fa-3x"></i>
                        <p class="regular">No hay eventos disponibles en este momento</p>
                        <p class="regular small">Los eventos creados por los jefes aparecerán aquí</p>
                    </div>
                `;
                return;
            }
            
            let eventosHTML = '';
            eventos.forEach(evento => {
                const fechaEvento = new Date(evento.fecha_evento);
                const fechaFormateada = fechaEvento.toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                const fechaCreacion = new Date();
                const esNuevo = (fechaCreacion - new Date(evento.fecha_evento)) < (7 * 24 * 60 * 60 * 1000); // Nuevo si es de hace menos de 7 días
                
                eventosHTML += `
                    <div class="evento-card-novedades" data-evento-id="${evento.id}">
                        ${esNuevo ? '<div class="badge-nuevo">NUEVO</div>' : ''}
                        <div class="evento-imagen-novedades">
                            <img src="../../../uploads/eventos/${evento.imagen_url}" alt="${evento.titulo}" loading="lazy">
                        </div>
                        <div class="evento-contenido-novedades">
                            <h3 class="regular x125">${evento.titulo}</h3>
                            <p class="regular evento-descripcion-novedades">${evento.descripcion}</p>
                            <div class="evento-meta-novedades">
                                <div class="fecha-evento-novedades">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <span class="regular">${fechaFormateada}</span>
                                </div>
                                <div class="evento-acciones-novedades">
                                    <button class="btn-like-novedades ${evento.me_gusta ? 'liked' : ''}" onclick="toggleLikeNovedades(${evento.id})">
                                        <i class="fa-solid fa-heart"></i>
                                        <span class="like-count">${evento.likes}</span>
                                    </button>
                                    <button class="btn-compartir" onclick="compartirEvento(${evento.id}, '${evento.titulo}')">
                                        <i class="fa-solid fa-share"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            listaEventos.innerHTML = eventosHTML;
        })
        .catch(error => {
            console.error('Error al cargar eventos:', error);
            listaEventos.innerHTML = `
                <div class="error-eventos">
                    <i class="fa-solid fa-exclamation-triangle fa-2x"></i>
                    <p class="regular">Error al cargar los eventos. Intenta recargar la página.</p>
                    <button onclick="cargarEventosNovedades()" class="btn-reintentar">
                        <i class="fa-solid fa-refresh"></i>
                        Reintentar
                    </button>
                </div>
            `;
        });
}

function toggleLikeNovedades(eventoId) {
    const botonLike = document.querySelector(`[data-evento-id="${eventoId}"] .btn-like-novedades`);
    const contadorLikes = botonLike.querySelector('.like-count');
    const esLiked = botonLike.classList.contains('liked');
    
    // Optimistic update
    botonLike.classList.toggle('liked');
    const likesActuales = parseInt(contadorLikes.textContent);
    contadorLikes.textContent = esLiked ? likesActuales - 1 : likesActuales + 1;
    
    // Enviar al servidor
    fetch('../../../backend/tablaEventos/toggle_like.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ evento_id: eventoId })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            // Revertir cambios si hay error
            botonLike.classList.toggle('liked');
            contadorLikes.textContent = likesActuales;
            console.error('Error al actualizar like:', data.message);
        }
    })
    .catch(error => {
        // Revertir cambios si hay error
        botonLike.classList.toggle('liked');
        contadorLikes.textContent = likesActuales;
        console.error('Error de conexión:', error);
    });
}

function compartirEvento(eventoId, titulo) {
    if (navigator.share) {
        navigator.share({
            title: titulo,
            text: `Mira este evento: ${titulo}`,
            url: window.location.href
        });
    } else {
        // Fallback para navegadores que no soportan Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(`${titulo} - ${url}`).then(() => {
            // Mostrar mensaje de éxito
            const mensaje = document.createElement('div');
            mensaje.className = 'mensaje-compartir';
            mensaje.textContent = 'Enlace copiado al portapapeles';
            document.body.appendChild(mensaje);
            
            setTimeout(() => {
                document.body.removeChild(mensaje);
            }, 3000);
        });
    }
}
</script>


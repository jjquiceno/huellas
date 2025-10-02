cargarEventos();
    
// Función para cargar los eventos
function cargarEventos() {
    fetch('../../apis/eventos/obtener_eventos.php')
        .then(async (response) => {
            if (!response.ok) {
                const text = await response.text();
                throw new Error(`HTTP ${response.status}: ${text.substring(0,120)}`);
            }
            const ct = response.headers.get('content-type') || '';
            if (!ct.includes('application/json')) {
                const text = await response.text();
                throw new Error(`Respuesta no-JSON: ${text.substring(0,120)}`);
            }
            return response.json();
        })
        .then(data => {
            const contenedor = document.getElementById('lista-eventos');
            
            if (data.length === 0) {
                contenedor.innerHTML = '<div class="cargando">No hay eventos disponibles en este momento.</div>';
                return;
            }
            
            let html = '';
            data.forEach(evento => {
                const fecha = new Date(evento.fecha_evento).toLocaleDateString('es-ES', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                html += `
                    <div class="evento-card" data-id="${evento.id}">
                        <img src="../../../uploads/eventos/${evento.imagen_url}" alt="${evento.titulo}" class="evento-imagen">
                        <div class="evento-contenido">
                            <h3 class="evento-titulo">${evento.titulo}</h3>
                            <span class="evento-fecha">${fecha}</span>
                            <p class="evento-descripcion">${evento.descripcion}</p>
                            <div class="evento-acciones">
                                <button class="like-btn ${evento.me_gusta ? 'liked' : ''}" 
                                        onclick="toggleLike(${evento.id}, this)">
                                    <i class="fa-${evento.me_gusta ? 'solid' : 'regular'} fa-heart"></i>
                                    <span class="like-counter">${evento.likes} Me gusta</span>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            contenedor.innerHTML = html;
        })
        .catch(error => {
            console.error('Error al cargar eventos:', error);
            document.getElementById('lista-eventos').innerHTML = 
                '<div class="cargando">Error al cargar los eventos. Por favor, intenta de nuevo más tarde.</div>';
        });
}

// Función global para manejar los "me gusta"
function toggleLike(eventoId, boton) {
    const icono = boton.querySelector('i');
    const contador = boton.querySelector('.like-counter');
    const isLiked = boton.classList.contains('liked');
    
    // Optimistic UI update
    const current = parseInt(contador.textContent);
    boton.classList.toggle('liked');
    contador.textContent = (isLiked ? current - 1 : current + 1) + ' Me gusta';
    icono.classList.toggle('fa-solid');
    icono.classList.toggle('fa-regular');

    fetch('../../apis/eventos/toggle_like.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ evento_id: eventoId })
    })
    .then(async (response) => {
        if (!response.ok) {
            const text = await response.text();
            throw new Error(`HTTP ${response.status}: ${text.substring(0,120)}`);
        }
        return response.json();
    })
    .then(data => {
        if (!data.success) {
            throw new Error(data.message || 'Error al actualizar el like');
        }
        // Ajustar con el total real si viene del backend
        if (typeof data.total_likes === 'number') {
            contador.textContent = data.total_likes + ' Me gusta';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revert UI on error
        const currentNow = parseInt(contador.textContent);
        boton.classList.toggle('liked');
        contador.textContent = (isLiked ? currentNow + 1 : currentNow - 1) + ' Me gusta';
        icono.classList.toggle('fa-solid');
        icono.classList.toggle('fa-regular');
    });
}
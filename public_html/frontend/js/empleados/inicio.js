// Slider JS puro para .sliderInicio

window.initSliderInicio = function() {
    // Verificar que el slider exista en el DOM
    const slider = document.querySelector('.sliderInicio');
    if (!slider) return; // Salir si no se encuentra el slider
    
    // Limpiar cualquier evento duplicado
    const oldPrevBtn = slider.querySelector('.prev');
    const oldNextBtn = slider.querySelector('.next');
    if (oldPrevBtn) oldPrevBtn.removeEventListener('click', null);
    if (oldNextBtn) oldNextBtn.removeEventListener('click', null);
    
    // Inicializar el slider
    const track = slider.querySelector('.slider-track');
    const slides = Array.from(track.children);
    const prevBtn = slider.querySelector('.slider-control.prev');
    const nextBtn = slider.querySelector('.slider-control.next');
    const indicatorsContainer = slider.querySelector('.slider-indicators');
    const slideCount = slides.length;
    let currentIndex = 0;
    let animating = false;

    // Crear indicadores
    function renderIndicators() {
        indicatorsContainer.innerHTML = '';
        for (let i = 0; i < slideCount; i++) {
            const dot = document.createElement('div');
            dot.classList.add('indicator');
            if (i === currentIndex) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(i));
            indicatorsContainer.appendChild(dot);
        }
    }

    // Mover el slider
    function updateSlider() {
        const slideWidth = slides[0].offsetWidth + parseInt(getComputedStyle(slides[0]).marginLeft) + parseInt(getComputedStyle(slides[0]).marginRight);
        track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
        renderIndicators();
    }

    function goToSlide(index) {
        if (animating || index === currentIndex || index < 0 || index >= slideCount) return;
        animating = true;
        currentIndex = index;
        updateSlider();
        setTimeout(() => { animating = false; }, 500);
    }

    prevBtn.addEventListener('click', () => {
        goToSlide(currentIndex - 1 < 0 ? slideCount - 1 : currentIndex - 1);
    });
    nextBtn.addEventListener('click', () => {
        goToSlide((currentIndex + 1) % slideCount);
    });

    // Responsive: actualizar ancho en resize
    window.addEventListener('resize', updateSlider);

    // Inicializar
    updateSlider();
    
    // Configurar autoplay
    let autoplayInterval = setInterval(() => {
        goToSlide((currentIndex + 1) % slideCount);
    }, 3000); // Cambia de slide cada 5 segundos
    
    // Pausar autoplay al hacer hover
    slider.addEventListener('mouseenter', () => {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    });
    
    // Reanudar autoplay al salir del hover
    slider.addEventListener('mouseleave', () => {
        if (!autoplayInterval) {
            autoplayInterval = setInterval(() => {
                goToSlide((currentIndex + 1) % slideCount);
            }, 3000);
        }
    });
    
    // Hacer la función accesible globalmente para recargar si es necesario
    window.sliderAPI = {
        goToSlide,
        next: () => goToSlide((currentIndex + 1) % slideCount),
        prev: () => goToSlide(currentIndex - 1 < 0 ? slideCount - 1 : currentIndex - 1)
    };
};

// Si el script se carga directamente (no por fetch), inicializar de inmediato
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', window.initSliderInicio);
} else {
    // Si el DOM ya está listo, inicializar después de un pequeño retraso
    // para asegurar que el HTML esté completamente renderizado
    setTimeout(window.initSliderInicio, 100);
}

// ----------------------- Resúmenes de INICIO -----------------------
(function(){
    const API_NOTI = '../../apis/notificaciones';
    const API_EMP = '../../apis/cupones';

    async function fetchJSON(url, options = {}){
        const res = await fetch(url, options);
        const text = await res.text();
        if(!res.ok) throw new Error(`HTTP ${res.status}: ${text.substring(0,200)}`);
        let data; try{ data = JSON.parse(text); } catch { throw new Error(`Respuesta no-JSON: ${text.substring(0,200)}`); }
        return data;
    }

    function fmtDateTime(s){
        const d = new Date(s);
        if (isNaN(d)) return s || '-';
        return d.toLocaleString('es-ES', { year:'numeric', month:'short', day:'2-digit', hour:'2-digit', minute:'2-digit' });
    }

    async function cargarNotificacionesResumen(){
        const box = document.querySelector('#inicio-notificaciones .lista');
        if(!box) return;
        box.innerHTML = '<div class="regular">Cargando...</div>';
        try{
            const data = await fetchJSON(`${API_NOTI}/listar.php?limit=5`);
            if(!data.success){ throw new Error(data.message || 'Error al listar notificaciones'); }
            const arr = data.data || [];
            if(arr.length === 0){
                box.innerHTML = '<div class="regular">No tienes notificaciones</div>';
                return;
            }
            const html = arr.slice(0,5).map(n => `
                <div class="card ${n.read ? 'read' : 'unread'}" style="background:#fff;padding:.75rem;border-radius:10px;border:1px solid #eee;box-shadow:0 2px 6px #0000000f;">
                    <div class="bold" style="margin-bottom:2px;">${n.title || 'Notificación'}</div>
                    ${n.body ? `<div class="regular" style="color:#444;margin-bottom:4px;">${n.body}</div>` : ''}
                    <div class="lightI" style="color:#666;font-size:.9rem;">${fmtDateTime(n.created_at)}</div>
                </div>
            `).join('');
            box.innerHTML = html;
        }catch(e){
            console.error(e);
            box.innerHTML = '<div class="regular">Error al cargar notificaciones</div>';
        }
    }

    async function cargarNovedadesResumen(){
        const cont = document.querySelector('#inicio-novedades .lista-eventos');
        if(!cont) return;
        cont.innerHTML = '<div class="cargando">Cargando novedades...</div>';
        try{
            const res = await fetch('/HUELLASdelAYER/backend/tablaEventos/obtener_eventos.php');
            const txt = await res.text();
            if(!res.ok) throw new Error(`HTTP ${res.status}: ${txt.substring(0,200)}`);
            let eventos; try{ eventos = JSON.parse(txt); } catch { throw new Error(`Respuesta no-JSON: ${txt.substring(0,200)}`); }
            if(!Array.isArray(eventos) || eventos.length === 0){
                cont.innerHTML = '<div class="cargando">No hay eventos recientes</div>';
                return;
            }
            const recent = eventos.slice(0,3);
            const html = recent.map(evento => {
                const fecha = new Date(evento.fecha_evento).toLocaleDateString('es-ES', { year:'numeric', month:'long', day:'numeric' });
                return `
                    <div class="evento-card-novedades" data-evento-id="${evento.id}">
                        <div class="evento-imagen-novedades">
                            <img src="../../../uploads/eventos/${evento.imagen_url}" alt="${evento.titulo}" loading="lazy">
                        </div>
                        <div class="evento-contenido-novedades">
                            <h3 class="bold x125">${evento.titulo}</h3>
                            <div class="fecha-evento-novedades"><i class="fa-solid fa-calendar-days"></i><span class="regular">${fecha}</span></div>
                        </div>
                    </div>
                `;
            }).join('');
            cont.innerHTML = html;
        }catch(e){
            console.error(e);
            cont.innerHTML = '<div class="cargando">Error al cargar novedades</div>';
        }
    }

    async function cargarCuponesResumen(){
        const labelResumen = document.getElementById('cupones-resumen-datos');
        const labelSlide = document.getElementById('cupones-slide-count');
        if(labelResumen) labelResumen.textContent = 'Cargando cupones...';
        try{
            const data = await fetchJSON(`${API_EMP}/lista_cupones_empleado.php`);
            if(!Array.isArray(data)) throw new Error('Formato inesperado de cupones');
            const total = data.length;
            const disponibles = data.filter(c => c.redeemable && c.status !== 'redimido').length;
            if(labelResumen){
                labelResumen.textContent = `Disponibles: ${disponibles} · Asignados: ${total}`;
            }
            if(labelSlide){
                labelSlide.textContent = disponibles > 0 ? `Tienes ${disponibles} cupón(es) disponible(s)` : 'No tienes cupones disponibles';
            }
        }catch(e){
            console.error(e);
            if(labelResumen) labelResumen.textContent = 'Error al cargar cupones';
            if(labelSlide) labelSlide.textContent = 'No se pudo cargar cupones';
        }
    }

    window.initInicioResumen = function(){
        cargarNotificacionesResumen();
        cargarNovedadesResumen();
        cargarCuponesResumen();
    };

    // Inicialización automática cuando esté listo el DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => setTimeout(window.initInicioResumen, 120));
    } else {
        setTimeout(window.initInicioResumen, 120);
    }
})();


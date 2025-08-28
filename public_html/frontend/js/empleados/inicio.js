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

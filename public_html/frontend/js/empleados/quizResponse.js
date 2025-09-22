const formulario = document.getElementById('quiz-Gnereal');
const mensajeDiv = document.getElementById('mensaje');

formulario.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(formulario);
    
    // Mostrar indicador de carga
    const botonEnviar = formulario.querySelector('button[type="submit"]');
    const textoOriginal = botonEnviar.textContent;
    botonEnviar.disabled = true;
    botonEnviar.textContent = 'Enviando ';
    
    fetch('../../../apis/quizes/quizGeneral.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(async (response) => {
        const ct = response.headers.get('content-type') || '';
        if (!response.ok) {
            const text = await response.text();
            throw new Error(`HTTP ${response.status}. Respuesta no OK.\n${text.slice(0, 200)}`);
        }
        if (!ct.includes('application/json')) {
            const text = await response.text();
            throw new Error(`Respuesta no-JSON:\n${text.slice(0, 200)}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            mostrarMensaje(
                'Ha respondido con exito todas las preguntas,<br>para descargar su certificado ingrese a su perfil', 
                // <br><a class="ppp download-btn" referencia="userProfile" href="../../../frontend/templatesIntranet/succes.php">ir al perfil</a>
                'exito',
                { allowHTML: true }
            );
            formulario.reset();
            // Opcional: Redirigir o actualizar la lista de eventos
            // setTimeout(() => { window.location.href = 'eventos.php'; }, 1500);
        } else {
            mostrarMensaje(data.message || 'Error al crear el evento', 'error', { allowHTML: false });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error en la conexión o respuesta no válida', 'error', { allowHTML: false });
    })
    .finally(() => {
        botonEnviar.disabled = false;
        botonEnviar.textContent = textoOriginal;
    });
});

function mostrarMensaje(mensaje, tipo, { allowHTML = false } = {}) {
    if (allowHTML) {
        mensajeDiv.innerHTML = mensaje;
    } else {
        mensajeDiv.textContent = mensaje;
    }
    mensajeDiv.className = 'mensaje ' + tipo;
    mensajeDiv.style.display = 'block';
    setTimeout(() => {
        mensajeDiv.classList.add('active');
    }, 100);
    
    // Ocultar el mensaje después de 5 segundos
    setTimeout(() => {
        mensajeDiv.classList.remove('active');
        mensajeDiv.style.display = 'none';
    }, 50000);
}
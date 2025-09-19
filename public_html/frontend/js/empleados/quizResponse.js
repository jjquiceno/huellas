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
            mostrarMensaje('Ha respondido con exito todas las preguntas', 'exito');
            formulario.reset();
            // Opcional: Redirigir o actualizar la lista de eventos
            // setTimeout(() => { window.location.href = 'eventos.php'; }, 1500);
        } else {
            mostrarMensaje(data.message || 'Error al crear el evento', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error en la conexión o respuesta no válida', 'error');
    })
    .finally(() => {
        botonEnviar.disabled = false;
        botonEnviar.textContent = textoOriginal;
    });
});

function mostrarMensaje(mensaje, tipo) {
    mensajeDiv.textContent = mensaje;
    mensajeDiv.className = 'mensaje ' + tipo;
    mensajeDiv.style.display = 'block';
    
    // Ocultar el mensaje después de 5 segundos
    setTimeout(() => {
        mensajeDiv.style.display = 'none';
    }, 5000);
}
const formulario = document.getElementById('formularioEvento');
const mensajeDiv = document.getElementById('mensaje');
const fechaHoy = new Date().toISOString().split('T')[0];
document.getElementById('fecha_evento').min = fechaHoy;

formulario.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(formulario);
    
    // Mostrar indicador de carga
    const botonEnviar = formulario.querySelector('button[type="submit"]');
    const textoOriginal = botonEnviar.textContent;
    botonEnviar.disabled = true;
    botonEnviar.textContent = 'Publicando...';
    
    fetch('../../../backend/tablaEventos/crear_evento.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje('Evento creado exitosamente', 'exito');
            formulario.reset();
            // Opcional: Redirigir o actualizar la lista de eventos
            // setTimeout(() => { window.location.href = 'eventos.php'; }, 1500);
        } else {
            mostrarMensaje(data.message || 'Error al crear el evento', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error en la conexión', 'error');
    })
    .finally(() => {
        botonEnviar.disabled = false;
        botonEnviar.textContent = textoOriginal;
    });
});

document.getElementById('cancelarEvento').addEventListener('click', function() {
    if (confirm('¿Estás seguro de que deseas cancelar? Los cambios no guardados se perderán.')) {
        window.history.back();
    }
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
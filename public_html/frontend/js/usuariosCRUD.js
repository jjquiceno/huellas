// Manejar el clic en el botón de eliminar
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-btn')) {
        e.preventDefault();
        const button = e.target;
        const row = button.closest('tr');
        const nombreUsuario = row.cells[0].textContent.trim();
        const usuarioId = button.dataset.id;
        
        // Mostrar confirmación
        if (confirm(`¿Estás seguro de que deseas eliminar al usuario "${nombreUsuario}"?`)) {
            eliminarUsuario(usuarioId, row);
        }
    }
});

// Función para eliminar un usuario
function eliminarUsuario(usuarioId, rowElement) {
    fetch('../../../backend/usuarios/delete_usuario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ nombre_usuario: usuarioId })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            alert(data.message || 'Usuario eliminado correctamente');
            // Eliminar la fila de la tabla
            rowElement.remove();
            
            // Si no quedan más filas, mostrar un mensaje
            const tbody = document.querySelector('table tbody');
            const rows = tbody.getElementsByTagName('tr');
            
            // Verificar si solo queda la fila del mensaje o si no hay filas
            if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector('td[colspan]'))) {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td colspan="4">No hay usuarios registrados.</td>';
                tbody.appendChild(tr);
            }
        } else {
            throw new Error(data.message || 'Error al eliminar el usuario');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el usuario: ' + (error.message || 'Error desconocido'));
    });
}
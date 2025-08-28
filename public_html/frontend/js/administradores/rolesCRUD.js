// Referencia al modal de edición
const editModal = document.createElement('div');
editModal.id = 'editRolModal';
editModal.className = 'modal';

// Función para manejar los clics en las celdas de funciones y botones
document.addEventListener('click', function(e) {
    // Manejar clic en celdas de funciones
    const box = e.target.closest('.funcionesBox');
    if (box) {
        const isExpanded = box.classList.toggle('expanded');
        
        if (isExpanded) {
            box.style.whiteSpace = 'normal';
            box.style.overflow = 'visible';
            box.style.wordWrap = 'break-word';
        } else {
            box.style.whiteSpace = 'nowrap';
            box.style.overflow = 'hidden';
            box.style.textOverflow = 'ellipsis';
        }
        return;
    }

    // Manejar clic en botones de eliminar
    if (e.target.classList.contains('delete-btn')) {
        e.preventDefault();
        const button = e.target;
        const row = button.closest('tr');
        const nombreCargo = row.cells[1].textContent.trim();
        const cargo_id = button.getAttribute('data-rol-id'); // Más confiable
        
        if (confirm(`¿Estás seguro de que deseas eliminar el cargo "${nombreCargo}"?`)) {
            eliminarCargo(cargo_id, row);
        }
    }
});

// Aplicar estilos iniciales a las celdas de funciones
function applyInitialStyles() {
    document.querySelectorAll('.funcionesBox').forEach(box => {
        if (!box.dataset.styled) {
            box.style.cursor = 'pointer';
            box.title = 'Click para expandir/contraer';
            box.style.whiteSpace = 'nowrap';
            box.style.overflow = 'hidden';
            box.style.textOverflow = 'ellipsis';
            box.style.maxWidth = '300px';
            box.dataset.styled = 'true';
        }
    });
}

// Función para eliminar un cargo
function eliminarCargo(cargo_id, rowElement) {
    fetch('../../../backend/roles/delete_cargo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ cargo_id: cargo_id })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(data.message || 'Cargo eliminado correctamente');
            rowElement.remove();
            
            // Si no quedan más filas, mostrar un mensaje
            const tbody = document.querySelector('table tbody');
            const rows = tbody.getElementsByTagName('tr');
            
            if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector('td[colspan]'))) {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td colspan="4">No hay cargos registrados.</td>';
                tbody.appendChild(tr);
            }
        } else {
            throw new Error(data.message || 'Error al eliminar el cargo');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el cargo: ' + (error.message || 'Error desconocido'));
    });
}

// Función de inicialización
function setupRolesCRUD() {
    applyInitialStyles();
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', setupRolesCRUD);

// Si el DOM ya está listo, inicializar de inmediato
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    setTimeout(setupRolesCRUD, 1);
}

// Hacer la función de configuración disponible globalmente
window.setupRolesCRUD = setupRolesCRUD;
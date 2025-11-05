// Referencia al modal de edición
const editModal = document.createElement('div');
editModal.id = 'editRolModal';
editModal.className = 'modal';

// Contenido del modal
editModal.innerHTML = `
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Editar Cargo</h2>
        <form id="editEmployeeForm">
            <input type="hidden" id="edit_rol_id" name="cargo_id">
            
            <div class="form-group">
                <label class="regular" for="cargo">Nombre del cargo:</label>
                <input class="regular" type="text" id="cargo" name="cargo" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="funciones">Funciones:</label>
                <textarea class="regular" id="funciones" name="funciones" required></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <button type="button" id="cancelEdit" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
`;
document.body.appendChild(editModal);

// Cierre del modal
editModal.querySelector('.close').addEventListener('click', function(){
    editModal.style.display = 'none';
});
document.getElementById('cancelEdit').addEventListener('click', function(){
    editModal.style.display = 'none';
});
window.addEventListener('click', function(e){
    if (e.target === editModal) editModal.style.display = 'none';
});

// Submit de edición
document.getElementById('editEmployeeForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const formData = new FormData(this);
    const payload = {};
    formData.forEach((v,k)=> payload[k]=v);

    const btn = this.querySelector('button[type="submit"]');
    const original = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

    try{
        const res = await fetch('../../apis/admons/update_cargo.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        });
        const text = await res.text();
        let data;
        try { data = JSON.parse(text); }
        catch { throw new Error(`Respuesta no-JSON (${res.status}): ${text.substring(0,200)}`); }

        if (!res.ok || data.success === false){
            throw new Error(data?.message || `Error HTTP ${res.status}`);
        }
        alert('Cargo actualizado correctamente');
        editModal.style.display = 'none';
        window.location.reload();
    } catch(err){
        console.error(err);
        alert('Error al actualizar el cargo: ' + err.message);
    } finally {
        btn.disabled = false;
        btn.innerHTML = original;
    }
});

// Manejar clic en el botón de editar (delegado y robusto)
document.addEventListener('click', function(e) {
    const button = e.target.closest('button.edit-btn');
    if (!button) return; // no es el botón de editar

    e.preventDefault();
    const row = button.closest('tr');
    if (!row) { console.warn('[rolesCRUD] No se encontró la fila (tr) para el botón editar'); return; }

    try {
        const cargoData = {
            cargo_id: (row.cells[0]?.textContent || '').trim(),
            cargo: (row.cells[1]?.textContent || '').trim(),
            funciones: (row.cells[2]?.textContent || '').trim()
        };
        console.debug('[rolesCRUD] Edit cargoData:', cargoData);

        const idInput = document.getElementById('edit_rol_id');
        const cargoInput = document.getElementById('cargo');
        const funcionesInput = document.getElementById('funciones');
        if (!idInput || !cargoInput || !funcionesInput) {
            console.error('[rolesCRUD] No se encontraron inputs del modal de edición');
            return;
        }

        idInput.value = cargoData.cargo_id;
        cargoInput.value = cargoData.cargo;
        funcionesInput.value = cargoData.funciones;

        editModal.style.display = 'block';
    } catch(err) {
        console.error('[rolesCRUD] Error al preparar datos de edición:', err);
    }
});

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
    fetch('../../apis/admons/delete_cargo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
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
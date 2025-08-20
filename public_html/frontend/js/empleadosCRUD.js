// Referencia al modal de edición
const editModal = document.createElement('div');
editModal.id = 'editEmployeeModal';
editModal.className = 'modal';

// Estilos para el modal
const modalStyles = document.createElement('style');
modalStyles.textContent = `
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto;
    }
    
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 700px;
        border-radius: 8px;
        position: relative;
    }
    
    .close {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    
    .form-actions {
        margin-top: 20px;
        text-align: right;
    }
    
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    
    .btn-primary {
        background-color: #4CAF50;
        color: white;
    }
    
    .btn-secondary {
        background-color: #f44336;
        color: white;
        margin-right: 10px;
    }
`;
document.head.appendChild(modalStyles);

// Contenido del modal
editModal.innerHTML = `
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Editar Empleado</h2>
        <form id="editEmployeeForm">
            <input type="hidden" id="edit_identificacion" name="identificacion">
            
            <div class="form-group">
                <label class="regular" for="edit_tipo_identificacion">Tipo de Identificación:</label>
                <select class="regular" id="edit_tipo_identificacion" name="tipo_identificacion_id" required>
                    <option value="">Tipo Identificacion</option>
                    <option value="CC132">CC</option>
                    <option value="CE798">CE</option>
                    <option value="TI548">TI</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_nombre">Nombre Completo:</label>
                <input class="regular" type="text" id="edit_nombre" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_fecha_nacimiento">Fecha de Nacimiento:</label>
                <input class="regular" type="date" id="edit_fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_fecha_ingreso">Fecha de Ingreso:</label>
                <input class="regular" type="date" id="edit_fecha_ingreso" name="fecha_ingreso" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_nombre_usuario">Nombre de Usuario:</label>
                <input class="regular" type="text" id="edit_nombre_usuario" name="nombre_usuario" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_cargo_id">Cargo:</label>
                <select class="regular" id="edit_cargo_id" name="cargo_id" required>
                    <!-- Se llenará dinámicamente -->
                </select>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_tipo_contrato_id">Tipo de Contrato:</label>
                <select class="regular" id="edit_tipo_contrato_id" name="tipo_contrato_id" required>
                    <option value="">Tipo Contrato</option>
                    <option value="CPS789">prestacion de servicios termino fijo</option>                                
                    <option value="CPSIN2">prestacion de servicios termino indefinido</option>
                    <option value="CTV145">vinculado termino indefinido</option>                                
                    <option value="CTVF32">vinculado termino fijo</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_duracion_contrato">Duración del Contrato (meses):</label>
                <input class="regular" type="number" id="edit_duracion_contrato" name="duracion_contrato" min="1" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_salario">Salario:</label>
                <input class="regular" type="number" id="edit_salario" name="salario" min="0" step="0.01" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <button type="button" id="cancelEdit" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
`;

document.body.appendChild(editModal);

// Cargar la lista de cargos
function cargarCargos() {
    return new Promise((resolve, reject) => {
        console.log('Iniciando carga de cargos...');
        const url = '../../../backend/tablaEmpleados/get_cargos.php';
        const timestamp = new Date().getTime(); // Para prevenir caché
        
        fetch(`${url}?t=${timestamp}`, {
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Error en la respuesta:', text);
                    throw new Error(`Error HTTP ${response.status}: ${response.statusText}`);
                });
            }
            return response.json();
        })
        .then(data => {
            const select = document.getElementById('edit_cargo_id');
            if (!select) {
                console.error('No se encontró el elemento select#edit_cargo_id');
                throw new Error('Error al cargar el formulario de edición');
            }
            
            // Guardar el valor seleccionado actual
            const selectedValue = select.value;
            
            // Limpiar opciones existentes
            select.innerHTML = '<option value="">Seleccione un cargo...</option>';
            
            if (!Array.isArray(data)) {
                console.error('La respuesta no es un array:', data);
                throw new Error('Formato de datos inválido');
            }
            
            // Agregar opciones al select
            data.forEach(cargo => {
                const option = document.createElement('option');
                option.value = cargo.cargo_id;
                option.textContent = cargo.cargo;
                select.appendChild(option);
            });
            
            // Restaurar el valor seleccionado si existe
            if (selectedValue) {
                select.value = selectedValue;
            }
            
            console.log('Cargos cargados correctamente:', data.length, 'cargos encontrados');
            resolve(data);
        })
        .catch(error => {
            console.error('Error en cargarCargos:', error);
            const select = document.getElementById('edit_cargo_id');
            if (select) {
                select.innerHTML = '<option value="">Error al cargar cargos</option>';
            }
            reject(error);
        });
    });
}

// Inicializar cargos al cargar la página
document.addEventListener('DOMContentLoaded', cargarCargos);

// Manejar clic en el botón de editar
document.addEventListener('click', function(e) {
    // Manejar clic en botón eliminar
    if (e.target.classList.contains('delete-btn')) {
        e.preventDefault();
        const button = e.target;
        const row = button.closest('tr');
        const nombreEmpleado = row.cells[2].textContent.trim();
        const usuarioId = button.dataset.id;
        
        // Mostrar confirmación
        if (confirm(`¿Estás seguro de que deseas eliminar al Empleado "${nombreEmpleado}"?`)) {
            eliminarEmpleado(usuarioId, row);
        }
    }
    
    // Manejar clic en botón editar
    if (e.target.classList.contains('edit-btn')) {
        e.preventDefault();
        const button = e.target;
        const row = button.closest('tr');
        
        // Obtener datos de la fila
        const empleadoData = {
            identificacion: row.cells[0].textContent.trim(),
            tipo_identificacion_id: row.cells[1].textContent.trim(),
            nombre: row.cells[2].textContent.trim(),
            fecha_nacimiento: row.cells[3].textContent.trim(),
            fecha_ingreso: row.cells[4].textContent.trim(),
            nombre_usuario: row.cells[5].textContent.trim(),
            cargo_id: row.cells[6].textContent.trim(),
            tipo_contrato_id: row.cells[7].textContent.trim(),
            duracion_contrato: row.cells[8].textContent.trim(),
            salario: row.cells[9].textContent.trim()
        };
        
        // Llenar el formulario con los datos del empleado
        document.getElementById('edit_identificacion').value = empleadoData.identificacion;
        document.getElementById('edit_tipo_identificacion').value = empleadoData.tipo_identificacion_id;
        document.getElementById('edit_nombre').value = empleadoData.nombre;
        document.getElementById('edit_fecha_nacimiento').value = empleadoData.fecha_nacimiento;
        document.getElementById('edit_fecha_ingreso').value = empleadoData.fecha_ingreso;
        document.getElementById('edit_nombre_usuario').value = empleadoData.nombre_usuario;
        
        // Asegurarse de que los cargos se hayan cargado antes de establecer el valor
        cargarCargos().then(() => {
            document.getElementById('edit_cargo_id').value = empleadoData.cargo_id;
        });
        
        document.getElementById('edit_tipo_contrato_id').value = empleadoData.tipo_contrato_id;
        document.getElementById('edit_duracion_contrato').value = empleadoData.duracion_contrato;
        document.getElementById('edit_salario').value = empleadoData.salario;
        
        // Mostrar el modal
        editModal.style.display = 'block';
    }
});

// Cerrar el modal al hacer clic en la X
editModal.querySelector('.close').addEventListener('click', function() {
    editModal.style.display = 'none';
});

// Cerrar el modal al hacer clic en Cancelar
document.getElementById('cancelEdit').addEventListener('click', function() {
    editModal.style.display = 'none';
});

// Cerrar el modal al hacer clic fuera del contenido
window.addEventListener('click', function(event) {
    if (event.target === editModal) {
        editModal.style.display = 'none';
    }
});

// Manejar el envío del formulario de edición
document.getElementById('editEmployeeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const empleadoData = {};
    
    // Convertir FormData a objeto
    formData.forEach((value, key) => {
        empleadoData[key] = value;
    });
    
    // Convertir valores numéricos
    empleadoData.duracion_contrato = parseInt(empleadoData.duracion_contrato);
    empleadoData.salario = parseFloat(empleadoData.salario);
    empleadoData.tipo_identificacion_id = parseInt(empleadoData.tipo_identificacion_id);
    empleadoData.cargo_id = parseInt(empleadoData.cargo_id);
    empleadoData.tipo_contrato_id = parseInt(empleadoData.tipo_contrato_id);
    
    // Mostrar indicador de carga
    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Guardando...';
    
    // Enviar datos al servidor
    fetch('../../../backend/tablaEmpleados/update_empleado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(empleadoData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Empleado actualizado correctamente');
            editModal.style.display = 'none';
            // Recargar la página para ver los cambios
            window.location.reload();
        } else {
            throw new Error(data.message || 'Error al actualizar el empleado');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar el empleado: ' + error.message);
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.textContent = originalButtonText;
    });
});

// Función para eliminar un usuario
function eliminarEmpleado(usuarioId, rowElement) {
    console.log('Intentando eliminar empleado con ID:', usuarioId);
    
    fetch('../../../backend/tablaEmpleados/delete_empleado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        credentials: 'same-origin',
        body: JSON.stringify({ identificacion: usuarioId })
    })
    .then(async response => {
        console.log('Respuesta del servidor - Estado:', response.status, response.statusText);
        const responseText = await response.text();
        console.log('Contenido de la respuesta:', responseText);
        
        if (!response.ok) {
            throw new Error(`Error en la respuesta del servidor: ${response.status} ${response.statusText}\n${responseText}`);
        }
        
        try {
            return JSON.parse(responseText);
        } catch (e) {
            throw new Error('La respuesta no es un JSON válido: ' + responseText);
        }
    })
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            alert(data.message || ' Empleado eliminado correctamente');
            // Eliminar la fila de la tabla
            rowElement.remove();
            
            // Si no quedan más filas, mostrar un mensaje
            const tbody = document.querySelector('table tbody');
            const rows = tbody.getElementsByTagName('tr');
            
            // Verificar si solo queda la fila del mensaje o si no hay filas
            if (rows.length === 0 || (rows.length === 1 && rows[0].querySelector('td[colspan]'))) {
                const tr = document.createElement('tr');
                tr.innerHTML = '<td colspan="4">No hay Empleados registrados.</td>';
                tbody.appendChild(tr);
            }
        } else {
            throw new Error(data.message || 'Error al eliminar el Empleado');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el Empleado: ' + (error.message || 'Error desconocido'));
    });
}
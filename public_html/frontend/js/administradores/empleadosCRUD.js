// Referencia al modal de edición
const editModal = document.createElement('div');
editModal.id = 'editEmployeeModal';
editModal.className = 'modal';

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
                    <option valueedit="">Tipo Identificacion</option>
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
                <label class="regular" for="edit_celular">Celular:</label>
                <input class="regular" type="number" id="edit_celular" name="celular" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_direccion">Direccion:</label>
                <input class="regular" type="text" id="edit_direccion" name="direccion" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_eps">EPS:</label>
                <input class="regular" type="text" id="edit_eps" name="eps" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_afp">AFP:</label>
                <input class="regular" type="text" id="edit_afp" name="afp" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_arl">ARL:</label>
                <input class="regular" type="text" id="edit_arl" name="arl" required>
            </div>
            
            <div class="form-group">
                <label class="regular" for="edit_caja">Caja:</label>
                <input class="regular" type="text" id="edit_caja" name="caja" required>
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
                    <option value="">Seleccione un tipo de contrato</option>
                    <option value="CPS789">Prestación de servicios término fijo</option>                                
                    <option value="CPSIN2">Prestación de servicios término indefinido</option>
                    <option value="CTV145">Vinculado término indefinido</option>                                
                    <option value="CTVF32">Vinculado término fijo</option>
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
        const url = '../../apis/admons/get_cargos.php';
        const timestamp = new Date().getTime(); // Para prevenir caché
        
        fetch(`${url}?t=${timestamp}`, {
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache'
            }
        })
        .then(async response => {
            const responseText = await response.text();
            console.log('Raw response:', responseText);
            
            if (!response.ok) {
                console.error('Error en la respuesta:', {
                    status: response.status,
                    statusText: response.statusText,
                    headers: [...response.headers],
                    body: responseText
                });
                throw new Error(`Error del servidor: ${response.status} ${response.statusText}`);
            }
            
            try {
                return JSON.parse(responseText);
            } catch (e) {
                console.error('Error al analizar JSON:', e);
                console.error('Respuesta recibida:', responseText);
                throw new Error('La respuesta del servidor no es un JSON válido');
            }
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
    
    // Manejar clic en botón editar (empleados o líderes)
    if (e.target.classList.contains('edit-btn')) {
        e.preventDefault();
        const button = e.target;
        const row = button.closest('tr');

        // Heurística para diferenciar filas de líderes (jefes) vs empleados:
        // Tabla de líderes tiene columnas: [0] id_jefe, [1] identificacion, [2] nombre, [3] correo, [4] nombre_usuario, [5] (btn cambiar pass), [6] acciones
        // Además, contiene un botón .change-password-btn en la fila.
        const isLeaderRow = !!row && row.cells.length >= 7 && row.querySelector('button.change-password-btn');
        if (isLeaderRow) {
            // Abrir modal de edición de líder (jefe)
            const jefeData = {
                id_jefe: (row.cells[0]?.textContent || '').trim(),
                identificacion: (row.cells[1]?.textContent || '').trim(),
                nombre: (row.cells[2]?.textContent || '').trim(),
                correo: (row.cells[3]?.textContent || '').trim(),
                nombre_usuario: (row.cells[4]?.textContent || '').trim()
            };
            // Rellenar y mostrar modal
            ensureLeaderModals();
            document.getElementById('edit_jefe_id').value = jefeData.id_jefe;
            document.getElementById('edit_jefe_username').value = jefeData.nombre_usuario;
            document.getElementById('edit_jefe_correo').value = jefeData.correo;
            leaderEditModal.style.display = 'block';
            return; // no seguir con flujo de empleados
        }
        
        // Obtener datos de la fila
        const empleadoData = {
            identificacion: row.cells[0].textContent.trim(),
            tipo_identificacion_id: row.cells[1].textContent.trim(),
            nombre: row.cells[2].textContent.trim(),
            fecha_nacimiento: row.cells[3].textContent.trim(),
            fecha_ingreso: row.cells[4].textContent.trim(),
            celular: row.cells[5].textContent.trim(),
            direccion: row.cells[6].textContent.trim(),
            eps: row.cells[7].textContent.trim(),
            afp: row.cells[8].textContent.trim(),
            arl: row.cells[9].textContent.trim(),
            caja: row.cells[10].textContent.trim(),
            nombre_usuario: row.cells[11].textContent.trim(),
            cargo_id: row.cells[12].textContent.trim(),
            tipo_contrato_id: row.cells[13].textContent.trim(),
            duracion_contrato: row.cells[14].textContent.trim(),
            salario: row.cells[15].textContent.trim()
        };
        
        // Llenar el formulario con los datos del empleado
        document.getElementById('edit_identificacion').value = empleadoData.identificacion;
        document.getElementById('edit_tipo_identificacion').value = empleadoData.tipo_identificacion_id;
        document.getElementById('edit_nombre').value = empleadoData.nombre;
        document.getElementById('edit_fecha_nacimiento').value = empleadoData.fecha_nacimiento;
        document.getElementById('edit_fecha_ingreso').value = empleadoData.fecha_ingreso;
        document.getElementById('edit_celular').value = empleadoData.celular;
        document.getElementById('edit_direccion').value = empleadoData.direccion;
        document.getElementById('edit_eps').value = empleadoData.eps;
        document.getElementById('edit_afp').value = empleadoData.afp;
        document.getElementById('edit_arl').value = empleadoData.arl;
        document.getElementById('edit_caja').value = empleadoData.caja;
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

// ===================== Líderes (Jefes) =====================
let leaderEditModal; let leaderPassModal; let leaderModalsReady = false;
function ensureLeaderModals(){
    if (leaderModalsReady) return;
    // Modal Editar Líder
    leaderEditModal = document.createElement('div');
    leaderEditModal.className = 'modal';
    leaderEditModal.id = 'leaderEditModal';
    leaderEditModal.innerHTML = `
      <div class="modal-content">
        <span class="close" id="closeLeaderEdit">&times;</span>
        <h2>Editar Líder</h2>
        <form id="editLeaderForm">
          <input type="hidden" id="edit_jefe_id" name="id_jefe">
          <div class="form-group">
            <label for="edit_jefe_username">Nombre de usuario</label>
            <input type="text" id="edit_jefe_username" name="nuevo_nombre_usuario" required>
          </div>
          <div class="form-group">
            <label for="edit_jefe_correo">Correo</label>
            <input type="email" id="edit_jefe_correo" name="correo" required>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <button type="button" class="btn btn-secondary" id="cancelLeaderEdit">Cancelar</button>
          </div>
        </form>
      </div>`;

    // Modal Cambiar Contraseña Líder
    leaderPassModal = document.createElement('div');
    leaderPassModal.className = 'modal';
    leaderPassModal.id = 'leaderPassModal';
    leaderPassModal.innerHTML = `
      <div class="modal-content">
        <span class="close" id="closeLeaderPass">&times;</span>
        <h2>Cambiar Contraseña (Líder)</h2>
        <form id="changeLeaderPasswordForm">
          <input type="hidden" id="cp_jefe_id" name="id_jefe">
          <div class="form-group">
            <label for="new_leader_password">Nueva contraseña</label>
            <input type="password" id="new_leader_password" name="new_password" minlength="8" required>
          </div>
          <div class="form-group">
            <label for="confirm_leader_password">Confirmar contraseña</label>
            <input type="password" id="confirm_leader_password" minlength="8" required>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <button type="button" class="btn btn-secondary" id="cancelLeaderPass">Cancelar</button>
          </div>
        </form>
      </div>`;

    document.body.appendChild(leaderEditModal);
    document.body.appendChild(leaderPassModal);

    // Cierres
    document.getElementById('closeLeaderEdit').addEventListener('click', ()=> leaderEditModal.style.display='none');
    document.getElementById('cancelLeaderEdit').addEventListener('click', ()=> leaderEditModal.style.display='none');
    document.getElementById('closeLeaderPass').addEventListener('click', ()=> leaderPassModal.style.display='none');
    document.getElementById('cancelLeaderPass').addEventListener('click', ()=> leaderPassModal.style.display='none');
    window.addEventListener('click', (e)=>{
        if (e.target === leaderEditModal) leaderEditModal.style.display='none';
        if (e.target === leaderPassModal) leaderPassModal.style.display='none';
    });

    // Submit Editar Líder
    document.getElementById('editLeaderForm').addEventListener('submit', async function(e){
        e.preventDefault();
        const payload = {
            id_jefe: document.getElementById('edit_jefe_id').value.trim(),
            nuevo_nombre_usuario: document.getElementById('edit_jefe_username').value.trim(),
            correo: document.getElementById('edit_jefe_correo').value.trim()
        };
        const btn = this.querySelector('button[type="submit"]');
        const original = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        try{
            const res = await fetch('../../apis/admons/update_jefe.php', {
                method: 'POST',
                headers: { 'Accept':'application/json', 'Content-Type':'application/json', 'X-Requested-With':'XMLHttpRequest' },
                body: JSON.stringify(payload)
            });
            const text = await res.text();
            let data; try{ data = JSON.parse(text); } catch{ throw new Error(`Respuesta no-JSON (${res.status}): ${text.substring(0,200)}`); }
            if (!res.ok || data.success === false) throw new Error(data?.message || `Error HTTP ${res.status}`);
            alert('Líder actualizado correctamente');
            leaderEditModal.style.display = 'none';
            window.location.reload();
        }catch(err){
            console.error(err); alert('Error al actualizar líder: ' + err.message);
        }finally{ btn.disabled = false; btn.innerHTML = original; }
    });

    // Submit Cambiar Contraseña Líder
    document.getElementById('changeLeaderPasswordForm').addEventListener('submit', async function(e){
        e.preventDefault();
        const np = document.getElementById('new_leader_password').value;
        const cp = document.getElementById('confirm_leader_password').value;
        if (np !== cp) { alert('Las contraseñas no coinciden'); return; }
        const payload = { id_jefe: document.getElementById('cp_jefe_id').value.trim(), new_password: np };
        const btn = this.querySelector('button[type="submit"]');
        const original = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
        try{
            const res = await fetch('../../apis/admons/change_password_jefe.php', {
                method: 'POST',
                headers: { 'Accept':'application/json', 'Content-Type':'application/json', 'X-Requested-With':'XMLHttpRequest' },
                body: JSON.stringify(payload)
            });
            const text = await res.text();
            let data; try{ data = JSON.parse(text); } catch{ throw new Error(`Respuesta no-JSON (${res.status}): ${text.substring(0,200)}`); }
            if (!res.ok || data.success === false) throw new Error(data?.message || `Error HTTP ${res.status}`);
            alert('Contraseña de líder actualizada correctamente');
            leaderPassModal.style.display = 'none';
        }catch(err){
            console.error(err); alert('Error al actualizar contraseña del líder: ' + err.message);
        }finally{ btn.disabled = false; btn.innerHTML = original; }
    });

    leaderModalsReady = true;
}

// Abrir modal Cambiar Contraseña (líder) desde la tabla
document.addEventListener('click', function(e){
    const btn = e.target.closest('button.change-password-btn');
    if (!btn) return;
    e.preventDefault();
    const row = btn.closest('tr');
    if (!row) return;
    ensureLeaderModals();
    const id_jefe = (row.cells[0]?.textContent || '').trim();
    document.getElementById('cp_jefe_id').value = id_jefe;
    document.getElementById('new_leader_password').value = '';
    document.getElementById('confirm_leader_password').value = '';
    leaderPassModal.style.display = 'block';
});

// Manejar el envío del formulario de edición
document.getElementById('editEmployeeForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const empleadoData = {};
    
    // Convertir FormData a objeto
    formData.forEach((value, key) => {
        empleadoData[key] = value;
    });
    
    // Validar campos numéricos
    if (empleadoData.duracion_contrato) {
        empleadoData.duracion_contrato = parseInt(empleadoData.duracion_contrato);
    }
    
    // Convertir IDs a enteros
    // empleadoData.tipo_identificacion_id = parseInt(empleadoData.tipo_identificacion_id);
    // empleadoData.cargo_id = parseInt(empleadoData.cargo_id);
    // empleadoData.tipo_contrato_id = parseInt(empleadoData.tipo_contrato_id);
    
    // Mostrar indicador de carga
    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    
    try {
        // Enviar datos al servidor
        const response = await fetch('../../apis/admons/update_empleado.php', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(empleadoData)
        });
        
        let responseData;
        const responseText = await response.text();
        
        try {
            responseData = JSON.parse(responseText);
            console.log('Response parsed successfully:', responseData);
        } catch (e) {
            console.error('Error parsing JSON response:', e);
            console.error('Full response text:', responseText);
            console.error('Response headers:', [...response.headers].map(([k, v]) => `${k}: ${v}`).join('\n'));
            throw new Error(`La respuesta del servidor no es un JSON válido: ${responseText.substring(0, 200)}...`);
        }
        
        if (!response.ok) {
            console.error('Error en la respuesta:', {
                status: response.status,
                statusText: response.statusText,
                data: responseData
            });
            throw new Error(responseData.message || `Error del servidor: ${response.status} ${response.statusText}`);
        }
        
        if (responseData.success) {
            alert('Empleado actualizado correctamente');
            editModal.style.display = 'none';
            // Recargar la página para ver los cambios
            window.location.reload();
        } else {
            throw new Error(responseData.message || 'Error al actualizar el empleado');
        }
    } catch (error) {
        console.error('Error al actualizar empleado:', error);
        alert('Error al actualizar el empleado: ' + (error.message || 'Error desconocido'));
    } finally {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
    }
});

// Función para eliminar un usuario
function eliminarEmpleado(usuarioId, rowElement) {
    console.log('Intentando eliminar empleado con ID:', usuarioId);
    
    fetch('../../apis/admons/delete_empleado.php', {
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
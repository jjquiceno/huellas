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

// ---------- Modales de edición y cambio de contraseña ----------
const editUserModal = document.createElement('div');
editUserModal.className = 'modal';
editUserModal.id = 'editUserModal';
editUserModal.innerHTML = `
  <div class="modal-content">
    <span class="close" id="closeEditUser">&times;</span>
    <h2>Editar Usuario</h2>
    <form id="editUserForm">
      <input type="hidden" id="current_username" name="nombre_usuario">
      <div class="form-group">
        <label for="nuevo_nombre_usuario">Nombre de usuario</label>
        <input type="text" id="nuevo_nombre_usuario" name="nuevo_nombre_usuario" required>
      </div>
      <div class="form-group">
        <label for="email_usuario">Email</label>
        <input type="email" id="email_usuario" name="email" required>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary" id="cancelEditUser">Cancelar</button>
      </div>
    </form>
  </div>`;

const changePassModal = document.createElement('div');
changePassModal.className = 'modal';
changePassModal.id = 'changePassModal';
changePassModal.innerHTML = `
  <div class="modal-content">
    <span class="close" id="closeChangePass">&times;</span>
    <h2>Cambiar Contraseña</h2>
    <form id="changePasswordForm">
      <input type="hidden" id="cp_username" name="nombre_usuario">
      <div class="form-group">
        <label for="new_password">Nueva contraseña</label>
        <input type="password" id="new_password" name="new_password" minlength="8" required>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirmar contraseña</label>
        <input type="password" id="confirm_password" minlength="8" required>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <button type="button" class="btn btn-secondary" id="cancelChangePass">Cancelar</button>
      </div>
    </form>
  </div>`;

document.body.appendChild(editUserModal);
document.body.appendChild(changePassModal);

// Abrir modal Editar usuario
document.addEventListener('click', function(e){
  const btn = e.target.closest('button.edit-btn');
  if (!btn) return;
  e.preventDefault();
  const row = btn.closest('tr');
  if (!row) return;
  const username = (row.cells[0]?.textContent || '').trim();
  const email = (row.cells[2]?.textContent || '').trim();
  document.getElementById('current_username').value = username;
  document.getElementById('nuevo_nombre_usuario').value = username;
  document.getElementById('email_usuario').value = email;
  editUserModal.style.display = 'block';
});

// Abrir modal Cambiar contraseña
document.addEventListener('click', function(e){
  const btn = e.target.closest('button.change-password-btn');
  if (!btn) return;
  e.preventDefault();
  const row = btn.closest('tr');
  if (!row) return;
  const username = (row.cells[0]?.textContent || '').trim();
  document.getElementById('cp_username').value = username;
  document.getElementById('new_password').value = '';
  document.getElementById('confirm_password').value = '';
  changePassModal.style.display = 'block';
});

// Cierres de modales
function closeEditUser(){ editUserModal.style.display = 'none'; }
function closeChangePass(){ changePassModal.style.display = 'none'; }
document.getElementById('closeEditUser').addEventListener('click', closeEditUser);
document.getElementById('cancelEditUser').addEventListener('click', closeEditUser);
document.getElementById('closeChangePass').addEventListener('click', closeChangePass);
document.getElementById('cancelChangePass').addEventListener('click', closeChangePass);
window.addEventListener('click', function(e){
  if (e.target === editUserModal) closeEditUser();
  if (e.target === changePassModal) closeChangePass();
});

// Submit Editar usuario
document.getElementById('editUserForm').addEventListener('submit', async function(e){
  e.preventDefault();
  const payload = {
    nombre_usuario: document.getElementById('current_username').value.trim(),
    nuevo_nombre_usuario: document.getElementById('nuevo_nombre_usuario').value.trim(),
    email: document.getElementById('email_usuario').value.trim()
  };
  const btn = this.querySelector('button[type="submit"]');
  const original = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
  try{
    const res = await fetch('../../apis/admons/update_usuario.php', {
      method: 'POST',
      headers: { 'Accept':'application/json', 'Content-Type':'application/json', 'X-Requested-With':'XMLHttpRequest' },
      body: JSON.stringify(payload)
    });
    const text = await res.text();
    let data; try{ data = JSON.parse(text); } catch{ throw new Error(`Respuesta no-JSON (${res.status}): ${text.substring(0,200)}`); }
    if (!res.ok || data.success === false) throw new Error(data?.message || `Error HTTP ${res.status}`);
    alert('Usuario actualizado correctamente');
    closeEditUser();
    window.location.reload();
  }catch(err){
    console.error(err); alert('Error al actualizar: ' + err.message);
  }finally{ btn.disabled = false; btn.innerHTML = original; }
});

// Submit Cambiar contraseña
document.getElementById('changePasswordForm').addEventListener('submit', async function(e){
  e.preventDefault();
  const np = document.getElementById('new_password').value;
  const cp = document.getElementById('confirm_password').value;
  if (np !== cp) { alert('Las contraseñas no coinciden'); return; }
  const payload = { nombre_usuario: document.getElementById('cp_username').value.trim(), new_password: np };
  const btn = this.querySelector('button[type="submit"]');
  const original = btn.innerHTML; btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Actualizando...';
  try{
    const res = await fetch('../../apis/admons/change_password.php', {
      method: 'POST',
      headers: { 'Accept':'application/json', 'Content-Type':'application/json', 'X-Requested-With':'XMLHttpRequest' },
      body: JSON.stringify(payload)
    });
    const text = await res.text();
    let data; try{ data = JSON.parse(text); } catch{ throw new Error(`Respuesta no-JSON (${res.status}): ${text.substring(0,200)}`); }
    if (!res.ok || data.success === false) throw new Error(data?.message || `Error HTTP ${res.status}`);
    alert('Contraseña actualizada correctamente');
    closeChangePass();
  }catch(err){
    console.error(err); alert('Error al actualizar contraseña: ' + err.message);
  }finally{ btn.disabled = false; btn.innerHTML = original; }
});

// Función para eliminar un usuario
function eliminarUsuario(usuarioId, rowElement) {
    fetch('../../apis/admons/delete_usuario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
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
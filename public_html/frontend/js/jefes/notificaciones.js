const API_BASE = '../../apis/cupones';

function setLoading(btn, loading) {
  if (!btn) return;
  btn.disabled = loading;
  btn.dataset.originalText = btn.dataset.originalText || btn.textContent;
  btn.textContent = loading ? 'Procesando...' : btn.dataset.originalText;
}

async function fetchJSON(url, options = {}) {
  const res = await fetch(url, options);
  const text = await res.text();
  if (!res.ok) throw new Error(`HTTP ${res.status}: ${text.substring(0,200)}`);
  let data;
  try { data = JSON.parse(text); } 
  catch { throw new Error(`Respuesta no-JSON: ${text.substring(0,200)}`); }
  return data;
}

async function cargarSolicitudes() {
  const cont = document.getElementById('listaSolicitudes');
  const msg = document.getElementById('notifMsg');
  if (!cont) return;
  cont.innerHTML = 'Cargando...';
  msg.textContent = '';
  try {
    const data = await fetchJSON(`${API_BASE}/listar_solicitudes.php`);
    if (!data.success) throw new Error(data.message || 'Error desconocido');
    const arr = data.data || [];
    if (arr.length === 0) {
      cont.innerHTML = '<div>No hay solicitudes pendientes</div>';
      return;
    }
    cont.innerHTML = arr.map(s => `
      <div class="card">
        <div class="card-title bold">#${s.request_id} - ${s.coupon_title || 'Cupón'}</div>
        <div class="regular">Empleado: ${s.empleado_nombre || s.empleado_usuario || s.empleado_id}</div>
        <div class="lightI">Solicitado: ${new Date(s.requested_at).toLocaleString('es-ES')}</div>
        ${s.coupon_description ? `<div class="regular">${s.coupon_description}</div>` : ''}
        <div class="actions" style="display:flex;gap:8px;margin-top:8px">
          <textarea class="note" placeholder="Nota (opcional)" style="flex:1;min-height:40px"></textarea>
          <button class="btn aprobar" data-request-id="${s.request_id}">Aprobar</button>
          <button class="btn rechazar" data-request-id="${s.request_id}">Rechazar</button>
        </div>
      </div>
    `).join('');
  } catch (e) {
    console.error(e);
    cont.innerHTML = '<div>Error al cargar solicitudes</div>';
    msg.textContent = e.message || 'Error al cargar';
  }
}

document.getElementById('btnRefrescarSolicitudes')?.addEventListener('click', cargarSolicitudes);

document.addEventListener('click', async (e) => {
  const aprobarBtn = e.target.closest('.aprobar');
  const rechazarBtn = e.target.closest('.rechazar');
  if (!aprobarBtn && !rechazarBtn) return;
  const btn = aprobarBtn || rechazarBtn;
  const card = btn.closest('.card');
  const note = card?.querySelector('.note')?.value || '';
  const requestId = btn.getAttribute('data-request-id');
  const accion = aprobarBtn ? 'aprobar' : 'rechazar';
  if (!requestId) return;

  if (accion === 'aprobar' && !confirm('¿Confirmas aprobar y redimir este cupón?')) return;
  if (accion === 'rechazar' && !confirm('¿Confirmas rechazar esta solicitud?')) return;

  setLoading(btn, true);
  try {
    const fd = new FormData();
    fd.append('request_id', requestId);
    fd.append('accion', accion);
    if (note) fd.append('note', note);
    const resp = await fetchJSON(`${API_BASE}/procesar_solicitud.php`, { method: 'POST', body: fd });
    if (!resp.success) throw new Error(resp.message || 'Error al procesar');
    // Refrescar lista
    await cargarSolicitudes();
  } catch (err) {
    alert(err.message || 'Error al procesar la solicitud');
  } finally {
    setLoading(btn, false);
  }
});

// Primera carga
document.addEventListener('DOMContentLoaded', cargarSolicitudes);

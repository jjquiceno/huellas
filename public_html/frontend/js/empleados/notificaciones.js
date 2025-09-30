const API_NOTI = '../../apis/notificaciones';

async function fetchJSON(url, options = {}) {
  const res = await fetch(url, options);
  const text = await res.text();
  if (!res.ok) throw new Error(`HTTP ${res.status}: ${text.substring(0,200)}`);
  let data; try { data = JSON.parse(text); } catch { throw new Error(`Respuesta no-JSON: ${text.substring(0,200)}`); }
  return data;
}

function fmtDateTime(s) {
  const d = new Date(s);
  if (isNaN(d)) return s || '-';
  return d.toLocaleString('es-ES', { year:'numeric', month:'short', day:'2-digit', hour:'2-digit', minute:'2-digit' });
}

async function cargarNotificacionesEmp() {
  const cont = document.getElementById('listaNotisEmp');
  const msg = document.getElementById('notifEmpMsg');
  if (!cont) return;
  cont.innerHTML = 'Cargando...';
  msg.textContent = '';
  try {
    const data = await fetchJSON(`${API_NOTI}/listar.php?limit=100`);
    if (!data.success) throw new Error(data.message || 'Error al listar');
    const arr = data.data || [];
    if (arr.length === 0) {
      cont.innerHTML = '<div>No tienes notificaciones</div>';
      return;
    }
    cont.innerHTML = arr.map(n => `
      <div class="card ${n.read ? 'read' : 'unread'}">
        <div class="card-title bold">${n.title}</div>
        <div class="regular">${n.body || ''}</div>
        <div class="lightI">${fmtDateTime(n.created_at)}</div>
      </div>
    `).join('');
  } catch (e) {
    console.error(e);
    cont.innerHTML = '<div>Error al cargar notificaciones</div>';
    msg.textContent = e.message || 'Error al cargar';
  }
}

async function marcarTodasLeidasEmp() {
  const msg = document.getElementById('notifEmpMsg');
  try {
    const resp = await fetchJSON(`${API_NOTI}/marcar_leidas.php`, { method: 'POST' });
    if (!resp.success) throw new Error(resp.message || 'No se pudo marcar');
    msg.textContent = 'Notificaciones marcadas como leídas';
    await cargarNotificacionesEmp();
  } catch (e) {
    alert(e.message || 'Error al marcar como leídas');
  }
}

document.getElementById('btnRefrescarNotisEmp')?.addEventListener('click', cargarNotificacionesEmp);

document.getElementById('btnMarcarTodasEmp')?.addEventListener('click', marcarTodasLeidasEmp);

// Primera carga
document.addEventListener('DOMContentLoaded', cargarNotificacionesEmp);

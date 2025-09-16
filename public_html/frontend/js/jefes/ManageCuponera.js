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

// Listar cupones
async function cargarCupones() {
  const lista = document.getElementById('listaCupones');
  const soloActivos = document.getElementById('soloActivos').checked ? 1 : 0;
  lista.innerHTML = 'Cargando...';
  try {
    const data = await fetchJSON(`${API_BASE}/lista_cupones.php?active=${soloActivos}`);
    if (!Array.isArray(data) || data.length === 0) {
      lista.innerHTML = '<div>No hay cupones</div>';
      return;
    }
    lista.innerHTML = data.map(c => `
      <div class="card">
        <div><b>#${c.id}</b> ${c.title}</div>
        <div>${c.description || ''}</div>
        <div>Vigencia: ${c.start_at || '-'} a ${c.end_at || '-'}</div>
        <div>Global: ${c.max_global_redemptions ?? '∞'} | Por usuario: ${c.per_user_limit ?? '∞'}</div>
        <div>Activo: ${c.active ? 'Sí' : 'No'}</div>
      </div>
    `).join('');
  } catch (e) {
    console.error(e);
    lista.innerHTML = '<div>Error al cargar cupones</div>';
  }
}

// Crear cupón
document.getElementById('formCrear')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const btn = e.target.querySelector('button[type="submit"]');
  setLoading(btn, true);
  const fd = new FormData(e.target);
  // Normaliza checkbox active
  if (!fd.has('active')) fd.append('active', '0'); else fd.set('active', '1');
  try {
    const data = await fetchJSON(`${API_BASE}/create_coupon.php`, { method: 'POST', body: fd });
    if (!data.success) throw new Error(data.message || 'Error desconocido');
    document.getElementById('msgCrear').textContent = `Creado. ID: ${data.coupon_id}`;
    e.target.reset();
    cargarCupones();
  } catch (e2) {
    document.getElementById('msgCrear').textContent = e2.message;
  } finally {
    setLoading(btn, false);
  }
});

// Asignar a empleado
document.getElementById('formAsignar')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const btn = e.target.querySelector('button[type="submit"]');
  setLoading(btn, true);
  const fd = new FormData(e.target);
  try {
    const data = await fetchJSON(`${API_BASE}/asignar_cupon.php`, { method: 'POST', body: fd });
    if (!data.success) throw new Error(data.message || 'Error desconocido');
    document.getElementById('msgAsignar').textContent = 'Asignado con éxito';
  } catch (e2) {
    document.getElementById('msgAsignar').textContent = e2.message;
  } finally {
    setLoading(btn, false);
  }
});

// Redimir
document.getElementById('formRedimir')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const btn = e.target.querySelector('button[type="submit"]');
  if (!confirm('¿Confirmas redimir este cupón para este empleado?')) return;
  setLoading(btn, true);
  const fd = new FormData(e.target);
  try {
    const data = await fetchJSON(`${API_BASE}/redimir_cupon.php`, { method: 'POST', body: fd });
    if (!data.success) throw new Error(data.message || 'Error desconocido');
    document.getElementById('msgRedimir').textContent = 'Redimido con éxito';
  } catch (e2) {
    document.getElementById('msgRedimir').textContent = e2.message;
  } finally {
    setLoading(btn, false);
  }
});

// Botón refrescar y checkbox
document.getElementById('btnRefrescar')?.addEventListener('click', cargarCupones);
document.getElementById('soloActivos')?.addEventListener('change', cargarCupones);

// Primera carga
document.addEventListener('DOMContentLoaded', cargarCupones);

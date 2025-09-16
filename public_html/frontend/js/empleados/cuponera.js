// public_html/frontend/js/empleados/cuponera.js
const API_EMP = '../../apis/cupones';
console.log('se cargo el js');

// Función auxiliar para fetch con robustez JSON
async function fetchJSON(url, options = {}) {
  const res = await fetch(url, options);
  const text = await res.text();
  if (!res.ok) throw new Error(`HTTP ${res.status}: ${text.substring(0,180)}`);
  let data;
  try { data = JSON.parse(text); } 
  catch { throw new Error(`Respuesta no-JSON: ${text.substring(0,180)}`); }
  return data;
}

// Utilidades
function fmtDate(s) {
  if (!s) return '-';
  const d = new Date(s);
  if (isNaN(d)) return s;
  return d.toLocaleDateString('es-ES', { year:'numeric', month:'short', day:'2-digit' });
}
function badge(text, cls) {
  return `<span class="badge ${cls}">${text}</span>`;
}

// Carga de cupones (encapsulada y async)
async function cargarCuponesEmpleado() {
  const cont = document.getElementById('listaCuponesEmp');
  if (!cont) return;
  cont.innerHTML = '<div class="cargando">Cargando cupones...</div>';
  try {
    const url = `${API_EMP}/lista_cupones_empleado.php`;
    console.log('GET:', url);
    const data = await fetchJSON(url);

    if (!Array.isArray(data) || data.length === 0) {
      cont.innerHTML = '<div class="cargando">Aún no tienes cupones asignados.</div>';
      return;
    }

    cont.innerHTML = data.map(c => {
      const estado = c.status === 'redimido'
        ? badge('Redimido', 'ok')
        : c.redeemable ? badge('Disponible', 'ok') : badge('No disponible', 'warn');

      const motivos = [];
      if (!c.redeemable) {
        if (!c.active) motivos.push('Cupón inactivo');
        if (c.start_at && new Date() < new Date(c.start_at)) motivos.push('Aún no vigente');
        if (c.end_at && new Date() > new Date(c.end_at)) motivos.push('Vencido');
        if (c.expires_at && new Date() > new Date(c.expires_at)) motivos.push('Asignación vencida');
        if (c.per_user_limit !== null && c.user_redemptions >= c.per_user_limit) motivos.push('Límite por usuario alcanzado');
        if (c.max_global_redemptions !== null && c.global_redemptions >= c.max_global_redemptions) motivos.push('Límite global alcanzado');
        if (c.status === 'redimido') motivos.push('Ya redimido');
      }

      return `
        <div class="cup-card">
          <div class="cup-h">
            <div class="cup-title"><b>${c.title}</b></div>
            <div>${estado}</div>
          </div>
          <div class="cup-body">
            <div class="desc">${c.description || ''}</div>
            <div>Vigencia: ${fmtDate(c.start_at)} a ${fmtDate(c.end_at)}</div>
            <div>Código: ${c.code || '-'}</div>
            <div>Asignado: ${fmtDate(c.assigned_at)} ${c.expires_at ? ' · Expira asignación: ' + fmtDate(c.expires_at) : ''}</div>
            <div>Límites: Global ${c.max_global_redemptions ?? '∞'} · Por usuario ${c.per_user_limit ?? '∞'}</div>
            ${motivos.length ? `<div class="motivos">Motivos: ${motivos.join(' · ')}</div>` : ''}
          </div>
          <div class="cup-foot">
            <button class="btn" ${c.redeemable ? '' : 'disabled'} title="${c.redeemable ? 'Solicitar redención con el jefe' : 'No disponible'}">
              Solicitar redención
            </button>
          </div>
        </div>
      `;
    }).join('');

  } catch (e) {
    console.error(e);
    cont.innerHTML = '<div class="cargando">Error al cargar cupones. Intenta de nuevo.</div>';
  }
}

// Ejecutar al cargar el DOM
// document.addEventListener('DOMContentLoaded', cargarCuponesEmpleado);
cargarCuponesEmpleado();
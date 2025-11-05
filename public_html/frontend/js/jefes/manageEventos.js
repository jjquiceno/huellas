(function(){
  const container = document.getElementById('eventsContainer');
  if (!container) return;

  function htmlEscape(s){ return (s||'').replace(/[&<>"']/g, c=>({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#39;"}[c])); }

  async function fetchEventos(){
    container.innerHTML = '<div class="loading">Cargando eventos...</div>';
    try{
      const res = await fetch('../../apis/eventos/obtener_eventos_jefe.php', { headers: { 'Accept':'application/json', 'X-Requested-With':'XMLHttpRequest' } });
      const text = await res.text();
      let data; try{ data = JSON.parse(text); } catch{ throw new Error(`Respuesta no-JSON (${res.status}): ${text.substring(0,200)}`); }
      if (!res.ok) throw new Error(data?.message || `Error HTTP ${res.status}`);

      if (!Array.isArray(data) || data.length === 0){
        container.innerHTML = '<div class="info-message">No hay eventos publicados actualmente.</div>';
        return;
      }

      const list = document.createElement('div');
      list.className = 'events-list';
      list.style.display = 'grid';
      list.style.gridTemplateColumns = 'repeat(auto-fill, minmax(280px, 1fr))';
      list.style.gap = '16px';

      data.forEach(ev => {
        const card = document.createElement('div');
        card.className = 'event-card';
        card.style.border = '1px solid #ddd';
        card.style.borderRadius = '8px';
        card.style.background = '#fff';
        card.style.overflow = 'hidden';

        const img = document.createElement('img');
        img.src = `../../../uploads/eventos/${encodeURIComponent(ev.imagen_url||'')}`;
        img.alt = ev.titulo || '';
        img.style.width = '100%';
        img.style.height = '160px';
        img.style.objectFit = 'cover';

        const body = document.createElement('div');
        body.style.padding = '12px';
        body.innerHTML = `
          <h3 style="margin:0 0 8px;">${htmlEscape(ev.titulo)}</h3>
          <p style="margin:0 0 8px; color:#555;">${htmlEscape(ev.descripcion)}</p>
          <div style="font-size: 0.9rem; color:#777; margin-bottom:8px;">Fecha: ${htmlEscape(ev.fecha_evento)}</div>
          <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="color:#333;">Likes: ${ev.likes||0}</span>
            <button class="delete-event-btn btn" data-id="${ev.id}">Eliminar</button>
          </div>
        `;

        card.appendChild(img);
        card.appendChild(body);
        list.appendChild(card);
      });

      container.innerHTML = '';
      container.appendChild(list);
    } catch(err){
      console.error(err);
      container.innerHTML = `<div class="error">Error al cargar eventos: ${htmlEscape(err.message||'')}</div>`;
    }
  }

  async function eliminarEvento(id){
    if (!confirm('¿Eliminar este evento? Esta acción no se puede deshacer.')) return;
    try{
      const res = await fetch('../../apis/eventos/eliminar_evento.php', {
        method:'POST',
        headers: { 'Accept':'application/json', 'Content-Type':'application/json', 'X-Requested-With':'XMLHttpRequest' },
        body: JSON.stringify({ id })
      });
      const text = await res.text();
      let data; try{ data = JSON.parse(text); } catch{ throw new Error(`Respuesta no-JSON (${res.status}): ${text.substring(0,200)}`); }
      if (!res.ok || data.success === false) throw new Error(data?.message || `Error HTTP ${res.status}`);
      alert('Evento eliminado correctamente');
      fetchEventos();
    } catch(err){
      console.error(err);
      alert('Error al eliminar evento: ' + (err.message||''));
    }
  }

  document.addEventListener('click', function(e){
    const btn = e.target.closest('button.delete-event-btn');
    if (!btn) return;
    const id = parseInt(btn.getAttribute('data-id'), 10);
    if (Number.isFinite(id)) eliminarEvento(id);
  });

  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    fetchEventos();
  } else {
    document.addEventListener('DOMContentLoaded', fetchEventos);
  }
})();

const menu = document.querySelector('.menu')
const menuToggle = document.querySelector('.menuToggle')
const menuItems = document.querySelectorAll('.menu-item')
const equis = document.querySelector('.equis')
const lineas = document.querySelector('.lineas')
const ppp = document.querySelectorAll('.ppp')
const buttonFormReference = document.querySelector('.buttonFormR')

// Función para cargar un módulo dinámicamente
function loadModule(moduleName) {
    const contentArea = document.querySelector('.main-content-fetch');
    const scriptId = 'dynamicModuleScript';
    
    // Mostrar indicador de carga
    contentArea.innerHTML = '<div class="loading">Cargando...</div>';
    
    // Eliminar el script anterior si existe
    const oldScript = document.getElementById(scriptId);
    if (oldScript) {
        oldScript.remove();
    }
    
    // Cargar el contenido del módulo
    fetch(`${moduleName}.php`)
        .then(response => response.text())
        .then(html => {
            // Insertar el HTML en el área de contenido
            contentArea.innerHTML = html;
            
            // Crear y cargar el script del módulo
            return new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = `../js/${moduleName}.js`;
                script.id = scriptId;
                
                script.onload = function() {
                    // Llamar a la función de inicialización específica del módulo si existe
                    if (window.setupRolesCRUD && typeof window.setupRolesCRUD === 'function') {
                        window.setupRolesCRUD();
                    }
                    resolve(moduleName);
                };
                
                script.onerror = function() {
                    reject(new Error(`Error al cargar el script: ${moduleName}.js`));
                };
                
                document.body.appendChild(script);
            });
        })
        .catch(error => {
            console.error('Error al cargar el módulo:', error);
            contentArea.innerHTML = `
                <div class="error">
                    <p>Error al cargar el módulo: ${error.message}</p>
                    <button onclick="window.location.reload()">Recargar página</button>
                </div>`;
        });
}

// Manejar clics en los elementos del menú
ppp.forEach(itemP => {
    itemP.addEventListener('click', () => {
        // Actualizar la selección visual
        ppp.forEach(item => item.classList.remove('selected'));
        itemP.classList.add('selected');
        
        // Cargar el módulo correspondiente
        const moduleName = itemP.getAttribute('referencia');
        if (moduleName) {
            loadModule(moduleName);
        }
    });
})

equis.style.opacity = '1'
lineas.style.opacity = '0'
menuToggle.addEventListener('click', () => {
    menu.classList.toggle('active')
    if(menu.classList.contains('active')){
        equis.style.opacity = '0'
        lineas.style.opacity = '1'
    }else{
        equis.style.opacity = '1'
        lineas.style.opacity = '0' 
    }
    menuItems.forEach(item => {
        item.classList.toggle('disapear')
    })
    setTimeout(() => {
        menuItems.forEach(item => {
            item.classList.toggle('dis')
        })
    }, 300);
})


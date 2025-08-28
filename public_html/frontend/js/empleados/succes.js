const menu = document.querySelector('.menu')
const menuToggle = document.querySelector('.menuToggle')
const menuItems = document.querySelectorAll('.menu-item')
const equis = document.querySelector('.equis')
const lineas = document.querySelector('.lineas')
const ppp = document.querySelectorAll('.ppp')
const userAbsoluteToggle = document.querySelector('.arrow')
const userAbsolute = document.querySelector('.user-absolute')
const arrowIcon = document.querySelector('.arrow-icon')

fetch('inicio.php')
    .then(response => response.text())
    .then(data => {
        document.querySelector('.main-content-fetch').innerHTML = data;

        // Remover script anterior si existe
        const oldScript = document.getElementById('FetchScript');
        if (oldScript) oldScript.remove();
        
        // Crear y cargar el script
        const script = document.createElement('script');
        script.src = `../js/empleados/inicio.js`;
        script.id = 'FetchScript';
        
        // Cuando el script se cargue, inicializar el slider
        script.onload = function() {
            // Pequeño retraso para asegurar que el DOM esté listo
            setTimeout(() => {
                if (typeof window.initSliderInicio === 'function') {
                    window.initSliderInicio();
                }
            }, 100);
        };
        
        document.body.appendChild(script);
    });

userAbsolute.style.display = 'none'
userAbsoluteToggle.addEventListener('click', () => {
    if(userAbsolute.style.display == 'none'){
        userAbsolute.style.display = 'block'
        setTimeout(() => {
            userAbsolute.classList.toggle('active')
        }, 300);
    }else{
        userAbsolute.classList.toggle('active')
        setTimeout(() => {
            userAbsolute.style.display = 'none'
        }, 300);
    }
    arrowIcon.classList.toggle('active')
})

ppp.forEach(itemP => {
    itemP.addEventListener('click', () => {
        ppp.forEach(itemP => {
            itemP.classList.remove('selected')
        })
        itemP.classList.add('selected')
        const referencia = itemP.getAttribute('referencia')
        fetch(`${referencia}.php`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.main-content-fetch').innerHTML = data
                
                const oldScript = document.getElementById('FetchScript');
                if (oldScript) oldScript.remove();
                const script = document.createElement('script');
                script.src = `../js/empleados/${referencia}.js`;
                script.id = 'FetchScript';
                document.body.appendChild(script);
            })
    })
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

const menu = document.querySelector('.menu')
const menuToggle = document.querySelector('.menuToggle')
const menuItems = document.querySelectorAll('.menu-item')
const equis = document.querySelector('.equis')
const lineas = document.querySelector('.lineas')
const ppp = document.querySelectorAll('.ppp')

fetch('register.php')
    .then(response => response.text())
    .then(data => {
        document.querySelector('.main-content-fetch').innerHTML = data;
    });

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
                script.src = `../js/${referencia}.js`;
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

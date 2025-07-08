fetch('frontend/templates/indexT.html')
    .then(response => response.text())
    .then(html => {
        document.getElementById('container').innerHTML = html;

        const menuToggle = document.getElementById('menu-toggle');
        const menuFloat = document.getElementById('menu-float');
        const closeToggle = document.getElementById('close-toggle');

        menuToggle.addEventListener("click", () => {
            menuFloat.classList.toggle('active');
        });

        closeToggle.addEventListener('click', () => {
            menuFloat.classList.remove('active');
        });

    })
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
        console.log("enviando");
        const response = await fetch('../../../backend/register.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        alert(result.message);
        // Si el registro fue exitoso, carga la página de empleados
        if (result.success) {
            fetch('registerEmpleado.php')
                .then(res => res.text())
                .then(data => {
                    document.querySelector('.main-content-fetch').innerHTML = data;
                    // Si necesitas cargar JS adicional, hazlo aquí
                    const oldScript = document.getElementById('FetchScript');
                    if (oldScript) oldScript.remove();
                    const script = document.createElement('script');
                    script.src = `../js/registerEmpleado.js`;
                    script.id = 'FetchScript';
                    document.body.appendChild(script);
                });
        }
    } catch (error) {
        alert('Error al enviar el formulario');
    }
});
document.getElementById('registerCargo').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
        console.log("enviando");
        const response = await fetch('../../../apis/cargos/crear_cargo.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        alert(result.message);
    } catch (error) {
        alert('Error al enviar el formulario');
    }
});
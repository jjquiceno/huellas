// variables de los modales
const cajon = document.querySelector('.modales');
const cerrar = document.querySelectorAll('.cerrar');
const modales = [
    {tarjeta: document.getElementById('mt1'), ventana: document.getElementById('modal1')}, 
    {tarjeta: document.getElementById('mt2'), ventana: document.getElementById('modal2')}, 
    {tarjeta: document.getElementById('mt3'), ventana: document.getElementById('modal3')}, 
    {tarjeta: document.getElementById('mt4'), ventana: document.getElementById('modal4')}, 
    {tarjeta: document.getElementById('mt5'), ventana: document.getElementById('modal5')}, 
    {tarjeta: document.getElementById('mt6'), ventana: document.getElementById('modal6')}
];

modales.forEach(modal => {
    modal.tarjeta.addEventListener("click", () => {
        modales.forEach(m => m.ventana.style.display = "none")
        cajon.style.display = "flex";
        setTimeout(() => {
            cajon.style.opacity = "1";
        }, 10)
        modal.ventana.style.display = "block";
    });
});
cerrar.forEach(close => {
    close.addEventListener("click", () => {
        cajon.style.opacity = "0";
        setTimeout(() => {
            cajon.style.display = "none";
            modal.ventana.style.display = "none";
        }, 300);
    });
});
// ----------------------------------------------------
document.addEventListener("DOMContentLoaded", function() {
    const numeros = document.querySelectorAll(".numeros");
    numeros.forEach(numero => {
        let start = 0; 
        const end = parseInt(numero.getAttribute("data-end"));
        const time = parseInt(numero.getAttribute("data-time"));
        const increment = 50;
        const incrementAmount = Math.ceil(end/(time/increment));
        const numerito = numero.querySelector('.numeros_number');

        function counter(){
            const interval = setInterval(() => {
                start += incrementAmount;
                if (start >= end){
                    start = end; 
                    clearInterval(interval);
                }
                numerito.textContent = start;
            }, increment);
        };
        const observar = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting){
                    counter();
                    observar.disconnect();
                }
            });
        });
        observar.observe(document.getElementById('numeros'));
    })
})
// ---------------------------------------------------------
AOS.init()
// ---------------------------------------------------------
document.getElementById('contact-btn').addEventListener("click", () => {
    window.location.href = "contacto.php"
})

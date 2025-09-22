// botones
const induccionGeneralBtn = document.getElementById('btnIgeneral');
const cerrarVentanas = document.querySelectorAll('.cerrarVentanas');

// quizes
const quizContainer1 = document.getElementById('modal-quiz-container-1');

// contenedor de estado completado
const quizContainerCompleted = document.getElementById('modal-quiz-container-completed');

// array de contenedores
const contenedores = [quizContainer1, quizContainerCompleted];

induccionGeneralBtn.addEventListener('click', async () => {
    try{
        induccionGeneralBtn.disabled = true;

        const response = await fetch('../../../apis/quizes/s_induccionGeneral.php', {
            method: 'GET',
            headers: {
                // 'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            } 
        });
        if(!response.ok){
            throw new Error('Error al consultar el estado de la inducción');
        }
        const data = await response.json();
        if(!data.completed){
            quizContainer1.style.display = 'flex';
            setTimeout(() => {
                quizContainer1.classList.add('active');
            }, 100);
        }else{
            quizContainerCompleted.style.display = 'flex';
            setTimeout(() => {
                quizContainerCompleted.classList.add('active');
            }, 100);
        }
    } catch(e){
        console.error(e);
    } finally {
        induccionGeneralBtn.disabled = false;
    }
});

cerrarVentanas.forEach(cerrarVentana => {
    cerrarVentana.addEventListener('click', () => {
        contenedores.forEach(contenedor => {
            contenedor.classList.remove('active');
            setTimeout(() => {
                contenedor.style.display = 'none';
            }, 300);
        })
    })
})
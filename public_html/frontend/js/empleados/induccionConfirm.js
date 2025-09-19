// botones
const induccionGeneralBtn = document.getElementById('btnIgeneral');

// quizes
const quizContainer1 = document.getElementById('modal-quiz-container-1');

induccionGeneralBtn.addEventListener('click', () => {
    quizContainer1.style.display = 'flex';
    setTimeout(() => {
        quizContainer1.classList.add('active');
    }, 100);
})
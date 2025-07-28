const containerCform = document.querySelector('.formColillasContainer')
const closeCform = document.querySelector('.closeCform')
const colillasBtn = document.querySelector('.colillas-btn')

containerCform.style.display = 'none'
closeCform.addEventListener('click', () => {
    containerCform.style.opacity = '0'
    setTimeout(() => {
        containerCform.style.display = 'none'
    }, 300)
})
colillasBtn.addEventListener('click', () => {
    containerCform.style.display = 'flex'
    setTimeout(() => {
        containerCform.style.opacity = '1'
    }, 10)
})

const btnDocument = document.querySelectorAll('.btn-document')
btnDocument.forEach(btn => {
    btn.addEventListener('click', () => {
        btnDocument.forEach(btn => {
            btn.classList.remove('selected')
        })
        btn.classList.add('selected')
        document.querySelectorAll('.angleD').forEach(flecha => {
            flecha.classList.remove('active')
        })
        const angleD = btn.querySelector('.angleD')
        angleD.classList.toggle('active')
        const target = btn.getAttribute('data-log')
        const iframe = document.querySelector('.pdf-viewer')
        iframe.src = `../docs/${target}.pdf#toolbar=0&navpanes=0&scrollbar=0`
    })
})
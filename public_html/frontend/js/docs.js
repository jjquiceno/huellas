// arreglo de todos los documento
const documentos = [
    {name: 'cristian', download: '../docs/AI Revolution Documentary Activity.pdf'},
    {name: 'quiceno', download: '../docs/AI Revolution Documentary Activity.pdf'},
    {name: 'juanse', download: '../docs/AI Revolution Documentary Activity.pdf'},
    {name: 'valen', download: '../docs/AI Revolution Documentary Activity.pdf'},
    {name: 'mari', download: '../docs/AI Revolution Documentary Activity.pdf'},
    {name: 'archivo 6', download: '../docs/AI Revolution Documentary Activity.pdf'},
    {name: 'archivo 7', download: '../docs/AI Revolution Documentary Activity.pdf'}
];

function mostrarDocumentos(){
    documentos.forEach((documento) => {
        const padre = document.getElementById('docs');
        const docCaja = document.createElement('div');
        docCaja.classList.add('docCaja');
        
        const docCajaint = document.createElement('div');
        docCajaint.classList.add('docCaja-int', 'dcI1');
    
        const icono = document.createElement('i');
        icono.classList.add('fa-solid', 'fa-file-pdf', 'fa-5x');
        const tittle = document.createElement('p');
        tittle.classList.add('regular'); 
        tittle.textContent = documento.name;   
    
        const separador = document.createElement('div');
        separador.classList.add('separador-black');
    
        const a = document.createElement('a');
        a.classList.add('docCaja-int', 'dcI2', 'bold');
        a.href = documento.download;
        a.download = documento.name;
        a.textContent = 'Descargar';
    
        docCajaint.appendChild(icono);
        docCajaint.appendChild(tittle);
        docCaja.appendChild(docCajaint);  
        docCaja.appendChild(separador);
        docCaja.appendChild(a);
        padre.appendChild(docCaja);
    });    
}

mostrarDocumentos();
// funcion del buscador
function searchFunction(){
    const input = document.querySelector('.buscador-input').value.toLowerCase();
    const padre = document.getElementById('docs');
    padre.innerHTML = ''; 

    if (input === '') {
        mostrarDocumentos(); // Mostrar todos los documentos si el input está vacío
    } else {
        const searchresults = documentos.filter((documento) => documento.name.toLowerCase().includes(input));
        if (searchresults.length > 0) {
            searchresults.forEach((documento) => {
                const docCaja = document.createElement('div');
                docCaja.classList.add('docCaja');
                
                const docCajaint = document.createElement('div');
                docCajaint.classList.add('docCaja-int', 'dcI1');
            
                const icono = document.createElement('i');
                icono.classList.add('fa-solid', 'fa-file-pdf', 'fa-5x');
                const tittle = document.createElement('p');
                tittle.classList.add('regular'); 
                tittle.textContent = documento.name;   
            
                const separador = document.createElement('div');
                separador.classList.add('separador-black');
            
                const a = document.createElement('a');
                a.classList.add('docCaja-int', 'dcI2', 'bold');
                a.href = documento.download;
                a.download = documento.name;
                a.textContent = 'Descargar';
            
                
                docCajaint.appendChild(icono);
                docCajaint.appendChild(tittle);
                docCaja.appendChild(docCajaint);  
                docCaja.appendChild(separador);
                docCaja.appendChild(a);
                padre.appendChild(docCaja);
            });
        } else {
            padre.innerHTML = '<p>No se encontraron resultados</p>'; // Mensaje si no hay resultados
        }
    }
}

const inputElement = document.querySelector('.buscador-input');
const buttonElement = document.querySelector('.buscador-button');

inputElement.addEventListener('input', () => {
    searchFunction();
});

buttonElement.addEventListener('click', (e) => {
    e.preventDefault();
    searchFunction();
});

document.addEventListener('DOMContentLoaded', function() {
    const tipo_contrato = document.getElementById('tipo_contrato');
    const duracion_contrato_div = document.getElementById('duracion_contrato_div');
    const duracion_contrato_input = document.getElementById('duracion_contrato');

    function toggleDuracion(){
        const contratosFijos = ['CPS789', 'CTVF32'];
        if (contratosFijos.includes(tipo_contrato.value)) {
            duracion_contrato_div.style.display = 'block'; 
            duracion_contrato_input.required = true; 
        }else{
            duracion_contrato_div.style.display = 'none';
            duracion_contrato_input.required = false;
            duracion_contrato_input.value = null;
        }
    }
    tipo_contrato.addEventListener('change', toggleDuracion);
    toggleDuracion();
})
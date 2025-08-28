console.log("registerEmpleado.js cargado");
 // Envío del formulario por fetch
 const form = document.getElementById('registerEmpleadoForm');
 if(form){
     console.log("Buscando form:", document.getElementById('registerEmpleadoForm'));
     form.addEventListener('submit', async function(e) {
         e.preventDefault();
         const formData = new FormData(this);
         try {
             const response = await fetch('../../../backend/tablaEmpleados/registerEmpleados.php', {
                 method: 'POST',
                 body: formData
             });
             console.log('Respuesta fetch:', response);
             let result = null;
             try {
                 result = await response.json();
                 console.log('JSON recibido:', result);
             } catch(parseError) {
                 console.error('Error parseando JSON:', parseError);
                 const text = await response.text();
                 console.error('Respuesta como texto:', text);
                 alert('Respuesta inesperada del servidor. Consulta consola para detalles.');
                 return;
             }
             alert(result.message);
             if(result.success){
                 form.reset();
             }
         } catch (error) {
             console.error('Error en fetch:', error);
             alert('Error al enviar el formulario');
         }
         console.log("¡Evento submit interceptado!");
     });
 }

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
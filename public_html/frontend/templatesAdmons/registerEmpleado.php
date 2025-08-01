<?php
    require_once __DIR__. '/../../../helpers/require_login_admin.php';
?>
<!DOCTYPE html>
<html lang="en">
<body> 
    <div class="form-container">
        <form method="post" class="form_form" action="../../../backend/tablaEmpleados/registerEmpleados.php">
            <div class="titule">
                <h3 class="bold WHITE" style="width: fit-content; margin: auto;">REGISTRAR EMPLEADO</h3>
            </div>
            <div class="info-message" data-validate = "La identificacion es requerida">
                <input class="caja_text regular" type="text" name="identificacion" required>
                <label class="label lightI" for="identificacion">identificacion</label>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="info-message" data-validate = "El tipo de identificacion es requerido">
                <select name="tipo_identificacion_id" class="caja_text regular" required>
                    <option value="">Tipo Identificacion</option>
                    <option value="CC132">CC</option>
                    <option value="CE798">CE</option>
                    <option value="TI548">TI</option>
                </select>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="info-message" data-validate = "El nombre es requerido">
                <input class="caja_text regular" type="text" name="nombre" required>
                <label class="label lightI" for="nombre">nombre</label>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="info-message" data-validate="La fecha de nacimiento es requerida">
                <input class="caja_text regular" type="date" name="fecha_nacimiento" required>
                <label class="label lightI" for="fecha_nacimiento">Fecha de Nacimiento</label>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="info-message" data-validate="La fecha de ingreso es requerida">
                <input class="caja_text regular" type="date" name="fecha_ingreso" required>
                <label class="label lightI" for="fecha_ingreso">Fecha de Ingreso</label>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="info-message" data-validate="El nombre de usuario es requerido">
                <input class="caja_text regular" type="text" name="nombre_usuario" required>
                <label class="label lightI" for="nombre_usuario">Nombre de Usuario</label>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="info-message" data-validate = "El cargo es requerido">
                <select name="cargo_id" class="caja_text regular" required>
                    <option value="">Cargo</option>
                    <option value="06">Médico General</option>
                    <option value="07">Oficios Varios – Mayordomo</option>
                    <option value="08">Contador</option>
                    <option value="09">Director Financiero</option>
                    <option value="10">Conductor</option>
                    <option value="11">Auxiliar de Servicios de Mantenimiento</option>
                    <option value="12">Manipulador de Alimentos</option>
                    <option value="13">Servicios Generales</option>
                    <option value="14">Líder Administrativo</option>
                    <option value="15">Gerontólogo</option>
                    <option value="16">Terapeuta Ocupacional</option>
                    <option value="17">Trabajador Social</option>
                    <option value="18">Fonoaudiólogo</option>
                    <option value="19">Fisioterapeuta</option>
                    <option value="20">Nutricionista</option>
                    <option value="21">Psicólogo</option>
                    <option value="22">Cuidador</option>
                    <option value="23">Auxiliar de Enfermería</option>
                    <option value="24">Líder de Enfermería</option>
                    <option value="25">Director General</option>
                </select>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="info-message" data-validate = "El tipo de contrato es requerido">
                <select id="tipo_contrato" name="tipo_contrato_id" class="caja_text regular" required>
                    <option value="">Tipo de Contrato</option>
                    <option value="CPS789">prestacion de servicios termino fijo</option>                                
                    <option value="CPSIN2">prestacion de servicios termino indefinido</option>
                    <option value="CTV145">vinculado termino indefinido</option>                                
                    <option value="CTVF32">vinculado termino fijo</option>
                </select>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div id="duracion_contrato_div" class="info-message" data-validate="La duracion del contrato es requerida">
                <input id="duracion_contrato" class="caja_text regular" type="number" name="duracion_contrato">
                <label class="label lightI" for="duracion_contrato">Duracion del contrato(meses)</label>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="info-message" data-validate="El salario es requerido">
                <input class="caja_text regular" type="text" name="salario" required>
                <label class="label lightI" for="salario">Salario(solo numeros)</label>
                <span></span>
                <div class="separador-black"></div>
            </div>
            <div class="e-b">
                <input type="submit" value="enviar" name="enviar" class="enviar bold">
            </div>
        </form>
    </div>
</body>
</html>
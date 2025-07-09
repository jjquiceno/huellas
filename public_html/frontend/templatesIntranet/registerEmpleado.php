<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Formulario de ingreso a la inducción de la Fundación Huellas del Ayer. Si vas a trabajar con nosotros, completa tu inducción aquí.">
    <meta name="keywords" content="inducción, ingreso, Fundación Huellas del Ayer, trabajar, empleados, formulario, acceso, bienestar">
    <meta name="author" content="Fundación Huellas del Ayer">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#f2ca007c">
    <meta property="og:title" content="Acceso a Inducción - Fundación Huellas del Ayer">
    <meta property="og:description" content="Si vas a trabajar con nosotros, completa tu ingreso a la inducción en este formulario. Fundación Huellas del Ayer.">
    <meta property="og:image" content="https://www.fundacionhuellasdelayer.com/frontend/img/logos/LOGO%20HUELLAS.png">
    <meta property="og:url" content="https://www.fundacionhuellasdelayer.com/frontend/templates/induccionacces.php">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Fundación Huellas del Ayer">
    <meta property="og:locale" content="es_CO">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="Logo de la Fundación Huellas del Ayer">
    <meta property="og:image:secure_url" content="https://www.fundacionhuellasdelayer.com/frontend/img/logos/LOGO%20HUELLAS.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Acceso a Inducción - Fundación Huellas del Ayer">
    <meta name="twitter:description" content="Completa el formulario para ingresar a tu inducción como parte del equipo de la Fundación Huellas del Ayer.">
    <meta name="twitter:image" content="https://www.fundacionhuellasdelayer.com/frontend/img/logos/LOGO%20HUELLAS.png">
    <meta name="twitter:image:alt" content="Logo de la Fundación Huellas del Ayer">
    <link rel="icon" href="../img/logos/LOGO HUELLAS.png">
    <title>REGISTRAR EMPLEADOS</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/induccionacces.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <section class="container">
        <div class="home">
            <div class="home-texts">
                <div class="separador-corto"></div>
                <br>
                <p class="black x2">REGISTRAR EMPLEADOS</p>
                <br>
                <div class="separador"></div>
                <br>
                <P class="regular x1-5">INGRESA LOS DATOS DEL EMPLEADO</P>
                <br>
                <div class="separador-corto"></div>
            </div>
        </div>
        
        <div class="append-content" style="height: fit-content;">
            <div class="form-padre" style="width: 100%; height: fit-content; padding: 7vh 0;">
                <div class="form" style="width: 100%;">
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
                            <select name="tipo_identificacion" class="caja_text regular">
                                <option value="">Tipo Identificacion</option>
                                <option value="">CC</option>
                                <option value="">CE</option>
                                <option value="">PA</option>
                                <option value="">TI</option>
                            </select>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>

                        <div class="info-message" data-validate="La fecha de nacimiento es requerida">
                            <input class="caja_text regular" type="date" name="fecha_nacimiento" required>
                            <label class="label lightI" for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="El nombre de usuarioes necesario">
                            <input class="caja_text regular" type="text" name="nombre_usuario" required>
                            <label class="label lightI" for="nombre_usuario">Nombre de Usuario</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate = "El cargo es requerido">
                            <select name="cargo_id" class="caja_text regular">
                                <option value="">Cargo</option>
                                <option value="1">Administrador</option>
                                <option value="2">Usuario</option>
                            </select>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate = "El tipo de contrato es requerido">
                            <select name="tipo_contrato_id" class="caja_text regular">
                                <option value="">Tipo de Contrato</option>
                                <option value="1">Contrato por prestacion de servicios</option>
                                <option value="2">Contrato vinculado</option>
                            </select>
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
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init()
    </script>
</body>
</html>
<?php
    require_once __DIR__. '/../../../helpers/require_login_admin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/intranetHome.css">
    <link rel="stylesheet" href="../css/admonsHome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Página de Éxito</title>
</head>
<body>
    <section class="dashboard">
        <div class="menu">
            <div class="menu-int">
                <div class="menuToggle">
                    <i class="fa-solid fa-xmark fa-2xl equis"></i>
                    <i class="fa-solid fa-bars fa-2xl lineas"></i>
                </div>
                <div class="separador"></div>
                <div class="boxItems">
                    <div class="menuItems_box">
                        <a href="succes.php" class="ppp2">
                            <i class="fa-solid fa-house"></i>
                            <span class="BLACK regular menu-item">Registrar un empleado nuevo</span>
                        </a>
                        <a href="registerJefe.php" class="ppp2">
                            <i class="fa-solid fa-house"></i>
                            <span class="BLACK regular menu-item">Registrar un líder nuevo</span>
                        </a>
                        <a href="empleadosCRUD.php" class="ppp2">
                            <i class="fa-solid fa-database"></i>
                            <span class="BLACK regular menu-item">ver tabla de empleados</span>
                        </a>
                        <a href="rolesCRUD.php" class="ppp2">
                            <i class="fa-solid fa-database"></i>
                            <span class="BLACK regular menu-item">ver tabla de roles</span>
                        </a>
                        <a href="usuariosCRUD.php" class="ppp2">
                            <i class="fa-solid fa-database"></i>
                            <span class="BLACK regular menu-item">ver tabla de usuarios</span>
                        </a>
                        <a href="lideresCRUD.php" class="ppp2">
                            <i class="fa-solid fa-database"></i>
                            <span class="BLACK regular menu-item">ver tabla de líderes</span>
                        </a>
                    </div>
                    <div class="menuItems_box">
                        <div class="separador"></div>
                        <a href="../../../backend/logout.php" class="ppp2">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="BLACK regular menu-item">Cerrar sesión</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-container">
            <div class="main-header">
                <div class="container-user">
                    <div class="legend">
                        <i class="fa-solid fa-circle-user fa-2xl" style="color: #f2ca00;"></i>
                    </div>
                    <div class="user-info">
                        <div class="user">
                            <span class="BLACK regular"><?php echo $_SESSION['username']; ?></span>
                        </div>
                        <div class="user">
                            <span class="BLACK regular"><?php echo $_SESSION['rol']; ?></span>
                        </div>
                    </div>
                </div>
                <div class="logoH">
                    <img style="width: 5vw;" src="../img/logos/LOGO HUELLAS.png" alt="logo">
                </div>
            </div>
            <div class="main-content-fetch">
                <!-- <form action="../../../backend/tablaJefes/registerJefe.php" method="post">
                    <label for="nombre_usuario">Nombre de usuario:</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" required>

                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" required>

                    <label for="correo">Email:</label>
                    <input type="email" id="correo" name="correo" required>

                    <label for="identificacion">Identificacion:</label>
                    <input type="text" id="identificacion" name="identificacion" required>

                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                    
                    <button type="submit">Registrarse</button>
                </form> -->

                <div class="form-container">
                    <form id="registerEmpleadoForm" class="form_form">
                        <div class="titule">
                            <h3 class="bold" style="width: fit-content; margin: auto;">REGISTRAR EMPLEADO</h3>
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
                        <div class="info-message" data-validate = "La identificacion es requerida">
                            <input class="caja_text regular" type="text" name="identificacion" required>
                            <label class="label lightI" for="identificacion">identificacion</label>
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
                            <label class="label lightI labelActive" for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="La fecha de ingreso es requerida">
                            <input class="caja_text regular" type="date" name="fecha_ingreso" required>
                            <label class="label lightI labelActive" for="fecha_ingreso">Fecha de Ingreso</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="el celular es requerido">
                            <input class="caja_text regular" type="text" name="celular" required>
                            <label class="label lightI" for="celular">celular</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="la dirección es requerido">
                            <input class="caja_text regular" type="text" name="direccion" required>
                            <label class="label lightI" for="direccion">direccion</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="la EPS es requerida">
                            <input class="caja_text regular" type="text" name="eps" id="eps" required>
                            <label class="label lightI" for="eps">EPS</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="la AFP es requerida">
                            <input class="caja_text regular" type="text" name="afp" id="afp" required>
                            <label class="label lightI" for="afp">AFP</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="la ARL es requerida">
                            <input class="caja_text regular" type="text" name="arl" id="arl" required>
                            <label class="label lightI" for="arl">ARL</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="la CAJA es requerida">
                            <input class="caja_text regular" type="text" name="caja" id="caja" required>
                            <label class="label lightI" for="caja">CAJA</label>
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate="El nombre de usuario es requerido">
                            <!-- <input class="caja_text regular" type="text" name="nombre_usuario" required> -->
                            <select name="nombre_usuario" class="caja_text regular" required>
                                <option value="">Nombre de Usuario</option>
                                <?php
                                include __DIR__ . '/../../../backend/conexion.php';
                                $sql = "SELECT * FROM usuarios";
                                $result = $conexion->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['nombre_usuario']) . "'>" . htmlspecialchars($row['nombre_usuario']) . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <!-- <label class="label lightI" for="nombre_usuario">Nombre de Usuario</label> -->
                            <span></span>
                            <div class="separador-black"></div>
                        </div>
                        <div class="info-message" data-validate = "El cargo es requerido">
                            <select name="cargo_id" class="caja_text regular" required>
                                <option value="">Cargo</option>
                                <?php
                                include __DIR__ . '/../../../backend/conexion.php';
                                $sql = "SELECT * FROM cargos";
                                $result = $conexion->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['cargo_id']) . "'>" . htmlspecialchars($row['cargo']) . "</option>";
                                    }
                                }
                                ?>
                                <!-- <option value="06">Médico General</option>
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
                                <option value="25">Director General</option> -->
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
            </div>
        </div>
    </section>
    <script src="../js/administradores/succesAdmonsCRUDS.js"></script>
    
</body>
</html>
<?php
$conexion->close();
?>
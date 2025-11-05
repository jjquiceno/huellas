<?php
    require_once __DIR__. '/../../../helpers/require_login_admin.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';"> -->
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/intranetHome.css">
    <link rel="stylesheet" href="../css/admonsHome.css">
    <!-- <link rel="stylesheet" href="../css/induccionacces.css"> -->
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
                        <p class="ppp">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <a href="../../../backend/logout.php" class="BLACK regular menu-item">Cerrar sesión</a>
                        </p>
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
                <div class="containerTables">
                    <h2 class="bold textFi">Lista de Empleados</h2>
                    <table class="regular empleadosTable" border="1" cellpadding="8" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Identificación</th>
                                <th>Tipo Identificación</th>
                                <th>Nombre</th>
                                <th>Fecha Nacimiento</th>
                                <th>Fecha Ingreso</th>
                                <th>Celular</th>
                                <th>Direccion</th>
                                <th>EPS</th>
                                <th>AFP</th>
                                <th>ARL</th>
                                <th>CAJA</th>
                                <th>Nombre Usuario</th>
                                <th>Cargo</th>
                                <th>Tipo Contrato</th>
                                <th>Duración Contrato</th>
                                <th>Salario</th>
                                <th>Inducción General</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        include __DIR__ . '/../../../backend/conexion.php';
                        $sql = "SELECT * FROM empleados";
                        $result = $conexion->query($sql);
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['identificacion']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['tipo_identificacion_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_nacimiento']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fecha_ingreso']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['celular']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['direccion']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['eps']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['afp']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['arl']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['caja']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nombre_usuario']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['cargo_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['tipo_contrato_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['duracion_contrato']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['salario']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['induccionGeneral']) . "</td>";
                                echo '
                                    <td>
                                        <button class="edit-btn">Editar</button> 
                                        <button class="delete-btn" data-id="' . htmlspecialchars($row['identificacion']) . '">Eliminar</button>
                                    </td>';
                                echo "</tr>";
                            }
                        } else {
                            echo '<tr><td colspan="11">No hay empleados registrados.</td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/administradores/succesAdmonsCRUDS.js"></script>
    <script src="../js/administradores/empleadosCRUD.js"></script>
</body>
</html>
<?php
$conexion->close();
?>
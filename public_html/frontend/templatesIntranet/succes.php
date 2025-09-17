<?php
require_once '../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/intranetHome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Página de Éxito</title>
    <!-- <script src="../js/empleados/cuponera.js" defer></script> -->
</head>
<body>
    <section class="dashboard">
        <div class="menu">
            <div class="menu-int">
                <div class="menuToggle" data-aos="fade-down">
                    <i class="fa-solid fa-xmark fa-2xl equis"></i>
                    <i class="fa-solid fa-bars fa-2xl lineas"></i>
                </div>
                <div class="separador"></div>
                <div class="boxItems">
                    <div class="menuItems_box">
                        <p class="ppp" referencia="inicio" data-aos="fade-down" data-aos-delay="100">
                            <i class="fa-solid fa-house"></i>
                            <span class="BLACK regular menu-item">Inicio</span>
                        </p>
                        <p class="ppp" referencia="induccion" data-aos="fade-down" data-aos-delay="200">
                            <i class="fa-solid fa-landmark"></i>
                            <span class="BLACK regular menu-item">Inducción</span>
                        </p>
                        <p class="ppp" referencia="documentos" data-aos="fade-down" data-aos-delay="300">
                            <i class="fa-solid fa-file"></i>
                            <span class="BLACK regular menu-item">Documentos<br>del empleado</span>
                        </p>
                        <p class="ppp" referencia="documentosReg" data-aos="fade-down" data-aos-delay="400">
                            <i class="fa-solid fa-book"></i>
                            <span class="BLACK regular menu-item">Documentos<br>reglamentarios</span>
                        </p>
                        <p class="ppp" referencia="novedades" data-aos="fade-down" data-aos-delay="500">
                            <i class="fa-solid fa-newspaper"></i>
                            <span class="BLACK regular menu-item">Novedades<br>en Huellas</span>
                        </p>
                        <p class="ppp" referencia="cuponera" data-aos="fade-down" data-aos-delay="600">
                            <i class="fa-solid fa-ticket"></i>
                            <span class="BLACK regular menu-item">Cuponera</span>
                        </p>
                    </div>
                    <div class="menuItems_box">
                        <div class="separador"></div>
                        <!-- <p class="ppp" referencia="ajustesPerfil">
                            <i class="fa-solid fa-user"></i>
                            <span class="BLACK regular menu-item">Ajustes<br>del perfil</span>
                        </p> -->
                        <p class="ppp" referencia="notificaciones">
                            <i class="fa-solid fa-bell"></i>
                            <span class="BLACK regular menu-item">Notificaciones</span>
                        </p>
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
                <div class="container-searchBar" data-aos="fade-down" data-aos-delay="100">
                    <div class="info-message" data-validate = "La identificacion es requerida">
                        <input class="caja_text regular" type="text" name="buscador" required>
                        <label class="label lightI" for="buscador"><i class="fa-solid fa-magnifying-glass fa-lg"></i></label>
                    </div>
                </div>
                <div class="container-user">
                    <div class="legend">
                        <i class="fa-solid fa-circle-user fa-2xl" style="color: #f2ca00;" data-aos="fade-down" data-aos-delay="200"></i>
                    </div>
                    <div class="user-info">
                        <div class="user">
                            <span class="BLACK regular" data-aos="fade-down" data-aos-delay="300"><?php echo $_SESSION['username']; ?></span>
                        </div>
                        <div class="user">
                            <span class="BLACK regular" data-aos="fade-down" data-aos-delay="400"><?php echo isset($_SESSION['cargo']) ? htmlspecialchars($_SESSION['cargo']) : 'Cargo no especificado'; ?></span>
                        </div>
                    </div>
                    <div class="arrow">
                        <i class="fa-solid fa-angle-down fa-xl arrow-icon"></i>
                    </div>
                    <div class="user-absolute">
                        <div>
                            <p class="ppp" referencia="userProfile">
                                <i class="fa-solid fa-user"></i>
                                <span class="BLACK regular menu-item">Mi perfil</span>
                            </p>
                            <p class="ppp" referencia="ajustesPerfil">
                                <i class="fa-solid fa-user"></i>
                                <span class="BLACK regular menu-item ppp" referencia="ajustesPerfil">Ajustes</span>
                            </p>
                            <div class="separador-op"></div>
                            <p class="ppp">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <a href="../../../backend/logout.php" class="BLACK regular menu-item">Cerrar sesión</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="logoH">
                    <img style="width: 5vw;" src="../img/logos/LOGO HUELLAS.png" alt="logo">
                </div>
            </div>
            <div class="main-content-fetch">

            </div>
        </div>
    </section>
    <script src="../js/empleados/succes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init()
    </script>
    <script>
        // public_html/frontend/js/empleados/cuponera.js
        const API_EMP = '../../apis/cupones';
        console.log('se cargo el js');

        // Función auxiliar para fetch con robustez JSON
        async function fetchJSON(url, options = {}) {
        const res = await fetch(url, options);
        const text = await res.text();
        if (!res.ok) throw new Error(`HTTP ${res.status}: ${text.substring(0,180)}`);
        let data;
        try { data = JSON.parse(text); } 
        catch { throw new Error(`Respuesta no-JSON: ${text.substring(0,180)}`); }
        return data;
        }

        // Utilidades
        function fmtDate(s) {
        if (!s) return '-';
        const d = new Date(s);
        if (isNaN(d)) return s;
        return d.toLocaleDateString('es-ES', { year:'numeric', month:'short', day:'2-digit' });
        }
        function badge(text, cls) {
        return `<span class="badge ${cls}">${text}</span>`;
        }

        // Carga de cupones (encapsulada y async)
        async function cargarCuponesEmpleado() {
        const cont = document.getElementById('listaCuponesEmp');
        if (!cont) return;
        cont.innerHTML = '<div class="cargando">Cargando cupones...</div>';
        try {
            const url = `${API_EMP}/lista_cupones_empleado.php`;
            console.log('GET:', url);
            const data = await fetchJSON(url);

            if (!Array.isArray(data) || data.length === 0) {
            cont.innerHTML = '<div class="cargando">Aún no tienes cupones asignados.</div>';
            return;
            }

            cont.innerHTML = data.map(c => {
            const estado = c.status === 'redimido'
                ? badge('Redimido', 'ok')
                : c.redeemable ? badge('Disponible', 'ok') : badge('No disponible', 'warn');

            const motivos = [];
            if (!c.redeemable) {
                if (!c.active) motivos.push('Cupón inactivo');
                if (c.start_at && new Date() < new Date(c.start_at)) motivos.push('Aún no vigente');
                if (c.end_at && new Date() > new Date(c.end_at)) motivos.push('Vencido');
                if (c.expires_at && new Date() > new Date(c.expires_at)) motivos.push('Asignación vencida');
                if (c.per_user_limit !== null && c.user_redemptions >= c.per_user_limit) motivos.push('Límite por usuario alcanzado');
                if (c.max_global_redemptions !== null && c.global_redemptions >= c.max_global_redemptions) motivos.push('Límite global alcanzado');
                if (c.status === 'redimido') motivos.push('Ya redimido');
            }

            return `
                <div class="cup-card">
                <div class="cup-h">
                    <div class="cup-title bold"><b>${c.title}</b></div>
                    <div class="light">${estado}</div>
                </div>
                <div class="cup-body">
                    <div class="desc regular">${c.description || ''}</div>
                    <div class="regular"><span class="bold">Vigencia:</span> ${fmtDate(c.start_at)} a ${fmtDate(c.end_at)}</div>
                    <div class="regular"><span class="bold">Asignado:</span> ${fmtDate(c.assigned_at)} ${c.expires_at ? ' · Expira asignación: ' + fmtDate(c.expires_at) : ''}</div>
                    ${motivos.length ? `<div class="motivos lightI">Motivos: ${motivos.join(' · ')}</div>` : ''}
                </div>
                <div class="cup-foot">
                    <button class="btn" ${c.redeemable ? '' : 'disabled'} title="${c.redeemable ? 'Solicitar redención con el jefe' : 'No disponible'}">
                    Solicitar redención
                    </button>
                </div>
                </div>
            `;
            }).join('');

        } catch (e) {
            console.error(e);
            cont.innerHTML = '<div class="cargando">Error al cargar cupones. Intenta de nuevo.</div>';
        }
        }

        // Ejecutar al cargar el DOM
        // document.addEventListener('DOMContentLoaded', cargarCuponesEmpleado);
        cargarCuponesEmpleado();
    </script>
</body>
</html>
<?php
$conexion->close();
?>
<!-- limites -->
<!-- <div class="regular"><span class="bold">Límites:</span> Global ${c.max_global_redemptions ?? '∞'} · Por usuario ${c.per_user_limit ?? '∞'}</div> -->

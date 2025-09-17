<?php
require_once '../../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/home.css">
    <link rel="stylesheet" href="../../css/formato-induccion.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container-Induccion">
        <div class="headerInduccion">
            <i class="fa-solid fa-angle-left fa-2xl InBack"></i>
            <div class="user">
                <p class="bold x1"><?php echo $_SESSION['username']; ?></p>
                <p class="regular x1"><?php echo $_SESSION['cargo']; ?></p>
            </div>
            <i class="fa-solid fa-minus fa-2xl"></i>
            <p class="bold x1">INDUCCIÓN GENERAL</p>
        </div>
        <div class="contentInduccion">
            <div class="CI_int regular">
                <article id="a-1">
                    <h1 class="bold title-border">¿QUIÉNES SOMOS?</h1>
                    <br>
                    <p>La Fundación Huellas del Ayer, creada en abril de 2011, nace con la misión de proporcionar un espacio de paz y calidad de vida para adultos mayores. Comprometidos con el servicio, la integración y el bienestar, nuestro equipo altamente calificado se enfoca en la tranquilidad de los usuarios y sus familias, marcando la diferencia para aquellos que nos necesitan.</p>
                </article>
                <!-- <br> -->
                <div id="a-MV">
                    <article>
                        <h1 class="bold title-border">MISIÓN</h1>
                        <br>
                        <P>Somos un equipo de profesionales dedicados con enfoque humano, comprometidos en desarrollar e implementar estrategias innovadoras para el cuidado, ampliando la esperanza de vida saludable y mejorando la calidad de vida de los adultos mayores.</P>
                    </article>
                    <article>
                        <h1 class="bold title-border">VISIÓN</h1>
                        <br>
                        <P>En el 2030, nos consolidaremos como líderes nacionales destacados en el diseño y ejecución de programas revolucionarios para el bienestar de la población adulta mayor y en condición de discapacidad. Buscamos generar transformaciones significativas no solo en su calidad de vida, sino también en su entorno más cercano, siendo reconocidos como agentes clave de positividad y cambio.</P>
                    </article>
                </div>
                <div id="a-2">
                    <h1 class="bold title-border">VALORES</h1>
                    <br><br>
                    <div>
                        <div>
                            <h2>Empatía</h2>
                            <p>Nos conectamos emocionalmente, compartiendo alegrías y apoyando en momentos difíciles. Somos un equipo que siente y comprende las emociones de los demás.</p>
                        </div>
                        <div>
                            <h2>Compromiso</h2>
                            <p>Convertimos promesas en acciones tangibles. Valoramos la importancia de cumplir plazos, dedicando nuestra máxima capacidad para llevar a cabo las tareas asignadas con eficiencia.</p>
                        </div>
                        <div>
                            <h2>Solidaridad</h2>
                            <p>Actuamos como un todo, comprendiendo nuestras necesidades con respeto y empatía. Entendemos que el apoyo mutuo es esencial para el bienestar de todos.</p>
                        </div>
                        <div>
                            <h2>Honestidad</h2>
                            <p>Vivimos con coherencia entre pensar, expresar y actuar, siempre priorizando la verdad. Construimos relaciones basadas en la transparencia y la integridad.</p>
                        </div>
                    </div>
                </div>
                <div class="separador-black"></div>
                <article id="a-3">
                    <h1 class="bold title-border">ASPECTOS CONTRACTUALES</h1>
                    <br><br>
                    <div>
                        <h2 style="width: 100%;">Contrato de trabajo a término fijo</h2>
                        <ol>
                            <li>Debe constar siempre por escrito y su duración no puede ser superior a tres (3) años, pero es renovable indefinidamente.</li>
                            <li>Si antes de la fecha de vencimiento del término estipulado, ninguna de las partes avisa por escrito a la otra su determinación de no prorrogar el contrato, con una antelación no inferior a treinta (30) días, éste se entenderá renovado por un período igual al inicialmente pactado, y así sucesivamente.</li>
                            <li>No obstante, si el término fijo es inferior a un (1) año, únicamente podrá prorrogarse sucesivamente el contrato hasta por tres (3) períodos iguales o inferiores, al cabo de los cuales, el término de renovación no podrá ser inferior a un (1) año, y así sucesivamente.</li>
                            <li>En los contratos a término fijo inferior a un año, los trabajadores tendrán derecho al pago de vacaciones y prima de servicios en proporción al tiempo laborado cualquiera que éste sea. (Art. 46 C.S.T.).</li>
                        </ol>
                    </div>
                    <br>
                    <div>
                        <h2>Nómina y Seguridad Social</h2>
                        <div style="display: flex; flex-direction: column; gap: .5rem;">
                            <p>La nómina se paga de forma mensual los días 5 primeros días de cada mes y es consignada en la cuenta bancaria reportada por el empleado.</p>
                            <p>Las y los recibos de pago son enviados al correo electrónico personal indicado por cada empleado.</p>
                            <p>En el caso de presentarse una incapacidad laboral (establecida por la EPS a la cual se encuentre afiliado el empleado), debe avisar al jefe inmediato y hacer llegar la incapacidad en el menor tiempo posible tanto al jefe inmediato como a talento humano.</p>
                            <p>El pago de la incapacidad general se pagará al empleado los primeros 2 días al 100% del valor del salario, a partir del día 3 hasta el día 90 se paga el 66,67%. Las incapacidades por accidente laboral se pagará al empleado al 100%.</p>
                            <p>Las madres gestantes deben notificar por escrito junto con la certificación de estado de embarazo a su jefe inmediato y a talento humano sobre su estado y la fecha aproximada del parto.</p>
                            <p>Igualmente, en el caso de un embarazo de alto riesgo o alguna prescripción médica especial se deben adjuntar los documentos que lo soporten.</p>
                            <p>Las inquietudes de nómina pueden dirigirse al correo electrónico: administracion@fundacionhuellasdelayer.com, en el cual la auxiliar de Talento Humano da la respuesta.</p>
                        </div>
                    </div>
                    <br>
                    <div>
                        <h2>Liquidación de prestaciones sociales</h2>
                        <div>
                            <p>Una vez terminado el contrato de trabajo, y el empleado esté a paz y salvo por todo concepto, será entregada la liquidación de prestaciones sociales correspondientes y proporcionales al período laborado, inclusive: prima, vacaciones, cesantías e intereses a las cesantías. La liquidación es consignada en la cuenta bancaria reportada por el empleado.</p>
                        </div>
                    </div>
                    <br>
                    <div>
                        <h2>Solicitud de cartas laborales, colillas de pago, cesantías y demás asuntos relacionados con la contratación</h2>
                        <div>
                            <p>Se debe realizar la solicitud al correo electrónico administracion@fundacionhuellasdelayer.com</p>
                        </div>
                    </div>
                </article>
                <div class="separador-black"></div>
                <article id="a-4">
                    <h1 class="bold title-border" style="margin: 0 auto;">REGLAMENTO INTERNO DE TRABAJO</h1>
                    <p>Su objetivo es permitir a la Fundación dirigir adecuadamente sus operaciones con disciplina, y emitir sanciones de acuerdo a la ley para resolver conflictos, y tratar a los empleados de acuerdo a lo que en él se indica</p>
                    <div id="a-4-1">
                        <div>
                            <h2>Son obligaciones especiales de la fundación:</h2>
                            <ol>
                                <li>Poner a disposición de los trabajadores, salvo estipulación en contrario, los instrumentos adecuados y las materias primas necesarias para la realización de las labores.</li>
                                <li>Pagar la remuneración pactada en las condiciones, períodos y lugares convenidos.</li>
                                <li>Abrir y llevar al día los registros de horas extras.</li>
                                <li>Guardar absoluto respeto a la dignidad personal del trabajador, a sus creencias e ideologías.</li>
                                <li>Cumplir este reglamento y mantener el orden, la moralidad y el respeto a las leyes.</li>
                                <li>Crear mecanismos de prevención de acoso laboral y establecer un procedimiento interno, confidencial y conciliatorio sobre él.</li>
                                <li>Fomentar y estabilizar la política de alcohol y drogas. Internamente se deberán establecer los instrumentos para prevenir el consumo, restringir el porte y evitar que el trabajador se presente a la jornada de trabajo bajo los efectos de sustancias psicotrópicas y/o psicoactivas. Lo anterior en virtud de las consecuencias disciplinarias que podrían imponerse al trabajador las cuales están reguladas en el presente documento.</li>
                            </ol>
                        </div>
                        <div>
                            <h2>Son obligaciones especiales del trabajador</h2>
                            <ol>
                                <li>Realizar personalmente la labor, en los términos estipulados.</li>
                                <li>Observar los preceptos del reglamento y acatar y cumplir las órdenes e instrucciones que de modo particular impartan el empleador o sus representantes, según el orden jerárquico establecido.</li>
                                <li>Participar en el cuidado y vigilancia de los elementos de trabajo y los productos que se encuentren dentro de las instalaciones de la fundación, con el fin de evitar daños o pérdidas a los mismos.</li>
                                <li>Guardar rigurosamente la moral en las relaciones con sus compañeros y compañeras.</li>
                                <li>Comunicar oportunamente al empleador las observaciones que estime conducentes a evitarle daños y perjuicios.</li>
                                <li>Cumplir las órdenes e instrucciones que le impartan los superiores jerárquicos en cuanto a tiempo, modo, lugar y calidad del trabajo.</li>
                            </ol>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$conexion->close();
?>

<?php
require_once '../../../../helpers/require_login.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/home.css">
    <link rel="stylesheet" href="../../css/intranetHome.css">
    <link rel="stylesheet" href="../../css/formato-induccion.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container-Induccion">
        <div class="headerInduccion">
            <i class="fa-solid fa-angle-left fa-2xl InBack" onclick="window.history.back()"></i>
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
                            <li><span class="indicador-list">1. </span>Debe constar siempre por escrito y su duración no puede ser superior a tres (3) años, pero es renovable indefinidamente.</li>
                            <li><span class="indicador-list">2. </span>Si antes de la fecha de vencimiento del término estipulado, ninguna de las partes avisa por escrito a la otra su determinación de no prorrogar el contrato, con una antelación no inferior a treinta (30) días, éste se entenderá renovado por un período igual al inicialmente pactado, y así sucesivamente.</li>
                            <li><span class="indicador-list">3. </span>No obstante, si el término fijo es inferior a un (1) año, únicamente podrá prorrogarse sucesivamente el contrato hasta por tres (3) períodos iguales o inferiores, al cabo de los cuales, el término de renovación no podrá ser inferior a un (1) año, y así sucesivamente.</li>
                            <li><span class="indicador-list">4. </span>En los contratos a término fijo inferior a un año, los trabajadores tendrán derecho al pago de vacaciones y prima de servicios en proporción al tiempo laborado cualquiera que éste sea. (Art. 46 C.S.T.).</li>
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
                            <h2>Son obligaciones especiales <br>de la fundación:</h2>
                            <ol>
                                <li><span class="indicador-list">1. </span>Poner a disposición de los trabajadores, salvo estipulación en contrario, los instrumentos adecuados y las materias primas necesarias para la realización de las labores.</li>
                                <li><span class="indicador-list">2. </span>Pagar la remuneración pactada en las condiciones, períodos y lugares convenidos.</li>
                                <li><span class="indicador-list">3. </span>Abrir y llevar al día los registros de horas extras.</li>
                                <li><span class="indicador-list">4. </span>Guardar absoluto respeto a la dignidad personal del trabajador, a sus creencias e ideologías.</li>
                                <li><span class="indicador-list">5. </span>Cumplir este reglamento y mantener el orden, la moralidad y el respeto a las leyes.</li>
                                <li><span class="indicador-list">6. </span>Crear mecanismos de prevención de acoso laboral y establecer un procedimiento interno, confidencial y conciliatorio sobre él.</li>
                                <li><span class="indicador-list">7. </span>Fomentar y estabilizar la política de alcohol y drogas. Internamente se deberán establecer los instrumentos para prevenir el consumo, restringir el porte y evitar que el trabajador se presente a la jornada de trabajo bajo los efectos de sustancias psicotrópicas y/o psicoactivas. Lo anterior en virtud de las consecuencias disciplinarias que podrían imponerse al trabajador las cuales están reguladas en el presente documento.</li>
                            </ol>
                        </div>
                        <div>
                            <h2>Son obligaciones especiales <br>del trabajador</h2>
                            <ol>
                                <li><span class="indicador-list">1. </span>Realizar personalmente la labor, en los términos estipulados.</li>
                                <li><span class="indicador-list">2. </span>Observar los preceptos del reglamento y acatar y cumplir las órdenes e instrucciones que de modo particular impartan el empleador o sus representantes, según el orden jerárquico establecido.</li>
                                <li><span class="indicador-list">3. </span>Participar en el cuidado y vigilancia de los elementos de trabajo y los productos que se encuentren dentro de las instalaciones de la fundación, con el fin de evitar daños o pérdidas a los mismos.</li>
                                <li><span class="indicador-list">4. </span>Guardar rigurosamente la moral en las relaciones con sus compañeros y compañeras.</li>
                                <li><span class="indicador-list">5. </span>Comunicar oportunamente al empleador las observaciones que estime conducentes a evitarle daños y perjuicios.</li>
                                <li><span class="indicador-list">6. </span>Cumplir las órdenes e instrucciones que le impartan los superiores jerárquicos en cuanto a tiempo, modo, lugar y calidad del trabajo.</li>
                            </ol>
                        </div>
                    </div>
                    <br>
                    <div class="separador-black" style="width: 90%;"></div>
                    <br>
                    <div id="a-4-2">
                        <h2>Sanciones disciplinarias</h2>
                        <p>El objetivo de las sanciones disciplinarias es el de corregir y evitar la reincidencia en faltas o irregularidades incurridas por parte del trabajador.</p>
                        <p>Es política de la fundación proporcionar las oportunidades a los trabajadores para corregir sus actitudes, salvo que éstas por su gravedad material, ameriten la aplicación inflexible de las disposiciones del presente reglamento.</p>
                        <p>La fundación estableció cinco (05) clases de sanciones disciplinarias para casos de infracciones de normas internas o legislación vigente, estas son:</p>
                        <br>
                        <ol style="width: 50%; margin: auto;">
                            <li><span class="indicador-list">1. </span>Amonestación verbal: Es la aplicación preventiva a la falta de gravedad leve. Podrá ser aplicada por el jefe inmediato al trabajador.</li>
                            <li><span class="indicador-list">2. </span>Amonestación escrita: Es la sanción correctiva de faltas leves pero renuentes y podrá ser aplicada por el jefe inmediato del trabajador.</li>
                            <li><span class="indicador-list">3. </span>Multa: No más del 20% del salario mensual vigente.</li>
                            <li><span class="indicador-list">4. </span>Suspensión del contrato.</li>
                            <li><span class="indicador-list">5. </span>Terminación del contrato por falta grave.</li>
                        </ol>
                        <br>
                        <div>
                            <div>
                                <p style="width: 100%;">Se establecen las siguientes clases de <span style="font-weight: bold;">faltas leves</span> y sus sanciones disciplinarias, así:</p>
                                <br>
                                <ol>
                                    <li><span class="indicador-list">1. </span>El retardo hasta de quince (15) minutos en la hora de entrada sin excusa suficiente, cuando no causa perjuicio de consideración a la fundación implica, por primera vez una amonestación escrita la cual debe quedar debidamente registrada por el jefe inmediato del trabajador. Por segunda vez, multa de la quinta parte del salario de un día; por tercera vez, suspensión en el trabajo hasta por tres días.</li>
                                    <li><span class="indicador-list">2. </span>La falta en el trabajo en el turno correspondiente, sin excusa suficiente cuando no causen perjuicio de consideración a la fundación, implica por primera vez una suspensión en el trabajo hasta por tres (3) días.</li>
                                    <li><span class="indicador-list">3. </span>La falta total al trabajo durante el día sin excusa suficiente, cuando no cause perjuicio de consideración a la fundación, implica, por primera vez, suspensión en el trabajo hasta por ocho (8) días.</li>
                                    <li><span class="indicador-list">4. </span>La violación leve por parte del trabajador de las obligaciones contractuales o reglamentarias implica, por primera vez, suspensión en el trabajo hasta por ocho (8) días, y por segunda vez, suspensión en el trabajo hasta por dos (2) meses.</li>
                                </ol>
                            </div>
                            <div>
                                <p style="width: 100%;">Constituyen algunas <span style="font-weight: bold;">faltas graves</span>, sancionables con la terminación del contrato con justa causa, además de las estipuladas en el contrato:</p>
                                <br>
                                <ol>
                                    <li><span class="indicador-list">1. </span>El retardo hasta de quince (15) minutos a la hora de entrada al trabajo sin excusa suficiente, por cuarta vez.</li>
                                    <li><span class="indicador-list">2. </span>La falta total del trabajador en el turno correspondiente, sin excusa suficiente por segunda vez.</li>
                                    <li><span class="indicador-list">3. </span>Ausentarse sin justa causa del lugar de trabajo una vez estando allí.</li>
                                    <li><span class="indicador-list">4. </span>La falta total del trabajador a sus labores durante el día sin excusa suficiente, por segunda vez.</li>
                                    <li><span class="indicador-list">5. </span>Violación grave por parte del trabajador de las obligaciones contractuales o reglamentarias.</li>
                                    <li><span class="indicador-list">6. </span>Proveer cualquier información inexacta, adulteración de tarjetas, registros de control médico, constancias de ausencia de servicio o cualquier asunto relacionado con las Entidades Prestadoras de Servicios de Salud o con una Institución prestadora de servicios de salud.</li>
                                    <li><span class="indicador-list">7. </span>Irregularidades de dinero, aún si es la primera vez, siempre y cuando no pueda justificar expresamente la razón del desfalco. El empleador procederá a realizar la investigación pertinente para determinar si se aplicará la sanción o no.</li>
                                    <li><span class="indicador-list">8. </span>Amenazar, golpear o instigar un ataque físico o verbal con o sin armas, sin importar, al trabajador, visitante, proveedor, cliente, o cualquier persona que tenga vínculo con la fundación, durante la jornada de trabajo.</li>
                                    <li><span class="indicador-list">9. </span>Cometer delitos o tentativa de comisión de delitos en contra de los intereses de la fundación, directivos o compañeros de trabajo.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </article>
                <div class="separador-black"></div>
                <article id="a-5">
                    <h1 class="title-border bold">SISTEMA DE GESTIÓN EN SEGURIDAD Y SALUD <br>EN EL TRABAJO - SG-SST</h1>
                    <p>El SG-SST a través de la ARL, cubre todos los riesgos laborales que sufra el trabajador afiliado como consecuencia directa del trabajo o labor desempeñada.</p>
                    <p>La afiliación a la ARL de un trabajador la hace en forma obligatoria el empleador quien asume el pago del valor total de la cotización.</p>
                    <p>La Administradora de Riesgos Laborales ARL para la fundación es POSITIVA. Las Entidades Prestadoras de Salud (EPS) y las Administradoras de Fondos de Pensiones (AFP) serán las elegidas por cada empleado, y reportadas al momento del ingreso con la documentación exigida para la legalización del contrato de trabajo.</p>
                    <p>Reglamento de higiene, seguridad y salud en el trabajo: tiene como objeto la identificación, reconocimiento, evaluación y control de los factores ambientales que se originen en los lugares de trabajo y que puedan afectar la salud de los trabajadores.</p>
                    <div>
                        <br>
                        <h2>RESPONSABILIDADES Y OBLIGACIONES - SG-SST</h2>
                        <ol style="width: 50%;">
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Procurar el cuidado integral de su salud.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Suministrar información clara, veraz y completa sobre el estado de salud.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Cumplir las normas, reglamentos e instrucciones del Sistema de Gestión de la Seguridad y Salud en el Trabajo de la empresa.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Informar oportunamente al empleador o contratante acerca de los peligros y riesgos latentes en su sitio de trabajo.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Participar en las actividades de capacitación en seguridad y salud en el trabajo definido en el plan de capacitación del SG-SST.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Participar y contribuir al cumplimiento de los objetivos del Sistema de Gestión de la Seguridad y Salud en el Trabajo (SG-SST).
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Informar al jefe inmediato o supervisor de contrato, todos los actos y condiciones inseguras identificados.</li></li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Efectúe únicamente aquellos trabajos para los que esté capacitado y autorizado.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Reportar todos los accidentes e incidentes de trabajo.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Conocer e identificar las rutas de evacuación y puntos de encuentro.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Mantener libre de obstáculos los equipos y elementos para atención de emergencias.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Mantenerse siempre alerta a las condiciones del entorno, caminar con precaución.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Utilizar todos los elementos de protección de acuerdo a la actividad a realizar y maquinaria o herramienta a utilizar.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Conocer el manual de la máquina o herramienta a manipular y los estándares de seguridad, respetar y mantener las guardas de seguridad.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Hacer parte de la Brigada de emergencias.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Participar en el COPASSST y comité de convivencia, cuando sea elegido por el empleador o trabajadores.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Realizar pausas activas y descanso vocal durante la jornada laboral.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Consumir sorbos de agua constantemente en el día, principalmente durante el habla continua para evitar deshidratación y sobreesfuerzo.</li>
                            <li><span class="indicador-list"><i class="fa-solid fa-circle dot"></i> </span>Participar en la prevención de los riesgos a través del COPASST.</li>
                        </ol>
                    </div>
                    <br>
                    <div>
                        <h2>ACCIDENTE DE TRABAJO</h2>
                        <p>"Es todo suceso repentino que sobrevenga por causa o con ocasión del trabajo, y que produzca en el trabajador una lesión orgánica, una perturbación funcional o psiquiátrica, una invalidez o la muerte"</p>
                        <p>"Aquel que se produce durante la ejecución de órdenes del empleador o contratante durante la ejecución de una labor bajo su autoridad, aún fuera del lugar y horas de trabajo"</p>
                        <p>"El que se produzca durante el traslado de los trabajadores o contratistas desde su residencia a los lugares de trabajo o viceversa, cuando el transporte lo suministre el empleador"</p>
                        <p>"El que se produzca por la ejecución de actividades recreativas, deportivas o culturales, cuando se actúe por cuenta o en representación del empleador o de la empresa usuaria cuando se trate de trabajadores de empresas temporales que se encuentren en misión"</p>
                        <p></p>
                    </div>
                    <br>
                    <div>
                        <h2>PROCEDIMIENTO EN CASO DE ACCIDENTE DE TRABAJO</h2>
                        <div style="width: 50%; margin: auto;" >
                            <p>"Empleado: Notifica al jefe inmediato"</p>
                            <p>"Jefe inmediato: Informa a SST"</p>
                            <p>"SST: Notifica a la ARL correspondiente y realiza el FURAT (Formato Único de Accidente de Trabajo)"</p>
                            <p>"Si el accidente desencadena una incapacidad, esta debe ser enviada al área de SST, Talento Humano y jefe inmediato."</p>
                            <p>"Empleado: Se dirige al centro de asistencia indicado por la ARL (con el documento de identidad)."</p>
                        </div>
                    </div>
                    <br>
                    <div id="nota">
                        <h2>NOTA</h2>
                        <p>"El empleado que sufrió el accidente de trabajo se le dificulta su movilidad deberá ir acompañado al centro de asistencia indicado por la ARL."</p>
                    </div>
                </article>
                <div class="download-btn" id="btnIgeneral">
                    <i class="fa-solid fa-book-tanakh"></i>
                    <p class="regular x1">Terminar Inducción</p>
                </div>
                <br>
            </div>
        </div>
    </div>
    <div id="modal-quiz-container-1" class="containerModal-quizes">
        <i class="fa-solid fa-xmark cerrarVentanas" id="cerrarVentanas"></i>
        <div id="mensaje"></div>
        <div class="quizContainer">
            <div class="previeQ containerR">
                <h2 class="bold">Esta a punto de realizar un breve cuestionario para certificar que usted ha realizado la induccion general para la fundacion huellas del ayer</h2>
                <p class="regular x1">Tenga presente que para poder desacrgar su certificado, debera responder correctamente todas las preguntas que encontrara a continuación, llegado el caso de que no responda correctamente debera intentar responder nuevamente el cuestionario</p>
            </div>
            <br>
            <div>
                <form id="quiz-Gnereal" enctype="multipart/form-data">
                    <input type="hidden" name="id_quiz" value="general">
                    <div class="containerR pregunta">
                        <h3>1. ¿Cuál es la capital de Francia?</h3>
                        <br>
                        <label><input type="radio" name="p1" value="a" required> Madrid</label><br>
                        <label><input type="radio" name="p1" value="b"> París</label><br>
                        <label><input type="radio" name="p1" value="c"> Roma</label><br>
                        <label><input type="radio" name="p1" value="d"> Berlín</label>
                    </div>
    
                    <div class="containerR pregunta">
                        <h3>2. ¿Qué planeta es conocido como el planeta rojo?</h3>
                        <br>
                        <label><input type="radio" name="p2" value="a" required> Venus</label><br>
                        <label><input type="radio" name="p2" value="b"> Marte</label><br>
                        <label><input type="radio" name="p2" value="c"> Júpiter</label><br>
                        <label><input type="radio" name="p2" value="d"> Saturno</label>
                    </div>

                    <div class="containerR pregunta">
                        <h3>3. ¿Cuál es el océano más grande del mundo?</h3>
                        <br>
                        <label><input type="radio" name="p3" value="a" required> Atlántico</label><br>
                        <label><input type="radio" name="p3" value="b"> Índico</label><br>
                        <label><input type="radio" name="p3" value="c"> Pacífico</label><br>
                        <label><input type="radio" name="p3" value="d"> Ártico</label>
                    </div>
                    <div class="containerR pregunta">
                        <h3>4. ¿Cuál es el océano más grande del mundo?</h3>
                        <br>
                        <label><input type="radio" name="p4" value="a" required> Atlántico</label><br>
                        <label><input type="radio" name="p4" value="b"> Índico</label><br>
                        <label><input type="radio" name="p4" value="c"> Pacífico</label><br>
                        <label><input type="radio" name="p4" value="d"> Ártico</label>
                    </div>
                    <div class="containerR pregunta">
                        <h3>5. ¿Cuál es el océano más grande del mundo?</h3>
                        <br>
                        <label><input type="radio" name="p5" value="a" required> Atlántico</label><br>
                        <label><input type="radio" name="p5" value="b"> Índico</label><br>
                        <label><input type="radio" name="p5" value="c"> Pacífico</label><br>
                        <label><input type="radio" name="p5" value="d"> Ártico</label>
                    </div>
                    <div class="containerR pregunta">
                        <h3>6. ¿Cuál es el océano más grande del mundo?</h3>
                        <br>
                        <label><input type="radio" name="p6" value="a" required> Atlántico</label><br>
                        <label><input type="radio" name="p6" value="b"> Índico</label><br>
                        <label><input type="radio" name="p6" value="c"> Pacífico</label><br>
                        <label><input type="radio" name="p6" value="d"> Ártico</label>
                    </div>
                    <div class="containerR pregunta">
                        <h3>7. ¿Cuál es el océano más grande del mundo?</h3>
                        <br>
                        <label><input type="radio" name="p7" value="a" required> Atlántico</label><br>
                        <label><input type="radio" name="p7" value="b"> Índico</label><br>
                        <label><input type="radio" name="p7" value="c"> Pacífico</label><br>
                        <label><input type="radio" name="p7" value="d"> Ártico</label>
                    </div>
                    <div class="containerR pregunta">
                        <h3>8. ¿Cuál es el océano más grande del mundo?</h3>
                        <br>
                        <label><input type="radio" name="p8" value="a" required> Atlántico</label><br>
                        <label><input type="radio" name="p8" value="b"> Índico</label><br>
                        <label><input type="radio" name="p8" value="c"> Pacífico</label><br>
                        <label><input type="radio" name="p8" value="d"> Ártico</label>
                    </div>
                    <div class="containerR pregunta">
                        <h3>9. ¿Cuál es el océano más grande del mundo?</h3>
                        <br>
                        <label><input type="radio" name="p9" value="a" required> Atlántico</label><br>
                        <label><input type="radio" name="p9" value="b"> Índico</label><br>
                        <label><input type="radio" name="p9" value="c"> Pacífico</label><br>
                        <label><input type="radio" name="p9" value="d"> Ártico</label>
                    </div>
                    <div class="containerR pregunta">
                        <h3>10. ¿Cuál es el océano más grande del mundo?</h3>
                        <br>
                        <label><input type="radio" name="p10" value="a" required> Atlántico</label><br>
                        <label><input type="radio" name="p10" value="b"> Índico</label><br>
                        <label><input type="radio" name="p10" value="c"> Pacífico</label><br>
                        <label><input type="radio" name="p10" value="d"> Ártico</label>
                    </div>
                    <div>
                        <button class="download-btn" type="submit" style="border: none;">Enviar respuestas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal-quiz-container-completed" class="containerModal-quizes"> 
        <i class="fa-solid fa-xmark cerrarVentanas" id="cerrarVentanas"></i>
        <div id="mensaje"></div>
        <div class="quizContainer">
            <h2>ya has completado eesta induccion</h2>
            <p>para descargar tu certificado consulta la pagina de tu perfil</p>
        </div>
    </div>
    <script src="../../js/empleados/quizResponse.js"></script>
    <script src="../../js/empleados/induccionConfirm.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
<?php
$conexion->close();
?>

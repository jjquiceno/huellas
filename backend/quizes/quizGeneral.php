<?php
header('Content-Type: application/json; charset=UTF-8');
// Opcional: en producción, asegúrate de no mostrar errores
// ini_set('display_errors', 0);

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../helpers/require_login.php';

$response = [
    'success' => false,
    'message' => '',
    'score'   => 0,
    'total'   => 10,
    'details' => []
];

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

try {
    // Validar id_quiz
    if (empty($_POST['id_quiz'])) {
        throw new Exception('Falta el identificador del quiz (id_quiz)');
    }
    $id_quiz = $_POST['id_quiz'];

    // Validar campos requeridos p1..p10
    $required = ['p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'p7', 'p8', 'p9', 'p10'];
    foreach ($required as $field) {
        if (!isset($_POST[$field]) || $_POST[$field] === '') {
            throw new Exception("El campo $field es requerido");
        }
        if (!in_array($_POST[$field], ['a','b','c','d'], true)) {
            throw new Exception("Valor inválido para $field");
        }
    }

    // Obtener respuestas correctas del quiz
    // NOTA: Ajusta este SELECT según el esquema real de tu tabla.
    // Esta lógica soporta columnas llamadas c1..c10 o p1_correct..p10_correct o p1..p10.
    $stmt = $conexion->prepare("SELECT * FROM quizes WHERE id_quiz = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception('Error preparando la consulta: ' . $conexion->error);
    }
    $stmt->bind_param('s', $id_quiz);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        throw new Exception('Quiz no encontrado');
    }

    $row = $result->fetch_assoc();

    // Comparar respuestas
    $score = 0;
    $details = [];
    for ($i = 1; $i <= 10; $i++) {
        $userAnswer = $_POST['p' . $i];

        // Detección flexible del campo de respuesta correcta
        $keyCandidates = [
            'a' . $i,
            // 'p' . $i . '_correct',
            // 'p' . $i,
        ];
        $correctAnswer = null;
        foreach ($keyCandidates as $k) {
            if (array_key_exists($k, $row) && $row[$k] !== null && $row[$k] !== '') {
                $correctAnswer = $row[$k];
                break;
            }
        }

        if ($correctAnswer === null) {
            throw new Exception("No se encontró la respuesta correcta para la pregunta $i en la base de datos");
        }

        $isCorrect = ($userAnswer === $correctAnswer);
        if ($isCorrect) { $score++; }

        $details[] = [
            'question' => $i,
            'your'     => $userAnswer,
            'correct'  => $correctAnswer,
            'ok'       => $isCorrect,
        ];
    }

    $response['score'] = $score;
    $response['details'] = $details;
    $response['success'] = ($score === $response['total']);
    $response['message'] = $response['success']
        ? 'Ha respondido correctamente todas las preguntas'
        : 'Algunas respuestas son incorrectas';
    if ($response['success'] == true) {
        $response['status'] = 'si';
        $stmt = $conexion->prepare("UPDATE empleados SET induccionGeneral = ? WHERE identificacion = ?");
        $stmt->bind_param('si', $response['status'], $_SESSION['identificacion']);
        $stmt->execute();
    }

} catch (Exception $e) {
    http_response_code(400);
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

// Limpiar cualquier salida accidental antes de responder
if (function_exists('ob_get_level')) {
    while (ob_get_level() > 0) { ob_end_clean(); }
}
echo json_encode($response);
exit;

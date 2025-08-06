<?php
    header('Content-Type: application/json');
    include "conexion.php"; 

    require_once '../helpers/Validator.php';
    
    // Función para responder en JSON
    function sendResponse($success, $message = '') {
        echo json_encode(['success' => $success, 'message' => $message]);
        exit;
    }

    // Validar y limpiar datos
    $username = Validator::sanitizeUsername($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

    // Validar contraseña
    if (!Validator::validatePassword($password)) {
        sendResponse(false, 'La contraseña debe tener al menos 8 caracteres');
    }

    // Validar email
    if (!Validator::validateEmail($email)) {
        sendResponse(false, 'Email inválido');
    }

    // Verificar si ya existe un usuario con estos datos
    $check_sql = "SELECT * FROM usuarios WHERE nombre_usuario = ? OR email = ? OR contraseña = ?";
    if ($check_stmt = $conexion->prepare($check_sql)) {
        $check_stmt->bind_param("sss", $username, $email, $password);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows > 0) {
            $check_stmt->close();
            sendResponse(false, 'Ya existe un usuario con este nombre de usuario o correo electrónico');
        }
        $check_stmt->close();
    }

    if (!$username || !$email || !$password) {
        sendResponse(false, 'Todos los campos son obligatorios');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre_usuario, email, contraseña) VALUES (?, ?, ?)";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular parámetros
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            $stmt->close();
            sendResponse(true, 'Usuario creado exitosamente');
        } else {
            $error = $stmt->error;
            $stmt->close();
            sendResponse(false, 'Error al crear el usuario: ' . $error);
        }
    } else {
        sendResponse(false, 'Error al preparar la consulta: ' . $conexion->error);
    }

    $conexion->close();
?>

    
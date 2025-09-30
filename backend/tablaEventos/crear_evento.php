<?php
header('Content-Type: application/json');
require_once '../../config.php';
require_once '../../helpers/require_login_jefe.php';

$response = ['success' => false, 'message' => ''];

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

try {
    // Validar campos requeridos
    $required = ['titulo', 'descripcion', 'fecha_evento'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("El campo $field es requerido");
        }
    }

    // Validar archivo de imagen
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Debes subir una imagen para el evento');
    }

    $imagen = $_FILES['imagen'];
    
    // Validar tipo de archivo
    $permitidos = ['image/jpeg', 'image/png', 'image/gif'];
    $tipo = mime_content_type($imagen['tmp_name']);
    
    if (!in_array($tipo, $permitidos)) {
        throw new Exception('Formato de archivo no permitido. Solo se aceptan JPG, PNG o GIF');
    }

    // Validar tamaño de archivo (máximo 2MB)
    $tamañoMaximo = 2 * 1024 * 1024; // 2MB
    if ($imagen['size'] > $tamañoMaximo) {
        throw new Exception('La imagen no debe pesar más de 2MB');
    }

    // Crear directorio de imágenes si no existe
    $directorioImagenes = '../../uploads/eventos/';
    if (!file_exists($directorioImagenes)) {
        mkdir($directorioImagenes, 0777, true);
    }

    // Generar nombre único para la imagen
    $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
    $nombreImagen = 'evento_' . uniqid() . '.' . $extension;
    $rutaImagen = $directorioImagenes . $nombreImagen;

    // Mover el archivo subido
    if (!move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
        throw new Exception('Error al subir la imagen');
    }

    // Insertar en la base de datos
    $stmt = $conexion->prepare("INSERT INTO eventos (titulo, descripcion, fecha_evento, imagen_url, creado_por) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", 
        $_POST['titulo'],
        $_POST['descripcion'],
        $_POST['fecha_evento'],
        $nombreImagen,
        $_SESSION['user_id']
    );

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Evento creado exitosamente';

        // Intentar crear notificaciones para todos los empleados (no interrumpe si falla)
        // Crear tabla si no existe
        $conexion->query("CREATE TABLE IF NOT EXISTS employee_notifications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            empleado_id INT NOT NULL,
            type VARCHAR(64) NOT NULL,
            title VARCHAR(255) NOT NULL,
            body TEXT NULL,
            link VARCHAR(128) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            read_at DATETIME NULL,
            INDEX idx_emp (empleado_id),
            INDEX idx_read (read_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        // Insertar una notificación por empleado con SELECT para evitar bucles en PHP
        if ($notif = $conexion->prepare("INSERT INTO employee_notifications (empleado_id, type, title, body, link)
            SELECT identificacion, 'evento_creado', CONCAT('Nuevo evento: ', ?), ?, 'inicio' FROM empleados")) {
            $notif->bind_param("ss", $_POST['titulo'], $_POST['descripcion']);
            // Ejecutar e ignorar el resultado/errores para no afectar la creación del evento
            $notif->execute();
        }
    } else {
        // Si hay un error, eliminar la imagen subida
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }
        throw new Exception('Error al guardar el evento en la base de datos');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>

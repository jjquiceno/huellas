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

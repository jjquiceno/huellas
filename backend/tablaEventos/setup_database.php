<?php
require_once '../../config.php';

try {
    // Crear tabla eventos_likes si no existe
    $sql = "CREATE TABLE IF NOT EXISTS eventos_likes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        evento_id INT NOT NULL,
        empleado_id INT NOT NULL,
        fecha_like TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_like (evento_id, empleado_id),
        INDEX idx_evento_id (evento_id),
        INDEX idx_empleado_id (empleado_id)
    )";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Tabla eventos_likes creada correctamente o ya existe.\n";
    } else {
        echo "Error al crear la tabla: " . $conexion->error . "\n";
    }
    
    // Verificar si la tabla eventos existe y tiene las columnas necesarias
    $result = $conexion->query("SHOW TABLES LIKE 'eventos'");
    if ($result->num_rows > 0) {
        echo "Tabla eventos existe.\n";
        
        // Verificar columnas de la tabla eventos
        $columns = $conexion->query("SHOW COLUMNS FROM eventos");
        $existing_columns = [];
        while ($row = $columns->fetch_assoc()) {
            $existing_columns[] = $row['Field'];
        }
        
        // Agregar columna fecha_creacion si no existe
        if (!in_array('fecha_creacion', $existing_columns)) {
            $conexion->query("ALTER TABLE eventos ADD COLUMN fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
            echo "Columna fecha_creacion agregada a la tabla eventos.\n";
        }
        
        echo "Columnas existentes en eventos: " . implode(', ', $existing_columns) . "\n";
    } else {
        // Crear tabla eventos si no existe
        $sql_eventos = "CREATE TABLE eventos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            descripcion TEXT NOT NULL,
            fecha_evento DATE NOT NULL,
            imagen_url VARCHAR(255) NOT NULL,
            creado_por INT NOT NULL,
            fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_fecha_evento (fecha_evento),
            INDEX idx_creado_por (creado_por)
        )";
        
        if ($conexion->query($sql_eventos) === TRUE) {
            echo "Tabla eventos creada correctamente.\n";
        } else {
            echo "Error al crear la tabla eventos: " . $conexion->error . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

$conexion->close();
?>

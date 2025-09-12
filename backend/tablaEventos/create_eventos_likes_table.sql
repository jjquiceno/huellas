-- Crear tabla para los likes de eventos si no existe
CREATE TABLE IF NOT EXISTS eventos_likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evento_id INT NOT NULL,
    empleado_id INT NOT NULL,
    fecha_like TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_like (evento_id, empleado_id),
    FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
    FOREIGN KEY (empleado_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Crear índices para mejorar el rendimiento
CREATE INDEX idx_evento_id ON eventos_likes(evento_id);
CREATE INDEX idx_empleado_id ON eventos_likes(empleado_id);

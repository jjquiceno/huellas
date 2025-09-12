<?php
    require_once '../../../helpers/require_login_jefe.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="crear-evento-container">
        <h2 class="regular x2">Crear Nuevo Evento</h2>
        
        <form id="formularioEvento" class="formulario-evento" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo" class="regular">Título del Evento:</label>
                <input type="text" id="titulo" name="titulo" class="regular" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion" class="regular">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="regular" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="fecha_evento" class="regular">Fecha del Evento:</label>
                <input type="date" id="fecha_evento" name="fecha_evento" class="regular" required>
            </div>
            
            <div class="form-group">
                <label for="imagen" class="regular">Imagen del Evento:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                <small class="regular">Formatos aceptados: JPG, PNG, GIF. Tamaño máximo: 2MB</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Publicar Evento</button>
                <button type="button" id="cancelarEvento" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
        
        <div id="mensaje" class="mensaje"></div>
    </div>
</body>
</html>

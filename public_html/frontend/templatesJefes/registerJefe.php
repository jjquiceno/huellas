<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../../../backend/tablaJefes/registerJefe.php" method="post">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <label for="correo">Email:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="identificacion">Identificacion:</label>
        <input type="text" id="identificacion" name="identificacion" required>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
<?php
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $base_datos = "huellasdelayer";

    $conexion = new mysqli($servidor, $usuario, $clave, $base_datos);
    // return $conexion;
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
?>
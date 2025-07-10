<?php

class Validator {
    // Validar y limpiar el nombre de usuario
    public static function sanitizeUsername($username) {
        if (!is_string($username)) {
            return '';
        }
        
        // Eliminar espacios al inicio y final
        $username = trim($username);
        
        // Eliminar caracteres no permitidos
        $username = preg_replace('/[^a-zA-Z0-9_\-]/', '', $username);
        
        return $username;
    }
    
    // validar identificacion
    public static function validateIdentificacion($identificacion) {
        if (!ctype_digit($identificacion) || strlen($identificacion) < 8 || strlen($identificacion) > 15) {
            return false;
        }
        return true;
    }
    
    // validar tipo de identificacion
    public static function validateTipoIdentificacion($tipo_identificacion_id){
        if($tipo_identificacion_id === "" || $tipo_identificacion_id === null || strlen($tipo_identificacion_id) == 0){ 
            return false;
        }
        return true;
    }

    // validar nombre
    public static function validateNombre($nombre){
        if($nombre === "" || $nombre === null || strlen($nombre) == 0){ 
            return false;
        }
        return true;
    }

    // validar fecha de nacimiento
    public static function validateFechaNacimiento($fecha_nacimiento){
        if($fecha_nacimiento === "" || $fecha_nacimiento === null){ 
            return false;
        }
        // Convertir a timestamps para comparar correctamente
        if(strtotime($fecha_nacimiento) > strtotime(date("Y-m-d"))){
            return false;
        }
        return true;
    }

    // validar cargo
    public static function validateCargo($cargo){
        if($cargo === "" || $cargo === null || strlen($cargo) == 0){ 
            return false;
        }
        return true;
    }

    // validar tipo de contrato
    public static function validateTipoContrato($tipo_contrato_id){
        if($tipo_contrato_id === "" || $tipo_contrato_id === null || strlen($tipo_contrato_id) == 0){ 
            return false;
        }
        return true;
    }

    //validar salario 
    public static function validateSalario($salario){
        if($salario === "" || $salario === null || $salario <= 0){ 
            return false;
        }
        return true;
    }

    // Validar contraseña
    public static function validatePassword($password) {
        if (!is_string($password) || strlen($password) < 8) {
            return false;
        }
        return true;
    }
    
    // Validar email
    public static function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    
    // Limpiar entrada general
    public static function sanitizeInput($input) {
        if (!is_string($input)) {
            return '';
        }
        
        // Eliminar espacios al inicio y final
        $input = trim($input);
        
        // Eliminar caracteres HTML
        $input = strip_tags($input);
        
        // Eliminar espacios múltiples
        $input = preg_replace('/\s+/', ' ', $input);
        
        return $input;
    }
}
?>

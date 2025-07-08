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

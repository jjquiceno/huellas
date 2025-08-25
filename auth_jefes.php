<?php
require_once 'config.php';
require_once 'backend/conexion.php';

// Clase para manejar la autenticación
class AuthJefes {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Verificar credenciales
    public function loginJefes($username, $password) {
        try {
            // Primero verificar si el usuario existe
            $sql = "SELECT id_jefe, identificacion, nombre, correo, nombre_usuario, contrasena FROM jefes WHERE nombre_usuario = ?";
            if($stmt = $this->conn->prepare($sql)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();
                    
                    // LOGS DE DEPURACIÓN
                    error_log('Intento login: username=' . $username);
                    error_log('Password en DB: ' . $user['contrasena']);
                    error_log('Password ingresada: ' . $password);
                    error_log('password_verify: ' . (password_verify($password, $user['contrasena']) ? 'OK' : 'FAIL'));
                    
                    // Verificar si la contraseña coincide
                    if (password_verify($password, $user['contrasena'])) {
                        // Actualizar sesión
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $user['nombre'];
                        $_SESSION['user_id'] = $user['nombre_usuario'];
                        $_SESSION['rol'] = 'jefe';
                        $_SESSION['last_activity'] = time();
                        
                        // Regenerar ID de sesión
                        session_regenerate_id(true);
                        return true;
                    }
                }
                $stmt->close();
            }
            return false;
        } catch (Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            return false;
        }
    }
    
    // Verificar si el usuario está logueado
    public function isLoggedInJefes() {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            return false;
        }
        // Verificar inactividad
        $max_inactivity = 1800; // 30 minutos
        if (isset($_SESSION['last_activity']) && 
            (time() - $_SESSION['last_activity']) > $max_inactivity) {
            $this->logoutJefes();
            return false;
        }
        $_SESSION['last_activity'] = time();
        return true;
    }
    
    // Cerrar sesión
    public function logoutJefes() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_destroy();
        }
    }
    
    // Obtener ID del usuario
    public function getUserIdJefes() {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }
}
?>

<?php
require_once 'config.php';
require_once 'backend/conexion.php';

// Clase para manejar la autenticación
class Auth {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Verificar credenciales
    public function login($username, $password) {
        try {
            // Primero verificar si el usuario existe
            $sql = "SELECT nombre_usuario, contraseña, email FROM usuarios WHERE nombre_usuario = ?";
            if($stmt = $this->conn->prepare($sql)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();
                    
                    // LOGS DE DEPURACIÓN
                    error_log('Intento login: username=' . $username);
                    error_log('Password en DB: ' . $user['contraseña']);
                    error_log('Password ingresada: ' . $password);
                    error_log('password_verify: ' . (password_verify($password, $user['contraseña']) ? 'OK' : 'FAIL'));
                    
                    // Verificar si la contraseña coincide
                    if (password_verify($password, $user['contraseña'])) {
                        // Actualizar sesión
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['user_id'] = $user['nombre_usuario'];
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
    public function isLoggedIn() {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            return false;
        }
        // Verificar inactividad
        $max_inactivity = 1800; // 30 minutos
        if (isset($_SESSION['last_activity']) && 
            (time() - $_SESSION['last_activity']) > $max_inactivity) {
            $this->logout();
            return false;
        }
        $_SESSION['last_activity'] = time();
        return true;
    }
    
    // Cerrar sesión
    public function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_destroy();
        }
    }
    
    // Obtener ID del usuario
    public function getUserId() {
        return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    }
}
?>

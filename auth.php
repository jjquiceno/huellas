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

                        $sql_empleado = "SELECT identificacion, tipo_identificacion_id, nombre, fecha_nacimiento, fecha_ingreso, nombre_usuario, cargo_id, tipo_contrato_id, salario FROM empleados WHERE nombre_usuario = ?";
                        if($stmt = $this->conn->prepare($sql_empleado)) {
                            $stmt->bind_param("s", $user['nombre_usuario']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows === 1) {
                                $empleado = $result->fetch_assoc();
                                $_SESSION['identificacion'] = $empleado['identificacion'];
                                $_SESSION['tipo_identificacion_id'] = $empleado['tipo_identificacion_id'];
                                $_SESSION['nombre'] = $empleado['nombre'];
                                $_SESSION['fecha_nacimiento'] = $empleado['fecha_nacimiento'];
                                $_SESSION['fecha_ingreso'] = $empleado['fecha_ingreso'];
                                $_SESSION['nombre_usuario'] = $empleado['nombre_usuario'];
                                $_SESSION['cargo_id'] = $empleado['cargo_id'];
                                $_SESSION['tipo_contrato_id'] = $empleado['tipo_contrato_id'];
                                $_SESSION['salario'] = $empleado['salario'];
                            }
                        }

                        $sql_contrato = "SELECT * FROM tipo_contrato WHERE tipo_contrato_id = ?";
                        if($stmt = $this->conn->prepare($sql_contrato)) {
                            $stmt->bind_param("s", $empleado['tipo_contrato_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows === 1) {
                                $tipo_contrato = $result->fetch_assoc();
                                $_SESSION['tipo_contrato'] = $tipo_contrato['tipo'];
                                $_SESSION['termino_contrato'] = $tipo_contrato['termino'];
                                $_SESSION['duracion_contrato'] = $tipo_contrato['duracion'];
                            }
                        }

                        $sql_cargo = "SELECT * FROM cargos WHERE cargo_id = ?";
                        if($stmt = $this->conn->prepare($sql_cargo)) {
                            $stmt->bind_param("s", $empleado['cargo_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows === 1) {
                                $cargo = $result->fetch_assoc();
                                $_SESSION['cargo'] = $cargo['cargo'];
                            }
                        }
                        
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

<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends Controller
{
    public function index($action = "")
    {
        $authenticacion = $this->model('AuthModel');
        $redirect = PATH;
        $error = null;

        // DEBUG: Verificar si ya está logueado
        error_log("=== LOGIN CONTROLLER ===");
        error_log("Acción solicitada: " . $action);
        error_log("¿Usuario logueado? " . ($this->is_user_logged() ? "SÍ" : "NO"));

        if ($this->is_user_logged()) {
            error_log("Usuario ya logueado, redirigiendo a home");
            header('Location: ' . PATH);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST recibido: " . print_r($_POST, true));
            
            $type = $_POST['type'] ?? 'login';
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validación básica
            if (empty($username) || empty($password)) {
                $error = "Por favor, completa todos los campos";
                error_log("Validación fallida: campos vacíos");
            } else {
                switch ($type) {
                    case "register":
                        error_log("=== PROCESANDO REGISTRO ===");
                        error_log("Username: " . $username);
                        error_log("Password length: " . strlen($password));

                        if ($authenticacion->register(['username' => $username, 'password' => $password])) {
                            error_log("Registro exitoso, procediendo a auto-login");
                            
                            // Auto-login después del registro
                            $jwt_token = $authenticacion->login([
                                'username' => $username, 
                                'password' => $password
                            ]);
                            
                            if ($jwt_token) {
                                error_log("Auto-login exitoso");
                                $this->setAuthCookie($jwt_token);
                                header('Location: ' . PATH);
                                exit();
                            } else {
                                error_log("Auto-login falló, redirigiendo a login manual");
                                $error = "Registro exitoso. Por favor, inicia sesión.";
                            }
                        } else {
                            error_log("Registro fallido");
                            $error = "Error al registrar. El usuario ya puede existir.";
                        }
                        break;

                    default: // LOGIN
                        error_log("=== PROCESANDO LOGIN ===");
                        error_log("Username: " . $username);
                        
                        $login_data = [
                            'username' => $username,
                            'password' => $password
                        ];

                        $jwt_token = $authenticacion->login($login_data);
                        
                        if ($jwt_token) {
                            error_log("Login exitoso, generando cookie");
                            $this->setAuthCookie($jwt_token);
                            header('Location: ' . $redirect);
                            exit();
                        } else {
                            error_log("Login fallido - credenciales incorrectas");
                            $error = "Usuario o contraseña incorrectos.";
                        }
                        break;
                }
            }
        }

        // Determinar qué vista mostrar
        switch ($action) {
            case 'register':
                $view = "auth/register";
                break;
            default:
                $view = "auth/login";
                break;
        }

        error_log("Renderizando vista: " . $view);
        $this->view_nostyle($view, ['error' => $error]);
    }

    private function setAuthCookie($jwt_token)
    {
        error_log("=== ESTABLECIENDO COOKIE JWT ===");
        error_log("Token (inicio): " . substr($jwt_token, 0, 50) . "...");
        
        // Eliminar cookie existente primero
        setcookie('jwt_token', '', time() - 3600, '/');
        
        // Establecer nueva cookie
        $result = setcookie('jwt_token', $jwt_token, [
            'expires' => time() + (3600 * 24), // 1 día
            'path' => '/',
            'httponly' => true,
            'secure' => false, // Cambiar a true en producción con HTTPS
            'samesite' => 'Lax'
        ]);
        
        error_log("Cookie establecida: " . ($result ? "ÉXITO" : "FALLÓ"));
        
        // También establecer en $_COOKIE para acceso inmediato
        if ($result) {
            $_COOKIE['jwt_token'] = $jwt_token;
        }
    }

    public function is_user_logged()
    {
        if (!isset($_COOKIE['jwt_token'])) {
            return false;
        }

        $jwt = $_COOKIE['jwt_token'];
        
        try {
            $payload = JWT::decode($jwt, new Key(JWT_SECRET, 'HS256'));
            return true;
        } catch (Exception $e) {
            error_log("Error validando JWT: " . $e->getMessage());
            // Limpiar cookie inválida
            setcookie('jwt_token', '', time() - 3600, '/');
            unset($_COOKIE['jwt_token']);
            return false;
        }
    }

    public function logout()
    {
        setcookie('jwt_token', '', time() - 3600, '/');
        unset($_COOKIE['jwt_token']);
        session_destroy();
        header('Location: ' . PATH . 'login');
        exit();
    }
}
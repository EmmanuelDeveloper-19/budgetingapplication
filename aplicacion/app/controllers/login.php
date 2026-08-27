<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends Controller
{
    public function index($action = "")
    {
        $authenticacion = $this->model('authModel');
        $redirect = PATH;
        $error = null;

        if ($this->is_user_logged()) {
            header('Location: ' . PATH);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $type = $_POST['type'] ?? 'login';
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($type === "register") {
                // Captura de los nuevos campos para el registro
                $name = trim($_POST['name'] ?? '');
                $last_name = trim($_POST['last_name'] ?? '');

                // Validación de campos vacíos para registro
                if (empty($username) || empty($password) || empty($name) || empty($last_name)) {
                    $error = "Por favor, completa todos los campos requeridos.";
                } else {

                    $register_data = [
                        'name'      => $name,
                        'last_name' => $last_name,
                        'username'  => $username,
                        'password'  => $password
                    ];

                    if ($authenticacion->register($register_data)) {
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
                        error_log("Registro fallido en el modelo");
                        $error = "Error al registrar. El usuario o correo ya puede existir.";
                    }
                }
            } else {
                // LOGIN POR DEFECTO
                if (empty($username) || empty($password)) {
                    $error = "Por favor, ingresa tu usuario y contraseña.";
                } else {
                    
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
                }
            }
        }

        // Determinar qué vista mostrar
        switch ($action) {
            case 'register':
            case 'reset':
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
        
        setcookie('jwt_token', '', time() - 3600, '/');
        
        $result = setcookie('jwt_token', $jwt_token, [
            'expires'  => time() + (3600 * 24), // 1 día
            'path'     => '/',
            'httponly' => true,
            'secure'   => false, // Cambiar a true en producción con HTTPS
            'samesite' => 'Lax'
        ]);
        
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

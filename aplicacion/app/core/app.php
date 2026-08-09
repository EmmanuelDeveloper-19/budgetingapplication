<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class App
{
    protected $controller;
    protected $method;
    protected $params;
    protected $user;
    protected $db;
    protected $is_api = false;

    // Rutas de API que no requieren JWT: "controller/method"
    protected $public_api_routes = [
        'auth/login',
        'auth/register',
    ];

    public function __construct()
    {
        $this->controller = "home";
        $this->method = "index";
        $this->params = [];
        $this->db = new Db();

        $url = $this->formatUrl();

        // Detectar si la petición es de la API
        if (isset($url[0]) && $url[0] === 'api') {
            $this->is_api = true;
            unset($url[0]);
            $url = array_values($url);
        }

        $controllers_path = $this->is_api ? API_CONTROLLERS : CONTROLLERS;

        if (isset($url[0])) {
            if (file_exists($controllers_path . $url[0] . ".php")) {
                $this->controller = $url[0];
                unset($url[0]);
            } else {
                $this->method = "e404";
            }
        }

        require_once($controllers_path . $this->controller . ".php");
        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else if (!is_numeric($url[1])) {
                $this->method = "e404";
            }
        }

        $this->params = $url ? array_values($url) : array();

        $route_key = get_class($this->controller) . '/' . $this->method;
        $route_key = strtolower($route_key);

        if ($this->is_api && in_array($route_key, $this->public_api_routes)) {
            call_user_func_array([$this->controller, $this->method], $this->params);
            return;
        }

        if ($this->is_user_logged()) {
            $this->controller->user = $this->user;
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            if ($this->is_api) {
                http_response_code(401);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['success' => false, 'error' => 'No autorizado']);
                exit;
            }
            require_once(CONTROLLERS . "login.php");
            call_user_func_array([new Login, 'index'], $this->params);
        }

    }

    public function formatUrl()
    {
        if (isset($_GET['url'])) {
            $url = str_replace("-", "_", $_GET['url']);
            return explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));
        }
    }

    public function is_user_logged()
    {
        $jwt = null;

        if ($this->is_api) {
            $headers = getallheaders();
            if (isset($headers['Authorization']) && str_starts_with($headers['Authorization'], 'Bearer ')) {
                $jwt = substr($headers['Authorization'], 7);
            }
        } else {
            $jwt = $_COOKIE['jwt_token'] ?? null;
        }

        if (!$jwt) {
            $this->user = null;
            return false;
        }

        try {
            $payload = JWT::decode($jwt, new Key(JWT_SECRET, 'HS256'));
            $this->user = $payload->data;
            return true;
        } catch (Exception $e) {
            $this->user = null;
            if (!$this->is_api) {
                setcookie('jwt_token', '', time() - 3000, '/');
            }
            return false;
        }
    }
}

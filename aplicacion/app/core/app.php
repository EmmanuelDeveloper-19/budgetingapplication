<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class App
{

    protected $controller;
    protected $method;
    protected $params;
    protected $error_404;
    protected $user;
    protected $db;

    public function __construct()
    {
        $this->controller = "home";
        $this->method = "index";
        $this->params = [];
        $this->db = new Db();

        $url = $this->formatUrl();

        if (isset($url[0])) {
            if (file_exists(CONTROLLERS . $url[0] . ".php")) {
                $this->controller = $url[0];
                unset($url[0]);
            } else {
                $this->method = "e404";
            }
        }

        require_once(CONTROLLERS . $this->controller . ".php");

        $this->controller = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else if (!is_numeric($url[1])) {
                $this->method = "e404";
            }
        }

        // Manejo de la autenticación
        if ($this->is_user_logged()) {
            $this->params = $url ? array_values($url) : array();
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            require_once(CONTROLLERS . "login.php");
            $this->params = $url ? array_values($url) : array();
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
        // Lee el jwt desde la cookie
        if(!isset($_COOKIE['jwt_token'])){
            $this->user = null;
            return false;
        }

        $jwt = $_COOKIE['jwt_token'];

        try{
            $payload = JWT::decode($jwt, new Key(JWT_SECRET, 'HS256'));

            $this->user  = $payload->data;
            return true;
        } catch(Exception $e){
            $this->user = null;
            setcookie('jwt_token', '', time() - 3000, '/');
            return false;
        }
    }
}
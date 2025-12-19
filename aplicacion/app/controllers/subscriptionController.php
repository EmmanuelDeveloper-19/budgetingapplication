<?php

class SubscriptionController extends Controller
{

    public function index()
    {

    }

    // Método para mostrar el formulario
    public function create()
    {
        $userModel = $this->model('UserModel');
        $userData = $userModel->getCurrentUser();

        $this->view("subscription/nuevo", [
            'user' => $userData
        ]);
    }

    // Método para procesar el formulario
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = $this->model('SubscriptionModel');
            $userModel = $this->model('UserModel');

            // Obtener usuario actual
            $userData = $userModel->getCurrentUser();
            $user_id = $userData['auth_id'];

            // Validar que exista usuario
            if (!$user_id) {
                header("Location: " . PATH . "login/index");
                exit();
            }

            $nombre = $_POST['nombre'] ?? '';
            $monto = $_POST['monto'] ?? 0;
            $plazo = $_POST['plazo'] ?? 'mensual';

            // Validar datos
            if (empty($nombre) || $monto <= 0) {
                $error = "Por favor complete todos los campos correctamente";
                $this->view("subscription/create", [
                    'user' => $userData,
                    'error' => $error,
                    'old' => $_POST
                ]);
                return;
            }

            $data = [
                'nombre' => $nombre,
                'monto' => $monto,
                'plazo' => $plazo,
            ];

            // Crear la suscripción
            if ($model->create($user_id, $data)) {
                header("Location: " . PATH . "userprofilecontroller/index");
                exit();
            } else {
                $error = "Error al crear la suscripción";
                $this->view("subscription/create", [
                    'user' => $userData,
                    'error' => $error,
                    'old' => $_POST
                ]);
            }
        } else {
            // Si no es POST, redirigir al formulario
            header("Location: " . PATH . "subscriptioncontroller/create");
            exit();
        }
    }
}
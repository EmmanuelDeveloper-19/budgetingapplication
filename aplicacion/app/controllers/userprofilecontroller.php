<?php

class UserprofileController extends Controller
{


    public function index()
    {
        $userModel = $this->model('UserModel');
        $userData = $userModel->getCurrentUser();
        $this->view("userProfile/index", [
            'user' => $userData
        ]);
    }

    public function updateUserInfo($user_id = 0)
    {
        $model = $this->model('UserModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? null;
            $balance = $_POST['balance'] ?? 0.00;

            // Usar el user_id del parámetro de la ruta si está disponible
            if ($user_id == 0 && isset($_POST['id'])) {
                $user_id = $_POST['id'];
            }

            $data = [
                'nombre' => $nombre,
                'apellido' => $apellido,
                'telefono' => $telefono,
                'fecha_nacimiento' => $fecha_nacimiento,
                'balance' => $balance
            ];

            // Usar el método correcto del modelo
            if ($model->updateUserProfile($user_id, $data)) {
                header("Location: " . PATH . "userprofilecontroller/index");
                exit();
            } else {
                // Mostrar error
                $error = "Error al actualizar la información";
                $userData = $model->getCurrentUser();
                $this->view("userProfile/index", [
                    'user' => $userData,
                    'error' => $error
                ]);
            }
        } else {
            // Si no es POST, redirigir
            header("Location: " . PATH . "userprofilecontroller/index");
            exit();
        }
    }

}
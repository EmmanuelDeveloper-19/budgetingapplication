<?php

class CreditCardController extends Controller
{

    public function nuevo()
    {
        $userModel = $this->model('UserModel');
        $userData = $userModel->getCurrentUser();

        $this->view(
            "creditCards/nuevo",
            ['user' => $userData]
        );
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = $this->model('creditCardModel');
            $userModel = $this->model('UserModel');

            $userData = $userModel->getCurrentUser();
            $user_id = $userData['auth_id'];

            $banco = $_POST['banco'] ?? '';
            $dia_corte = $_POST['dia_corte'] ?? '';
            $dia_pago = $_POST['dia_pago'] ?? '';
            $balance_total = $_POST['balance_total'] ?? '';
            $deuda = $_POST['deuda'] ?? '';

            $data = [
                'banco' => $banco,
                'dia_corte' => $dia_corte,
                'dia_pago' => $dia_pago,
                'balance_total' => $balance_total,
                'deuda' => $deuda
            ];

            if ($model->create($user_id, $data)) {
                header("Location: " . PATH . "home/index");
                exit();
            } else {
                $error = "Error al agregar la tarjeta de credito";
                $this->view("creditCardController/nuevo", [
                    'user' => $userData,
                    'error' => $error,
                    'old' => $_POST
                ]);
            }
        }
    }
}
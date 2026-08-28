<?php

class CreditCardController extends Controller
{

    public function nuevo()
    {
        $userModel = $this->model('userModel');
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
            $userModel = $this->model('userModel');

            $userData = $userModel->getCurrentUser();
            $user_id = $userData['id'];

            $banco = $_POST['bank'] ?? '';
            $dia_corte = $_POST['statement_closing_date'] ?? '';
            $dia_pago = $_POST['payment_date'] ?? '';
            $balance_total = $_POST['credit_limit'] ?? '';
            $deuda = $_POST['outstanding_balance'] ?? '';
            $installments = $_POST['installments'] ??'';
            $status = $_POST['status'] ??'';

            $data = [
                'bank' => $banco,
                'statement_closing_date' => $dia_corte,
                'payment_date' => $dia_pago,
                'credit_limit' => $balance_total,
                'outstanding_balance' => $deuda,

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

    public function editView($id)
    {
        $model = $this->model('creditCardModel');
        $creditCard = $model->getById($id);

        return $this->view("creditCards/editar", [
            'creditCard' => $creditCard
        ]);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $model = $this->model('creditCardModel');

            $id = $_POST['id'] ?? null;

            if (!$id) {
                $error = "ID de tarjeta no válido";

                $this->view("creditCards/editar", [
                    'error' => $error,
                    'old' => $_POST
                ]);

                return;
            }

            $data = [
                'bank' => $_POST['bank'] ?? '',
                'statement_closing_date' => $_POST['statement_closing_date'] ?? '',
                'payment_date' => $_POST['payment_date'] ?? '',
                'credit_limit' => $_POST['credit_limit'] ?? 0,
                'outstanding_balance' => $_POST['outstanding_balance'] ?? 0
            ];

            if ($model->update($id, $data)) {

                header("Location: " . PATH . "home/index");
                exit();

            } else {

                $error = "Error al actualizar la tarjeta de crédito";

                $this->view("creditCards/editar", [
                    'error' => $error,
                    'old' => $_POST
                ]);
            }
        }
    }

    public function delete(){

    }
}
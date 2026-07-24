<?php

class DebitCardController extends Controller
{

    public function nuevo()
    {

        $this->view("debitCards/nuevo");
    }

    public function store()
    {
        $model = $this->model('debitCardModel');
        $userModel = $this->model('UserModel');

        $userData = $userModel->getCurrentUser();
        $user_id = $userData['id'];

        $banco = $_POST['bank'];
        $balance = $_POST['balance'];

        $data = [
            'bank' => $banco,
            'balance' => $balance
        ];

        if ($model->create($user_id, $data)) {
            header('Location: ' . PATH . "home/index");
            exit();
        } else {
            $e = "Error al agregar la tarjeta de debito.";
            $this->view("debitCardController/nuevo", [
                'error' => $e,
                'old' => $_POST
            ]);
        }
    }

    public function editar($id)
    {
        $model = $this->model('debitCardModel');

        $debitCard = $model->getById($id);

        return $this->view("debitCards/editar", [
            'debitCard' => $debitCard
        ]);
    }

    public function update($id)
    {

        $model = $this->model('debitCardModel');

        $data = [
            'banco' => $_POST['banco'],
            'balance' => $_POST['balance']
        ];

        if ($model->update($id, $data)) {
            header('Location: ' . PATH . 'home/index');
            exit;
        } else {
            $e = "Error al actualizar la tarjeta de debito.";
            $this->view("debitCardController/editar", [
                'error' => $e,
                'old' => $_POST
            ]);
        }
    }

    public function delete($id)
    {
        $model = $this->model('debitCardModel');
        if ($model->delete($id)) {
            header('Location: ' . PATH . 'home/index');
            exit;
        } else {
            $e = "Error al actualizar la tarjeta de debito.";
            $this->view("home/index", [
                'error' => $e,
            ]);
        }
    }
}
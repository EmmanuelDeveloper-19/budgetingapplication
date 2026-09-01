<?php

class DebitCardController extends Controller
{

    public function nuevo()
    {
        $_SESSION['previous_url'] = $_SERVER['HTTP_REFERER'] ?? PATH . "home/index";

        $this->view("debitCards/nuevo");
    }

    public function store()
    {
        $model = $this->model('debitCardModel');
        $userModel = $this->model('userModel');

        $userData = $userModel->getCurrentUser();
        $user_id = $userData['id'];

        $banco = $_POST['bank'];
        $balance = $_POST['balance'];

        $data = [
            'bank' => $banco,
            'balance' => $balance
        ];

        if ($model->create($user_id, $data)) {

            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Tarjeta agregada correctamente'
            ];

            $redirect = $_SESSION['previous_url'] ?? PATH . "home/index";

            unset($_SESSION['previous_url']);

            header("Location: " . $redirect);
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

    function abonarTarjeta($cardId)
    {
        $userModel = $this->model('userModel');
        $model = $this->model('debitCardModel');

        // Usuario autenticado
        $userData = $userModel->getCurrentUser();
        $userId = $userData['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $amount = $_POST['amount'] ?? '';

            if (!$cardId) {
                die("No hay ID de la tarjeta");
            }

            if (!$amount) {
                die("No hay cantidad para abonar");
            }

            $data = [
                'amount' => $amount,
                'user_id' => $userId,
                'id' => $cardId
            ];

            if ($model->abonarTarjeta($data)) {

                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => 'Abono agregado correctamente.'
                ];

                header("Location: " . PATH . "home/index");
                exit();

            } else {

                $e = "Error al pagar la tarjeta.";

                $this->view("home/index", [
                    'error' => $e,
                    'old' => $_POST
                ]);
            }
        }
    }
}
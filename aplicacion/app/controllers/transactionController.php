<?php

class TransactionController extends Controller
{

    function __construct()
    {

    }

    public function create()
    {

        $this->view('transaction/create');
    }

    public function store()
    {
        $model = $this->model('TransactionModel');

        $userModel = $this->model('UserModel');
        $userData = $userModel->getCurrentUser();

        $user_id = $userData['id'];
        
        $name = $_POST['name'];
        $type = $_POST['type'];
        $amount = $_POST['amount'];
        $payment_method = $_POST['payment_method'];
        $description = $_POST['description'];

        $data = [
            'name' => $name,
            'type' => $type,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'description' => $description,
            'user_id' => $user_id
        ];

        switch ($_POST['payment_method']) {

            case 'cash':

                if ($model->processCashTransaction($data)) {
                    header('Location: ' . PATH . 'transaction/create');
                    exit();
                }

                $this->view('transaction/create', [
                    'error' => 'Error al agregar la transacción.',
                    'old' => $_POST
                ]);

                break;

            case 'debit_card':
                break;

            case 'credit_card':
                break;
        }
    }
}
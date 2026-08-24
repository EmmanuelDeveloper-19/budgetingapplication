<?php

class TransactionController extends Controller
{

    function __construct()
    {

    }

    public function create()
    {
        $user = $this->model("UserModel");
        $userData = $user->getCurrentUser();
        $user_id = $userData['id'];

        $debitModel = $this->model("DebitCardModel");
        $debitCard = $debitModel->getByUserId($user_id);

        $creditCardModel = $this->model("CreditCardModel");
        $creditCard = $creditCardModel->getByUserId($user_id);


        $this->view("transaction/create", [
            'creditCards' => $creditCard,
            'debitCards' => $debitCard
        ]);
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
        $id_credit_card = $payment_method === 'credit_card'
            ? ($_POST['credit_card_id'] ?? null)
            : null;

        $id_debit_card = $payment_method === 'debit_card'
            ? ($_POST['debit_card_id'] ?? null)
            : null;

        $data = [
            'name' => $name,
            'type' => $type,
            'amount' => $amount,
            'payment_method' => $payment_method,
            'description' => $description,
            'id_credit_card' => $id_credit_card,
            'id_debit_card' => $id_debit_card,
            'user_id' => $user_id
        ];

        switch ($_POST['payment_method']) {

            case 'cash':

                if ($model->processCashTransaction($data)) {
                    $_SESSION['alert'] = [
                        'type' => 'success',
                        'message' => 'Transacción agregada correctamente'
                    ];

                    header("Location: " . PATH . "home/index");
                    exit();
                }

                $this->view('transaction/create', [
                    'error' => 'Error al agregar la transacción.',
                    'old' => $_POST
                ]);

                break;

            case 'debit_card':
                if ($model->processDebitTransaction($data)) {
                    header('Location: ' . PATH . 'home/index');
                    exit();
                } else {
                    $this->view('transaction/create', [
                        'error' => 'Error al agregar la transacción.',
                        'old' => $_POST
                    ]);
                }
                break;

            case 'credit_card':
                break;
        }
    }
}
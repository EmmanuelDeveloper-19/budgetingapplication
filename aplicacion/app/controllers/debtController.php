<?php

class DebtController extends Controller
{

    public function index()
    {
        $userModel = $this->model('userModel');
        $creditCardModel = $this->model('creditCardModel');
        $debtModel = $this->model('debtModel');
        $userData = $userModel->getCurrentUser();

        $user_id = $userData['id'];

        $creditCards = $creditCardModel->getByUserId($user_id);
        $contacts = $debtModel->getContactWithAmount($user_id);
        $debts = $debtModel->getDebtsByUserId($user_id);
        $totalDebt = $debtModel->getTotalDebtByUserId($user_id);

        return $this->view("debts/index", [
            'creditCards' => $creditCards,
            'contacts' => $contacts,
            'debts' => $debts,
            'total' => $totalDebt
        ]);
    }

    public function contactCreate()
    {

        return $this->view("debts/contactCreate");
    }

    public function contactStore()
    {
        $model = $this->model('debtModel');
        $userModel = $this->model('userModel');

        $userData = $userModel->getCurrentUser();
        $user_id = $userData['id'];

        $name = $_POST['name'];

        $data = [
            'name' => $name,
            'user_id' => $user_id
        ];


        if ($model->createContact($data)) {

            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Contacto agregado correctamente'
            ];

            header("Location: " . PATH . 'debtController/index');
            exit();
        } else {

            $e = "Error al crear contacto.";

            $this->view("debitCardController/nuevo", [
                'error' => $e,
                'old' => $_POST
            ]);
        }
    }

    public function debtCreate()
    {
        $model = $this->model('debtModel');
        $userModel = $this->model('userModel');
        $userData = $userModel->getCurrentUser();
        $user_id = $userData['id'];
        $contacts = $model->getAllContactsByUserId($user_id);

        return $this->view("debts/debtCreate", [
            'contacts' => $contacts
        ]);
    }

    public function debtStore()
    {
        $model = $this->model('debtModel');
        $userModel = $this->model('userModel');
        $userData = $userModel->getCurrentUser();
        $user_id = $userData['id'];

        $amount = $_POST['amount'];
        $contact_id = $_POST['contact_id'];
        $debt_date = $_POST['debt_date'];
        $due_date = $_POST['due_date'];
        $interest = $_POST['interest'];

        $data = [
            'user_id' => $user_id,
            'amount' => $amount,
            'contact_id' => $contact_id,
            'debt_date' => $debt_date,
            'due_date' => $due_date,
            'interest' => $interest

        ];

        if ($model->create_debt($data)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Deuda agregada correctamnete'
            ];
            header('Location: ' . PATH . 'debtController/index');
            exit();
        } else {

            $e = "Error al crear contacto.";

            $this->view("debitCardController/nuevo", [
                'error' => $e,
                'old' => $_POST
            ]);
        }
    }

    public function deleteDebt()
    {
        $model = $this->model('debtModel');
        $debt_id = $_POST['debt_id'];

        if ($model->deleteDebt($debt_id)) {
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Deuda eliminada correctamente'
            ];
            header('Location: ' . PATH . 'debtController/index');
            exit();
        } else {

            $e = "Error al crear contacto.";

            $this->view("debitCardController/index", [
                'error' => $e,
                'old' => $_POST
            ]);
        }
    }
}
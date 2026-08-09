<?php

class Home extends Controller
{
    public function index()
    {
        $userModel = $this->model('UserModel');
        $creditCardModel = $this->model('CreditCardModel');
        $debitCardModel = $this->model('debitCardModel');
        $transactionModel = $this->model('transactionModel');

        $userData = $userModel->getCurrentUser();

        if (!$userData) {
            header('Location: ' . PATH . 'login');
            exit();
        }

        $user_id = $userData['id'];

        $creditCards = $creditCardModel->getByUserId($user_id);
        $debitCards = $debitCardModel->getByUserId($user_id);
        $transactions = $transactionModel->getTransactions($user_id);

        $this->view("home/index", [
            'user' => $userData,
            'creditCards' => $creditCards,
            'debitCards' => $debitCards,
            'transactions' => $transactions
        ]);
    }
}
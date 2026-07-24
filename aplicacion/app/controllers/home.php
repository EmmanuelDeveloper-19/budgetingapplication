<?php

class Home extends Controller
{
    public function index()
    {
        $userModel = $this->model('UserModel');
        $creditCardModel = $this->model('CreditCardModel');
        $debitCardModel = $this->model('debitCardModel');

        $userData = $userModel->getCurrentUser();

        // VALIDACIÓN: Si no hay usuario o expiro la sesión, redirigir al login
        if (!$userData) {
            header('Location: ' . PATH . 'login');
            exit();
        }

        $user_id = $userData['id'];

        $creditCards = $creditCardModel->getByUserId($user_id);
        $debitCards = $debitCardModel->getByUserId($user_id);

        $this->view("home/index", [
            'user' => $userData,
            'creditCards' => $creditCards,
            'debitCards' => $debitCards
        ]);
    }
}
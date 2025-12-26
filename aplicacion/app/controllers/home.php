<?php

class Home extends Controller
{

    public function index()
    {

        $userModel = $this->model('UserModel');
        $subModel = $this->model('SubscriptionModel');
        $creditCardModel = $this->model('CreditCardModel');
        $debitCardModel = $this->model('debitCardModel');


        $userData = $userModel->getCurrentUser();

        $user_id = $userData['auth_id'];

        $subscriptions = $subModel->getByUser($user_id);
        $creditCards = $creditCardModel->getByUserId($user_id);
        $debitCards = $debitCardModel->getByUserId($user_id);




        $this->view("home/index", [
            'user' => $userData,
            'subscriptions' => $subscriptions,
            'creditCards' => $creditCards,
            'debitCards' => $debitCards

        ]);
    }




}
<?php

class Home extends Controller
{

    public function index()
    {

        $userModel = $this->model('UserModel');
        $subModel = $this->model('SubscriptionModel');
    
        $userData = $userModel->getCurrentUser();

        $user_id = $userData['auth_id'];

        $subscriptions = $subModel->getByUser($user_id);

        
        $this->view("home/index", [
            'user' => $userData,
            'subscriptions' => $subscriptions
        ]);
    }




}
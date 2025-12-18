<?php

class Home extends Controller{

    public function index(){
        
        $userModel = $this->model('UserModel');
        $userData = $userModel->getCurrentUser();
        $this->view("home/index", [
            'user' => $userData
        ]);
    }

}
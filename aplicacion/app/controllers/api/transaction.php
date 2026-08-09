<?php

class Transaction extends ApiController 
{
    public function index()
    {

        $uModel = $this->model('UserModel');
        $uData = $uModel->getCurrentUser();
        $user_id = $uData['id'];
        if(!$user_id)
        {
            $this->json(401, null, 'No autorizado');
            return;
        }

        $model = $this->model('TransactionModel');
        $transactions = $model->getTransactions($user_id);

        $this->json(200, $transactions);

    }
}


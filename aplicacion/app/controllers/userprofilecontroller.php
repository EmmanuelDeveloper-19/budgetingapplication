<?php

class UserprofileController extends Controller
{


    public function index()
    {
        $userModel = $this->model('userModel');
        $debitCardModel = $this->model('debitCardModel');
        $creditCardModel = $this->model('creditCardModel');


        $userData = $userModel->getCurrentUser();
        $user_id = $userData['id'];
        $debitData = $debitCardModel->getByUserId($user_id);
        $creditData = $creditCardModel->getByUserId($user_id);

        $this->view("userProfile/index", [
            'user' => $userData,
            'creditCardData' => $creditData,
            'debitData' => $debitData
        ]); 
    }

    public function updateUserInfo($user_id = 0)
    {
        $model = $this->model('userModel');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $balance = $_POST['balance'] ?? 0.00;

            if ($user_id == 0 && isset($_POST['id'])) {
                $user_id = $_POST['id'];
            }

            $data = [
                'name' => $name,
                'last_name' => $last_name,
                'balance' => $balance
            ];

            if ($model->updateUserProfile($user_id, $data)) {
                header("Location: " . PATH . "userprofilecontroller/index");
                exit();
            } else {
                $error = "Error al actualizar la información";
                $userData = $model->getCurrentUser();
                $this->view("userProfile/index", [
                    'user' => $userData,
                    'error' => $error
                ]);
            }
        } else {
            header("Location: " . PATH . "userprofilecontroller/index");
            exit();
        }
    }

}
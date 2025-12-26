<?php

class SubscriptionController extends Controller
{

    public function index()
    {

    }

    // Método para mostrar el formulario
    public function create()
    {
        $userModel = $this->model('UserModel');
        $userData = $userModel->getCurrentUser();

        $user_id = $userData['auth_id'];

        $creditCardModel = $this->model('CreditCardModel');
        $debitCardModel = $this->model('DebitCardModel');

        $creditCards = $creditCardModel->getByUserId($user_id);
        $debitCards = $debitCardModel->getByUserId($user_id);

        $this->view("subscription/nuevo", [
            'user' => $userData,
            'creditCards' => $creditCards,
            'debitCards' => $debitCards,
            'old' => $_POST ?? []
        ]);
    }

    // Método para procesar el formulario
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = $this->model('SubscriptionModel');
            $userModel = $this->model('UserModel');

            // Obtener usuario actual
            $userData = $userModel->getCurrentUser();
            $user_id = $userData['auth_id'];

            $nombre = $_POST['nombre'] ?? '';
            $monto = $_POST['monto'] ?? 0;
            $plazo = $_POST['plazo'] ?? 'mensual';
            $metodo_pago = $_POST['metodo_pago'] ?? '';
            $tarjeta_id = $_POST['tarjeta_id'] ?? null;

            $data = [
                'nombre' => $nombre,
                'monto' => $monto,
                'plazo' => $plazo,
                'metodo_pago' => $metodo_pago,
                'tarjeta_id' => $tarjeta_id
            ];

            $success = false;

            switch ($metodo_pago) {
                case 'credito':
                    $success = $model->procesar_pago_credito($user_id, $data);
                    break;
                case 'debito':
                    $success = $model->procesar_pago_debito($user_id, $data);
                    break;
                case 'efectivo':
                    $success = $model->procesar_pago_efectivo($user_id, $data);
                    break;
                default:
                    $error = "Método de pago no válido";
                    $this->view("subscription/nuevo", [
                        'user' => $userData,
                        'error' => $error,
                        'old' => $_POST
                    ]);
                    return;
            }

            if($success){
                $_SESSION['response'] = [
                    "type" => "success",
                    "message" => "Subscripción creada correctamente"
                ];
                header("Location: " . PATH . "home/index");
                exit();
            } else {
                $_SESSION['response'] = [
                    "type" => "danger",
                    "message" => "Hubo un error al procesar la solicitud."
                ];
            }
        } else {
            // Si no es POST, redirigir al formulario
            header("Location: " . PATH . "subscriptioncontroller/create");
            exit();
        }
    }

    public function editar($id)
    {
        $model = $this->model("subscriptionModel");
        $sub = $model->getById($id);

        return $this->view("subscription/editar", [
            'subscription' => $sub
        ]);
    }

    public function update($id)
    {

        $model = $this->model('subscriptionModel');

        $data = [
            'nombre' => $_POST['nombre'],
            'monto' => $_POST['monto'],
            'plazo' => $_POST['plazo']
        ];

        if ($model->update($id, $data)) {
            header('Location: ' . PATH . 'home/index');
            exit;
        } else {
            $e = "Error al actualizar la subscripción.";
            $this->view("subscriptionController/editar", [
                'error' => $e,
                'old' => $_POST
            ]);
        }
    }

    public function delete($id)
    {
        $model = $this->model('subscriptionModel');
        if ($model->delete($id)) {
            $_SESSION['response'] = [
                "type" => "success",
                "message" => "Suscripción eliminada correctamente"
            ];
            header('Location: ' . PATH . 'home/index');
            exit;
        } else {
            $e = "Error borrar la subscripción.";
            $this->view("home/index", [
                'error' => $e,
            ]);
        }
    }
}
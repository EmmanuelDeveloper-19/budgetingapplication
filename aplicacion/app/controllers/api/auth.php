<?php

class Auth extends ApiController
{
    public function login()
    {
        $body = $this->get_json_body();

        if (empty($body['username']) || empty($body['password'])) {
            $this->json(
                422,
                null,
                'Email y contraseña son requeridos'
            );
            return;
        }

        $authModel = $this->model('AuthModel');

        $jwt = $authModel->login([
            'username' => $body['username'],
            'password' => $body['password']
        ]);

        if (!$jwt) {
            $this->json(
                401,
                null,
                'Usuario o contraseña incorrectos'
            );
            return;
        }

        setcookie(
            'jwt_token',
            $jwt,
            [
                'expires' => time() + (3600 * 24),
                'path' => '/',
                'httponly' => true,
                'secure' => false,
                'samesite' => 'Lax'
            ]
        );

        $this->json(
            200,
            [
                'authenticated' => true
            ],
            'Inicio de sesión exitoso'
        );
    }
}

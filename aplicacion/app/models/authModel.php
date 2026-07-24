<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthModel extends Db
{
    private $table = 'authentication';

    public function __construct()
    {
        parent::__construct();
    }

    public function register(array $data)
    {
        $name = trim($data['name'] ?? '');
        $last_name = trim($data['last_name'] ?? '');
        $username = trim($data['username']);
        $password = $data['password'];

        // 1. Verificar si el usuario ya existe
        $queryCheck = "SELECT id FROM authentication WHERE username = ?";
        $existing = $this->preparedSelect($queryCheck, "s", [$username]);

        if (!empty($existing)) {
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $this->beginTransaction();

            $queryUsers = "INSERT INTO users (name, last_name, balance) VALUES (?, ?, ?)";
            $user_id = $this->preparedQuery($queryUsers, "ssd", [$name, $last_name, 0.00], true);

            if ($user_id && $user_id > 0) {
                $query_auth = "INSERT INTO authentication (idUser, username, password) VALUES (?, ?, ?)";
                $result_auth = $this->preparedQuery($query_auth, "iss", [$user_id, $username, $hashed_password]);

                if ($result_auth > 0) {
                    $this->commit(); 
                    return true;
                }
            }

            $this->rollback(); // Cancelar si falla la segunda tabla
            return false;

        } catch (Exception $e) {
            $this->rollback();
            error_log("Error en registro: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verifica las credenciales y genera un JWT
     */
    public function login(array $data)
    {

        if (empty($data['username']) || empty($data['password'])) {
            return false;
        }

        $username = trim($data['username']);
        $password = $data['password'];

        // Buscar usuario
        $query = "SELECT id, username, password FROM {$this->table} WHERE username = ?";
        $users = $this->preparedSelect($query, "s", [$username]);

        if (empty($users)) {
            return false;
        }

        $user = $users[0];

        $password_match = false;

        // Método 1: password_hash (moderno)
        if (password_verify($password, $user['password'])) {
            $password_match = true;
        }
        // Método 2: SHA-256 (legacy - 64 caracteres hex)
        else if (strlen($user['password']) === 64 && preg_match('/^[a-f0-9]{64}$/i', $user['password'])) {
            $sha256_hash = hash('sha256', $password);
            if ($sha256_hash === $user['password']) {
                $password_match = true;
                $this->updatePassword($user['id'], $password);
            }
        }

        if (!$password_match) {
            return false;
        }


        $payload = [
            'iss' => PATH,
            'iat' => time(),
            'exp' => time() + (3600 * 24), // 1 día
            'data' => [
                'user_id' => $user['id'],
                'username' => $user['email']
            ]
        ];

        try {
            $jwt = JWT::encode($payload, JWT_SECRET, 'HS256');
            return $jwt;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updatePassword($user_id, $new_password)
    {
        error_log("Actualizando contraseña para usuario ID: " . $user_id);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE {$this->table} SET password_hash = ? WHERE id = ?";
        $result = $this->preparedQuery($query, "si", [$hashed_password, $user_id]);

        error_log("Resultado actualización: " . ($result > 0 ? "Éxito" : "Falló"));
        return $result > 0;
    }

    // ... resto de los métodos permanecen igual ...
}
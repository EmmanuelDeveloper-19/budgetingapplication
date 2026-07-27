<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserModel extends Db
{
    private $table = 'authentication';

    public function __construct()
    {
        parent::__construct();
    }

    public function getCurrentUser()
    {
        // Leer JWT desde cookie
        if (!isset($_COOKIE['jwt_token'])) {
            return null;
        }

        try {
            // Decodificar JWT
            $jwt = $_COOKIE['jwt_token'];
            $payload = JWT::decode($jwt, new Key(JWT_SECRET, 'HS256'));

            // CORRECCIÓN: Acceder a user_id que es la clave definida al generar el JWT
            $data = $payload->data;
            $user_id = is_array($data) ? ($data['user_id'] ?? $data['id'] ?? null) : ($data->user_id ?? $data->id ?? null);

            if (!$user_id) {
                return null;
            }

            // Buscar usuario en la BD
            return $this->getUserProfileInfo($user_id);

        } catch (Exception $e) {
            error_log("Error obteniendo usuario actual: " . $e->getMessage());
            return null;
        }
    }

    public function getUserById($user_id)
    {
        $query = "SELECT id, username FROM {$this->table} WHERE id = ?";
        $result = $this->preparedSelect($query, "i", [$user_id]);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }


    public function getAllUsers()
    {
        $query = "SELECT id, email, is_active, created_at FROM {$this->table} ORDER BY created_at DESC";
        return $this->select($query);
    }
    public function updateProfile($user_id, $data)
    {
        $query = "UPDATE {$this->table} SET username = ? WHERE id = ?";
        $result = $this->preparedQuery($query, "si", [$data['email'], $user_id]);

        return $result > 0;
    }

    public function getUserProfileInfo($user_id)
    {
        $q = "SELECT a.id AS id_auth,
                     a.username,
                     a.created_at AS fecha_registro,
                     p.id AS id,
                     p.name,
                     p.last_name,
                     p.balance
                FROM authentication a
                INNER JOIN users p ON a.idUser = p.id
                WHERE a.id = ?";

        $result = $this->preparedSelect($q, "i", [$user_id]);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    public function updateUserProfile($user_id, array $data)
    {
        $query = "UPDATE users SET 
                  name = ?,
                  last_name = ?,
                  balance = ?
                  WHERE id = ?";

        return $this->preparedQuery($query, "ssdi", [
            $data['name'] ?? null,
            $data['last_name'] ?? null,
            $data['balance'] ?? 0.00,
            $user_id
        ]);
    }
}
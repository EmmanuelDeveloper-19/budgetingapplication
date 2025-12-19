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

            // Obtener user_id del payload
            $user_id = $payload->data->user_id;

            // Buscar usuario en la BD
            return $this->getUserProfileInfo($user_id);

        } catch (Exception $e) {
            return null;
        }
    }

    public function getUserById($user_id)
    {
        $query = "SELECT id, email, is_active, created_at FROM {$this->table} WHERE id = ?";
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
        $query = "UPDATE {$this->table} SET email = ? WHERE id = ?";
        $result = $this->preparedQuery($query, "si", [$data['email'], $user_id]);

        return $result > 0;
    }

    public function getUserProfileInfo($user_id)
    {
        $q = "SELECT a.id AS auth_id,
                    a.email,
                    a.created_at AS fecha_registro,
                    a.is_active,
                    p.id AS profile_id,
                    p.user_id,
                    p.nombre,
                    p.apellido,
                    p.telefono,
                    p.fecha_nacimiento,
                    p.balance
                FROM authentication a
                LEFT JOIN user_profiles p ON a.id = p.user_id
                WHERE a.id = ?";
        $result = $this->preparedSelect($q, "i", [$user_id]);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    public function updateUserProfile($user_id, array $data)
    {
        // Verificar si ya existe un perfil para este usuario
        $checkQuery = "SELECT id FROM user_profiles WHERE user_id = ?";
        $existing = $this->preparedSelect($checkQuery, "i", [$user_id]);

        if (empty($existing)) {
            // INSERT si no existe perfil
            $query = "INSERT INTO user_profiles 
                  (user_id, nombre, apellido, telefono, fecha_nacimiento, balance)
                  VALUES (?, ?, ?, ?, ?, ?)";

            return $this->preparedQuery($query, "issssd", [
                $user_id,
                $data['nombre'] ?? null,
                $data['apellido'] ?? null,
                $data['telefono'] ?? null,
                $data['fecha_nacimiento'] ?? null,
                $data['balance'] ?? 0.00
            ]);
        } else {
            // UPDATE si ya existe
            $query = "UPDATE user_profiles SET 
                  nombre = ?,
                  apellido = ?,
                  telefono = ?,
                  fecha_nacimiento = ?,
                  balance = ?
                  WHERE user_id = ?";

            return $this->preparedQuery($query, "ssssdi", [
                $data['nombre'] ?? null,
                $data['apellido'] ?? null,
                $data['telefono'] ?? null,
                $data['fecha_nacimiento'] ?? null,
                $data['balance'] ?? 0.00,
                $user_id
            ]);
        }
    }
}
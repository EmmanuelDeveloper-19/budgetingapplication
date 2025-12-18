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

    /**
     * Obtener información del usuario logueado desde la cookie JWT
     * @return array|null Datos del usuario o null si no está logueado
     */
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
            return $this->getUserById($user_id);
            
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Obtener usuario por ID
     * @param int $user_id
     * @return array|null Datos del usuario o null si no existe
     */
    public function getUserById($user_id)
    {
        $query = "SELECT id, email, is_active, created_at FROM {$this->table} WHERE id = ?";
        $result = $this->preparedSelect($query, "i", [$user_id]);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    /**
     * Obtener todos los usuarios (opcional)
     * @return array Lista de usuarios
     */
    public function getAllUsers()
    {
        $query = "SELECT id, email, is_active, created_at FROM {$this->table} ORDER BY created_at DESC";
        return $this->select($query);
    }

    /**
     * Actualizar perfil de usuario
     * @param int $user_id
     * @param array $data Datos a actualizar (email, etc)
     * @return bool
     */
    public function updateProfile($user_id, $data)
    {
        $query = "UPDATE {$this->table} SET email = ? WHERE id = ?";
        $result = $this->preparedQuery($query, "si", [$data['email'], $user_id]);
        
        return $result > 0;
    }
}
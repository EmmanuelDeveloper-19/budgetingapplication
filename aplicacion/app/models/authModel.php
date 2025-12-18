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

    /**
     * Registrar un nuevo usuario
     */
    public function register(array $data)
    {
        error_log("=== REGISTER MODEL ===");
        error_log("Datos: " . print_r($data, true));
        
        if (empty($data['username']) || empty($data['password'])) {
            error_log("Error: Datos incompletos");
            return false;
        }

        $username = trim($data['username']);
        $password = $data['password'];

        // Verificar si el usuario ya existe
        $query = "SELECT id FROM {$this->table} WHERE email = ?";
        $existing = $this->preparedSelect($query, "s", [$username]);

        if (!empty($existing)) {
            error_log("Usuario ya existe: " . $username);
            return false;
        }

        // Crear hash de la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        error_log("Password original: " . $password);
        error_log("Password hasheada: " . $hashed_password);
        error_log("Longitud hash: " . strlen($hashed_password));

        // Insertar usuario
        $query = "INSERT INTO {$this->table} (email, password_hash) VALUES (?, ?)";
        $result = $this->preparedQuery($query, "ss", [$username, $hashed_password]);

        if ($result > 0) {
            error_log("Usuario registrado exitosamente");
            
            // Verificar inmediatamente que se puede verificar la contraseña
            $check_query = "SELECT password_hash FROM {$this->table} WHERE email = ?";
            $saved = $this->preparedSelect($check_query, "s", [$username]);
            
            if (!empty($saved)) {
                $verify = password_verify($password, $saved[0]['password_hash']);
                error_log("Verificación inmediata: " . ($verify ? "OK" : "FALLÓ"));
                
                // Si falla, podría ser un problema de codificación
                if (!$verify) {
                    error_log("Hash guardado: " . $saved[0]['password_hash']);
                    error_log("Longitud hash guardado: " . strlen($saved[0]['password_hash']));
                }
            }
            
            return true;
        }

        error_log("Error en INSERT: " . $this->error());
        return false;
    }

    /**
     * Verifica las credenciales y genera un JWT
     */
    public function login(array $data)
    {
        error_log("=== LOGIN MODEL ===");
        error_log("Intentando login para: " . $data['username']);
        
        if (empty($data['username']) || empty($data['password'])) {
            error_log("Error: Credenciales vacías");
            return false;
        }

        $username = trim($data['username']);
        $password = $data['password'];

        // Buscar usuario
        $query = "SELECT id, email, password_hash FROM {$this->table} WHERE email = ?";
        $users = $this->preparedSelect($query, "s", [$username]);

        if (empty($users)) {
            error_log("Usuario no encontrado: " . $username);
            return false;
        }

        $user = $users[0];
        error_log("Usuario encontrado - ID: " . $user['id']);
        error_log("Hash en DB (inicio): " . substr($user['password_hash'], 0, 30) . "...");
        error_log("Longitud hash en DB: " . strlen($user['password_hash']));

        // Verificar contraseña
        $password_match = false;
        
        // Método 1: password_hash (moderno)
        if (password_verify($password, $user['password_hash'])) {
            error_log("Verificación con password_hash: CORRECTA");
            $password_match = true;
        } 
        // Método 2: SHA-256 (legacy - 64 caracteres hex)
        else if (strlen($user['password_hash']) === 64 && preg_match('/^[a-f0-9]{64}$/i', $user['password_hash'])) {
            error_log("Intentando verificación con SHA-256");
            $sha256_hash = hash('sha256', $password);
            if ($sha256_hash === $user['password_hash']) {
                error_log("Verificación con SHA-256: CORRECTA");
                $password_match = true;
                // Actualizar a password_hash
                $this->updatePassword($user['id'], $password);
            }
        }

        if (!$password_match) {
            error_log("CONTRASEÑA INCORRECTA");
            error_log("Password ingresada: " . $password);
            error_log("Hash esperado: " . $user['password_hash']);
            return false;
        }

        // Generar JWT
        error_log("Generando JWT para usuario ID: " . $user['id']);
        
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
            error_log("JWT generado exitosamente");
            return $jwt;
        } catch (Exception $e) {
            error_log("Error generando JWT: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualizar contraseña a password_hash moderno
     */
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
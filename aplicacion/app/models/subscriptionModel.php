<?php

class SubscriptionModel extends Db
{
    private $table = 'subscriptions';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Crear nueva suscripción
     */
    public function create($user_id, array $data)
    {
        $query = "INSERT INTO {$this->table} 
                  (user_id, nombre, monto, plazo) 
                  VALUES (?, ?, ?, ?)";

        return $this->preparedQuery($query, "isds", [
            $user_id,
            $data['nombre'],
            $data['monto'],
            $data['plazo']
        ]);
    }

    /**
     * Obtener suscripciones de un usuario
     */
    public function getByUser($user_id)
    {
        $query = "SELECT * FROM {$this->table} 
                  WHERE user_id = ? 
                  ORDER BY created_at DESC";

        $result = $this->preparedSelect($query, "i", [$user_id]);

        return $result ?: [];
    }

    /**
     * Obtener una suscripción por ID
     */
    public function getById($subscription_id, $user_id = null)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $params = ["i", $subscription_id];

        if ($user_id) {
            $query .= " AND user_id = ?";
            $params[0] .= "i";
            $params[] = $user_id;
        }

        $result = $this->preparedSelect($query, ...$params);

        return $result ? $result[0] : null;
    }

    /**
     * Actualizar suscripción
     */
    public function update($subscription_id, $user_id, array $data)
    {
        $query = "UPDATE {$this->table} SET 
                  nombre = ?, 
                  monto = ?, 
                  plazo = ?
                  WHERE id = ? AND user_id = ?";

        return $this->preparedQuery($query, "sdsii", [
            $data['nombre'],
            $data['monto'],
            $data['plazo'],
            $subscription_id,
            $user_id
        ]);
    }

    /**
     * Eliminar suscripción
     */
    public function delete($subscription_id, $user_id)
    {
        $query = "DELETE FROM {$this->table} 
                  WHERE id = ? AND user_id = ?";

        return $this->preparedQuery($query, "ii", [
            $subscription_id,
            $user_id
        ]);
    }

    /**
     * Obtener total de suscripciones por usuario
     */
    public function getTotalByUser($user_id)
    {
        $query = "SELECT 
                  COUNT(*) as total,
                  SUM(monto) as monto_total
                  FROM {$this->table} 
                  WHERE user_id = ?";

        $result = $this->preparedSelect($query, "i", [$user_id]);

        return $result ? $result[0] : ['total' => 0, 'monto_total' => 0];
    }
}
<?php

class SubscriptionModel extends Db
{
    private $table = 'subscriptions';
    private $creditCardTable = 'credit_cards';
    private $debitCardTable = 'debit_cards';
    private $user = 'user_profiles';

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

    public function getById($id)
    {
        $q = "SELECT 
                id,
                nombre,
                monto,
                plazo
                FROM {$this->table}
                WHERE id = ?";
        $r = $this->preparedSelect($q, "i", [$id]);
        return $r ? $r[0] : null;
    }

    public function update($id, $data)
    {
        $q = "UPDATE {$this->table}
                SET nombre = ?, monto = ?, plazo = ?
                WHERE id = ?";
        return $this->preparedQuery($q, "sdsi", [
            $data['nombre'],
            $data['monto'],
            $data['plazo'],
            $id

        ]);
    }

    public function delete($id)
    {
        $q = "DELETE FROM {$this->table} WHERE id = ?";
        $t = "i";
        return $this->preparedQuery($q, $t, [$id]);
    }

    /* === PROCESAR DISTINTOS MÉTODOS DE PAGOS === */
    public function procesar_pago_credito($user_id, $data)
    {
        $this->beginTransaction();

        try {
            // 1. Inserta la subscripción y obtiene su ID
            $qSub = "INSERT INTO {$this->table}
                 (user_id, nombre, monto, plazo)
                 VALUES(?, ?, ?, ?)";

            $subscription_id = $this->preparedQuery($qSub, "isds", [
                $user_id,
                $data['nombre'],
                $data['monto'],
                $data['plazo']
            ], true); // <-- aquí pedimos el insert_id

            if (!$subscription_id) {
                throw new Exception("Error al crear la subscripción.");
            }

            // 2. Actualizar la tarjeta de crédito
            $qCard = "UPDATE {$this->creditCardTable}
                  SET deuda = deuda + ?,
                      balance_total = balance_total - ?
                  WHERE id = ? AND user_id = ?";
            $resultCard = $this->preparedQuery($qCard, "ddii", [
                $data['monto'],
                $data['monto'],
                $data['tarjeta_id'],
                $user_id
            ]);

            if (!$resultCard) {
                throw new Exception("Error al actualizar la tarjeta de crédito.");
            }

            // 3. Insertar relación en credit_card_subscription
            $qCardSub = "INSERT INTO credit_card_subscription
                        (user_id, credit_card_id, subscription_id)
                     VALUES(?,?,?)";
            $resultQuery = $this->preparedQuery($qCardSub, "iii", [
                $user_id,
                $data['tarjeta_id'],
                $subscription_id
            ]);

            if (!$resultQuery) {
                throw new Exception("Error al crear la relación con la tarjeta.");
            }

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }

    public function procesar_pago_debito($user_id, $data)
    {
        $this->beginTransaction();

        try {
            // 1. Inserta la subscripción y obtiene su ID
            $qSub = "INSERT INTO {$this->table}
                 (user_id, nombre, monto, plazo)
                 VALUES(?, ?, ?, ?)";

            $subscription_id = $this->preparedQuery($qSub, "isds", [
                $user_id,
                $data['nombre'],
                $data['monto'],
                $data['plazo']
            ], true); // <-- aquí pedimos el insert_id

            if (!$subscription_id) {
                throw new Exception("Error al crear la subscripción.");
            }

            // 2. Actualizar la tarjeta de crédito
            $qCard = "UPDATE {$this->debitCardTable}
                    SET balance = balance - ?
                    WHERE id = ? AND user_id = ?";
            $resultCard = $this->preparedQuery($qCard, "dii", [
                $data['monto'],
                $data['tarjeta_id'],
                $user_id
            ]);

            if (!$resultCard) {
                throw new Exception("Error al actualizar la tarjeta de crédito.");
            }

            // 3. Insertar relación en credit_card_subscription
            $qCardSub = "INSERT INTO debit_card_subscription
                        (user_id, debit_card_id, subscription_id)
                        VALUES(?,?,?)";
            $resultQuery = $this->preparedQuery($qCardSub, "iii", [
                $user_id,
                $data['tarjeta_id'],
                $subscription_id
            ]);

            if (!$resultQuery) {
                throw new Exception("Error al crear la relación con la tarjeta.");
            }

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }

    public function procesar_pago_efectivo($user_id, $data)
    {
        $this->beginTransaction();

        try {
            // 1. Inserta la subscripción y obtiene su ID
            $qSub = "INSERT INTO {$this->table}
                 (user_id, nombre, monto, plazo)
                 VALUES(?, ?, ?, ?)";

            $subscription_id = $this->preparedQuery($qSub, "isds", [
                $user_id,
                $data['nombre'],
                $data['monto'],
                $data['plazo']
            ], true); // <-- aquí pedimos el insert_id

            if (!$subscription_id) {
                throw new Exception("Error al crear la subscripción.");
            }

            // 2. Actualizar la tarjeta de crédito
            $qCard = "UPDATE {$this->user}
                    SET balance = balance - ?
                    WHERE user_id = ?";
            $resultCard = $this->preparedQuery($qCard, "di", [
                $data['monto'],
                $user_id
            ]);

            if (!$resultCard) {
                throw new Exception("Error al actualizar la tarjeta de crédito.");
            }

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollback();
            return false;
        }
    }


}
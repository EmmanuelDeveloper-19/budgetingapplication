<?php

class CreditCardModel extends Db
{

    private $table = 'credit_cards';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($user_id, $data = [])
    {
        $q = "INSERT INTO {$this->table}
                (user_id, banco, dia_corte, dia_pago, balance_total, deuda)
                VALUES(?,?,?,?,?,?)";

        return $this->preparedQuery($q, "isiidd", [
            $user_id,
            $data['banco'],
            $data['dia_corte'],
            $data['dia_pago'],
            $data['balance_total'],
            $data['deuda']
        ]);
    }

    public function getByUserId($user_id)
    {
        $query = "SELECT
                id,
                banco,
                dia_corte,
                dia_pago,
                balance_total,
                deuda
              FROM {$this->table}
              WHERE user_id = ?";

        return $this->preparedSelect($query, "i", [$user_id]);
    }

    public function getById($id)
    {
        $q = "SELECT 
                id,
                banco,
                dia_corte,
                dia_pago,
                balance_total,
                deuda
                FROM {$this->table}
                WHERE id = ?";
        $r = $this->preparedSelect($q, "i", [$id]);
        return $r ? $r[0] : null;
    }

    public function update($id, $data)
    {
        $q = "UPDATE {$this->table}
                SET banco = ?, dia_corte = ?, dia_pago = ?, balance_total = ?, deuda = ?
                WHERE id = ?";
        return $this->preparedQuery($q, "siidd", [
            $data['banco'],
            $data['dia_corte'],
            $data['dia_pago'],
            $data['balance_total'],
            $data['deuda'],
            $id
        ]);
    }

    public function delete($id)
    {
        $q = "DELETE FROM {$this->table} WHERE id = ?";
        $t = "i";
        return $this->preparedQuery($q, $t, [$id]);
    }

}
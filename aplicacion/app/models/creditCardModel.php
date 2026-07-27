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
            (user_id, bank, statement_closing_date, payment_date, credit_limit, outstanding_balance)
            VALUES(?,?,?,?,?,?)";

        return $this->preparedQuery($q, "isssdd", [
            $user_id,
            $data['bank'],
            $data['statement_closing_date'],
            $data['payment_date'],
            $data['credit_limit'],
            $data['outstanding_balance']
        ]);
    }

    public function getByUserId($user_id)
    {
        $query = "SELECT
                id,
                bank,
                statement_closing_date,
                payment_date,
                credit_limit,
                outstanding_balance
              FROM {$this->table}
              WHERE user_id = ?";

        return $this->preparedSelect($query, "i", [$user_id]);
    }

    public function getById($id)
    {
        $q = "SELECT 
            id,
            user_id,
            bank,
            statement_closing_date,
            payment_date,
            credit_limit,
            outstanding_balance
            FROM {$this->table}
            WHERE id = ?";

        $r = $this->preparedSelect($q, "i", [$id]);

        return $r ? $r[0] : null;
    }

    public function update($id, $data = [])
    {
        $q = "UPDATE {$this->table}
          SET bank = ?,
              statement_closing_date = ?,
              payment_date = ?,
              credit_limit = ?,
              outstanding_balance = ?
          WHERE id = ?";

        return $this->preparedQuery(
            $q,
            "sssddi",
            [
                $data['bank'],
                $data['statement_closing_date'],
                $data['payment_date'],
                $data['credit_limit'],
                $data['outstanding_balance'],
                $id
            ]
        );
    }

    public function delete($id)
    {
        $q = "DELETE FROM {$this->table} WHERE id = ?";
        $t = "i";
        return $this->preparedQuery($q, $t, [$id]);
    }

}
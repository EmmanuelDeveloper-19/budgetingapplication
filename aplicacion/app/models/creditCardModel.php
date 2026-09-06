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

    public function pagarTarjeta($data)
    {
        try {
            $this->beginTransaction();

            $updateCreditLimit = "UPDATE {$this->table} SET credit_limit = credit_limit + ? WHERE id = ? AND user_id = ?";

            $queryLimitResponse = $this->preparedQuery($updateCreditLimit, "dii", [
                $data["amount"],
                $data["id"],
                $data["user_id"],
            ], false);

            $updateBalance = "UPDATE {$this->table} SET outstanding_balance = outstanding_balance - ? WHERE id = ? AND user_id = ?";

            $qBalance = $this->preparedQuery($updateBalance, "dii", [
                $data["amount"],
                $data["id"],
                $data["user_id"],
            ], false);


            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollBack();
            die($e->getMessage());
        }
    }

    public function eliminarTarjeta($idTarjeta, $idUsuario){

        $q = "DELETE FROM {$this->table} WHERE id = ? AND user_id = ?";

        $result = $this->preparedQuery($q, "ii",[
            $idTarjeta,
            $idUsuario
        ], false);
        return true;
    }
}
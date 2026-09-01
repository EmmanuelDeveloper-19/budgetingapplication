<?php

class DebitCardModel extends Db
{

    private $table = 'debit_cards';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($user_id, $data = [])
    {
        $q = "INSERT INTO debit_cards
      (user_id, bank, balance)
      VALUES (?, ?, ?)";


        return $this->preparedQuery($q, 'isd', [
            $user_id,
            $data['bank'],
            $data['balance']
        ]);
    }

    public function getByUserId($user_id)
    {
        $query = "SELECT
                id,
                bank,
                balance
              FROM {$this->table}
              WHERE user_id = ?";

        return $this->preparedSelect($query, "i", [$user_id]);
    }

    public function getById($id)
    {
        $q = "SELECT
            id,
            bank,
            balance
          FROM {$this->table}
          WHERE id = ?";

        $result = $this->preparedSelect($q, "i", [$id]);

        return $result ? $result[0] : null;
    }

    public function update($id, $data)
    {
        $q = "UPDATE {$this->table}
          SET bank = ?, bank = ?
          WHERE id = ?";

        return $this->preparedQuery($q, "sdi", [
            $data['banco'],
            $data['balance'],
            $id
        ]);
    }

    public function delete($id)
    {
        $q = "DELETE FROM {$this->table} WHERE id = ?";
        $t = 'i';

        return $this->preparedQuery($q, $t, [$id]);
    }

    public function abonarTarjeta($data){
        try{
            $this->beginTransaction();

            $query = "UPDATE {$this->table} SET balance = balance + ? WHERE id = ? AND user_id = ?";
            $result = $this->preparedQuery($query, "dii",[
                $data["amount"],
                $data["id"],
                $data["user_id"],
            ], false);

            $this->commit();
            return true;
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
    }

}


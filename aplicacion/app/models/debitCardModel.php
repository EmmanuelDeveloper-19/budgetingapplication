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
      (user_id, banco, balance)
      VALUES (?, ?, ?)";


        return $this->preparedQuery($q, 'isd', [
            $user_id,
            $data['banco'],
            $data['balance']
        ]);
    }

    public function getByUserId($user_id)
    {
        $query = "SELECT
                id,
                banco,
                balance
              FROM {$this->table}
              WHERE user_id = ?";

        return $this->preparedSelect($query, "i", [$user_id]);
    }

    public function getById($id)
    {
        $q = "SELECT
            id,
            banco,
            balance
          FROM {$this->table}
          WHERE id = ?";

        $result = $this->preparedSelect($q, "i", [$id]);

        return $result ? $result[0] : null;
    }

    public function update($id, $data)
    {
        $q = "UPDATE {$this->table}
          SET banco = ?, balance = ?
          WHERE id = ?";

        return $this->preparedQuery($q, "sdi", [
            $data['banco'],
            $data['balance'],
            $id
        ]);
    }

    public function delete($id){
        $q = "DELETE FROM {$this->table} WHERE id = ?";
        $t = 'i';

        return $this->preparedQuery($q, $t, [$id]);
    }

}


<?php

class DebtModel extends Db
{
public function getTotalDebtByUserId($user_id)
{
    $q = "  SELECT
            (
                SELECT COALESCE(SUM(amount), 0)
                FROM debts
                WHERE user_id = ?
            ) +
            (
                SELECT COALESCE(SUM(outstanding_balance), 0)
                FROM credit_cards
                WHERE user_id = ?
            ) AS total_deuda";

    $result = $this->preparedSelect(
        $q,
        "ii",
        [$user_id, $user_id]
    );

    return (float) ($result[0]['total_deuda'] ?? 0);
}
    public function createContact($data = [])
    {
        $q = "INSERT INTO contacts(name, user_id) VALUES(?,?)";

        return $this->preparedQuery($q, 'si', [
            $data['name'],
            $data['user_id']
        ]);
    }

    public function getAllContactsByUserId($user_id)
    {
        $q = "SELECT * FROM contacts WHERE user_id = ? ORDER BY name ASC";

        return $this->preparedSelect($q, "i", [$user_id]);
    }


    public function getContactWithAmount($user_id)
    {
        $q = "SELECT
            contacts.id AS contact_id,
            contacts.name AS contacto,
            COALESCE(SUM(debts.amount), 0) AS cantidad_deuda
          FROM contacts
          LEFT JOIN debts
            ON debts.contact_id = contacts.id
            AND debts.user_id = ?
          WHERE contacts.user_id = ?
          GROUP BY contacts.id, contacts.name
          ORDER BY contacts.name ASC";

        return $this->preparedSelect($q, "ii", [$user_id, $user_id]);
    }

    public function create_debt($data)
    {
        $q = "INSERT INTO debts(amount, contact_id, user_id, status, debt_date, interest, due_date)
                            VALUES(?,?,?, 'PENDING', ?,?,?)";

        return $this->preparedQuery($q, 'siisds', [
            $data['amount'],
            $data['contact_id'],
            $data['user_id'],
            $data['debt_date'],
            $data['interest'],
            $data['due_date'],
        ]);
    }


    public function getDebtsByUserId($user_id)
    {
        $q = "SELECT
            debts.id,
            contacts.name AS contacto,
            debts.amount,
            debts.user_id,
            debts.status,
            debts.debt_date,
            debts.interest,
            debts.due_date,
            debts.description
          FROM debts
          INNER JOIN contacts
            ON debts.contact_id = contacts.id
          WHERE debts.user_id = ?
          ORDER BY debts.debt_date DESC";

        return $this->preparedSelect($q, "i", [$user_id]);
    }

    public function payDebtWithCash($user_id, $debt_id)
    {

    }

    public function payDebtWithDebitCard($user_id, $debt_id, $debit_card_id)
    {

    }

    public function payDebtWithCreditCard($user_id, $debtId, $credit_card_id)
    {

    }

    public function editDebt($data, $debt_id)
    {

    }

    public function deleteDebt($debt_id)
    {
        $q = "DELETE FROM debts WHERE id = ?";

        return $this->preparedQuery($q, "i", [$debt_id]);
    }

}
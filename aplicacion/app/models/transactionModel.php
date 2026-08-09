<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class TransactionModel extends Db
{


    public function getTransactions($user_id)
    {
        $q = "SELECT    name,
                        type,
                        amount,
                        payment_method,
                        description
                FROM transactions
                WHERE user_id = ?";
        
        return $this->preparedSelect($q, "i", [$user_id]);
    }

    public function processCashTransaction($data)
    {
        try {
            $this->beginTransaction();

            $userId = $data['user_id'];
            $amount = $data['amount'];

            $qTransaction = "
            INSERT INTO transactions
            (name, type, amount, payment_method, description, user_id)
            VALUES (?, ?, ?, ?, ?, ?)
            ";

            $transaction = $this->preparedQuery(
                $qTransaction,
                "ssissi",
                $data
            );

            if ($transaction <= 0) {
                throw new Exception("No se pudo registrar la transacción");
            }

            $qUser = "
            UPDATE users
            SET balance = balance - ?
            WHERE id = ?
        ";

            $resultUser = $this->preparedQuery(
                $qUser,
                "di",
                [$amount, $userId]
            );

            if ($resultUser <= 0) {
                throw new Exception("No se pudo actualizar el balance");
            }

            $this->commit();

            return true;

        } catch (Exception $e) {
            $this->rollback();

            error_log($e->getMessage());

            return false;
        }
    }

    public function processDebitTransaction()
    {

    }

    public function processCreditTransaction()
    {

    }

    public function getBalanceUser()
    {
        $userId = $this->getCurrentUserId();

        $q = "SELECT balance FROM users WHERE id = ?";

        return $this->preparedSelect($q, "i", [$userId]);
    }
    public function getCurrentUserId()
    {
        $jwt = $_COOKIE['jwt_token'];
        $payload = JWT::decode($jwt, new Key(JWT_SECRET, 'HS256'));

        return $payload->data->user_id;
    }
}
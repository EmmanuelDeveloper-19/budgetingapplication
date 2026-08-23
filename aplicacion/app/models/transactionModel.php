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

    public function processDebitTransaction($data)
    {
        try {
            $this->beginTransaction();

            $userId = $data['user_id'];
            $amount = $data['amount'];
            $debitCardId = $data['id_debit_card'];

            /*
             * 1. Registrar la transacción
             */
            $qTransaction = "
            INSERT INTO transactions
            (
                name,
                type,
                amount,
                payment_method,
                description,
                user_id
            )
            VALUES (?, ?, ?, ?, ?, ?)
        ";

            $transactionId = $this->preparedQuery(
                $qTransaction,
                "ssdssi",
                [
                    $data['name'],
                    $data['type'],
                    $data['amount'],
                    $data['payment_method'],
                    $data['description'],
                    $data['user_id']
                ],
                true
            );

            if ($transactionId <= 0) {
                throw new Exception(
                    "No se pudo registrar la transacción"
                );
            }


            /*
             * 2. Relacionar la transacción con la tarjeta de débito
             */
            $qTransactionDebit = "
            INSERT INTO transaction_debit
            (
                transaction_id,
                debit_card_id
            )
            VALUES (?, ?)
        ";

            $this->preparedQuery(
                $qTransactionDebit,
                "ii",
                [
                    $transactionId,
                    $debitCardId
                ]
            );


            /*
             * 3. Restar el monto del saldo de la tarjeta
             */
            $qDebitCard = "
            UPDATE debit_cards
            SET balance = balance - ?
            WHERE id = ?
            AND user_id = ?
        ";

            $result = $this->preparedQuery(
                $qDebitCard,
                "dii",
                [
                    $amount,
                    $debitCardId,
                    $userId
                ]
            );

            if ($result <= 0) {
                throw new Exception(
                    "No se pudo actualizar el balance de la tarjeta"
                );
            }


            /*
             * 4. Confirmar todas las operaciones
             */
            $this->commit();

            return true;

        } catch (Exception $e) {

            $this->rollback();

            die($e->getMessage());
        }
    }
    public function processCreditTransaction($data)
    {
        try {
            $this->beginTransaction();

            $userId = $data['user_id'];
            $amount = $data['amount'];
            $debitCardId = $data['id_debit_card'];

            /*
             * 1. Registrar la transacción
             */
            $qTransaction = "
            INSERT INTO transactions
            (
                name,
                type,
                amount,
                payment_method,
                description,
                user_id
            )
            VALUES (?, ?, ?, ?, ?, ?)
        ";

            $transactionId = $this->preparedQuery(
                $qTransaction,
                "ssdssi",
                [
                    $data['name'],
                    $data['type'],
                    $data['amount'],
                    $data['payment_method'],
                    $data['description'],
                    $data['user_id']
                ],
                true
            );

            if ($transactionId <= 0) {
                throw new Exception(
                    "No se pudo registrar la transacción"
                );
            }


            /*
             * 2. Relacionar la transacción con la tarjeta de débito
             */
            $qTransactionDebit = "
            INSERT INTO transaction_credit_card
            (
                transaction_id,
                credit_card_id,
                installments,
                status,
                transaction_date
            )
            VALUES (?, ?,?,?, NOW())";

            $this->preparedQuery(
                $qTransactionDebit,
                "iiiss",
                [
                    $transactionId,
                    $debitCardId
                ]
            );


            /*
             * 3. Restar el monto del saldo de la tarjeta
             */
            $qDebitCard = "
            UPDATE credit_cards
            SET balance = balance - ?
            WHERE id = ?
            AND user_id = ?
        ";

            $result = $this->preparedQuery(
                $qDebitCard,
                "dii",
                [
                    $amount,
                    $debitCardId,
                    $userId
                ]
            );

            if ($result <= 0) {
                throw new Exception(
                    "No se pudo actualizar el balance de la tarjeta"
                );
            }


            /*
             * 4. Confirmar todas las operaciones
             */
            $this->commit();

            return true;

        } catch (Exception $e) {

            $this->rollback();

            die($e->getMessage());
        }
    }
}
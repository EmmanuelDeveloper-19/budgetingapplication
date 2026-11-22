<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class TransactionModel extends Db
{
    private $table = "transactions";

    public function getTransactions($user_id)
    {
        $q = "SELECT    name,
                        type,
                        amount,
                        payment_method,
                        description,
                        transaction_date
                FROM transactions
                WHERE user_id = ?
                AND deleted_at IS NULL
                ORDER BY transaction_date DESC";

        return $this->preparedSelect($q, "i", [$user_id]);
    }

    public function processCashTransaction($data)
    {
        try {
            $this->beginTransaction();

            $qTransaction = "
            INSERT INTO transactions
            (name, type, amount, payment_method, description, user_id)
            VALUES (?, ?, ?, ?, ?, ?)
            ";

            $transaction = $this->preparedQuery(
                $qTransaction,
                "ssissi",
                [
                    $data['name'],
                    $data['type'],
                    $data['amount'],
                    $data['payment_method'],
                    $data['description'],
                    $data['user_id']
                ]
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
                [
                    $data['amount'],
                    $data['user_id']
                ]
            );

            if ($resultUser <= 0) {
                throw new Exception("No se pudo actualizar el balance");
            }

            $this->commit();

            return true;

        } catch (Exception $e) {
            $this->rollback();
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
            $creditCard = $data['id_credit_card'];

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
                installments
            )
            VALUES (?, ?,?)";

            $this->preparedQuery(
                $qTransactionDebit,
                "iii",
                [
                    $transactionId,
                    $creditCard,
                    $data['installments']

                ]
            );


            /*
             * 3. Restar el monto del saldo de la tarjeta
             */
            $qCreditCard = "
                UPDATE credit_cards
                SET credit_limit = credit_limit - ?,
                outstanding_balance = outstanding_balance + ?
                WHERE id = ?
                AND user_id = ?";

            $result = $this->preparedQuery(
                $qCreditCard,
                "ddii",
                [
                    $amount,
                    $amount,
                    $creditCard,
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

    public function getTransactionByCreditCard($user_id){
        $q = "SELECT * FROM {$this->table} WHERE user_id = ? AND payment_method = ?";
        $t = "is";

        return $this->preparedSelect($q,$t,[$user_id, 'credit_card']);
    }

    public function processCashIncome($data){

        try {
            $this->beginTransaction();

            $q = "INSERT INTO transactions
                    (name, type, amount, payment_method, description, user_id, category)
                    VALUES(?,?,?,?,?,?,?)";

            $transaction = $this->preparedQuery(
                $q,
                "ssissis",
                [
                    $data['name'],
                    'INCOME',
                    $data['amount'],
                    'CASH',
                    $data['description'],
                    $data['user_id'],
                    $data['category']
                ]
            );

            if($transaction <= 0){
                throw new Exception("No se pudo procesar la solicitud");
            }

            $qUser = "UPDATE users SET balance = balance + ? WHERE id = ?";

            $result = $this->preparedQuery(
                $qUser,
                "di",
                [
                    $data['amount'],
                    $data['user_id']
                ]
            );

            $this->commit();
            return true;
        } catch(Exception $e){
            $this->rollback();
            return false;
        }
    }

    public function processDebitCardIncome($data){

        try {
            $this->beginTransaction();

            $q = "INSERT INTO transactions(name, type, amount, payment_method, description, user_id, category)
                    VALUES(?,?,?,?,?,?,?)";

            $transaction = $this->preparedQuery($q, "ssissis",[
                $data['name'],
                'INCOME',
                $data['amount'],
                'DEBIT_CARD',
                $data['description'],
                $data['user_id'],
                $data['category']
            ]);

            if($transaction <= 0){
                throw new Exception("No se pudo procesar la solicitud");
            }

            $qUser = "UPDATE debit_cards SET balance = balance + ? WHERE id = ? AND user_id = ?";

            $result = $this->preparedQuery($qUser, "dii", [
                $data['amount'],
                $data['id_debit_card'],
                $data['user_id']
            ]);
            
            if($result <= 0){
                throw new Exception("No se pudo actualizar el balance de la tarjeta");
            }

            $this->commit();
            return true;
        } catch(Exception $e){
            $this->rollback();
            return false;
        }
    }
}
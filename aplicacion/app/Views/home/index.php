<?php require_once INCLUDES . '/components/modalComponent.php'; ?>

<div class="row column-reverse">
    <div class="col-md-3">
        <div class="content">
            <div class="texto-resaltado">
                <p>Patrimonio neto</p>
            </div>
            <?php

            $saldoTarjetas = 0;

            foreach ($data['debitCards'] as $card) {
                $saldoTarjetas += $card['balance'];
            }

            $saldoTotal = $data['user']['balance'] + $saldoTarjetas;
            ?>
            <h1 class="title">$
                <?=
                    $saldoTotal
                    ?>
            </h1>
        </div>
        <!-- A futuro-->
        <?php //require_once("accounts.php"); ?>

        <?php require_once("credit-cards.php"); ?>
        <?php require_once("debit-cards.php"); ?>
    </div>
    <div class="col-md-9">
        <div class="content">
            <div class="row space-between">
                <div class="texto-resaltado">
                    <p>Transacciones</p>
                </div>
                <a href="<?= PATH . 'transactionController/create'; ?>" class="btn btn-primary">
                    Agregar movimiento
                </a>
            </div>
            <?php include("transaction-list.php"); ?>
        </div>
    </div>
</div>
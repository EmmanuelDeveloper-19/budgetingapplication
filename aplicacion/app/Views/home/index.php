<div class="row dr-flex-column">
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
            <h1>$
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
            <div class="row dr-flex-column space-between gap-10">
                <div class="texto-resaltado">
                    <p>Transacciones</p>
                </div>
                <a href="" class="btn btn-secondary">
                    Agregar transacción
                </a>
            </div>
            <?php
            include("transaction-list.php"); ?>
        </div>
    </div>
</div>
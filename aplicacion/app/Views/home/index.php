<?php require_once INCLUDES . '/components/modalComponent.php'; ?>

<div class="row column-reverse">
    <div class="col-md-3">
        <div class="content flex-start">
            <div class="capsule">
                <p>Patrimonio neto</p>
            </div>
            <?php

            $saldoTarjetas = 0;

            foreach ($data['debitCards'] as $card) {
                $saldoTarjetas += $card['balance'];
            }

            $saldoTotal = $data['user']['balance'] + $saldoTarjetas;


            function diasHastaSabado()
            {
                $diaActual = (int) date('N'); // Lunes=1 ... Sábado=6, Domingo=7
            
                return (6 - $diaActual + 7) % 7;
            }

            ?>
            <h1 class="text-primary">$
                <?=
                    $saldoTotal
                    ?>
            </h1>
            <p>Próximo pago en <?= diasHastaSabado(); ?> días</p>
            <a class="link-muted" href="<?= PATH . 'transactionController/newIncome';?>">Añadir nuevo ingreso</a>
        </div>
        <!-- A futuro-->
        <?php //require_once("accounts.php"); ?>

        <?php require_once("credit-cards.php"); ?>
        <?php require_once("debit-cards.php"); ?>
    </div>
    <div class="col-md-9">
        <div class="content">
            <div class="row space-between align-center">
                <div class="capsule">
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
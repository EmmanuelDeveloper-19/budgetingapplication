<?php require_once INCLUDES . '/components/modalComponent.php'; ?>

<div class="row column-reverse">
    <div class="col-md-3 gap-10">
        <div class="card content flex-start">

            <div class="capsule">
                <p>Patrimonio neto</p>
            </div>

            <?php
            $saldoTarjetas = 0;

            foreach ($data['debitCards'] as $card) {
                $saldoTarjetas += $card['balance'];
            }

            $saldoTotal = $data['user']['balance'] + $saldoTarjetas;

            $today = new DateTime();

            $actually_day = (int) $today->format('d');

            if ($actually_day < 15) {
                $nextPay = new DateTime($today->format('Y-m-15'));
            } else if ($actually_day < 30) {
                $nextPay = new DateTime(
                    $today->format('Y-m-t')
                );
            } else {
                $nextPay = new DateTime('first day of next month');
                $nextPay->setDate(
                    (int) $nextPay->format('Y'),
                    (int) $nextPay->format('M'),
                    15
                );
            }

            $month = [
                1 => 'enero',
                2 => 'febrero',
                3 => 'marzo',
                4 => 'abril',
                5 => 'mayo',
                6 => 'junio',
                7 => 'julio',
                8 => 'agosto',
                9 => 'septiembre',
                10 => 'octubre',
                11 => 'noviembre',
                12 => 'diciembre'
            ];

            $paymentDay = $nextPay->format('d') . ' de ' . $month[(int) $nextPay->format('m')];
            ?>

            <h1 class="text-primary">
                $<?= number_format($saldoTotal, 2) ?>
            </h1>

            <div class="next-payment">
                <i class="fa-solid fa-calendar"></i>
                <span>Próximo pago:</span>
                <strong><?= $paymentDay ?></strong>
            </div>

            <a class="link-muted" href="<?= PATH . 'transactionController/newIncome'; ?>">
                Añadir nuevo ingreso
            </a>

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
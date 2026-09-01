<?php
$meses = [
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
?>

<?php if (empty($data['transactions'])): ?>

    <div class="empty-state">
        <p>No hay transacciones realizadas</p>
    </div>

<?php else: ?>

    <div class="transaction-list">

        <?php
        $fechaActual = null;
        ?>

        <?php foreach ($data['transactions'] as $t): ?>

            <?php
            $fechaTimestamp = strtotime($t['transaction_date']);

            $fecha = date('Y-m-d', $fechaTimestamp);

            if ($fecha !== $fechaActual):
                $fechaActual = $fecha;

                $dia = date('d', $fechaTimestamp);
                $mes = $meses[(int) date('m', $fechaTimestamp)];
                $anio = date('Y', $fechaTimestamp);
            ?>

                <div class="transaction-date">
                    <?= $dia . ' de ' . $mes . ' de ' . $anio; ?>
                </div>

            <?php endif; ?>

            <?php
            $isExpense = $t['amount'] < 0;
            $amountClass = $isExpense ? 'expense' : 'income';
            $sign = $isExpense ? '-' : '+';
            ?>

            <div class="transaction-card">

                <div class="transaction-info">

                    <p class="transaction-name">
                        <?= htmlspecialchars($t['name']); ?>
                    </p>

                    <p class="transaction-description">
                        <?= htmlspecialchars($t['description']); ?>
                    </p>

                </div>

                <span class="transaction-amount <?= $amountClass; ?>">
                    <?= $sign; ?>$<?= number_format(abs($t['amount']), 2); ?>
                </span>

            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>
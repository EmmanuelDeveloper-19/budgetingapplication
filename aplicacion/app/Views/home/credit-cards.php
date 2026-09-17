<div class="content flex-start">

    <div class="capsule">
        <p>Tarjetas de crédito</p>
    </div>
    <?php if (empty($data['creditCards'])): ?>

        <div class="empty-state">
            <p>No hay tarjetas de crédito agregadas</p>
            <a href="<?= PATH . 'creditCardController/nuevo'; ?>" class="link-muted">Agregar una nueva tarjeta</a>
        </div>

    <?php else: ?>

        <div class="list-items" id="creditCardsList">

            <?php foreach ($data['creditCards'] as $c): ?>

                <?php
                $saldo = $c['outstanding_balance'];
                $limite = $c['credit_limit'];
                ?>

                <div class="card-item" data-id="<?= $c['id']; ?>" data-bank="<?= htmlspecialchars($c['bank']); ?>"
                    data-closing="<?= htmlspecialchars($c['statement_closing_date']); ?>"
                    data-payment="<?= htmlspecialchars($c['payment_date']); ?>" data-limit="<?= $limite; ?>"
                    data-balance="<?= $saldo; ?>">

                    <div class="card-bank">
                        <img class="img-icon" src="<?= PATH . 'assets/' . $c['bank'] . '.png'; ?>" alt="">
                        <p><?= $c['bank']; ?></p>
                    </div>

                    <div class="card-amounts">
                        <div class="amount debt">
                            <p>-$<?= number_format($saldo, 2); ?></p>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <a href="<?= PATH . 'creditCardController/index';?>" class="link-muted">
            Administrar tarjetas de crédito
        </a>
    <?php endif; ?>



</div>
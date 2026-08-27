<div class="content">

    <p class="texto-resaltado">Tarjetas de crédito</p>

    <?php if (empty($data['creditCards'])): ?>

        <div class="empty-state">
            <p>No hay tarjetas de crédito agregadas</p>
        </div>

    <?php else: ?>

        <div class="credit-cards-list">

            <?php foreach ($data['creditCards'] as $c): ?>

                <?php
                    $saldo = $c['outstanding_balance'];
                    $limite = $c['credit_limit'];
                ?>

                <div class="credit-card-item">

                    <!-- Banco -->
                    <div class="card-bank">
                        <img
                            class="img-icon"
                            src="<?= PATH . 'assets/' . $c['bank'] . '.png'; ?>"
                            alt=""
                        >

                        <strong><?= $c['bank']; ?></strong>
                    </div>

                    <!-- Montos -->
                    <div class="card-amounts">

                        <div class="amount debt">
                            <strong>
                                -$<?= number_format($saldo, 2); ?>
                            </strong>
                        </div>

                        <div class="amount limit">
                            <strong>
                                $<?= number_format($limite, 2); ?>
                            </strong>
                        </div>

                    </div>

                    <!-- Opciones -->
                    <div class="menu-opciones">

                        <button class="menu-btn">⋮</button>

                        <div class="menu-dropdown">

                            <a href="<?= PATH . 'creditCardController/editView/' . $c['id']; ?>">
                                Actualizar
                            </a>

                            <a
                                href="<?= PATH . 'creditCardController/eliminar/' . $c['id']; ?>"
                                class="danger"
                            >
                                Eliminar
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <a
        href="<?= PATH . 'creditCardController/nuevo'; ?>"
        class="link_add"
    >
        Agregar tarjeta de crédito
    </a>

</div>
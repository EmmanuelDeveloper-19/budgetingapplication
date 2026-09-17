<div class="content flex-start">

    <div class="capsule">
        <p>Tarjetas de débito</p>
    </div>
    <?php if (empty($data['debitCards'])): ?>

        <div class="empty-state">
            <p>No hay tarjetas de débito agregadas</p>
            <a class="link-muted" href="<?= PATH . 'debitCardController/nuevo'; ?>">Agregar nueva tarjeta</a>
        </div>

    <?php else: ?>

        <div class="list-items" id="debitCardsList">

            <?php foreach ($data['debitCards'] as $d): ?>

                <div class="card-item" data-id="<?= htmlspecialchars($d['id']); ?>"
                    data-balance="<?= htmlspecialchars($d['balance']); ?>">

                    <!-- Banco -->
                    <div class="card-bank">

                        <img class="img-icon" src="<?= PATH . 'assets/' . htmlspecialchars($d['bank']) . '.png'; ?>" alt="">

                        <p>
                            <?= htmlspecialchars(ucfirst($d['bank'])); ?>
                        </p>
                    </div>


                    <!-- Balance -->
                    <div class="card-amounts">

                        <div class="amount debt">

                            <p>
                                $<?= number_format($d['balance'], 2); ?>
                            </p>

                        </div>

                    </div>




                </div>

            <?php endforeach; ?>

        </div>
        <!-- AGREGAR TARJETA -->
        <a href="" class="link-muted">
            Administrar tarjetas
        </a>

    <?php endif; ?>



</div>
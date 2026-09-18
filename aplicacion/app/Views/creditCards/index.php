<div class="content">

    <div class="row">

        <!-- TARJETAS -->
        <div class="col-md-6">

            <div class="section-header">
                <div>
                    <h1 class="text-heading">Mis tarjetas</h1>
                    <p class="text-muted">
                        Resumen de tus tarjetas de crédito
                    </p>
                </div>
            </div>

            <div class="credit-card-list">

                <?php if (empty($data['creditCards'])): ?>

                    <div class="empty-state glass-panel">
                        <i class="fa-regular fa-credit-card"></i>
                        <p>No hay tarjetas de crédito agregadas</p>
                    </div>

                <?php else: ?>

                    <?php foreach ($data['creditCards'] as $c): ?>

                        <div class="credit-card glass-panel">

                            <!-- HEADER -->
                            <div class="credit-card-header">

                                <div class="credit-card-bank">

                                    <img class="img-icon-md" src="<?= PATH . 'assets/' . $c['bank'] . '.png'; ?>" alt="">

                                    <div>
                                        <span class="card-label">
                                            Tarjeta de crédito
                                        </span>

                                        <p class="credit-card-bank-name">
                                            <?= $c['bank']; ?>
                                        </p>
                                    </div>

                                </div>

                                <div class="card-options-wrapper">
                                    <button class="btn-icon card-options-btn" type="button" aria-label="Opciones">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>

                                    <div class="card-options-menu">
                                        <button type="button" class="card-option">
                                            <i class="fa-solid fa-money-bill-wave"></i>
                                            <span>Pagar tarjeta</span>
                                        </button>

                                        <button type="button" class="card-option">
                                            <i class="fa-solid fa-pen"></i>
                                            <span>Editar tarjeta</span>
                                        </button>

                                        <button type="button" class="card-option card-option-warning">
                                            <i class="fa-solid fa-ban"></i>
                                            <span>Cancelar tarjeta</span>
                                        </button>

                                        <button type="button" class="card-option card-option-danger">
                                            <i class="fa-solid fa-trash"></i>
                                            <span>Eliminar tarjeta</span>
                                        </button>
                                    </div>
                                </div>

                            </div>


                            <!-- SALDO -->
                            <div class="credit-card-balance">

                                <span class="card-label">
                                    Saldo
                                </span>

                                <strong>
                                    -$<?= number_format($c['outstanding_balance'], 2); ?>
                                </strong>

                            </div>


                            <!-- INFORMACIÓN -->
                            <div class="credit-card-info">

                                <div class="credit-card-stat">
                                    <span class="card-label">
                                        Disponible
                                    </span>

                                    <strong>
                                        $7,550.00
                                    </strong>
                                </div>


                                <div class="credit-card-stat">
                                    <span class="card-label">
                                        Límite
                                    </span>

                                    <strong>
                                        $<?= number_format($c['credit_limit'], 2); ?>
                                    </strong>
                                </div>

                            </div>


                            <!-- FECHAS -->
                            <div class="credit-card-dates">

                                <div>
                                    <span>Corte</span>
                                    <strong>15 SEP</strong>
                                </div>

                                <div>
                                    <span>Pago</span>
                                    <strong>30 SEP</strong>
                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>
                <?php endif;?>

            </div>

        </div>

<div class="col-md-6">

    <div class="section-header">
        <div>
            <h1 class="text-heading">
                Compras con tarjeta
            </h1>

            <p class="text-muted">
                Movimientos recientes
            </p>
        </div>
    </div>


    <div class="transaction-list">

        <?php if (empty($data['transactions'])): ?>

            <div class="transaction-card glass-panel">
                <p>
                    No hay transacciones hechas con tarjeta de crédito
                </p>
            </div>

        <?php else: ?>

            <?php foreach ($data['transactions'] as $t): ?>

                <div class="transaction-card glass-panel">

                    <div class="transaction-icon">
                        <i class="fa-solid fa-receipt"></i>
                    </div>

                    <div class="transaction-info">

                        <p class="transaction-name">
                            <?=$t['name'];?>
                        </p>

                        <span class="transaction-date">
                            Hoy
                        </span>

                    </div>

                    <strong class="transaction-amount">
                        -$200.00
                    </strong>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>

    </div>

</div>

<script>
    document.querySelectorAll('.card-options-btn').forEach(button => {

        button.addEventListener('click', function (event) {

            event.stopPropagation();

            const wrapper = this.closest('.card-options-wrapper');

            const isOpen = wrapper.classList.contains('is-open');

            // Cerrar todos los demás menús
            document
                .querySelectorAll('.card-options-wrapper')
                .forEach(item => {
                    item.classList.remove('is-open');

                    const btn = item.querySelector('.card-options-btn');

                    if (btn) {
                        btn.setAttribute('aria-expanded', 'false');
                    }
                });

            // Abrir este si estaba cerrado
            if (!isOpen) {
                wrapper.classList.add('is-open');

                this.setAttribute('aria-expanded', 'true');
            }

        });

    });


    /* Cerrar al hacer clic fuera */

    document.addEventListener('click', function () {

        document
            .querySelectorAll('.card-options-wrapper')
            .forEach(wrapper => {

                wrapper.classList.remove('is-open');

                const button = wrapper.querySelector('.card-options-btn');

                if (button) {
                    button.setAttribute('aria-expanded', 'false');
                }

            });

    });
</script>
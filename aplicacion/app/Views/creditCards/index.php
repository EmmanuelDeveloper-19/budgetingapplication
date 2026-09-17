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

                                    <img
                                        class="img-icon-md"
                                        src="<?= PATH . 'assets/' . $c['bank'] . '.png'; ?>"
                                        alt=""
                                    >

                                    <div>
                                        <span class="card-label">
                                            Tarjeta de crédito
                                        </span>

                                        <p class="credit-card-bank-name">
                                            <?= $c['bank']; ?>
                                        </p>
                                    </div>

                                </div>

                                <button
                                    class="btn-icon"
                                    type="button"
                                    aria-label="Opciones"
                                >
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

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

                <?php endif; ?>

            </div>

        </div>


        <!-- COMPRAS -->
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

                <div class="transaction-card glass-panel">

                    <div class="transaction-icon">
                        <i class="fa-solid fa-receipt"></i>
                    </div>

                    <div class="transaction-info">

                        <p class="transaction-name">
                            Netflix
                        </p>

                        <span class="transaction-date">
                            Hoy
                        </span>

                    </div>

                    <strong class="transaction-amount">
                        -$200.00
                    </strong>

                </div>


                <div class="transaction-card glass-panel">

                    <div class="transaction-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>

                    <div class="transaction-info">

                        <p class="transaction-name">
                            Amazon
                        </p>

                        <span class="transaction-date">
                            Hace 2 días
                        </span>

                    </div>

                    <strong class="transaction-amount">
                        -$850.00
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>
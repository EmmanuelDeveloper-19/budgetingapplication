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

                <div class="credit-card-item" onclick="abrirModalTarjeta(this)" data-id="<?= $c['id']; ?>"
                    data-bank="<?= htmlspecialchars($c['bank']); ?>"
                    data-closing="<?= htmlspecialchars($c['statement_closing_date']); ?>"
                    data-payment="<?= htmlspecialchars($c['payment_date']); ?>" data-limit="<?= $c['credit_limit']; ?>"
                    data-balance="<?= $c['outstanding_balance']; ?>">
                    <div class="card-bank">
                        <img class="img-icon" src="<?= PATH . 'assets/' . $c['bank'] . '.png'; ?>" alt="">

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

                        <button type="button" class="menu-btn" onclick="event.stopPropagation()">
                            ⋮
                        </button>

                        <div class="menu-dropdown">

                            <a href="<?= PATH . 'creditCardController/editView/' . $c['id']; ?>"
                                onclick="event.stopPropagation()">
                                Actualizar
                            </a>

                            <a href="<?= PATH . 'creditCardController/eliminar/' . $c['id']; ?>" class="danger"
                                onclick="event.stopPropagation()">
                                Eliminar
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

    <a href="<?= PATH . 'creditCardController/nuevo'; ?>" class="link_add">
        Agregar tarjeta de crédito
    </a>

</div>


<div class="modal" id="cardModal">

    <div class="modal-body">

        <button
            type="button"
            class="modal-close"
            onclick="cerrarModalTarjeta()"
        >
            ×
        </button>

        <h2 id="modalBank"></h2>

        <div class="modal-info">

            <p>
                <strong>ID:</strong>
                <span id="modalId"></span>
            </p>

            <p>
                <strong>Banco:</strong>
                <span id="modalBankInfo"></span>
            </p>

            <p>
                <strong>Fecha de corte:</strong>
                <span id="modalClosing"></span>
            </p>

            <p>
                <strong>Fecha de pago:</strong>
                <span id="modalPayment"></span>
            </p>

            <p>
                <strong>Límite de crédito:</strong>
                $<span id="modalLimit"></span>
            </p>

            <p>
                <strong>Saldo pendiente:</strong>
                $<span id="modalBalance"></span>
            </p>

            <p>
                <strong>Crédito disponible:</strong>
                $<span id="modalAvailable"></span>
            </p>

        </div>

    </div>

</div>

<script>

function abrirModalTarjeta(card) {

    const id = card.dataset.id;
    const bank = card.dataset.bank;
    const closing = card.dataset.closing;
    const payment = card.dataset.payment;

    const limit = parseFloat(card.dataset.limit) || 0;
    const balance = parseFloat(card.dataset.balance) || 0;

    const available = limit - balance;

    document.getElementById('modalId').textContent = id;

    document.getElementById('modalBank').textContent = bank;

    document.getElementById('modalBankInfo').textContent = bank;

    document.getElementById('modalClosing').textContent = closing;

    document.getElementById('modalPayment').textContent = payment;

    document.getElementById('modalLimit').textContent =
        limit.toLocaleString('es-MX', {
            minimumFractionDigits: 2
        });

    document.getElementById('modalBalance').textContent =
        balance.toLocaleString('es-MX', {
            minimumFractionDigits: 2
        });

    document.getElementById('modalAvailable').textContent =
        available.toLocaleString('es-MX', {
            minimumFractionDigits: 2
        });

    document.getElementById('cardModal').classList.add('active');
}


function cerrarModalTarjeta() {

    document
        .getElementById('cardModal')
        .classList.remove('active');

}

</script>
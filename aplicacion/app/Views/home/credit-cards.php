<div class="content">

    <p class="texto-resaltado">Tarjetas de crédito</p>

    <?php if (empty($data['creditCards'])): ?>

        <div class="empty-state">
            <p>No hay tarjetas de crédito agregadas</p>
        </div>

    <?php else: ?>

        <div class="credit-cards-list" id="creditCardsList">

            <?php foreach ($data['creditCards'] as $c): ?>

                <?php
                $saldo = $c['outstanding_balance'];
                $limite = $c['credit_limit'];
                ?>

                <div class="credit-card-item" data-id="<?= $c['id']; ?>" data-bank="<?= htmlspecialchars($c['bank']); ?>"
                    data-closing="<?= htmlspecialchars($c['statement_closing_date']); ?>"
                    data-payment="<?= htmlspecialchars($c['payment_date']); ?>" data-limit="<?= $limite; ?>"
                    data-balance="<?= $saldo; ?>">

                    <div class="card-bank">
                        <img class="img-icon" src="<?= PATH . 'assets/' . $c['bank'] . '.png'; ?>" alt="">
                        <strong><?= $c['bank']; ?></strong>
                    </div>

                    <div class="card-amounts">
                        <div class="amount debt">
                            <strong>-$<?= number_format($saldo, 2); ?></strong>
                        </div>
                        <div class="amount limit">
                            <strong>$<?= number_format($limite, 2); ?></strong>
                        </div>
                    </div>

                    <div class="menu-opciones">
                        <button type="button" class="menu-btn" data-no-modal>⋮</button>
                        <div class="menu-dropdown">
                            <a 
                            href="#" 
                            class="update-card-btn"
                            data-id="<?= $c['id']; ?>" 
                            data-balance="<?= $saldo; ?>"
                            data-no-modal>
                                Agregar pago
                            </a>
                            <a href="<?= PATH . 'creditCardController/editView/' . $c['id'];?>" data-no-modal>
                                Actualizar datos
                            </a>
                            <a href="<?= PATH . 'creditCardController/delete/' . $c['id']; ?>" class="danger" data-no-modal>
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

<div class="modal" id="updateModal">
    <?php include(VIEWS . "components/modal/pagarTarjeta.php"); ?>
</div>

<div class="modal" id="cardModal">
    <div class="modal-body">

        <button type="button" class="modal-close" id="modalClose">×</button>

        <div class="modal-header">
            <img class="modal-bank-icon" id="modalBankIcon" src="" alt="">
            <h2 id="modalBank"></h2>
        </div>

        <div class="modal-amounts">
            <div class="amount debt">
                <span>Saldo</span>
                <strong id="modalBalance"></strong>
            </div>
            <div class="amount limit">
                <span>Disponible</span>
                <strong id="modalAvailable"></strong>
            </div>
        </div>

        <div class="credit-progress">
            <div class="credit-progress-bar">
                <div class="credit-progress-fill" id="modalProgressFill"></div>
            </div>
            <span class="credit-progress-label" id="modalProgressLabel"></span>
        </div>

        <div class="modal-dates">
            <div>
                <span>Fecha de corte</span>
                <strong id="modalClosing"></strong>
            </div>
            <div>
                <span>Fecha de pago</span>
                <strong id="modalPayment"></strong>
            </div>
        </div>

        <p class="modal-limit-total">
            Límite total: <strong id="modalLimit"></strong>
        </p>

    </div>
</div>

<script>
    const ASSETS_PATH = "<?= PATH . 'assets/'; ?>";
    const PATH_URL = "<?= PATH; ?>";

    (function () {
        const list = document.getElementById('creditCardsList');
        const cardModal = document.getElementById('cardModal');
        const updateModal = document.getElementById('updateModal');

        function formatoMoneda(valor) {
            return '$' + valor.toLocaleString('es-MX', { minimumFractionDigits: 2 });
        }

        function abrirModalInfo(card) {
            const bank = card.dataset.bank;
            const closing = card.dataset.closing;
            const payment = card.dataset.payment;
            const limit = parseFloat(card.dataset.limit) || 0;
            const balance = parseFloat(card.dataset.balance) || 0;
            const available = limit - balance;
            const porcentaje = limit > 0 ? Math.min(100, Math.max(0, Math.round((balance / limit) * 100))) : 0;

            document.getElementById('modalBank').textContent = bank;
            document.getElementById('modalBankIcon').src = ASSETS_PATH + bank + '.png';
            document.getElementById('modalClosing').textContent = closing;
            document.getElementById('modalPayment').textContent = payment;
            document.getElementById('modalLimit').textContent = formatoMoneda(limit);
            document.getElementById('modalBalance').textContent = formatoMoneda(balance);
            document.getElementById('modalAvailable').textContent = formatoMoneda(available);

            const fill = document.getElementById('modalProgressFill');
            fill.style.width = porcentaje + '%';
            fill.classList.remove('nivel-bajo', 'nivel-medio', 'nivel-alto');
            fill.classList.add(porcentaje >= 80 ? 'nivel-alto' : porcentaje >= 50 ? 'nivel-medio' : 'nivel-bajo');
            document.getElementById('modalProgressLabel').textContent = porcentaje + '% del límite usado';

            cardModal.classList.add('active');
        }

        function abrirModalPago(btn) {

            const cardId = btn.dataset.id;

            const form = document.getElementById('pagarTarjetaForm');

            form.action = PATH_URL
                + 'creditCardController/abonarTarjeta/'
                + cardId;

            updateModal.classList.add('active');
        }

        function cerrarModales() {
            document.querySelectorAll('.modal.active').forEach(m => m.classList.remove('active'));
        }

        list.addEventListener('click', (e) => {
            const updateBtn = e.target.closest('.update-card-btn');
            if (updateBtn) {
                e.preventDefault();       // evita el salto de página del href="#"
                abrirModalPago(updateBtn);
                return;
            }

            if (e.target.closest('[data-no-modal]')) return;

            const item = e.target.closest('.credit-card-item');
            if (!item) return;

            abrirModalInfo(item);
        });

        // Cierre genérico: sirve para AMBOS modales, no solo cardModal
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) cerrarModales();
            });
        });

        document.addEventListener('click', (e) => {
            if (e.target.closest('.modal-close')) cerrarModales();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') cerrarModales();
        });
    })();
</script>
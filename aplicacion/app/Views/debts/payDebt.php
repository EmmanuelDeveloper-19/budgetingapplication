
<dialog id="modal-pay" class="app-modal">
    <form id="form-pay" method="POST"
          action="<?= PATH . 'debtController/payDebt' ?>">

        <div class="modal-header">
            <div>
                <h2>Pagar deuda</h2>
                <p>Registra un pago para esta deuda.</p>
            </div>

            <button type="button" class="modal-close"
                    data-close-modal aria-label="Cerrar">
                &times;
            </button>
        </div>

        <div class="modal-body">
            <input type="hidden" name="debt_id" id="pay-debt-id">

            <div class="field-group">
                <label>Contacto</label>
                <p id="pay-contact"></p>
            </div>

            <div class="field-group">
                <label>Deuda original</label>
                <p id="pay-original-amount"></p>
            </div>

            <div class="field-group">
                <label for="pay-amount">Cantidad a pagar</label>
                <input
                    class="field-control"
                    type="number"
                    id="pay-amount"
                    name="amount"
                    min="0.01"
                    step="0.01"
                    required>
            </div>

            <div class="field-group">
                <label for="pay-date">Fecha del pago</label>
                <input
                    class="field-control"
                    type="date"
                    id="pay-date"
                    name="payment_date"
                    required>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                    data-close-modal>
                Cancelar
            </button>

            <button type="submit" class="btn btn-primary">
                Registrar pago
            </button>
        </div>
    </form>
</dialog>

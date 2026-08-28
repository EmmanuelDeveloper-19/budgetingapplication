<div class="content">
    <div class="row d-flex settings-wrapper justify-center align-center">
        <div class="col-md-6">
            <div class="card mb-10">
                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger">
                        <?= $data['error'] ?>
                    </div>
                <?php endif; ?>
                <h1 class="title">Registrar nueva transacción</h1>

                <form action="<?= PATH . 'transactionController/store'; ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $data['old']['id'] ?? '' ?>" required>

                    <div class="form-group">
                        <label class="form-label">Nombre de la transacción</label>
                        <input type="text" class="form-control" placeholder="Ej. Pago de internet, Netflix, Gasolina"
                            name="name">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Categoría</label>
                        <select class="form-control" name="type">
                            <option value="">Selecciona una categoría</option>
                            <option value="Servicios">Servicios</option>
                            <option value="Subscripciones">Suscripciones</option>
                            <option value="Deudas">Deudas</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Método de pago</label>
                        <div class="payment-methods">

                            <!-- Efectivo -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash" checked
                                    onchange="changePaymentMethod(this.value)">
                                <span>Efectivo</span>
                            </label>

                            <!-- Tarjeta de crédito -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="credit_card"
                                    onchange="changePaymentMethod(this.value)">
                                <span>Tarjeta de Crédito</span>
                            </label>

                            <!-- Tarjeta de débito -->
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="debit_card"
                                    onchange="changePaymentMethod(this.value)">
                                <span>Débito</span>
                            </label>

                        </div>
                    </div>

                    <!-- Tarjetas de crédito -->
                    <div id="credit-card-container" class="form-group" style="display: none;">
                        <label class="form-label">Tarjeta de crédito</label>

                        <select class="form-control" name="credit_card_id">
                            <option value="">Seleccione una tarjeta</option>

                            <?php if (empty($data['creditCards'])): ?>

                                <option value="" disabled>
                                    No hay tarjetas de crédito agregadas
                                </option>

                            <?php else: ?>

                                <?php foreach ($data['creditCards'] as $d): ?>

                                    <option value="<?= $d['id']; ?>">
                                        <?= $d['bank']; ?>
                                    </option>

                                <?php endforeach; ?>

                            <?php endif; ?>
                        </select>
                    </div>

                    <div id="installments-container" class="form-group" style="display: none;">
                        <label for="" class="form-label">Meses</label>
                        <input type="number" class="form-control" name="installments" value="1" min="1" step="1">
                    </div>


                    <!-- Tarjetas de débito -->
                    <div id="debit-card-container" class="form-group" style="display: none;">
                        <label class="form-label">Tarjeta de débito</label>

                        <select class="form-control" name="debit_card_id">
                            <option value="">Seleccione una tarjeta</option>

                            <?php if (empty($data['debitCards'])): ?>

                                <option value="" disabled>
                                    No hay tarjetas de débito agregadas
                                </option>

                            <?php else: ?>

                                <?php foreach ($data['debitCards'] as $d): ?>

                                    <option value="<?= $d['id']; ?>">
                                        <?= $d['bank']; ?>
                                    </option>

                                <?php endforeach; ?>

                            <?php endif; ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label class="form-label">Monto</label>
                        <input type="number" class="form-control" placeholder="Ej. 350.00" name="amount" step="0.01"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Descripción (opcional)</label>
                        <textarea class="form-control" rows="4"
                            placeholder="Agrega un comentario o detalle de la transacción"
                            name="description"></textarea>
                    </div>

                    <div class="action-buttons mt-3">
                        <button type="submit" class="btn btn-primary">
                            Guardar transacción
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function changePaymentMethod(method) {

        const creditCardContainer = document.getElementById('credit-card-container');
        const debitCardContainer = document.getElementById('debit-card-container');
        const installmentsContainer = document.getElementById('installments-container');

        // Ocultar ambos inicialmente
        creditCardContainer.style.display = 'none';
        debitCardContainer.style.display = 'none';
        installmentsContainer.style.display = 'none';

        // Mostrar según el método seleccionado
        if (method === 'credit_card') {
            creditCardContainer.style.display = 'block';
            installmentsContainer.style.display = 'block';
        }

        if (method === 'debit_card') {
            debitCardContainer.style.display = 'block';
        }
    }
</script>
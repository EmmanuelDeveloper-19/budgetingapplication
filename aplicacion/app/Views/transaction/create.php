<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card bg-white">

                <?php if (isset($data['error'])): ?>
                    <div class="glass-alert">
                        <?= $data['error'] ?>
                    </div>
                <?php endif; ?>

                <h1 class="text-heading">Registrar nueva transacción</h1>
                <p class="text-secondary">Captura el movimiento y elige cómo lo pagaste o de dónde vino.</p>

                <form class="form" action="<?= PATH . 'transactionController/store'; ?>" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data['old']['id'] ?? '') ?>">

                    <!-- Tipo de movimiento -->
                    <div class="form-field">
                        <span class="form-label" id="label-type-transaction">Tipo de movimiento</span>
                        <div class="form-choice-group" role="radiogroup" aria-labelledby="label-type-transaction">
                            <label class="form-choice">
                                <input class="form-choice__input" type="radio" name="type-transaction" value="expense"
                                    checked onchange="changeTransactionType(this.value)">
                                <span class="form-choice__text">Gasto</span>
                            </label>
                            <label class="form-choice">
                                <input class="form-choice__input" type="radio" name="type-transaction" value="income"
                                    onchange="changeTransactionType(this.value)">
                                <span class="form-choice__text">Ingreso</span>
                            </label>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="form-field">
                        <label class="form-label" for="transaction-name">Nombre de la transacción</label>
                        <input type="text" id="transaction-name" class="form-input" name="name" required
                            placeholder="Ej. Pago de internet, Netflix, Gasolina">
                    </div>

                    <!-- Monto -->
                    <div class="form-field">
                        <label class="form-label" for="amount">Monto</label>
                        <div class="form-input-group">
                            <span class="form-input-group__addon" aria-hidden="true">$</span>
                            <input type="number" name="amount" id="amount" class="form-input form-input-group__control"
                                inputmode="decimal" min="0.01" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>

                    <!-- ==================== SECCIÓN: GASTO ==================== -->
                    <div id="expense-section" class="form-section">
                        <div class="form-section__header">
                            <h2 class="form-section__title">Detalles del gasto</h2>
                            <p class="form-section__description">Elige la categoría y cómo lo pagaste.</p>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="expense-category">Categoría del gasto</label>
                            <select class="form-select" name="type" id="expense-category" required>
                                <option value="">Selecciona una categoría</option>
                                <option value="Vivienda">Vivienda</option>
                                <option value="Servicios">Servicios</option>
                                <option value="Mantenimiento">Mantenimiento</option>
                                <option value="Alimentación">Alimentación</option>
                                <option value="Supermercado">Supermercado</option>
                                <option value="Comida fuera">Comida fuera</option>
                                <option value="Snacks y antojos">Snacks y antojos</option>
                                <option value="Transporte">Transporte</option>
                                <option value="Transporte público">Transporte público</option>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Estacionamiento">Estacionamiento</option>
                                <option value="Entretenimiento">Entretenimiento</option>
                                <option value="Suscripciones">Suscripciones</option>
                                <option value="Videojuegos">Videojuegos</option>
                                <option value="Salidas">Salidas</option>
                                <option value="Compras">Compras</option>
                                <option value="Ropa">Ropa</option>
                                <option value="Tecnología">Tecnología</option>
                                <option value="Regalos">Regalos</option>
                                <option value="Deudas">Deudas</option>
                                <option value="Comisiones">Comisiones</option>
                                <option value="Intereses">Intereses</option>
                                <option value="Salud">Salud</option>
                                <option value="Cuidado personal">Cuidado personal</option>
                                <option value="Educación">Educación</option>
                                <option value="Mascotas">Mascotas</option>
                                <option value="Donaciones">Donaciones</option>
                                <option value="Imprevistos">Imprevistos</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>

                        <div class="form-field">
                            <span class="form-label" id="label-payment-method">Método de pago</span>
                            <div class="form-choice-group" role="radiogroup" aria-labelledby="label-payment-method">
                                <label class="form-choice">
                                    <input class="form-choice__input" type="radio" name="payment_method" value="cash"
                                        checked onchange="changePaymentMethod(this.value)">
                                    <span class="form-choice__text">💵 Efectivo</span>
                                </label>
                                <label class="form-choice">
                                    <input class="form-choice__input" type="radio" name="payment_method"
                                        value="credit_card" onchange="changePaymentMethod(this.value)">
                                    <span class="form-choice__text">💳 Crédito</span>
                                </label>
                                <label class="form-choice">
                                    <input class="form-choice__input" type="radio" name="payment_method"
                                        value="debit_card" onchange="changePaymentMethod(this.value)">
                                    <span class="form-choice__text">🏧 Débito</span>
                                </label>
                            </div>
                        </div>

                        <!-- Crédito -->
                        <div id="credit-card-container" class="form-conditional" style="display: none;">
                            <div class="form-field">
                                <label class="form-label" for="credit-card-id">Tarjeta de crédito</label>
                                <select class="form-select" name="credit_card_id" id="credit-card-id">
                                    <option value="">Selecciona una tarjeta</option>
                                    <?php if (empty($data['creditCards'])): ?>
                                        <option value="" disabled>No hay tarjetas de crédito agregadas</option>
                                    <?php else: ?>
                                        <?php foreach ($data['creditCards'] as $d): ?>
                                            <option value="<?= $d['id']; ?>"><?= htmlspecialchars($d['bank']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div id="installments-container" class="form-conditional" style="display: none;">
                            <div class="form-field">
                                <label class="form-label" for="installments">Número de meses</label>
                                <input type="number" id="installments" class="form-input" name="installments" value="1"
                                    min="1" step="1">
                                <p class="form-hint">Usa 1 si pagas en una sola exhibición.</p>
                            </div>
                        </div>

                        <!-- Débito -->
                        <div id="debit-card-container" class="form-conditional" style="display: none;">
                            <div class="form-field">
                                <label class="form-label" for="debit-card-id">Tarjeta de débito</label>
                                <select class="form-select" name="debit_card_id" id="debit-card-id">
                                    <option value="">Selecciona una tarjeta</option>
                                    <?php if (empty($data['debitCards'])): ?>
                                        <option value="" disabled>No hay tarjetas de débito agregadas</option>
                                    <?php else: ?>
                                        <?php foreach ($data['debitCards'] as $d): ?>
                                            <option value="<?= $d['id']; ?>"><?= htmlspecialchars($d['bank']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ==================== FIN SECCIÓN: GASTO ==================== -->


                    <!-- ==================== SECCIÓN: INGRESO ==================== -->
                    <div id="income-section" class="form-section" style="display: none;">
                        <div class="form-section__header">
                            <h2 class="form-section__title">Detalles del ingreso</h2>
                            <p class="form-section__description">Indica de dónde viene y a dónde llegó el dinero.</p>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="income-category">Origen del ingreso</label>
                            <select class="form-select" name="type" id="income-category" required>
                                <option value="">Selecciona el origen</option>
                                <option value="Nómina">Pago de nómina</option>
                                <option value="Venta">Venta</option>
                                <option value="Freelance">Freelance / Trabajo independiente</option>
                                <option value="Reembolso">Reembolso</option>
                                <option value="Regalo">Regalo</option>
                                <option value="Inversión">Rendimiento de inversión</option>
                                <option value="Préstamo recibido">Préstamo recibido</option>
                                <option value="Devolución de impuestos">Devolución de impuestos</option>
                                <option value="Otros ingresos">Otros ingresos</option>
                            </select>
                        </div>

                        <div class="form-field">
                            <span class="form-label" id="label-income-destination">Destino del ingreso</span>
                            <div class="form-choice-group" role="radiogroup" aria-labelledby="label-income-destination">
                                <label class="form-choice">
                                    <input class="form-choice__input" type="radio" name="income_destination"
                                        value="cash" checked onchange="changeIncomeDestination(this.value)">
                                    <span class="form-choice__text">💵 Efectivo</span>
                                </label>
                                <label class="form-choice">
                                    <input class="form-choice__input" type="radio" name="income_destination"
                                        value="debit_card" onchange="changeIncomeDestination(this.value)">
                                    <span class="form-choice__text">🏧 Débito</span>
                                </label>
                            </div>
                        </div>

                        <div id="debit-card-container-income" class="form-conditional" style="display: none;">
                            <div class="form-field">
                                <label class="form-label" for="debit-card-id-income">Tarjeta de débito</label>
                                <select class="form-select" name="debit_card_id_income" id="debit-card-id-income">
                                    <option value="">Selecciona una tarjeta</option>
                                    <?php if (empty($data['debitCards'])): ?>
                                        <option value="" disabled>No hay tarjetas de débito agregadas</option>
                                    <?php else: ?>
                                        <?php foreach ($data['debitCards'] as $d): ?>
                                            <option value="<?= $d['id']; ?>"><?= htmlspecialchars($d['bank']); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ==================== FIN SECCIÓN: INGRESO ==================== -->

                    <!-- Descripción -->
                    <div class="form-field">
                        <label class="form-label" for="transaction-description">
                            Descripción <span class="form-label__optional">(opcional)</span>
                        </label>
                        <textarea class="form-textarea" id="transaction-description" rows="4" name="description"
                            placeholder="Agrega un comentario o detalle de la transacción"></textarea>
                    </div>

                    <!-- Acciones -->
                    <div class="form-actions">
                        <button type="submit" class="form-button form-button--primary form-button--block">
                            Guardar transacción
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Alterna entre la sección de Gasto y la sección de Ingreso
    function changeTransactionType(type) {

        const expenseSection = document.getElementById('expense-section');
        const incomeSection = document.getElementById('income-section');

        const expenseCategory = document.getElementById('expense-category');
        const incomeCategory = document.getElementById('income-category');

        if (type === 'expense') {
            expenseSection.style.display = 'block';
            incomeSection.style.display = 'none';

            // Habilita/deshabilita para que solo se envíe el select visible
            expenseCategory.disabled = false;
            incomeCategory.disabled = true;

            enableSection(expenseSection);
            disableSection(incomeSection);

            // Restablece el método de pago de gasto a su estado inicial
            document.querySelector('input[name="payment_method"][value="cash"]').checked = true;
            changePaymentMethod('cash');

        } else if (type === 'income') {
            expenseSection.style.display = 'none';
            incomeSection.style.display = 'block';

            expenseCategory.disabled = true;
            incomeCategory.disabled = false;

            disableSection(expenseSection);
            enableSection(incomeSection);

            // Restablece el destino del ingreso a su estado inicial
            document.querySelector('input[name="income_destination"][value="cash"]').checked = true;
            changeIncomeDestination('cash');
        }
    }

    // Lógica de método de pago para GASTO (efectivo / crédito / débito)
    function changePaymentMethod(method) {

        const creditCardContainer = document.getElementById('credit-card-container');
        const debitCardContainer = document.getElementById('debit-card-container');
        const installmentsContainer = document.getElementById('installments-container');

        creditCardContainer.style.display = 'none';
        debitCardContainer.style.display = 'none';
        installmentsContainer.style.display = 'none';

        setFieldsDisabled(creditCardContainer, true);
        setFieldsDisabled(debitCardContainer, true);
        setFieldsDisabled(installmentsContainer, true);

        if (method === 'credit_card') {
            creditCardContainer.style.display = 'block';
            installmentsContainer.style.display = 'block';
            setFieldsDisabled(creditCardContainer, false);
            setFieldsDisabled(installmentsContainer, false);
        }

        if (method === 'debit_card') {
            debitCardContainer.style.display = 'block';
            setFieldsDisabled(debitCardContainer, false);
        }
    }

    // Lógica de destino para INGRESO (efectivo / débito)
    function changeIncomeDestination(destination) {

        const debitCardContainerIncome = document.getElementById('debit-card-container-income');

        debitCardContainerIncome.style.display = 'none';
        setFieldsDisabled(debitCardContainerIncome, true);

        if (destination === 'debit_card') {
            debitCardContainerIncome.style.display = 'block';
            setFieldsDisabled(debitCardContainerIncome, false);
        }
    }

    // Utilidades para no enviar campos ocultos en el POST
    function setFieldsDisabled(container, disabled) {
        container.querySelectorAll('input, select, textarea').forEach(el => {
            el.disabled = disabled;
        });
    }

    function disableSection(section) {
        section.querySelectorAll('input, select, textarea').forEach(el => {
            el.disabled = true;
        });
    }

    function enableSection(section) {
        section.querySelectorAll('input, select, textarea').forEach(el => {
            // Los que dependen de un método/destino específico los deja como estaban
            if (!el.closest('#credit-card-container') &&
                !el.closest('#debit-card-container') &&
                !el.closest('#installments-container') &&
                !el.closest('#debit-card-container-income')) {
                el.disabled = false;
            }
        });
    }

    // Inicializa el estado correcto al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        changeTransactionType('expense');
    });
</script>
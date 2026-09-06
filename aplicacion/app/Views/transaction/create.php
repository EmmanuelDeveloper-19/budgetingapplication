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
                        <label for="" class="form-label">Tipo de movimiento</label>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="type-transaction" value="expense" checked
                                    onchange="changeTransactionType(this.value)">
                                <span>Gasto</span>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="type-transaction" value="income"
                                    onchange="changeTransactionType(this.value)">
                                <span>Ingreso</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nombre de la transacción</label>
                        <input type="text" class="form-control" placeholder="Ej. Pago de internet, Netflix, Gasolina"
                            name="name">
                    </div>

                    <!-- ==================== SECCIÓN: GASTO ==================== -->
                    <div id="expense-section">

                        <div class="form-group">
                            <label class="form-label">Categoría del gasto</label>

                            <select class="form-control" name="type" id="expense-category">

                                <option value="">Selecciona una categoría</option>

                                <!-- 🏠 Hogar -->
                                <option value="Vivienda">Vivienda</option>
                                <option value="Servicios">Servicios</option>
                                <option value="Mantenimiento">Mantenimiento</option>

                                <!-- 🍔 Día a día -->
                                <option value="Alimentación">Alimentación</option>
                                <option value="Supermercado">Supermercado</option>
                                <option value="Comida fuera">Comida fuera</option>
                                <option value="Snacks y antojos">Snacks y antojos</option>

                                <!-- 🚌 Transporte -->
                                <option value="Transporte">Transporte</option>
                                <option value="Transporte público">Transporte público</option>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Estacionamiento">Estacionamiento</option>

                                <!-- 📱 Entretenimiento -->
                                <option value="Entretenimiento">Entretenimiento</option>
                                <option value="Suscripciones">Suscripciones</option>
                                <option value="Videojuegos">Videojuegos</option>
                                <option value="Salidas">Salidas</option>

                                <!-- 🛍️ Compras -->
                                <option value="Compras">Compras</option>
                                <option value="Ropa">Ropa</option>
                                <option value="Tecnología">Tecnología</option>
                                <option value="Regalos">Regalos</option>

                                <!-- 💳 Finanzas -->
                                <option value="Deudas">Deudas</option>
                                <option value="Comisiones">Comisiones</option>
                                <option value="Intereses">Intereses</option>

                                <!-- ❤️ Personal -->
                                <option value="Salud">Salud</option>
                                <option value="Cuidado personal">Cuidado personal</option>
                                <option value="Educación">Educación</option>

                                <!-- 📦 Otros -->
                                <option value="Mascotas">Mascotas</option>
                                <option value="Donaciones">Donaciones</option>
                                <option value="Imprevistos">Imprevistos</option>
                                <option value="Otros">Otros</option>

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

                        <!-- Tarjetas de débito (gasto) -->
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

                    </div>
                    <!-- ==================== FIN SECCIÓN: GASTO ==================== -->


                    <!-- ==================== SECCIÓN: INGRESO ==================== -->
                    <div id="income-section" style="display: none;">

                        <div class="form-group">
                            <label class="form-label">Origen del ingreso</label>

                            <select class="form-control" name="type" id="income-category">

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

                        <div class="form-group">
                            <label class="form-label">Destino del ingreso</label>
                            <div class="payment-methods">

                                <!-- Efectivo -->
                                <label class="payment-option">
                                    <input type="radio" name="income_destination" value="cash" checked
                                        onchange="changeIncomeDestination(this.value)">
                                    <span>Efectivo</span>
                                </label>

                                <!-- Tarjeta de débito -->
                                <label class="payment-option">
                                    <input type="radio" name="income_destination" value="debit_card"
                                        onchange="changeIncomeDestination(this.value)">
                                    <span>Tarjeta de débito</span>
                                </label>

                            </div>
                        </div>

                        <!-- Tarjetas de débito (ingreso) -->
                        <div id="debit-card-container-income" class="form-group" style="display: none;">
                            <label class="form-label">Tarjeta de débito</label>

                            <select class="form-control" name="debit_card_id_income">
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

                    </div>
                    <!-- ==================== FIN SECCIÓN: INGRESO ==================== -->


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
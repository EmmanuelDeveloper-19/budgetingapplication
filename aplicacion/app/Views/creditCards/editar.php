<div class="content">
    <div class="row">
        <div class="col-md-6">
            <h1>Editar tarjeta de crédito</h1>

            <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= $data['error'] ?>
                </div>
            <?php endif; ?>

            <form action="<?= PATH . 'creditCardController/update'; ?>" method="POST" class="login-form">

                <input type="hidden" name="id" value="<?= $data['creditCard']['id'] ?? $data['old']['id'] ?? '' ?>">
                <input type="hidden" name="user_id" value="<?= $data['creditCard']['user_id'] ?? $data['old']['user_id'] ?? '' ?>" required>

                <!-- Banco -->
                <div class="form-group">
                    <label for="bank" class="form-label">Banco:</label>
                    <select class="form-control" name="bank" id="bank" required>
                        <?php $bancoSeleccionado = $data['old']['bank'] ?? $data['creditCard']['bank'] ?? ''; ?>
                        <option value="">Selecciona un banco</option>
                        <option value="uala" <?= $bancoSeleccionado === 'uala' ? 'selected' : '' ?>>Ualá</option>
                        <option value="nu" <?= $bancoSeleccionado === 'nu' ? 'selected' : '' ?>>Nu</option>
                        <option value="banco azteca" <?= $bancoSeleccionado === 'banco azteca' ? 'selected' : '' ?>>Banco Azteca</option>
                        <option value="bbva" <?= $bancoSeleccionado === 'bbva' ? 'selected' : '' ?>>BBVA</option>
                        <option value="santander" <?= $bancoSeleccionado === 'santander' ? 'selected' : '' ?>>Santander</option>
                        <option value="banamex" <?= $bancoSeleccionado === 'banamex' ? 'selected' : '' ?>>Banamex</option>
                        <option value="mercado libre" <?= ($data['old']['bank'] ?? '') === 'mercado libre' ? 'selected' : '' ?>>Mercado Libre

                    </select>
                </div>

                <!-- Fecha de corte -->
                <div class="form-group">
                    <label for="statement_closing_date">Fecha de corte</label>
                    <input 
                        type="date"
                        min="<?= date('Y-m-d') ?>"
                        class="form-control"
                        name="statement_closing_date"
                        id="statement_closing_date"
                        required
                        value="<?= $data['old']['statement_closing_date'] ?? $data['creditCard']['statement_closing_date'] ?? '' ?>">
                </div>

                <!-- Fecha de pago -->
                <div class="form-group">
                    <label for="payment_date">Fecha de pago</label>
                    <input 
                        type="date"
                        min="<?= date('Y-m-d') ?>"
                        class="form-control"
                        name="payment_date"
                        id="payment_date"
                        required
                        value="<?= $data['old']['payment_date'] ?? $data['creditCard']['payment_date'] ?? '' ?>">
                </div>

                <!-- Saldo disponible -->
                <div class="form-group">
                    <label for="credit_limit">Saldo disponible</label>
                    <input 
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        name="credit_limit"
                        id="credit_limit"
                        value="<?= $data['old']['credit_limit'] ?? $data['creditCard']['credit_limit'] ?? '0.00' ?>">
                </div>

                <!-- Saldo pendiente -->
                <div class="form-group">
                    <label for="outstanding_balance">Saldo pendiente</label>
                    <input 
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        name="outstanding_balance"
                        id="outstanding_balance"
                        value="<?= $data['old']['outstanding_balance'] ?? $data['creditCard']['outstanding_balance'] ?? '0.00' ?>">
                </div>

                <button type="submit" class="btn btn-primary">
                    Actualizar tarjeta
                </button>

            </form>
        </div>
    </div>
</div>
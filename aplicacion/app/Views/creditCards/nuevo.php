<div class="content">
    <div class="row">
        <div class="col-md-6">
            <h1>Añadir nueva tarjeta de crédito</h1>

            <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= $data['error'] ?>
                </div>
            <?php endif; ?>

            <form action="<?= PATH . 'creditCardController/store'; ?>" method="POST" class="login-form">

                <input type="hidden" name="user_id" value="<?= $data['old']['user_id'] ?? '' ?>" required>

                <!-- Banco -->
                <div class="form-group">
                    <label for="banco" class="form-label">Banco:</label>
                    <select class="form-control" name="banco" id="banco" required>
                        <option value="">Selecciona un banco</option>
                        <option value="uala" <?= ($data['old']['banco'] ?? '') === 'uala' ? 'selected' : '' ?>>Ualá</option>
                        <option value="nu" <?= ($data['old']['banco'] ?? '') === 'nu' ? 'selected' : '' ?>>Nu</option>
                        <option value="banco azteca" <?= ($data['old']['banco'] ?? '') === 'banco azteca' ? 'selected' : '' ?>>Banco Azteca</option>
                        <option value="bbva" <?= ($data['old']['banco'] ?? '') === 'bbva' ? 'selected' : '' ?>>BBVA</option>
                        <option value="santander" <?= ($data['old']['banco'] ?? '') === 'santander' ? 'selected' : '' ?>>Santander</option>
                        <option value="banamex" <?= ($data['old']['banco'] ?? '') === 'banamex' ? 'selected' : '' ?>>Banamex</option>
                    </select>
                </div>

                <!-- Día de corte -->
                <div class="form-group">
                    <label for="dia_corte">Día de corte</label>
                    <input 
                        type="number"
                        min="1"
                        max="31"
                        class="form-control"
                        name="dia_corte"
                        id="dia_corte"
                        required
                        value="<?= $data['old']['dia_corte'] ?? '' ?>">
                </div>

                <!-- Día de pago -->
                <div class="form-group">
                    <label for="dia_pago">Día de pago</label>
                    <input 
                        type="number"
                        min="1"
                        max="31"
                        class="form-control"
                        name="dia_pago"
                        id="dia_pago"
                        required
                        value="<?= $data['old']['dia_pago'] ?? '' ?>">
                </div>

                <!-- Saldo disponible -->
                <div class="form-group">
                    <label for="balance_total">Saldo disponible</label>
                    <input 
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        name="balance_total"
                        id="balance_total"
                        value="<?= $data['old']['balance_total'] ?? '0.00' ?>">
                </div>

                <!-- Saldo pendiente -->
                <div class="form-group">
                    <label for="deuda">Saldo pendiente</label>
                    <input 
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        name="deuda"
                        id="deuda"
                        value="<?= $data['old']['deuda'] ?? '0.00' ?>">
                </div>

                <button type="submit" class="btn btn-primary">
                    Guardar tarjeta
                </button>

            </form>
        </div>
    </div>
</div>

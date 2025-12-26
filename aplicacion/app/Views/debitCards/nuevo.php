<div class="content">
    <div class="row">
        <div class="col-md-6">
            <h1>Añadir nueva tarjeta de debito</h1>

            <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= $data['error'] ?>
                </div>
            <?php endif; ?>

            <form action="<?= PATH . 'debitCardController/store'; ?>" method="POST" class="login-form">

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

                <!-- Saldo disponible -->
                <div class="form-group">
                    <label for="balance">Monto</label>
                    <input 
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        name="balance"
                        id="balance">
                </div>

                <button type="submit" class="btn btn-primary">
                    Guardar tarjeta
                </button>

            </form>
        </div>
    </div>
</div>

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

                <input type="hidden" name="id" value="<?= $data['old']['id'] ?? '' ?>" required>

                <!-- Banco -->
                <div class="form-group">
                    <label for="banco" class="form-label">Banco:</label>
                    <select class="form-control" name="bank" id="bank" required>
                        <option value="">Selecciona un banco</option>
                        <option value="uala" <?= ($data['old']['bank'] ?? '') === 'uala' ? 'selected' : '' ?>>Ualá</option>
                        <option value="nu" <?= ($data['old']['bank'] ?? '') === 'nu' ? 'selected' : '' ?>>Nu</option>
                        <option value="banco azteca" <?= ($data['old']['bank'] ?? '') === 'banco azteca' ? 'selected' : '' ?>>Banco Azteca</option>
                        <option value="bbva" <?= ($data['old']['bank'] ?? '') === 'bbva' ? 'selected' : '' ?>>BBVA</option>
                        <option value="santander" <?= ($data['old']['bank'] ?? '') === 'santander' ? 'selected' : '' ?>>Santander</option>
                        <option value="banamex" <?= ($data['old']['bank'] ?? '') === 'banamex' ? 'selected' : '' ?>>Banamex</option>
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

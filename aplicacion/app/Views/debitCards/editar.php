<div class="content">
    <div class="row">
        <div class="col-md-6">
            <h1>Actualizar tarjeta de debito</h1>

            <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= $data['error'] ?>
                </div>
            <?php endif; ?>

            <form action="<?= PATH . 'debitCardController/update/' . $data['debitCard']['id']; ?>" method="POST" class="login-form">

                <input type="hidden" name="user_id" value="<?= $data['old']['user_id'] ?? '' ?>" required>

                <!-- Banco -->
                <select class="form-control" name="banco" id="banco" required>
                    <option value="">Selecciona un banco</option>

                    <?php
                    $banco = $data['debitCard']['banco'];
                    ?>

                    <option value="uala" <?= $banco === 'uala' ? 'selected' : '' ?>>Ualá</option>
                    <option value="nu" <?= $banco === 'nu' ? 'selected' : '' ?>>Nu</option>
                    <option value="banco azteca" <?= $banco === 'banco azteca' ? 'selected' : '' ?>>Banco Azteca</option>
                    <option value="bbva" <?= $banco === 'bbva' ? 'selected' : '' ?>>BBVA</option>
                    <option value="santander" <?= $banco === 'santander' ? 'selected' : '' ?>>Santander</option>
                    <option value="banamex" <?= $banco === 'banamex' ? 'selected' : '' ?>>Banamex</option>
                </select>

                <!-- Saldo disponible -->
                <div class="form-group">
                    <label for="balance">Monto</label>
                    <input type="number" step="0.01" min="0" class="form-control" name="balance" id="balance"
                        value="<?= ($data['debitCard']['balance']) ?>">
                </div>

                <button type="submit" class="btn btn-primary">
                    Guardar tarjeta
                </button>

            </form>
        </div>
    </div>
</div>
<div class="content">
    <div class="row d-flex settings-wrapper justify-center align-center">
        <div class="col-md-6">

            <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= $data['errorK'] ?>
                </div>
            <?php endif; ?>

            <div class="card mb-10">
                <h1 class="title">Añadir nueva tarjeta de crédito</h1>

                <form action="<?= PATH . 'creditCardController/store'; ?>" method="POST">

                    <input type="hidden" name="user_id"
                        value="<?= $data['user']['id'] ?? $data['old']['user_id'] ?? '' ?>" required>

                    <div class="form-group">
                        <label for="bank" class="form-label">Banco:</label>
                        <select class="form-control" name="bank" id="bank" required>
                            <option value="<?= $data['old']['statement_closing_date'] ?? 'Seleccione un banco' ?>">
                                Selecciona
                                un banco</option>
                            <option value="uala" <?= ($data['old']['bank'] ?? '') === 'uala' ? 'selected' : '' ?>>Ualá
                            </option>
                            <option value="nu" <?= ($data['old']['bank'] ?? '') === 'nu' ? 'selected' : '' ?>>Nu</option>
                            <option value="banco azteca" <?= ($data['old']['bank'] ?? '') === 'banco azteca' ? 'selected' : '' ?>>Banco Azteca</option>
                            <option value="bbva" <?= ($data['old']['bank'] ?? '') === 'bbva' ? 'selected' : '' ?>>BBVA
                            </option>
                            <option value="santander" <?= ($data['old']['bank'] ?? '') === 'santander' ? 'selected' : '' ?>>
                                Santander</option>
                            <option value="banamex" <?= ($data['old']['bank'] ?? '') === 'banamex' ? 'selected' : '' ?>>
                                Banamex
                            </option>
                            <option value="mercadopago" <?= ($data['old']['bank'] ?? '') === 'mercadopago' ? 'selected' : '' ?>>Mercado pago
                            </option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="statement_closing_date" class="form-label">Fecha de corte</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control" name="statement_closing_date"
                            id="statement_closing_date" required
                            value="<?= $data['old']['statement_closing_date'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="payment_date" class="form-label">Fecha de pago</label>
                        <input type="date" min="<?= date('Y-m-d') ?>" class="form-control" name="payment_date"
                            id="payment_date" required value="<?= $data['old']['payment_date'] ?? '' ?>">
                    </div>

                    <div class="form-group">
                        <label for="credit_limit" class="form-label">Límite de crédito</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="credit_limit"
                            id="credit_limit" required value="<?= $data['old']['credit_limit'] ?? '0.00' ?>">
                    </div>

                    <div class="form-group">
                        <label for="outstanding_balance" class="form-label">Saldo pendiente (Deuda)</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="outstanding_balance"
                            id="outstanding_balance" required
                            value="<?= $data['old']['outstanding_balance'] ?? '0.00' ?>">
                    </div>

                    <div class="actions-buttons mt-3">
                        <button type="submit" class="btn btn-primary">
                            Guardar tarjeta
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
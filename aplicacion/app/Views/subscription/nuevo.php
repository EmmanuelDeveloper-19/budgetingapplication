<div class="content">
    <div class="row">
        <div class="col-md-6">
            <h1>Añadir nueva subscripción</h1>

            <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= $data['error'] ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= PATH . 'subscriptioncontroller/store'; ?>">
                <input type="hidden" name="user_id" value="<?= $data['user']['auth_id'] ?>">

                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" value="<?= $data['old']['nombre'] ?? '' ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="monto" class="form-label">Monto: </label>
                    <input type="number" step="0.01" min="0.01" class="form-control" name="monto"
                        value="<?= $data['old']['monto'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="plazo" class="form-label">Plazo: </label>
                    <select id="plazo" class="form-control" name="plazo" required>
                        <option value="">Selecciona el plazo</option>
                        <option value="mensual" <?= isset($data['old']['plazo']) && $data['old']['plazo'] == 'mensual' ? 'selected' : '' ?>>Mensual</option>
                        <option value="anual" <?= isset($data['old']['plazo']) && $data['old']['plazo'] == 'anual' ? 'selected' : '' ?>>Anual</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-1">Añadir subscripción</button>
                <a href="<?= PATH ?>userprofilecontroller/index" class="btn btn-secondary mt-1">Cancelar</a>
            </form>
        </div>
    </div>
</div>
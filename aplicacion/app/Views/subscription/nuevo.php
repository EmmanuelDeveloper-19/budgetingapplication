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

                <div class="form-group">
                    <label for="metodo_pago" class="form-label">Método de pago</label>
                    <select name="metodo_pago" class="form-control" id="metodo_pago" required>
                        <option value="">Selecciona el método de pago</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="credito">Tarjeta de credito</option>
                        <option value="debito">Tarjeta de debito</option>
                    </select>
                </div>

                <div class="form-group" id="tarjeta-group" style="display:none;">
                    <label for="tarjeta_id" class="form-label">Tarjeta</label>
                    <select name="tarjeta_id" id="tarjeta_id" class="form-control">
                        <option value="">Selecciona una tarjeta</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary mt-1">Añadir subscripción</button>
                <a href="<?= PATH ?>userprofilecontroller/index" class="btn btn-secondary mt-1">Cancelar</a>
            </form>
        </div>
    </div>
</div>


<script>
    const creditCards = <?= json_encode($data['creditCards'] ?? []) ?>;
    const debitCards = <?= json_encode($data['debitCards'] ?? []) ?>;
    const metodoPago = document.getElementById('metodo_pago');
    const tarjetaGroup = document.getElementById('tarjeta-group');
    const tarjetaSelect = document.getElementById('tarjeta_id');

    metodoPago.addEventListener('change', () => {
        tarjetaSelect.innerHTML = '<option value="">Selecciona una tarjeta</option>';

        let tarjetas = [];

        if (metodoPago.value === 'credito') {
            tarjetas = creditCards;
        } else if (metodoPago.value === 'debito') {
            tarjetas = debitCards;
        } else if (metodoPago.value === 'efectivo') {
            // Para efectivo no se muestran tarjetas
            tarjetas = [];
        }

        if (tarjetas.length > 0) {
            tarjetas.forEach(t => {
                const option = document.createElement('option');
                option.value = t.id;
                option.textContent = t.banco;
                tarjetaSelect.appendChild(option);
            });
            tarjetaGroup.style.display = 'block';
        } else {
            tarjetaGroup.style.display = 'none';
        }
    });
</script>

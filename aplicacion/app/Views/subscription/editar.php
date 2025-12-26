<div class="content">
    <div class="row">
        <div class="col-md-6">
            <h1>Actualizar subscripción</h1>

            <?php if (isset($data['error'])): ?>
                <div class="alert alert-danger">
                    <?= $data['error'] ?>
                </div>
            <?php endif; ?>

            <form 
                action="<?= PATH . 'subscriptionController/update/' . $data['subscription']['id']; ?>" 
                method="POST" 
                class="login-form"
            >

                <!-- Nombre -->
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input 
                        type="text"
                        class="form-control"
                        name="nombre"
                        id="nombre"
                        value="<?= $data['subscription']['nombre']; ?>"
                        required
                    >
                </div>

                <!-- Monto -->
                <div class="form-group">
                    <label for="monto">Monto</label>
                    <input 
                        type="number"
                        step="0.01"
                        min="0"
                        class="form-control"
                        name="monto"
                        id="monto"
                        value="<?= $data['subscription']['monto']; ?>"
                        required
                    >
                </div>

                <!-- Plazo -->
                <div class="form-group">
                    <label for="plazo">Plazo</label>
                    <select 
                        class="form-control"
                        name="plazo"
                        id="plazo"
                        required
                    >
                        <option value="">Selecciona un plazo</option>
                        <option value="mensual" <?= $data['subscription']['plazo'] === 'mensual' ? 'selected' : '' ?>>
                            Mensual
                        </option>
                        <option value="anual" <?= $data['subscription']['plazo'] === 'anual' ? 'selected' : '' ?>>
                            Anual
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Actualizar subscripción
                </button>

            </form>
        </div>
    </div>
</div>

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
                        <label class="form-label">Nombre de la transacción</label>
                        <input type="text" class="form-control" placeholder="Ej. Pago de internet, Netflix, Gasolina"
                            name="name">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Categoría</label>
                        <select class="form-control" name="type">
                            <option value="">Selecciona una categoría</option>
                            <option value="Servicios">Servicios</option>
                            <option value="Subscripciones">Suscripciones</option>
                            <option value="Deudas">Deudas</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Método de pago</label>
                        <select class="form-control" name="payment_method">
                            <option value="">Seleccione el método de pago</option>
                            <option value="cash">Efectivo</option>
                            <option value="credit_card">Tarjeta de Crédito</option>
                            <option value="debit_card">Débito</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Monto</label>
                        <input type="number" class="form-control" placeholder="Ej. 350.00" name="amount">
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
<div class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="card glass-panel">
                <?php if (isset($data['error'])): ?>
                    <div class="glass-alert">
                        <?= $data['error'] ?>
                    </div>
                <?php endif; ?>

                <h1 class="text-heading">Agregar nuevo ingreso</h1>

                <form action="" method="POST">
                    <div class="field-group">
                        <label for="" class="field-label">Nombre del ingreso</label>
                        <input type="text" class="field-control">
                    </div>
                    <div class="field-group field-select">
                        <label class="field-label">Origen del ingreso</label>
                        <select class="field-control" name="type" id="income-category">
                            <option value="">Selecciona el origen</option>
                            <option value="Nómina">Pago de nómina</option>
                            <option value="Venta">Venta</option>
                            <option value="Freelance">Freelance / Trabajo independiente</option>
                            <option value="Reembolso">Reembolso</option>
                            <option value="Regalo">Regalo</option>
                            <option value="Inversión">Rendimiento de inversión</option>
                            <option value="Préstamo recibido">Préstamo recibido</option>
                            <option value="Devolución de impuestos">Devolución de impuestos</option>
                            <option value="Otros ingresos">Otros ingresos</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Destino</label>
                        <div class="type-toggle type-toggle--triple">
                            <label class="field-checkbox type-toggle-option">
                                <input type="radio" name="payment_method" value="cash" checked
                                    onchange="changePaymentMethod(this.value)">
                                <span class="field-checkbox-box"></span>
                                <span class="field-checkbox-label">💵 Efectivo</span>
                            </label>
                            <label class="field-checkbox type-toggle-option">
                                <input type="radio" name="payment_method" value="debit_card"
                                    onchange="changePaymentMethod(this.value)">
                                <span class="field-checkbox-box"></span>
                                <span class="field-checkbox-label">🏧 Débito</span>
                            </label>
                        </div>
                    </div>
                    <div class="field-group">
                        <label for="" class="field-label">Monto del ingreso</label>
                        <input type="number" name="" id="" class="field-control">
                    </div>
                    <div class="field-group">
                        <button class="btn btn-primary w100">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
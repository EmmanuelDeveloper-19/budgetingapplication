
<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-white w100">

                <h1 class="text-heading-lg text-primary">
                    Registrar nueva deuda
                </h1>

                <p class="text-secondary">
                    Registra el dinero que te han prestado y lleva
                    el control de tus pagos pendientes.
                </p>

                <form action="<?= PATH . 'debtController/debtStore';?>" method="POST" class="mt-10">

                    <!-- Acreedor -->
                    <div class="field-group">
                        <label for="creditor_id" class="field-label">
                            ¿A quién le debes dinero?
                        </label>

                        <div class="field-select">
                            <select
                                name="contact_id"
                                id="contact_id"
                                required
                            >
                                <option value="" selected disabled>
                                    Selecciona a tu acreedor
                                </option>
                                <?php if(!$data['contacts']):?>
                                <option value="">No hay contactos disponibles</option>
                                <?php else:?>
                                    <?php foreach($data['contacts'] as $c):?>
                                        <option value="<?= $c['id'];?>"><?= $c['name'];?></option>
                                    <?php endforeach?>
                                <?php endif;?>
     
                            </select>
                        </div>

                        <small class="field-help">
                            Selecciona a la persona o institución
                            que te prestó el dinero.
                        </small>
                    </div>

                    <!-- Importe -->
                    <div class="field-group">
                        <label for="amount" class="field-label">
                            Cantidad prestada
                        </label>

                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            class="field-control"
                            placeholder="Ej. 1500.00"
                            min="0.01"
                            step="0.01"
                            required
                        >

                        <small class="field-help">
                            Indica el importe total que recibiste
                            en préstamo, en pesos mexicanos.
                        </small>
                    </div>

                    <!-- Fecha del préstamo -->
                    <div class="field-group">
                        <label for="loan_date" class="field-label">
                            ¿Cuándo recibiste el dinero?
                        </label>

                        <input
                            type="date"
                            id="debt_date"
                            name="debt_date"
                            class="field-control"
                            value="<?= date('Y-m-d'); ?>"
                            required
                        >

                        <small class="field-help">
                            Por defecto aparece la fecha de hoy.
                            Puedes cambiarla si recibiste el dinero
                            en otro día.
                        </small>
                    </div>

                    <!-- Fecha límite -->
                    <div class="field-group">
                        <label for="due_date" class="field-label">
                            Fecha límite de pago
                        </label>

                        <input
                            type="date"
                            id="due_date"
                            name="due_date"
                            class="field-control"
                            min="<?= date('Y-m-d'); ?>"
                            required
                        >

                        <small class="field-help">
                            Indica la fecha acordada para devolver
                            el dinero.
                        </small>
                    </div>

                    <!-- Interés -->
                    <div class="field-group">
                        <label for="interest" class="field-label">
                            Tasa de interés (%)
                        </label>

                        <input
                            type="number"
                            id="interest"
                            name="interest"
                            class="field-control"
                            placeholder="Ej. 0"
                            min="0"
                            max="100"
                            step="0.01"
                            value="0"
                            required
                        >

                        <small class="field-help">
                            Indica el interés acordado por el préstamo.
                            Escribe 0 si debes devolver únicamente
                            el dinero que recibiste.
                        </small>
                    </div>

                    <!-- Botón -->
                    <div class="field-group">
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Registrar deuda
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<!--


<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-white w100">

                <h1 class="text-heading-lg text-primary">
                    Registrar nueva deuda
                </h1>

                <p class="text-secondary">
                    Registra el dinero que has prestado y establece
                    cuándo esperas recibir el pago.
                </p>

                <form action="" method="POST" class="mt-10">

                    <div class="field-group">
                        <label for="creditor_id" class="field-label">
                            ¿A quién le prestaste dinero?
                        </label>

                        <div class="field-select">
                            <select
                                name="creditor_id"
                                id="creditor_id"
                                required
                            >
                                <option value="" selected disabled>
                                    Selecciona una persona
                                </option>
                            </select>
                        </div>

                        <small class="field-help">
                            Selecciona a la persona que debe devolverte
                            el dinero.
                        </small>
                    </div>

                    <div class="field-group">
                        <label for="amount" class="field-label">
                            Cantidad prestada
                        </label>

                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            class="field-control"
                            placeholder="Ej. 1500.00"
                            min="0.01"
                            step="0.01"
                            required
                        >

                        <small class="field-help">
                            Introduce el importe total que le prestaste,
                            en pesos mexicanos.
                        </small>
                    </div>

                    <div class="field-group">
                        <label for="loan_date" class="field-label">
                            Fecha del préstamo
                        </label>

                        <input
                            type="date"
                            id="loan_date"
                            name="loan_date"
                            class="field-control"
                            value="<?= date('Y-m-d'); ?>"
                            required
                        >

                        <small class="field-help">
                            Selecciona el día en que entregaste el dinero.
                            Por defecto, aparece la fecha de hoy.
                        </small>
                    </div>

                    <div class="field-group">
                        <label for="due_date" class="field-label">
                            Fecha límite de pago
                        </label>

                        <input
                            type="date"
                            id="due_date"
                            name="due_date"
                            class="field-control"
                            min="<?= date('Y-m-d'); ?>"
                            required
                        >

                        <small class="field-help">
                            Indica la fecha acordada para que te devuelvan
                            el dinero.
                        </small>
                    </div>

                    <div class="field-group">
                        <label for="interest_rate" class="field-label">
                            Tasa de interés (%)
                        </label>

                        <input
                            type="number"
                            id="interest_rate"
                            name="interest_rate"
                            class="field-control"
                            placeholder="Ej. 0 para un préstamo sin intereses"
                            min="0"
                            max="100"
                            step="0.01"
                            value="0"
                            required
                        >

                        <small class="field-help">
                            Introduce el porcentaje de interés acordado.
                            Usa 0 si no cobrarás intereses.
                        </small>
                    </div>

                    <div class="field-group">
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Registrar deuda
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
-->
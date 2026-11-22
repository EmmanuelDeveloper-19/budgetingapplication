
<dialog id="modal-edit" class="app-modal">
    <form id="form-edit" method="POST"
          action="<?= PATH . 'debtController/updateDebt' ?>">

        <div class="modal-header">
            <div>
                <h2>Editar deuda</h2>
                <p>Modifica la información del préstamo.</p>
            </div>

            <button type="button" class="modal-close"
                    data-close-modal aria-label="Cerrar">
                &times;
            </button>
        </div>

        <div class="modal-body">
            <input type="hidden" name="debt_id" id="edit-debt-id">

            <div class="field-group">
                <label for="edit-contact">Contacto</label>
                <input
                    class="field-control"
                    type="text"
                    id="edit-contact"
                    readonly>
                <small>El contacto se muestra como referencia.</small>
            </div>

            <div class="field-group">
                <label for="edit-amount">Monto</label>
                <input
                    class="field-control"
                    type="number"
                    id="edit-amount"
                    name="amount"
                    min="0.01"
                    step="0.01"
                    required>
            </div>

            <div class="field-group">
                <label for="edit-debt-date">Fecha del préstamo</label>
                <input
                    class="field-control"
                    type="date"
                    id="edit-debt-date"
                    name="debt_date"
                    required>
            </div>

            <div class="field-group">
                <label for="edit-due-date">Fecha límite</label>
                <input
                    class="field-control"
                    type="date"
                    id="edit-due-date"
                    name="due_date">
            </div>

            <div class="field-group">
                <label for="edit-interest">Interés (%)</label>
                <input
                    class="field-control"
                    type="number"
                    id="edit-interest"
                    name="interest"
                    min="0"
                    max="999.99"
                    step="0.01">
            </div>

            <div class="field-group">
                <label for="edit-status">Estatus</label>
                <select class="field-control"
                        id="edit-status" name="status" required>
                    <option value="PENDING">Pendiente</option>
                    <option value="PAID">Pagada</option>
                    <option value="CANCELLED">Cancelada</option>
                </select>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                    data-close-modal>
                Cancelar
            </button>

            <button type="submit" class="btn btn-primary">
                Guardar cambios
            </button>
        </div>
    </form>
</dialog>

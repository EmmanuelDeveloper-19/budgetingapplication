
<dialog id="modal-delete" class="app-modal">
    <form id="form-delete" method="POST"
          action="<?= PATH . 'debtController/deleteDebt' ?>">

        <div class="modal-header">
            <h2>Eliminar deuda</h2>

            <button type="button" class="modal-close"
                    data-close-modal aria-label="Cerrar">
                &times;
            </button>
        </div>

        <div class="modal-body">
            <input type="hidden" name="debt_id" id="delete-debt-id">

            <div class="delete-warning-icon">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <p>
                ¿Estás seguro de que deseas eliminar esta deuda?
            </p>

            <p>
                Contacto: <strong id="delete-contact"></strong>
            </p>

            <p class="text-secondary">
                Esta acción puede afectar tu historial financiero.
                Verifica la información antes de continuar.
            </p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                    data-close-modal>
                Cancelar
            </button>

            <button type="submit" class="btn btn-danger">
                Sí, eliminar
            </button>
        </div>
    </form>
</dialog>

<dialog id="app-modal" class="modal">
    <div class="modal-header">
        <h2 id="modal-title">Título del modal</h2>

        <button type="button" class="modal-close" data-modal-close aria-label="Cerrar modal">
            &times;
        </button>
    </div>

    <div id="modal-body" class="modal-body"></div>

    <div class="modal-footer">
        <button type="button" class="btn-secondary" data-modal-close>
            Cancelar
        </button>

        <button type="button" id="modal-confirm" class="btn-primary">
            Confirmar
        </button>
    </div>
</dialog>
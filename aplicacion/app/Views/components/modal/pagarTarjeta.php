<div class="modal-body">

    <h1>Actualizar saldo de tarjeta</h1>

    <form id="pagarTarjetaForm" method="POST" class="login-form">

        <input type="hidden" id="pagarCardId" name="id">

        <div class="form-group">
            <label for="amount">
                Cantidad a abonar
            </label>

            <input class="form-control" type="number" id="amount" name="amount" step="0.01" min="0.01" required>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">
                Abonar
            </button>
        </div>

    </form>

</div>
<div class="modal-body">

    <h1 class="title">
        Actualizar saldo
    </h1>
    <form
        id="abonarDebitoForm"
        class="login-form"
        method="POST"
    >

        <input
            type="hidden"
            id="debitCardId"
            name="id"
        >

        <div class="form-group">
            <label for="amount" class="form-label">
                Cantidad a abonar
            </label>

            <input
                class="form-control"
                type="number"
                id="amount"
                name="amount"
                step="0.01"
                min="0.01"
                required
            >
        </div>

        <button class="btn btn-primary" type="submit">
            Abonar
        </button>

    </form>

</div>
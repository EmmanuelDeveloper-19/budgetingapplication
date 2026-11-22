<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-white w100">
                <h1 class="text-heading-lg text-primary">Crear nuevo contacto</h1>

                <form method="POST" action="<?= PATH . 'debtController/contactStore';?>" class="mt-10">

                    <div class="field-group">
                        <label for="username" class="field-label">Nombre del contacto</label>
                        <input type="text" id="name" name="name" class="field-control"
                            placeholder="ejemp. Fatima del Carmen" required autocomplete="name">
                    </div>

                    <div class="field-group">
                        <button type="submit" class="btn btn-primary">Crear contacto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
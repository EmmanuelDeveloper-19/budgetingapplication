<div class="content">

    <div class="row">
        <div class="col-md-4">
            <form class="card" method="POST"
                action="<?= PATH . 'userprofilecontroller/updateUserInfo/' . $data['user']['id']; ?>">
                <h1 class="title">Información del usuario</h1>

                <input type="hidden" name="id" value="<?= $data['user']['id'] ?>">

                <div class="form-group">
                    <label for="email" class="form-label">Correo: </label>
                    <input type="text" class="form-control" name="email" value="<?= $data['user']['username'] ?>"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" value="<?= $data['user']['name'] ?>">
                </div>
                <div class="form-group">
                    <label for="apellido" class="form-label">Apellidos: </label>
                    <input type="text" class="form-control" name="apellido" value="<?= $data['user']['last_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="balance" class="form-label">Balance: </label>
                    <input type="number" step="0.01" class="form-control" name="balance"
                        value="<?= $data['user']['balance'] ?? 0.00 ?>">
                </div>
                <div class="action-buttons mt-3">
                    <button type="submit" class="btn btn-primary w-100 mb-2">Actualizar campos</button>
                    <a href="<?= PATH ?>login/logout" class="btn btn-light text-danger w-100">Cerrar Sesión</a>
                </div>
            </form>
        </div>
    </div>
</div>
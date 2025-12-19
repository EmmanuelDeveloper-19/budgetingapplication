<div class="content">
    <h1>Información del usuario</h1>

    <div class="row">
        <div class="col-md-3">
            <form method="POST"
                action="<?= PATH . 'userprofilecontroller/updateUserInfo/' . $data['user']['auth_id']; ?>">
                <input type="hidden" name="id" value="<?= $data['user']['auth_id'] ?>">

                <div class="form-group">
                    <label for="email" class="form-label">Correo: </label>
                    <input type="text" class="form-control" name="email" value="<?= $data['user']['email'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="nombre" value="<?= $data['user']['nombre'] ?>">
                </div>
                <div class="form-group">
                    <label for="apellido" class="form-label">Apellidos: </label>
                    <input type="text" class="form-control" name="apellido" value="<?= $data['user']['apellido'] ?>">
                </div>
                <div class="form-group">
                    <label for="telefono" class="form-label">Número de teléfono: </label>
                    <input type="text" class="form-control" name="telefono" value="<?= $data['user']['telefono'] ?>">
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento: </label>
                    <input type="date" class="form-control" name="fecha_nacimiento"
                        value="<?= isset($data['user']['fecha_nacimiento']) ? $data['user']['fecha_nacimiento'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="balance" class="form-label">Balance: </label>
                    <input type="number" step="0.01" class="form-control" name="balance"
                        value="<?= $data['user']['balance'] ?? 0.00 ?>">
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-primary mt-1">Actualizar campos</button>
                    <a href="<?= PATH ?>login/logout" class="btn btn-primary">Cerrar Sesión</a>
                </div>
            </form>
        </div>
    </div>
</div>
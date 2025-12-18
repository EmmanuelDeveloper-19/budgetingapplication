<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Bienvenido</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($data['user']) && $data['user']): ?>
                        <h5>Información del Usuario</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>ID:</strong></td>
                                <td><?= htmlspecialchars($data['user']['id']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Email/Usuario:</strong></td>
                                <td><?= htmlspecialchars($data['user']['email']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Registrado:</strong></td>
                                <td><?= htmlspecialchars($data['user']['created_at']) ?></td>
                            </tr>
                        </table>

                        <div class="alert alert-success mt-3">
                            ¡Sesión activa! Estás logueado correctamente.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            Error: No se pudo obtener información del usuario.
                        </div>
                    <?php endif; ?>
                    <!-- En tu vista home/index.php -->
                    <a href="<?= PATH ?>login/logout" class="btn btn-danger">
                        Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
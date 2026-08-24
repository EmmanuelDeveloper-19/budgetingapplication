<div class="content">
    <div class="row d-flex settings-wrapper justify-center align-center">
        <div class="col-md-6">
            <div class="card mb-10">
                <?php require_once INCLUDES . "alerts.php"; ?>

                <h1 class="title">Información del usuario</h1>
                <form method="POST"
                    action="<?= PATH . 'userprofilecontroller/updateUserInfo/' . $data['user']['id']; ?>">

                    <input type="hidden" name="id" value="<?= $data['user']['id'] ?>">

                    <div class="form-group">
                        <label for="username" class="form-label">Correo: </label>
                        <input type="text" class="form-control" name="username" id="username"
                            value="<?= $data['user']['username'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre: </label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="<?= $data['user']['name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="form-label">Apellidos: </label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            value="<?= $data['user']['last_name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="balance" class="form-label">Balance: </label>
                        <input type="number" step="0.01" class="form-control" name="balance" id="balance"
                            value="<?= $data['user']['balance'] ?? 0.00 ?>">
                    </div>

                    <div class="action-buttons mt-3">
                        <button type="submit" class="btn btn-primary w-100 mb-2">Actualizar campos</button>
                    </div>
                </form>
            </div>

            <!-- ================= TARJETAS ================= -->
            <div class="card mb-10">
                <h1 class="title">Tarjetas de credito</h1>
                <ul class="item-list">
                    <?php if (empty($data['creditCardData'])): ?>
                        <div class="empty-state">
                            <p>No hay tarjetas de crédito agregadas</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($data['creditCardData'] as $d): ?>
                            <li>
                                <a href="#">
                                    <span class="item-title"><?= $d['bank']; ?></span>
                                    <i class="fa-solid fa-chevron-right icon-arrow"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <a class="btn btn-primary" href="<?= PATH . 'creditCardController/nuevo'; ?>">Nueva tarjeta de
                    crédito</a>
            </div>

            <!-- ================= TARJETAS ================= -->
            <div class="card mb-10">
                <h1 class="title">Tarjetas de débito</h1>
                <ul class="item-list">
                    <?php if (empty($data['debitData'])): ?>
                        <div class="empty-state">
                            <p>No hay tarjetas de débito agregadas</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($data['debitData'] as $d): ?>
                            <li>
                                <a href="#">
                                    <span class="item-title"><?= $d['bank']; ?></span>
                                    <i class="fa-solid fa-chevron-right icon-arrow"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </ul>
                <a class="btn btn-primary" href="<?= PATH . 'debitCardController/nuevo'; ?>">Nueva tarjeta de debito</a>
            </div>


            <!-- ================= SUSCRIPCIONES (Futuro) ================= -->
            <!--
                        <div class="card mb-10">
                <h1 class="title">Subscripciones</h1>
                <ul class="item-list">
                    <li>
                        <a href="#">
                            <span class="item-title">Nu</span>
                            <i class="fa-solid fa-chevron-right icon-arrow"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="item-title">BBVA</span>
                            <i class="fa-solid fa-chevron-right icon-arrow"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="item-title">Mercado Pago</span>
                            <i class="fa-solid fa-chevron-right icon-arrow"></i>
                        </a>
                    </li>
                </ul>
                <button class="btn btn-primary">Nueva subscripcion</button>
            </div>-->

            <div class="card">
                <a href="<?= PATH ?>login/logout" class="btn btn-light text-danger w-100">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</div>
<div class="content">

    <div class="row justify-center align-center">

        <div class="col-md-6">

            <!-- ================= INFORMACIÓN DEL USUARIO ================= -->

            <div class="card glass-panel mb-sm">

                <?php require_once INCLUDES . "alerts.php"; ?>

                <h1 class="text-heading">Información del usuario</h1>
                <p class="glass-subtext">
                    Actualiza la información de tu perfil.
                </p>

                <form method="POST"
                action="<?= PATH . 'userprofilecontroller/updateUserInfo/' . $data['user']['id']; ?>">

                    <input type="hidden" name="id" value="<?= $data['user']['id'] ?>">

                    <!-- CORREO -->
                    <div class="field-group">

                        <label for="username" class="field-label">
                            Correo
                        </label>

                        <input type="text" class="field-control" name="username" id="username"
                            value="<?= $data['user']['username'] ?>" readonly>

                    </div>

                    <!-- NOMBRE -->
                    <div class="field-group">

                        <label for="name" class="field-label">
                            Nombre
                        </label>

                        <input type="text" class="field-control" name="name" id="name"
                            value="<?= $data['user']['name'] ?>">

                    </div>

                    <!-- APELLIDOS -->
                    <div class="field-group">

                        <label for="last_name" class="field-label">
                            Apellidos
                        </label>

                        <input type="text" class="field-control" name="last_name" id="last_name"
                            value="<?= $data['user']['last_name'] ?>">

                    </div>

                    <!-- BALANCE -->
                    <div class="field-group">

                        <label for="balance" class="field-label">
                            Balance
                        </label>

                        <div class="field-control-wrap field-control-wrap--amount">

                            <span class="field-prefix">$</span>

                            <input type="number" step="0.01" class="field-control field-control--amount" name="balance"
                                id="balance" value="<?= $data['user']['balance'] ?? 0.00 ?>">

                        </div>

                    </div>

                    <!-- ACCIÓN -->
                    <div class="link-row">

                        <button type="submit" class="btn btn-primary btn-glass w100">
                            Actualizar campos
                        </button>

                    </div>

                </form>

            </div>


            <!-- ================= TARJETAS DE CRÉDITO ================= -->

            <div class="card glass-panel mb-sm">

                <h1 class="text-heading">
                    Tarjetas de crédito
                </h1>

                <p class="glass-subtext">
                    Administra tus tarjetas de crédito.
                </p>

                <ul class="list-items">

                    <?php if (empty($data['creditCardData'])): ?>

                        <div class="glass-alert">
                            No hay tarjetas de crédito agregadas
                        </div>

                    <?php else: ?>

                        <?php foreach ($data['creditCardData'] as $d): ?>

                            <li class="card-item">

                                <a href="#" class="card-bank">

                                    <span class="text-primary">
                                        <?= $d['bank']; ?>
                                    </span>

                                    <i class="fa-solid fa-chevron-right"></i>

                                </a>

                            </li>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </ul>

                <a class="btn btn-primary btn-glass" href="<?= PATH . 'creditCardController/nuevo'; ?>">
                    Nueva tarjeta de crédito
                </a>

            </div>


            <!-- ================= TARJETAS DE DÉBITO ================= -->

            <div class="card glass-panel mb-sm">

                <h1 class="text-heading">
                    Tarjetas de débito
                </h1>

                <p class="glass-subtext">
                    Administra tus tarjetas de débito.
                </p>

                <ul class="list-items">

                    <?php if (empty($data['debitData'])): ?>

                        <div class="glass-alert">
                            No hay tarjetas de débito agregadas
                        </div>

                    <?php else: ?>

                        <?php foreach ($data['debitData'] as $d): ?>

                            <li class="card-item">

                                <a href="#" class="card-bank">

                                    <span class="text-primary">
                                        <?= $d['bank']; ?>
                                    </span>

                                    <i class="fa-solid fa-chevron-right"></i>

                                </a>

                            </li>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </ul>

                <a class="btn btn-primary btn-glass" href="<?= PATH . 'debitCardController/nuevo'; ?>">
                    Nueva tarjeta de débito
                </a>

            </div>


            <!-- ================= CERRAR SESIÓN ================= -->


                <a href="<?= PATH ?>login/logout" class="btn btn-primary w100">
                    Cerrar sesión
                </a>


        </div>

    </div>

</div>
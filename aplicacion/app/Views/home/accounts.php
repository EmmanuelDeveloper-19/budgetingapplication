<div class="content">
    <div class="texto-resaltado">
        <p>Cuentas o subscripciones</p>
    </div>

    <?php if (empty($data['subscriptions'])): ?>
        <div class="empty-state">
            <p>No hay subscripciones agregadas</p>
        </div>
    <?php else: ?>
        <?php foreach ($data['subscriptions'] as $subscription): ?>
            <div class="lista-elementos">
                <img src="<?= PATH . 'assets/' . $subscription['nombre'] . '.png'; ?>" alt="">
                <div class="info">
                    <div class="col">
                        <strong><?= ucfirst($subscription['nombre']); ?></strong>
                        <p><?= $subscription['plazo']; ?></p>
                    </div>
                    <strong>$<?= $subscription['monto']; ?></strong>
                </div>

                <!-- Menú de opciones -->
                <div class="menu-opciones">
                    <button class="menu-btn">⋮</button>
                    <div class="menu-dropdown">
                        <a href="<?= PATH . 'subscriptionController/editar/' . $subscription['id']; ?>">Editar</a>
                        <a href="<?= PATH . 'subscriptionController/delete/' . $subscription['id']; ?>" class="danger">Eliminar</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <a href="<?= PATH . 'subscriptionController/create'; ?>" class="link_add">
        Añadir subscripción
    </a>
</div>

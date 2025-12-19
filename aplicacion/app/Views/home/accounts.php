<div class="content">
    <div class="texto-resaltado">
        <p>Cuentas o subscripciones</p>
    </div>
    <?php foreach ($data['subscriptions'] as $subscription): ?>
        <div class="lista-elementos">
            <img src="<?= PATH . 'assets/' . $subscription['nombre'] . '.png';?>"
                alt="">
            <div class="info">
                <div class="col">
                    <strong><?= $subscription['nombre']; ?></strong>
                    <p><?= $subscription['plazo'];?></p>
                </div>
                <strong>$<?= $subscription['monto']; ?></strong>
            </div>
        </div>
    <?php endforeach; ?>
    <a href="<?= PATH . 'subscriptionController/create'; ?>" class="link_add">Añadir subscripción</a>
</div>
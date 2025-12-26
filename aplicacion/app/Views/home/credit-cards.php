<div class="content">
    <div class="texto-resaltado">
        <p>Tarjetas de credito</p>
    </div>
    <?php if (empty($data['creditCards'])): ?>
        <div class="empty-state">
            <p>No hay tarjetas de credito agregadas</p>
        </div>
    <?php else: ?>
        <?php foreach ($data['creditCards'] as $c): ?>
            <div class="lista-elementos">
                <img src="<?= PATH . 'assets/' . $c['banco'] . '.png'; ?>" alt="">
                <div class="info">
                    <strong><?= $c['banco']; ?></strong>
                    <strong>$<?= $c['balance_total']; ?></strong>
                </div>
                <!-- Menú de opciones -->
                <div class="menu-opciones">
                    <button class="menu-btn">⋮</button>
                    <div class="menu-dropdown">
                        <a href="<?= PATH . 'creditCardController/editar/' . $c['id']; ?>">Editar</a>
                        <a href="<?= PATH . 'creditCardController/eliminar/' . $c['id']; ?>" class="danger">Eliminar</a>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="<?= PATH . 'creditCardController/nuevo'; ?>" class="link_add">Agregar tarjeta de credito</a>
</div>
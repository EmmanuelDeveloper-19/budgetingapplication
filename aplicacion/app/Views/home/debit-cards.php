<div class="content">
    <div class="texto-resaltado">
        <p>Tarjetas de débito</p>
    </div>

    <?php if (empty($data['debitCards'])): ?>
        <div class="empty-state">
            <p>No hay tarjetas de debito agregadas</p>
        </div>
    <?php else: ?>
        <?php foreach ($data['debitCards'] as $d): ?>
            <div class="lista-elementos">

                <img src="<?= PATH . 'assets/' . $d['banco'] . '.png'; ?>" alt="">

                <div class="info">
                    <strong><?= ucfirst($d['banco']); ?></strong>
                    <strong>$<?= number_format($d['balance'], 2); ?></strong>
                </div>

                <!-- Menú de opciones -->
                <div class="menu-opciones">
                    <button class="menu-btn">⋮</button>
                    <div class="menu-dropdown">
                        <a href="<?= PATH . 'debitCardController/editar/' . $d['id']; ?>">Editar</a>
                        <a href="<?= PATH . 'debitCardController/delete/' . $d['id']; ?>" class="danger">Eliminar</a>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="<?= PATH . 'debitCardController/nuevo'; ?>" class="link_add">Añadir tarjeta de débito</a>
</div>
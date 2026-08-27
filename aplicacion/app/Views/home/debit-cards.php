<div class="content dr-none">
    <p class="texto-resaltado">Tarjetas de débito</p>

    <?php if (empty($data['debitCards'])): ?>
        <div class="empty-state">
            <p>No hay tarjetas de debito agregadas</p>
        </div>
    <?php else: ?>
        <?php foreach ($data['debitCards'] as $d): ?>
            <div class="credit-cards-list">

                <div class="credit-card-item">
                    <div class="card-bank">
                        <img class="img-icon" src="<?= PATH . 'assets/' . $d['bank'] . '.png'; ?>" alt="">
                        <strong><?= ucfirst($d['bank']); ?></strong>

                    </div>
                    <div class="card-amounts">
                        <div class="amount limit">
                            <strong>$<?= number_format($d['balance'], 2); ?></strong>
                        </div>
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

            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="<?= PATH . 'debitCardController/nuevo'; ?>" class="link_add">Añadir tarjeta de débito</a>
</div>
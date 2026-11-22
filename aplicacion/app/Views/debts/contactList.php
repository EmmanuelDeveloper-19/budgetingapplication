<section class="summary-panel">
    <div class="summary-header">
        <div>
            <h2 class="summary-title">Contactos</h2>
            <p class="summary-subtitle">Resumen de tus deudas con personas</p>
        </div>
        <div class="summary-icon">
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
    <?php if (empty($data['contacts'])): ?>
        <div class="summary-header">
            <p>No hay</p>
        </div>
    <?php else: ?>
        <?php foreach ($data['contacts'] as $c): ?>
            <div class="summary-chart">
                <div class="progress-info">
                    <div class="progress-name"><?= $c['contacto']; ?></div>
                    <div class="summar-value text-danger"><?= $c['cantidad_deuda']; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="summary-footer">
        <a href="<?= PATH . 'debtController/contactCreate'; ?>" class="link-muted">Añadir contacto</a>
    </div>
</section>
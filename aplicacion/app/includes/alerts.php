<?php if (isset($_SESSION['alert'])): ?>

    <div class="alert alert-<?= $_SESSION['alert']['type']; ?>">
        <?= $_SESSION['alert']['message']; ?>
    </div>

    <?php unset($_SESSION['alert']); ?>

<?php endif; ?>
<?php if ($response): ?>
    <div class="alert alert-<?= $response['type']; ?>">
        <?= $response['message']; ?>
    </div>
<?php endif; ?>

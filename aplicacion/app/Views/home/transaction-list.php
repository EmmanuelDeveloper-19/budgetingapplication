<?php if (empty($data['transactions'])): ?>
    <div class="empty-state">
        <p>No hay transacciones realizadas</p>
    </div>
<?php else: ?>
    <div class="transaction-list">
        <?php foreach ($data['transactions'] as $t): ?>
            <?php
                $isExpense = $t['amount'] < 0;
                $amountClass = $isExpense ? 'expense' : 'income';
                $sign = $isExpense ? '-' : '+';
            ?>
            <div class="transaction-card">
                <div class="transaction-info">
                    <p class="transaction-name"><?= htmlspecialchars($t['name']); ?></p>
                    <p class="transaction-description"><?= htmlspecialchars($t['description']); ?></p>
                </div>
                <span class="transaction-amount <?= $amountClass; ?>">
                    <?= $sign; ?>$<?= number_format(abs($t['amount']), 2); ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
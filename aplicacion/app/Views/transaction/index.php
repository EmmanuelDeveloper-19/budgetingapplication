<table class="table-transacciones">
    <caption>Reporte de transacciones</caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Monto</th>
            <th>Tipo</th>
            <th>Método de pago</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data['transactions'])): ?>
            <tr>
                <td colspan="6" class="empty-row">No hay transacciones registradas.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data['transactions'] as $i => $t): ?>
                <tr>
                    <td class="col-index"><?= $i + 1; ?></td>
                    <td><?= htmlspecialchars($t['name']); ?></td>
                    <td class="amount-col <?= $t['type'] === 'income' ? 'income' : 'expense'; ?>">
                        <?= $t['type'] === 'income' ? '+' : '-'; ?>$<?= number_format($t['amount'], 2); ?>
                    </td>
                    <td>
                        <span class="badge <?= $t['type'] === 'income' ? 'badge-success' : 'badge-error'; ?>">
                            <?= $t['type'] === 'income' ? 'Ingreso' : 'Gasto'; ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars(ucfirst($t['payment_method'])); ?></td>
                    <td><?= date('d/m/Y', strtotime($t['transaction_date'])); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
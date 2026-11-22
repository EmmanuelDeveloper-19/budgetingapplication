    <div class="row space-between">
    <div class="capsule">
        <p>Lista de deudas</p>
    </div>

    <a class="btn btn-primary" href="<?= PATH . 'debtController/debtCreate' ?>">
        Agregar deuda
    </a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Préstamo</th>
            <th>Monto</th>
            <th>Fecha de préstamo</th>
            <th>Límite</th>
            <th>Interés</th>
            <th>Estatus</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($data['debts'])): ?>
            <tr>
                <td colspan="8">No hay deudas aún.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data['debts'] as $d): ?>
                <tr>
                    <td><?= (int) $d['id'] ?></td>

                    <td><?= htmlspecialchars($d['contacto'] ?? '') ?></td>

                    <td>
                        $<?= number_format((float) $d['amount'], 2) ?>
                    </td>

                    <td><?= htmlspecialchars($d['debt_date'] ?? '') ?></td>

                    <td><?= htmlspecialchars($d['due_date'] ?? 'Sin límite') ?></td>

                    <td>
                        <?= $d['interest'] !== null
                            ? number_format((float) $d['interest'], 2) . '%'
                            : 'Sin interés' ?>
                    </td>

                    <td>
                        <div class="capsule <?= $d['status'] === 'PENDING' ? 'btn-warning' : 'btn-success'; ?>">
                            <?= htmlspecialchars($d['status'] === 'PENDING' ? 'Pendiente' : 'Pagado') ?>
                    </td>
                    </div>

                    <td>
                        <div class="row">
                            <!-- Pagar -->
                            <button type="button" class="btn btn-icon btn-primary" data-open-pay data-id="<?= (int) $d['id'] ?>"
                                data-contact="<?= htmlspecialchars($d['contacto'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-amount="<?= htmlspecialchars((string) $d['amount'], ENT_QUOTES, 'UTF-8') ?>"
                                aria-label="Pagar deuda">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </button>

                            <!-- Editar -->
                            <button type="button" class="btn btn-icon btn-secondary" data-open-edit
                                data-id="<?= (int) $d['id'] ?>"
                                data-contact="<?= htmlspecialchars($d['contacto'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-amount="<?= htmlspecialchars((string) $d['amount'], ENT_QUOTES, 'UTF-8') ?>"
                                data-debt-date="<?= htmlspecialchars($d['debt_date'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-due-date="<?= htmlspecialchars($d['due_date'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                data-interest="<?= htmlspecialchars((string) ($d['interest'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                data-status="<?= htmlspecialchars($d['status'] ?? 'PENDING', ENT_QUOTES, 'UTF-8') ?>"
                                aria-label="Editar deuda">
                                <i class="fa-solid fa-pencil"></i>
                            </button>

                            <!-- Eliminar -->
                            <button type="button" class="btn btn-icon btn-danger" data-open-delete
                                data-id="<?= (int) $d['id'] ?>"
                                data-contact="<?= htmlspecialchars($d['contacto'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                aria-label="Eliminar deuda">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<section class="summary-panel">
    <div class="summary-header">
        <div>
            <h2 class="summary-title">Tarjetas de credito</h2>
            <p class="summary-subtitle">
                Resumen de todas tus tarjetas
            </p>
        </div>

        <div class="summary-icon" aria-hidden="true">
            <i class="fa-solid fa-chart-column"></i>
        </div>
    </div>


    <?php
    $creditCards = $data['creditCards'] ?? [];

    $totalLimit = 0;
    $totalDebt = 0;

    foreach ($creditCards as $card) {
        $totalLimit += (float) $card['credit_limit'];
        $totalDebt += (float) $card['outstanding_balance'];
    }

    $totalAvailable = $totalLimit - $totalDebt;
    ?>

    <div class="summary-chart">

        <?php if (empty($creditCards)): ?>

            <p class="summary-empty">
                No tienes tarjetas de crédito registradas.
            </p>

        <?php else: ?>

            <?php foreach ($creditCards as $card): ?>

                <?php
                $limit = (float) $card['credit_limit'];
                $debt = (float) $card['outstanding_balance'];

                $available = $limit - $debt;

                $percentage = $limit > 0
                    ? ($debt / $limit) * 100
                    : 0;

                // Limitar la barra visual al rango 0-100.
                $barWidth = max(0, min(100, $percentage));
                ?>

                <div class="progress-item">

                    <div class="progress-info">

                        <span class="progress-name">
                            <?= htmlspecialchars($card['bank'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>

                        <span class="progress-amount">
                            <?= '$' . number_format($debt, 2); ?>
                            <span>
                                / <?= '$' . number_format($limit, 2); ?>
                            </span>
                        </span>

                    </div>

                    <div class="progress-track" role="progressbar"
                        aria-label="Utilización de crédito de <?= htmlspecialchars($card['bank'], ENT_QUOTES, 'UTF-8'); ?>"
                        aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= round($barWidth, 2); ?>">
                        <div class="progress-bar" style="width: <?= $barWidth; ?>%"></div>
                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <div class="summary-footer">

        <div class="summary-metric">
            <span class="summary-label">
                Deuda total
            </span>

            <strong class="summary-value">
                <?= '$' . number_format($totalDebt, 2); ?>
            </strong>
        </div>

        <div class="summary-metric">
            <span class="summary-label">
                Crédito disponible
            </span>

            <strong class="summary-value text-success">
                <?= '$' . number_format($totalAvailable, 2); ?>
            </strong>
        </div>
    </div>
    <div class="summary-footer">
        <a href="<?= PATH . 'creditCardController/index';?>" class="link-muted">Gestionar tarjetas</a>
    </div>

</section>
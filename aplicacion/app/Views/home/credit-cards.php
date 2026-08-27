<div class="content dr-none">
    <p class="texto-resaltado">Tarjetas de credito</p>

    <?php if (empty($data['creditCards'])): ?>
        <div class="empty-state">
            <p>No hay tarjetas de credito agregadas</p>
        </div>
    <?php else: ?>
        <?php
        $meses = [
            '01' => 'ene',
            '02' => 'feb',
            '03' => 'mar',
            '04' => 'abr',
            '05' => 'may',
            '06' => 'jun',
            '07' => 'jul',
            '08' => 'ago',
            '09' => 'sep',
            '10' => 'oct',
            '11' => 'nov',
            '12' => 'dic'
        ];
        function formatoCorto($fecha, $meses)
        {
            $partes = explode('-', $fecha); // YYYY-MM-DD
            return ((int) $partes[2]) . ' ' . $meses[$partes[1]];
        }
        ?>
        <?php foreach ($data['creditCards'] as $c): ?>
            <?php
            $saldo = $c['outstanding_balance'];
            $limite = $c['credit_limit'];
            $disponible = $limite - $saldo;
            $porcentaje = $limite > 0 ? round(($saldo / $limite) * 100) : 0;
            $porcentaje = max(0, min(100, $porcentaje));
            $nivelUso = $porcentaje >= 80 ? 'alto' : ($porcentaje >= 50 ? 'medio' : 'bajo');
            ?>
            <div class="lista-elementos">
                <div class="card-list">
                    <div class="list-header">
                        <div class="row">
                            <img class="img-icon" src="<?= PATH . 'assets/' . $c['bank'] . '.png'; ?>" alt="">
                            <strong><?= $c['bank']; ?></strong>
                        </div>
                        <div class="row">
                            <div class="menu-opciones">
                                <button class="menu-btn">⋮</button>
                                <div class="menu-dropdown">
                                    <a href="<?= PATH . 'creditCardController/editView/' . $c['id']; ?>">Editar</a>
                                    <a href="<?= PATH . 'creditCardController/eliminar/' . $c['id']; ?>"
                                        class="danger">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="list-body row">
                        <div class="column">
                            <span>Saldo</span>
                            <strong>$<?= number_format($saldo, 2); ?></strong>
                        </div>
                        <div class="column" style="text-align: right;">
                            <span>Disponible</span>
                            <strong>$<?= number_format($disponible, 2); ?></strong>
                        </div>
                    </div>
                    <div class="list-body row credit-dates">
                        <div class="column">
                            <span>Fecha corte</span>
                            <strong><?= formatoCorto($c['statement_closing_date'], $meses); ?></strong>
                        </div>
                        <div class="column" style="text-align: right;">
                            <span>Fecha pago</span>
                            <strong><?= formatoCorto($c['payment_date'], $meses); ?></strong>
                        </div>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="<?= PATH . 'creditCardController/nuevo'; ?>" class="btn btn-primary">Agregar tarjeta de credito</a>
</div>
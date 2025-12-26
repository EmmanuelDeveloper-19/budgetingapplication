
<div class="row">
    <div class="col-md-3">
        <div class="content">
            <div class="texto-resaltado">
                <p>Patrimonio neto</p>
            </div>
            <h1>$ <?= $data['user']['balance']; ?></h1>
        </div>

        <?php require_once("accounts.php"); ?>
        <?php require_once("credit-cards.php"); ?>
        <?php require_once("debit-cards.php"); ?>
    </div>
    <div class="col-md-9">
        <div class="content">
            <div class="row space-between">
                <div class="texto-resaltado">
                    <p>Transacciones</p>
                </div>
                <a href="" class="btn btn-secondary">
                    Agregar transacción
                </a>
            </div>
            <?php
            include("transaction-list.php"); ?>
        </div>
    </div>
</div>
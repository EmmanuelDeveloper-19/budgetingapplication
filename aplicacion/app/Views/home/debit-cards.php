
<div class="content">

    <p class="texto-resaltado">Tarjetas de débito</p>

    <?php if (empty($data['debitCards'])): ?>

        <div class="empty-state">
            <p>No hay tarjetas de débito agregadas</p>
        </div>

    <?php else: ?>

        <div class="credit-cards-list" id="debitCardsList">

            <?php foreach ($data['debitCards'] as $d): ?>

                <div
                    class="credit-card-item"
                    data-id="<?= htmlspecialchars($d['id']); ?>"
                    data-balance="<?= htmlspecialchars($d['balance']); ?>"
                >

                    <!-- Banco -->
                    <div class="card-bank">

                        <img
                            class="img-icon"
                            src="<?= PATH . 'assets/' . htmlspecialchars($d['bank']) . '.png'; ?>"
                            alt=""
                        >

                        <strong>
                            <?= htmlspecialchars(ucfirst($d['bank'])); ?>
                        </strong>

                    </div>


                    <!-- Balance -->
                    <div class="card-amounts">

                        <div class="amount debt">

                            <strong>
                                $<?= number_format($d['balance'], 2); ?>
                            </strong>

                        </div>

                    </div>


                    <!-- Menú -->
                    <div class="menu-opciones">

                        <button
                            type="button"
                            class="menu-btn"
                            data-no-modal
                        >
                            ⋮
                        </button>


                        <div class="menu-dropdown">

                            <!-- ABONAR -->
                            <a
                                href="#"
                                class="debit-abonar-btn"
                                data-id="<?= htmlspecialchars($d['id']); ?>"
                                data-balance="<?= htmlspecialchars($d['balance']); ?>"
                                data-no-modal
                            >
                                Abonar
                            </a>


                            <!-- EDITAR -->
                            <a
                                href="<?= PATH . 'debitCardController/editar/' . $d['id']; ?>"
                                data-no-modal
                            >
                                Editar
                            </a>


                            <!-- ELIMINAR -->
                            <a
                                href="<?= PATH . 'debitCardController/delete/' . $d['id']; ?>"
                                class="danger"
                                data-no-modal
                            >
                                Eliminar
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>


    <!-- AGREGAR TARJETA -->
    <a
        href="<?= PATH . 'debitCardController/nuevo'; ?>"
        class="link_add"
    >
        Añadir tarjeta de débito
    </a>

</div>


<!-- ========================================================= -->
<!-- MODAL PARA ABONAR DÉBITO -->
<!-- ========================================================= -->

<div
    class="modal"
    id="debitPaymentModal"
>

    <?php include(VIEWS . "components/modal/abonarTarjetaDebito.php"); ?>

</div>


<script>

const DEBIT_PATH_URL = "<?= PATH; ?>";

(function () {

    /*
    |--------------------------------------------------------------------------
    | ELEMENTOS
    |--------------------------------------------------------------------------
    */

    const debitCardsList =
        document.getElementById('debitCardsList');

    const debitPaymentModal =
        document.getElementById('debitPaymentModal');


    /*
    |--------------------------------------------------------------------------
    | ABRIR MODAL
    |--------------------------------------------------------------------------
    */

    function abrirModalDebito(button) {

        /*
        |----------------------------------------------------------
        | Obtener ID y balance directamente del botón
        |----------------------------------------------------------
        */

        const cardId =
            button.getAttribute('data-id');

        const balance =
            button.getAttribute('data-balance');


        console.log('Tarjeta seleccionada:', cardId);
        console.log('Balance:', balance);


        /*
        |----------------------------------------------------------
        | Buscar formulario
        |----------------------------------------------------------
        */

        const form =
            document.getElementById('abonarDebitoForm');


        if (!form) {

            console.error(
                'No existe el formulario #abonarDebitoForm'
            );

            return;
        }


        /*
        |----------------------------------------------------------
        | Buscar input de ID
        |----------------------------------------------------------
        */

        const cardIdInput =
            document.getElementById('debitCardId');


        if (!cardIdInput) {

            console.error(
                'No existe el input #debitCardId'
            );

            return;
        }


        /*
        |----------------------------------------------------------
        | Guardar ID de tarjeta
        |----------------------------------------------------------
        */

        cardIdInput.value = cardId;


        /*
        |----------------------------------------------------------
        | Guardar balance
        |----------------------------------------------------------
        */

        const balanceInput =
            document.getElementById('debitCardBalance');


        if (balanceInput) {

            balanceInput.value = balance;

        }


        /*
        |----------------------------------------------------------
        | Action
        |----------------------------------------------------------
        */

        form.action =
            DEBIT_PATH_URL +
            'debitCardController/abonarTarjeta/' + cardId;


        /*
        |----------------------------------------------------------
        | Mostrar modal
        |----------------------------------------------------------
        */

        debitPaymentModal.classList.add('active');

    }


    /*
    |--------------------------------------------------------------------------
    | CLICK EN LA LISTA
    |--------------------------------------------------------------------------
    */

    if (debitCardsList) {

        debitCardsList.addEventListener(
            'click',
            function (event) {

                const button =
                    event.target.closest(
                        '.debit-abonar-btn'
                    );


                /*
                |--------------------------------------------------
                | No fue click en "Abonar"
                |--------------------------------------------------
                */

                if (!button) {

                    return;

                }


                /*
                |--------------------------------------------------
                | Evitar href="#"
                |--------------------------------------------------
                */

                event.preventDefault();

                event.stopPropagation();


                /*
                |--------------------------------------------------
                | Abrir modal
                |--------------------------------------------------
                */

                abrirModalDebito(button);

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CERRAR MODAL
    |--------------------------------------------------------------------------
    */

    function cerrarModalDebito() {

        if (debitPaymentModal) {

            debitPaymentModal.classList.remove('active');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | CLICK FUERA DEL MODAL
    |--------------------------------------------------------------------------
    */

    if (debitPaymentModal) {

        debitPaymentModal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === debitPaymentModal
                ) {

                    cerrarModalDebito();

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | BOTÓN CERRAR DEL MODAL
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            /*
            |------------------------------------------------------
            | IMPORTANTE:
            | Solo buscamos el botón dentro del modal de débito.
            |------------------------------------------------------
            */

            const closeButton =
                event.target.closest(
                    '#debitPaymentModal .debit-modal-close'
                );


            if (closeButton) {

                cerrarModalDebito();

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                cerrarModalDebito();

            }

        }
    );


})();
</script>
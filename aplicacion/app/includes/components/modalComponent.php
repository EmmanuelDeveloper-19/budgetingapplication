<?php if (isset($_SESSION['modal'])): ?>
    <div class="modal">
        <div class="modal-body">
            <h1>Prueba de modal</h1>
        </div>
    </div>
    <?php unset($_SESSION['modal']); ?>
<?php endif; ?>
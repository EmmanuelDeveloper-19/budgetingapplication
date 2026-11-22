<div class="content">
    <div class="row">
        <div class="col-md-9">
            <div class="row space-between">
                <div>
                    <h1 class="text-primary">Hola Fatima, debes</h1>
                    <h1 class="text-primary">$<?= $data['total']; ?></h1>
                </div>
            </div>
            <?php include('debtList.php'); ?>
        </div>
        <div class="col-md-3">
            <?php include('creditCardDebts.php'); ?>
            <?php include('contactList.php'); ?>
        </div>
    </div>
</div>

<?php include('payDebt.php'); ?>
<?php include('editDebt.php'); ?>
<?php include('deleteDebt.php'); ?>
<?php include('successModal.php'); ?>
<script>

    document.addEventListener("DOMContentLoaded", () => {
        const payModal = document.getElementById("modal-pay");
        const editModal = document.getElementById("modal-edit");
        const deleteModal = document.getElementById("modal-delete");
        const successModal = document.getElementById("modal-success");

        const formatMoney = (amount) =>
            new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN"
            }).format(Number(amount) || 0);

        // Cerrar los modales desde cualquier botón correspondiente.
        document.querySelectorAll("[data-close-modal]").forEach((button) => {
            button.addEventListener("click", () => {
                button.closest("dialog")?.close();
            });
        });

        // Cerrar al hacer clic en el fondo.
        document.querySelectorAll(".app-modal").forEach((modal) => {
            modal.addEventListener("click", (event) => {
                if (event.target === modal) {
                    modal.close();
                }
            });
        });

        // 1. PAGAR DEUDA
        document.querySelectorAll("[data-open-pay]").forEach((button) => {
            button.addEventListener("click", () => {
                const { id, contact, amount } = button.dataset;

                document.getElementById("pay-debt-id").value = id;
                document.getElementById("pay-contact").textContent = contact;
                document.getElementById("pay-original-amount").textContent =
                    formatMoney(amount);

                const paymentInput = document.getElementById("pay-amount");
                paymentInput.value = "";
                paymentInput.max = amount;

                // Fecha local, sin posibles desfases por zona horaria.
                const now = new Date();
                const localDate = [
                    now.getFullYear(),
                    String(now.getMonth() + 1).padStart(2, "0"),
                    String(now.getDate()).padStart(2, "0")
                ].join("-");

                document.getElementById("pay-date").value = localDate;

                payModal.showModal();
            });
        });

        // 2. EDITAR DEUDA
        document.querySelectorAll("[data-open-edit]").forEach((button) => {
            button.addEventListener("click", () => {
                const d = button.dataset;

                document.getElementById("edit-debt-id").value = d.id;
                document.getElementById("edit-contact").value = d.contact;
                document.getElementById("edit-amount").value = d.amount;
                document.getElementById("edit-debt-date").value = d.debtDate;
                document.getElementById("edit-due-date").value = d.dueDate;
                document.getElementById("edit-interest").value = d.interest;
                document.getElementById("edit-status").value = d.status;

                editModal.showModal();
            });
        });

        // 3. ELIMINAR DEUDA
        document.querySelectorAll("[data-open-delete]").forEach((button) => {
            button.addEventListener("click", () => {
                document.getElementById("delete-debt-id").value =
                    button.dataset.id;

                document.getElementById("delete-contact").textContent =
                    button.dataset.contact;

                deleteModal.showModal();
            });
        });

        // 4. SUCCESS REUTILIZABLE
        window.showSuccess = (message, title = "Operación completada") => {
            document.getElementById("success-title").textContent = title;
            document.getElementById("success-message").textContent = message;

            if (!successModal.open) {
                successModal.showModal();
            }
        };
    });
</script>
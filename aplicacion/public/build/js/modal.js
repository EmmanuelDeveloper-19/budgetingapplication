
const Modal = (() => {
    const dialog = document.getElementById("app-modal");
    const title = document.getElementById("modal-title");
    const body = document.getElementById("modal-body");
    const confirmButton = document.getElementById("modal-confirm");

    let onConfirm = null;

    function open({
        title: modalTitle,
        content,
        confirmText = "Confirmar",
        onConfirm: callback = null
    }) {
        title.textContent = modalTitle;
        body.replaceChildren();

        // Acepta un elemento HTML o texto plano.
        if (content instanceof Node) {
            body.appendChild(content);
        } else {
            body.textContent = content ?? "";
        }

        confirmButton.textContent = confirmText;
        onConfirm = callback;

        if (!dialog.open) {
            dialog.showModal();
        }
    }

    function close() {
        if (dialog.open) {
            dialog.close();
        }
    }

    // Cerrar desde cualquier botón con data-modal-close.
    dialog.addEventListener("click", (event) => {
        if (event.target.closest("[data-modal-close]")) {
            close();
        }
    });

    // Cerrar al hacer clic fuera del cuadro.
    dialog.addEventListener("click", (event) => {
        if (event.target === dialog) {
            close();
        }
    });

    // Ejecutar la acción de confirmación.
    confirmButton.addEventListener("click", async () => {
        if (!onConfirm) {
            close();
            return;
        }

        confirmButton.disabled = true;

        try {
            const result = await onConfirm(body);

            // Si el callback devuelve false, mantiene abierto
            // el modal, por ejemplo, cuando hay un error.
            if (result !== false) {
                close();
            }
        } catch (error) {
            console.error("Error en el modal:", error);
        } finally {
            confirmButton.disabled = false;
        }
    });

    return { open, close };
})();

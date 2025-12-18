<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Prestamos App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="<?= PATH . 'build/css/login.css?v=' . rand(0, 999999) ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title h3">Registro de Usuario</h1>

                <?php if (isset($data['error']) && $data['error']): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($data['error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= PATH ?>login/register" id="registerForm">
                    <input type="hidden" name="type" value="register">

                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario:</label>
                        <input type="text" id="username" name="username" class="form-control"
                            placeholder="Ingresa tu nombre de usuario" required minlength="3" autocomplete="username">
                        <small class="form-text text-muted">Mínimo 3 caracteres</small>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <div class="password">
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="Ingresa tu contraseña" required minlength="6" autocomplete="new-password">

                            <button id="toggle-password" class="eye-button" type="button" title="Mostrar Contraseña"
                                onclick="togglePassword('password', 'toggle-icon')">
                                <i id="toggle-icon" class="fa fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted">Mínimo 6 caracteres</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmar Contraseña:</label>
                        <div class="password">
                            <input id="password_confirm" name="password_confirm" type="password" class="form-control"
                                placeholder="Confirma tu contraseña" required minlength="6" autocomplete="new-password">

                            <button id="toggle-password-confirm" class="eye-button" type="button"
                                title="Mostrar Contraseña"
                                onclick="togglePassword('password_confirm', 'toggle-icon-confirm')">
                                <i id="toggle-icon-confirm" class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="column">
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                        <a href="<?= PATH ?>login">¿Ya tienes cuenta? Iniciar sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Ohx3xPnY4n4x9C8qd57U48xOjz4M1pR+TIhVzI6vZj1w0KN/TfgCQjpKlRqTw2kS"
        crossorigin="anonymous"></script>

    <script>
        function togglePassword(inputId, iconId) {
            const passInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const button = icon.parentElement;

            // Cambiar el tipo (password <-> text)
            if (passInput.type === "password") {
                passInput.type = "text";
                button.title = "Ocultar Contraseña";
            } else {
                passInput.type = "password";
                button.title = "Mostrar Contraseña";
            }

            // Cambiar el icono del ojo
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }

        // Validar que las contraseñas coincidan antes de enviar
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirm').value;

            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden. Por favor, verifica e intenta de nuevo.');
                return false;
            }
        });
    </script>
</body>

</html>
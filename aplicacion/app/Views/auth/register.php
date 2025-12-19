<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Prestamos App</title>
    <link href="<?= PATH . 'build/css/login.css?v=' . rand(0, 999999) ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1 class="login-title">Registro de Usuario</h1>
        </div>
        <?php if (isset($data['error']) && $data['error']): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($data['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= PATH ?>login/register" id="registerForm" class="login-form">
            <input type="hidden" name="type" value="register">

            <div class="form-group">
                <label for="username" class="form-label">Usuario:</label>
                <input type="text" id="username" name="username" class="form-control"
                    placeholder="Ingresa tu nombre de usuario" required minlength="3" autocomplete="username">
                <small class="form-text text-muted">Mínimo 3 caracteres</small>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <div class="password-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••"
                        required autocomplete="current-password">
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>

            <div class="login-links">
                <a href="<?= PATH ?>login" class="login-link">¿Ya tienes cuenta? Iniciar sesión</a>
            </div>
        </form>

    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Ohx3xPnY4n4x9C8qd57U48xOjz4M1pR+TIhVzI6vZj1w0KN/TfgCQjpKlRqTw2kS"
        crossorigin="anonymous"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.toggle-password i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        // Enfocar automáticamente el primer input
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('username').focus();
        });
    </script>
</body>

</html>
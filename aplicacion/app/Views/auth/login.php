<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - BudgetingApp</title>
    <link rel="stylesheet" href="<?= PATH . 'build/css/custom.css?v=' . rand(0, 999999) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-login">
        <div class="card glass-panel card-sm">
            <h1 class="heading-text">Iniciar Sesión</h1>
            <p class="glass-subtext">Bienvenido de vuelta</p>

            <?php if (isset($data['error']) && $data['error']): ?>
                <div class="glass-alert">
                    <?= htmlspecialchars($data['error']) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= PATH ?>login">
                <input type="hidden" name="type" value="login">

                <div class="field-group">
                    <label for="username" class="field-label">Usuario</label>
                    <input type="text" id="username" name="username" class="field-control"
                        placeholder="usuario@ejemplo.com" required autocomplete="username">
                </div>

                <div class="field-group">
                    <label for="password" class="field-label">Contraseña</label>
                    <div class="field-control-wrap">
                        <input type="password" id="password" name="password" class="field-control"
                            placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="field-icon-btn" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="field-group">
                    <button type="submit" class="btn btn-primary w100">
                        Ingresar
                    </button>
                </div>

                <div class="link-row">
                    <a href="<?= PATH ?>login/register" class="link-muted">
                        ¿No tienes cuenta? Regístrate
                    </a>
                    <a href="#" class="link-muted">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </form>
        </div>
    </div>

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
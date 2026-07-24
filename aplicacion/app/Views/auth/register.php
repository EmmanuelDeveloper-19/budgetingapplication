<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Prestamos App</title>
    <link href="<?= PATH . 'build/css/login.css?v=' . rand(0, 999999) ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        <form method="POST" action="<?= PATH . 'login/register' ?>" id="registerForm" class="login-form">
            <input type="hidden" name="type" value="register">

            <div class="form-group">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" id="name" name="name" class="form-control"
                    placeholder="Ingresa tu nombre" required autocomplete="given-name">
            </div>

            <div class="form-group">
                <label for="last_name" class="form-label">Apellido:</label>
                <input type="text" id="last_name" name="last_name" class="form-control"
                    placeholder="Ingresa tu apellido" required autocomplete="family-name">
            </div>

            <div class="form-group">
                <label for="username" class="form-label">Usuario / Correo:</label>
                <input type="text" id="username" name="username" class="form-control"
                    placeholder="Ingresa tu usuario o email" required minlength="3" autocomplete="username">
                <small class="form-text text-muted">Mínimo 3 caracteres</small>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <div class="password-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••"
                        required autocomplete="new-password">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

        // Enfocar automáticamente el primer input (Nombre)
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('name').focus();
        });
    </script>
</body>

</html>
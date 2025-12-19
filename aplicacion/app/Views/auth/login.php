<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - BudgetingApp</title>
    <link rel="stylesheet" href="<?= PATH . 'build/css/login.css?v=' . rand(0, 999999) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1 class="login-title">Iniciar Sesión</h1>
            <p class="login-subtitle">Bienvenido de vuelta</p>
        </div>

        <?php if (isset($data['error']) && $data['error']): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($data['error']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= PATH ?>login" class="login-form">
            <input type="hidden" name="type" value="login">
            
            <div class="form-group">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       class="form-control"
                       placeholder="usuario@ejemplo.com"
                       required 
                       autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <div class="password-group">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control"
                           placeholder="••••••••"
                           required 
                           autocomplete="current-password">
                    <button type="button" 
                            class="toggle-password" 
                            onclick="togglePassword()">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Ingresar
            </button>

            <div class="login-links">
                <a href="<?= PATH ?>login/register" class="login-link">
                    ¿No tienes cuenta? Regístrate
                </a>
                <a href="#" class="login-link">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
        </form>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });
    </script>
</body>
</html>
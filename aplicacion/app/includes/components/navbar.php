<nav class="navbar">
    <div class="logo">
        <a href="<?= PATH . 'home/index';?>">Mirry's Money</a>
    </div>

    <!-- Menú que se ocultará/desplegará en móvil -->
    <div class="nav-elements" id="nav-elements">
        <ul>
            <li>
                <a href="<?= PATH . 'home/index'; ?>">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
            </li>
            <li>
                <a href="<?= PATH . 'transactionController/index';?>">
                    <i class="fas fa-money-bill-transfer"></i>
                    Transacciones
                </a>
            </li>
            <li>
                <a href="<?= PATH . 'debtController/index';?>">
                    <i class="fas fa-file-invoice-dollar"></i>
                    Deudas
                </a>
            </li>
            <li>
                <a href="<?= PATH . 'wishlistController/index';?>">
                    <i class="fas fa-gift"></i>
                    Lista de deseos
                </a>
            </li>
            <li>
                <a href="<?= PATH . 'userprofilecontroller/index'; ?>" class="dr-display-none">Información del Perfil</a>
            </li>
        </ul>
    </div>

    <div class="nav-account">
        <a href="<?= PATH . 'userprofilecontroller/index'; ?>" class="btn-account">
            <i class="fas fa-user"></i>
            Cuenta
        </a>
    </div>

    <!-- Botón hamburguesa -->
    <button type="button" class="btn-icon" id="menu-toggle" aria-label="Abrir menú">
        <i class="fa fa-bars"></i>
    </button>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const navElements = document.getElementById('nav-elements');
        const menuIcon = menuToggle.querySelector('i');

        menuToggle.addEventListener('click', () => {
            // Alterna la clase 'active' que muestra el menú en CSS
            navElements.classList.toggle('active');

            // Opcional: Cambia el icono de barras (☰) a una tachuca (✕) al abrir
            if (navElements.classList.contains('active')) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            } else {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        });
    });
</script>
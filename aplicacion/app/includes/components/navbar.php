<nav class="navbar">
    <div class="logo">
        <a href="#">BudgetingApp</a>
    </div>

    <!-- Menú que se ocultará/desplegará en móvil -->
    <div class="nav-elements" id="nav-elements">
        <ul>
            <li> <a href="<?= PATH . 'home/index'; ?>">Inicio</a></li>
            <li><a href="#">Transacciones</a></li>
            <li><a href="#">Balance Mensual</a></li>
            <li><a href="#">Lista de deseos</a></li>
            <li>
                <a href="<?= PATH . 'userprofilecontroller/index'; ?>" class="dr-display-none">Información del Perfil</a>
            </li>
        </ul>
    </div>

    <div class="nav-account">
        <a href="<?= PATH . 'userprofilecontroller/index'; ?>" class="btn-account">Cuenta</a>
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
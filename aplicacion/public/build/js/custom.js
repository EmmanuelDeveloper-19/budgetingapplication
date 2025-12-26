document.addEventListener('click', function (e) {
    const menus = document.querySelectorAll('.menu-opciones');

    menus.forEach(menu => {
        const btn = menu.querySelector('.menu-btn');

        if (btn.contains(e.target)) {
            // Cerrar otros menús
            menus.forEach(m => m !== menu && m.classList.remove('active'));
            // Toggle actual
            menu.classList.toggle('active');
        } else if (!menu.contains(e.target)) {
            menu.classList.remove('active');
        }
    });
});
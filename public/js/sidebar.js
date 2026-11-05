document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');

    if (!sidebar) {
        return;
    }

    // El menú permanece oculto y se muestra automáticamente
    // cuando el mouse entra en la zona lateral.
    sidebar.classList.add('collapsed');
    document.body.classList.add('sidebar-collapsed');

    // Menú desplegable: Registro
    const registroToggle = document.getElementById('registroDropdownToggle');
    const registroDropdown = document.querySelector('.registro-dropdown');

    if (registroToggle && registroDropdown) {
        registroToggle.addEventListener('click', function () {
            const abierto = registroDropdown.classList.toggle('open');
            registroToggle.setAttribute('aria-expanded', abierto ? 'true' : 'false');
        });
    }

});

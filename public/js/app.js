document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       AYUDA CONTEXTUAL
    ========================================================= */
    const helpButton = document.getElementById('help-floating-button');
    const helpPanel = document.getElementById('help-panel');
    const helpClose = document.getElementById('help-close');
    const helpCurrent = document.getElementById('help-current');
    const helpSectionList = document.getElementById('help-section-list');

    const helpData = {
        dashboard: {
            label: 'Dashboard',
            icon: 'fa-house',
            steps: [
                'Consulta el resumen general de NutriControl.',
                'Revisa las gráficas y estadísticas de las entregas.',
                'Usa esta pantalla como punto de partida para acceder a los demás módulos.'
            ]
        },
        registro: {
            label: 'Registro',
            icon: 'fa-camera',
            steps: [
                'Usa Registro llegada para registrar la recepción de refrigerios.',
                'Usa Cierre del día para dejar constancia del cierre de la jornada.',
                'Revisa el historial de registros para consultar movimientos anteriores.'
            ]
        },
        refrigerios: {
            label: 'Refrigerios',
            icon: 'fa-utensils',
            steps: [
                'Crea y consulta los refrigerios disponibles.',
                'Registra cantidad, stock mínimo y fecha de vencimiento.',
                'Edita la información cuando sea necesario y elimina registros que ya no utilices.'
            ]
        },
        entregas: {
            label: 'Entregas',
            icon: 'fa-clipboard-check',
            steps: [
                'Registra cada entrega de refrigerios realizada.',
                'Consulta el historial y el detalle de las entregas.',
                'Verifica la fecha, hora, refrigerio y cantidad registrada.'
            ]
        },
        reportes: {
            label: 'Reportes',
            icon: 'fa-chart-column',
            steps: [
                'Consulta las estadísticas generales del sistema.',
                'Revisa las últimas entregas, el bajo stock y los próximos vencimientos.',
                'Usa Exportar PDF para guardar o imprimir el reporte.'
            ]
        },
        usuarios: {
            label: 'Usuarios',
            icon: 'fa-users',
            steps: [
                'Consulta los usuarios registrados en el sistema.',
                'Crea, edita y consulta usuarios según tus permisos.',
                'Antes de eliminar un usuario, revisa que realmente ya no necesites su cuenta.'
            ]
        },
        importante: {
            label: 'IMPORTANTE',
            icon: 'fa-circle-exclamation',
            steps: [
                'Consulta la información general definida por la administración.',
                'Revisa el refrigerio del día y el horario de entrega.',
                'Lee el mensaje o aviso publicado para los usuarios.'
            ]
        },
        configuracion: {
            label: 'Configuración',
            icon: 'fa-gear',
            steps: [
                'Configura los datos generales de NutriControl.',
                'Actualiza la información institucional y los datos mostrados en el sistema.',
                'Guarda los cambios antes de salir de la página.'
            ]
        },
        nosotros: {
            label: '¿Quiénes Somos?',
            icon: 'fa-circle-info',
            steps: [
                'Conoce el propósito de NutriControl.',
                'Consulta la información del proyecto y de la institución.',
                'Utiliza esta sección como presentación general del sistema.'
            ]
        },
        contacto: {
            label: 'Información de contacto',
            icon: 'fa-address-book',
            steps: [
                'Consulta los medios oficiales de contacto.',
                'Usa los datos publicados para solicitar información o soporte.',
                'Verifica que estés utilizando los canales indicados por la institución.'
            ]
        },
        perfil: {
            label: 'Mi perfil',
            icon: 'fa-user',
            steps: [
                'Consulta tu información personal y tu cuenta.',
                'Actualiza los datos permitidos por el sistema.',
                'Utiliza el menú de usuario para cerrar sesión cuando termines.'
            ]
        }
    };

    const sectionOrder = [
        'dashboard',
        'registro',
        'refrigerios',
        'entregas',
        'reportes',
        'usuarios',
        'importante',
        'configuracion',
        'nosotros',
        'contacto'
    ];

    function getCurrentSection() {
        const raw = new URLSearchParams(window.location.search).get('url') || 'dashboard';
        const normalized = raw.toLowerCase().replace(/^\//, '');

        if (normalized.startsWith('registro/')) return 'registro';
        if (normalized.startsWith('auth/')) return 'dashboard';
        if (normalized.startsWith('perfil')) return 'perfil';

        const first = normalized.split('/')[0];
        return helpData[first] ? first : 'dashboard';
    }

    function renderHelp(sectionKey) {
        if (!helpCurrent || !helpSectionList) return;

        const current = helpData[sectionKey] || helpData.dashboard;

        helpCurrent.innerHTML = `
            <h4><i class="fa-solid ${current.icon}"></i> ${current.label}</h4>
            <ul>${current.steps.map(step => `<li>${step}</li>`).join('')}</ul>
        `;

        helpSectionList.innerHTML = sectionOrder.map(key => {
            const item = helpData[key];
            return `
                <button type="button" class="help-section-button ${key === sectionKey ? 'active' : ''}" data-help-section="${key}">
                    <i class="fa-solid ${item.icon}"></i>
                    <span>${item.label}</span>
                </button>
            `;
        }).join('');

        helpSectionList.querySelectorAll('[data-help-section]').forEach(button => {
            button.addEventListener('click', function () {
                renderHelp(this.dataset.helpSection);
            });
        });
    }

    if (helpButton && helpPanel) {
        const currentSection = getCurrentSection();
        renderHelp(currentSection);

        helpButton.addEventListener('click', function (event) {
            event.stopPropagation();
            const open = helpPanel.classList.toggle('open');
            helpButton.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        if (helpClose) {
            helpClose.addEventListener('click', function () {
                helpPanel.classList.remove('open');
                helpButton.setAttribute('aria-expanded', 'false');
            });
        }

        helpPanel.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        document.addEventListener('click', function () {
            helpPanel.classList.remove('open');
            helpButton.setAttribute('aria-expanded', 'false');
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                helpPanel.classList.remove('open');
                helpButton.setAttribute('aria-expanded', 'false');
            }
        });
    }

    /* =========================================================
       CONFIRMACIÓN PERSONALIZADA DE ELIMINACIÓN
    ========================================================= */
    const deleteBackdrop = document.getElementById('delete-modal-backdrop');
    const deleteMessage = document.getElementById('delete-modal-message');
    const deleteCancel = document.getElementById('delete-cancel');
    const deleteConfirm = document.getElementById('delete-confirm');
    let pendingDeleteUrl = null;

    const deleteMessages = {
        'Eliminar entrega': 'Vas a eliminar esta entrega. Esta acción no se puede deshacer.',
        'Eliminar registro': 'Vas a eliminar este registro. Esta acción no se puede deshacer.',
        'Eliminar cierre': 'Vas a eliminar este cierre del día. Esta acción no se puede deshacer.',
        'Eliminar usuario': 'Vas a eliminar este usuario. Esta acción no se puede deshacer.',
        'Eliminar refrigerio': 'Vas a eliminar este refrigerio. Esta acción no se puede deshacer.'
    };

    function closeDeleteModal() {
        if (!deleteBackdrop) return;
        deleteBackdrop.classList.remove('open');
        deleteBackdrop.setAttribute('aria-hidden', 'true');
        pendingDeleteUrl = null;
    }

    document.querySelectorAll('a[href*="/eliminar/"]').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            pendingDeleteUrl = this.href;

            const title = this.getAttribute('title') || 'Eliminar registro';
            if (deleteMessage) {
                deleteMessage.textContent = deleteMessages[title] || 'Esta acción no se puede deshacer. ¿Deseas continuar?';
            }

            if (deleteBackdrop) {
                deleteBackdrop.classList.add('open');
                deleteBackdrop.setAttribute('aria-hidden', 'false');
            }
        });
    });

    if (deleteCancel) {
        deleteCancel.addEventListener('click', closeDeleteModal);
    }

    if (deleteConfirm) {
        deleteConfirm.addEventListener('click', function () {
            if (pendingDeleteUrl) {
                window.location.href = pendingDeleteUrl;
            }
        });
    }

    if (deleteBackdrop) {
        deleteBackdrop.addEventListener('click', function (event) {
            if (event.target === deleteBackdrop) {
                closeDeleteModal();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
});

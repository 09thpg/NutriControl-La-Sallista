function actualizarFechaHora() {

    const ahora = new Date();

    const opciones = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };

    const elemento = document.getElementById('fechaHora');

    if (elemento) {

        elemento.innerHTML =
            ahora.toLocaleDateString('es-CO', opciones);

    }

}

actualizarFechaHora();

setInterval(actualizarFechaHora, 1000);

document.addEventListener('DOMContentLoaded', function () {

    const welcomeScreen = document.getElementById('welcomeScreen');

    if (!welcomeScreen) {
        return;
    }

    setTimeout(function () {

        welcomeScreen.classList.add('hide');

        setTimeout(function () {

            welcomeScreen.remove();

        }, 700);

    }, 2500);

});

/* =========================================
   GRÁFICAS DEL DASHBOARD
========================================= */

document.addEventListener('DOMContentLoaded', function () {

    if (typeof Chart === 'undefined' || typeof window.dashboardChartData === 'undefined') {
        return;
    }

    const datos = window.dashboardChartData;

    const etiquetasDias = [];
    const valoresDias = [];

    const hoy = new Date();

    for (let i = 6; i >= 0; i--) {
        const fecha = new Date(hoy);
        fecha.setDate(hoy.getDate() - i);

        const yyyy = fecha.getFullYear();
        const mm = String(fecha.getMonth() + 1).padStart(2, '0');
        const dd = String(fecha.getDate()).padStart(2, '0');
        const clave = `${yyyy}-${mm}-${dd}`;

        const registro = (datos.entregas || []).find(item => item.dia === clave);

        etiquetasDias.push(
            fecha.toLocaleDateString('es-CO', {
                weekday: 'short',
                day: '2-digit'
            })
        );

        valoresDias.push(
            registro ? Number(registro.total) : 0
        );
    }

    const canvasSemana = document.getElementById('entregasSemanaChart');

    if (canvasSemana) {
        new Chart(canvasSemana, {
            type: 'bar',
            data: {
                labels: etiquetasDias,
                datasets: [{
                    label: 'Refrigerios entregados',
                    data: valoresDias,
                    backgroundColor: 'rgba(37, 99, 235, 0.75)',
                    borderColor: '#2563eb',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#cbd5e1'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#94a3b8' },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#94a3b8',
                            precision: 0
                        },
                        grid: {
                            color: 'rgba(148, 163, 184, 0.12)'
                        }
                    }
                }
            }
        });
    }

    const canvasRefrigerios = document.getElementById('refrigeriosChart');

    if (canvasRefrigerios) {
        const nombres = (datos.refrigerios || []).map(item => item.nombre);
        const cantidades = (datos.refrigerios || []).map(item => Number(item.total));

        if (nombres.length === 0) {
            const contenedor = canvasRefrigerios.parentElement;
            contenedor.innerHTML = '<div class="chart-empty">Aún no hay entregas suficientes para mostrar esta gráfica.</div>';
            return;
        }

        new Chart(canvasRefrigerios, {
            type: 'doughnut',
            data: {
                labels: nombres,
                datasets: [{
                    data: cantidades,
                    backgroundColor: [
                        '#2563eb',
                        '#16a34a',
                        '#f59e0b',
                        '#06b6d4',
                        '#9333ea'
                    ],
                    borderColor: '#1e293b',
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#cbd5e1',
                            padding: 18,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }
});

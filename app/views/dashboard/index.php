<?php

$titulo = 'Dashboard';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content fade-in">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<?php if (!empty($_SESSION['mostrar_bienvenida'])): ?>

<div id="welcomeScreen" class="welcome-screen">

    <div class="welcome-content">

        <div class="welcome-icon">
            <i class="fa-solid fa-hand-wave"></i>
        </div>

        <h1>
            Hola,
            <span><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></span>
        </h1>

        <p>
            Bienvenido a
            <strong>NutriControl La Sallista</strong>
        </p>

        <div class="welcome-loader">
            <div></div>
        </div>

    </div>

</div>

<?php unset($_SESSION['mostrar_bienvenida']); ?>

<?php endif; ?>


<!-- =========================================
     TARJETAS PRINCIPALES
========================================= -->

<div class="dashboard-grid">

    <div class="dashboard-card">

        <i class="fa-solid fa-users"></i>

        <h3>Administradores</h3>

        <span>
            <?= $totalAdministradores ?>
        </span>

    </div>


    <div class="dashboard-card">

    <i class="fa-solid fa-user"></i>

    <h3>Supervisores</h3>

    <span>
        <?= $totalSupervisores ?>
    </span>

</div>


    <div class="dashboard-card">

        <i class="fa-solid fa-utensils"></i>

        <h3>Refrigerios</h3>

        <span>
            <?= $totalRefrigerios ?>
        </span>

    </div>


    <div class="dashboard-card">

        <i class="fa-solid fa-clipboard-check"></i>

        <h3>Entregas</h3>

        <span>
            <?= $totalEntregas ?>
        </span>

    </div>


</div>


<!-- =========================================
     GRÁFICAS DEL DASHBOARD
========================================= -->

<div class="dashboard-charts">

    <section class="dashboard-chart-card">

        <div class="dashboard-chart-header">
            <div>
                <h4>
                    <i class="fa-solid fa-chart-column"></i>
                    Entregas de los últimos 7 días
                </h4>
                <p>Consulta cuántos refrigerios se han entregado por día.</p>
            </div>
        </div>

        <div class="chart-wrapper">
            <canvas id="entregasSemanaChart"></canvas>
        </div>

    </section>


    <section class="dashboard-chart-card">

        <div class="dashboard-chart-header">
            <div>
                <h4>
                    <i class="fa-solid fa-chart-pie"></i>
                    Refrigerios más entregados
                </h4>
                <p>Los refrigerios con mayor cantidad de entregas registradas.</p>
            </div>
        </div>

        <div class="chart-wrapper chart-wrapper-doughnut">
            <canvas id="refrigeriosChart"></canvas>
        </div>

    </section>

</div>

<script>
window.dashboardChartData = <?= json_encode([
    'entregas' => $entregasUltimos7Dias ?? [],
    'refrigerios' => $refrigeriosMasEntregados ?? []
], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
</script>

<!-- =========================================
     CONTENIDO DEL DASHBOARD
========================================= -->

<div class="dashboard-sections">


    <!-- =====================================
         ADMINISTRADORES
    ====================================== -->

    <section class="dashboard-section dashboard-admins">

        <div class="table-container">

            <div class="dashboard-section-title">

                <h4>
                    Últimos Administradores
                </h4>

            </div>


            <div class="dashboard-table-wrapper">

                <table class="dashboard-table">

                    <thead>

                        <tr>

                            <th>Nombre</th>

                            <th>Usuario</th>

                            <th>Correo</th>

                            <th>Rol</th>

                            <th>Registro</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if (!empty($administradoresRecientes)): ?>

                        <?php foreach ($administradoresRecientes as $u): ?>

                            <tr>

                                <td>

                                    <?= htmlspecialchars(
                                        trim(
                                            ($u['nombre'] ?? '') . ' ' .
                                            ($u['apellido'] ?? '')
                                        )
                                    ) ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $u['usuario'] ?? ''
                                    ) ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $u['correo'] ?? ''
                                    ) ?>

                                </td>


                                <td>

                                    <span class="badge administrador">

                                        Administrador

                                    </span>

                                </td>


                                <td>

                                    <?php if (!empty($u['fecha_registro'])): ?>

                                        <?= date(
                                            'd/m/Y',
                                            strtotime($u['fecha_registro'])
                                        ) ?>

                                    <?php else: ?>

                                        -

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5">

                                No hay administradores registrados.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </section>


    <!-- =====================================
         ÚLTIMAS ENTREGAS
    ====================================== -->

    <section class="dashboard-section dashboard-deliveries">

        <div class="table-container">

            <div class="dashboard-section-title">

                <h4>
                    Últimas Entregas
                </h4>

            </div>


            <div class="dashboard-table-wrapper">

                <table class="dashboard-table">

                    <thead>

                        <tr>

                            <th>Fecha</th>

                            <th>Hora</th>

                            <th>Estudiante</th>

                            <th>Refrigerio</th>

                            <th>Entregado por</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if (!empty($entregasRecientes)): ?>

                        <?php foreach ($entregasRecientes as $entrega): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars(
                                        $entrega['fecha'] ?? ''
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $entrega['hora'] ?? ''
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $entrega['estudiante'] ?? ''
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $entrega['refrigerio'] ?? ''
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $entrega['usuario'] ?? ''
                                    ) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5">

                                No hay entregas registradas.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </section>


</div>

</div>


<?php

require APP_PATH . '/views/layouts/footer.php';

?>
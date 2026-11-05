<?php

$titulo = 'IMPORTANTE';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<link rel="stylesheet" href="<?= BASE_URL ?>public/css/importante.css">

<div class="main-content fade-in">

    <?php require APP_PATH . '/views/layouts/topbar.php'; ?>

    <div class="important-page">

        <div class="important-title">

            <div>
                <span class="important-label">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    INFORMACIÓN
                </span>

                <h1>IMPORTANTE</h1>

                <p>
                    Información importante de NutriControl La Sallista.
                </p>
            </div>

        </div>

        <div class="important-container">

            <div class="important-header">

                <div class="important-header-icon">
                    <i class="fa-solid fa-circle-info"></i>
                </div>

                <div class="important-header-text">

                    <h2>Información para estudiantes</h2>

                    <p>
                        Consulta aquí la información establecida por los administradores.
                    </p>

                </div>

            </div>

            <div class="important-grid">

                <div class="important-card">

                    <div class="important-card-icon">
                        <i class="fa-solid fa-school"></i>
                    </div>

                    <div class="important-card-content">

                        <span>Nombre del sistema</span>

                        <h3>
                            <?= htmlspecialchars(
                                $configuracion['nombre_sistema'] ?? 'No disponible'
                            ) ?>
                        </h3>

                    </div>

                </div>

                <div class="important-card">

                    <div class="important-card-icon">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>

                    <div class="important-card-content">

                        <span>Institución</span>

                        <h3>
                            <?= htmlspecialchars(
                                $configuracion['nombre_institucion'] ?? 'No disponible'
                            ) ?>
                        </h3>

                    </div>

                </div>

                <div class="important-card">

                    <div class="important-card-icon">
                        <i class="fa-solid fa-utensils"></i>
                    </div>

                    <div class="important-card-content">

                        <span>Refrigerio del día</span>

                        <h3>
                            <?= htmlspecialchars(
                                $configuracion['refrigerio_dia'] ?? 'Sin asignar'
                            ) ?>
                        </h3>

                    </div>

                </div>

                <div class="important-card">

                    <div class="important-card-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div class="important-card-content">

                        <span>Horario de entrega</span>

                        <h3>
                            <?= htmlspecialchars(
                                $configuracion['horario_entrega'] ?? 'No establecido'
                            ) ?>
                        </h3>

                    </div>

                </div>

            </div>

            <div class="important-message">

                <div class="important-message-icon">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>

                <div class="important-message-content">

                    <span>Mensaje de la administración</span>

                    <p>
                        <?= nl2br(htmlspecialchars(
                            $configuracion['mensaje_inicio']
                            ?? 'No hay ningún mensaje disponible.'
                        )) ?>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
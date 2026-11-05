<?php

$titulo = 'Modo mantenimiento';
$activo = (bool) ($estado['activo'] ?? false);
$mensaje = $estado['mensaje'] ?? 'NutriControl se encuentra temporalmente en mantenimiento.';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content maintenance-page">

    <?php require APP_PATH . '/views/layouts/topbar.php'; ?>

    <div class="page-header">
        <div>
            <span class="maintenance-label">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                ADMINISTRACIÓN
            </span>
            <h2>Modo mantenimiento</h2>
            <p>Controla temporalmente el acceso al sistema mientras se realizan ajustes.</p>
        </div>
    </div>

    <div class="maintenance-card">
        <div class="maintenance-icon <?= $activo ? 'is-active' : 'is-inactive' ?>">
            <i class="fa-solid <?= $activo ? 'fa-lock' : 'fa-lock-open' ?>"></i>
        </div>

        <div class="maintenance-content">
            <h3>
                <?= $activo ? 'El modo mantenimiento está ACTIVADO' : 'El modo mantenimiento está DESACTIVADO' ?>
            </h3>

            <p>
                <?= $activo
                    ? 'Los usuarios que no sean Super Administradores no podrán acceder al sistema mientras permanezca activo.'
                    : 'El sistema está disponible normalmente para los usuarios autorizados.' ?>
            </p>
        </div>
    </div>

    <?php if ($esSuperAdministrador): ?>
        <div class="form-card maintenance-form-card">
            <form action="<?= BASE_URL ?>index.php?url=mantenimiento/guardar" method="POST">

                <div class="mb-4">
                    <label class="form-label">Estado del sistema</label>

                    <div class="maintenance-switch-row">
                        <label class="maintenance-switch">
                            <input
                                type="checkbox"
                                name="activo"
                                value="1"
                                <?= $activo ? 'checked' : '' ?>
                            >
                            <span class="maintenance-slider"></span>
                        </label>

                        <div>
                            <strong><?= $activo ? 'Mantenimiento activo' : 'Sistema operativo' ?></strong>
                            <small>
                                <?= $activo
                                    ? 'Solo los Super Administradores podrán continuar utilizando el sistema.'
                                    : 'Los usuarios autorizados pueden utilizar NutriControl normalmente.' ?>
                            </small>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="mensaje">Mensaje para los usuarios</label>
                    <textarea
                        id="mensaje"
                        name="mensaje"
                        class="form-control"
                        rows="4"
                        maxlength="500"
                        placeholder="Ejemplo: Estamos realizando una actualización del sistema. Intenta nuevamente más tarde."
                    ><?= htmlspecialchars($mensaje) ?></textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar estado
                </button>
            </form>
        </div>
    <?php else: ?>
        <div class="maintenance-user-message">
            <i class="fa-solid fa-circle-info"></i>
            <div>
                <strong>Acceso temporalmente restringido</strong>
                <p>El sistema está en modo mantenimiento. Intenta nuevamente cuando la administración finalice el mantenimiento.</p>
            </div>
        </div>
    <?php endif; ?>


</div>

<?php require APP_PATH . '/views/layouts/footer.php'; ?>

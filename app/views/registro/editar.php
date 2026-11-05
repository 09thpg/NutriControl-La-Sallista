<?php

$titulo = 'Editar registro';
$rolUsuario = $_SESSION['usuario']['rol'] ?? '';
$tipoRegistro = $registro['tipo'] ?? 'llegada';
$esCierre = $tipoRegistro === 'cierre';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

$fechaValor = !empty($registro['fecha']) ? date('Y-m-d', strtotime($registro['fecha'])) : date('Y-m-d');
$horaValor = !empty($registro['hora']) ? substr((string)$registro['hora'], 0, 5) : date('H:i');
?>

<div class="main-content">
    <?php require APP_PATH . '/views/layouts/topbar.php'; ?>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="registro-alert registro-alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <?= htmlspecialchars((string) $_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="registro-alert registro-alert-error">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= htmlspecialchars((string) $_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="page-header">
        <div>
            <h2>Editar <?= $esCierre ? 'cierre del día' : 'registro de llegada' ?></h2>
            <p>Actualiza la información del registro seleccionado.</p>
        </div>
        <a href="<?= BASE_URL ?>index.php?url=<?= $esCierre ? 'registro/cierre' : 'registro/llegada' ?>"
           class="registro-nav-button">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Volver al historial</span>
        </a>
    </div>

    <div class="registro-grid">
        <section class="registro-card">
            <div class="registro-card-header">
                <div class="registro-icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h3>Información del registro</h3>
                    <p>Los campos marcados son obligatorios. La fotografía es opcional.</p>
                </div>
            </div>

            <form action="<?= BASE_URL ?>index.php?url=registro/actualizar/<?= (int) $registro['id'] ?>"
                  method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="form-control"
                               value="<?= htmlspecialchars($fechaValor, ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="hora" class="form-label">Hora</label>
                        <input type="time" id="hora" name="hora" class="form-control"
                               value="<?= htmlspecialchars($horaValor, ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="cantidad_recibida" class="form-label">
                            <?= $esCierre ? 'Cantidad recibida' : 'Cantidad de refrigerios recibidos' ?>
                        </label>
                        <input type="number" id="cantidad_recibida" name="cantidad_recibida"
                               class="form-control" min="0" step="1"
                               value="<?= (int) ($registro['cantidad_recibida'] ?? 0) ?>" required>
                    </div>

                    <?php if ($esCierre): ?>
                        <div class="col-md-6 mb-3">
                            <label for="cantidad_entregada" class="form-label">Cantidad entregada</label>
                            <input type="number" id="cantidad_entregada" name="cantidad_entregada"
                                   class="form-control" min="0" step="1"
                                   value="<?= (int) ($registro['cantidad_entregada'] ?? 0) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cantidad_sobrante" class="form-label">Cantidad sobrante</label>
                            <input type="number" id="cantidad_sobrante" name="cantidad_sobrante"
                                   class="form-control" min="0" step="1"
                                   value="<?= (int) ($registro['cantidad_sobrante'] ?? 0) ?>" required>
                        </div>
                    <?php endif; ?>

                    <div class="col-md-12 mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" class="form-control" rows="4"
                                  placeholder="Escribe alguna observación..."><?= htmlspecialchars((string) ($registro['observaciones'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="foto" class="form-label">Cambiar fotografía (opcional)</label>
                        <input type="file" id="foto" name="foto" class="form-control"
                               accept="image/jpeg,image/png,image/webp">
                        <small class="registro-help">JPG, PNG o WEBP. Máximo 5 MB. Si no seleccionas una nueva imagen, se conservará la actual.</small>
                    </div>

                    <?php if (!empty($registro['id']) && !empty($registro['foto'])): ?>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Fotografía actual</label>
                            <div>
                                <a href="<?= BASE_URL ?>index.php?url=registro/foto/<?= (int) $registro['id'] ?>" target="_blank" rel="noopener">
                                    <img src="<?= BASE_URL ?>index.php?url=registro/foto/<?= (int) $registro['id'] ?>"
                                         class="registro-thumbnail" alt="Fotografía actual del registro">
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="registro-form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar cambios
                    </button>
                    <a href="<?= BASE_URL ?>index.php?url=<?= $esCierre ? 'registro/cierre' : 'registro/llegada' ?>"
                       class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form[action*="registro/actualizar/"]');
    if (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm('¿Confirmas que deseas guardar los cambios de este registro?')) {
                event.preventDefault();
            }
        });
    }
});
</script>

<?php require APP_PATH . '/views/layouts/footer.php'; ?>

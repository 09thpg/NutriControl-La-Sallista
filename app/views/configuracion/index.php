<?php

$titulo = 'Configuración';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Configuración del Sistema</h2>

        <p>
            Consulta la información general de NutriControl La Sallista.
        </p>

    </div>

</div>

<div class="form-card">

<form action="<?= BASE_URL ?>index.php?url=configuracion/guardar" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Nombre del Sistema

</label>

<input
type="text"
name="nombre_sistema"
class="form-control"
value="<?= htmlspecialchars($configuracion['nombre_sistema']) ?>"
<?= !$esAdministrador ? 'readonly' : '' ?>
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nombre de la Institución

</label>

<input
type="text"
name="nombre_institucion"
class="form-control"
value="<?= htmlspecialchars($configuracion['nombre_institucion']) ?>"
<?= !$esAdministrador ? 'readonly' : '' ?>
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Refrigerio del Día

</label>

<input
type="text"
name="refrigerio_dia"
class="form-control"
value="<?= htmlspecialchars($configuracion['refrigerio_dia']) ?>"
<?= !$esAdministrador ? 'readonly' : '' ?>
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Horario de Entrega

</label>

<input
type="text"
name="horario_entrega"
class="form-control"
value="<?= htmlspecialchars($configuracion['horario_entrega']) ?>"
<?= !$esAdministrador ? 'readonly' : '' ?>
required>

</div>

<div class="col-12 mb-4">

<label class="form-label">

Mensaje de Inicio

</label>

<textarea
name="mensaje_inicio"
class="form-control"
rows="5"
<?= !$esAdministrador ? 'readonly' : '' ?>
required><?= htmlspecialchars($configuracion['mensaje_inicio']) ?></textarea>

</div>

</div>

<?php if ($esAdministrador): ?>

<div class="d-flex gap-2">

<button
type="submit"
class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Guardar Cambios

</button>

</div>

<?php else: ?>

<div class="alert alert-info">

<i class="fa-solid fa-circle-info"></i>

La configuración es de solo lectura para los usuarios.

</div>

<?php endif; ?>

</form>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
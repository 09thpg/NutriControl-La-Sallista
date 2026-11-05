<?php

$titulo = 'Nuevo Estudiante';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Registrar Estudiante</h2>

        <p>Completa la información del estudiante.</p>

    </div>

    <a href="<?= BASE_URL ?>index.php?url=estudiantes" class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left"></i>

        Volver

    </a>

</div>

<div class="form-card">

<form action="<?= BASE_URL ?>index.php?url=estudiantes/guardar" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Documento

</label>

<input
type="text"
name="documento"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Grado

</label>

<select
name="grado"
class="form-select"
required>

<option value="">Seleccione...</option>

<option>6°</option>
<option>7°</option>
<option>8°</option>
<option>9°</option>
<option>10°</option>
<option>11°</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nombres

</label>

<input
type="text"
name="nombres"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Apellidos

</label>

<input
type="text"
name="apellidos"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Jornada

</label>

<select
name="jornada"
class="form-select"
required>

<option value="">Seleccione...</option>

<option>Mañana</option>

<option>Tarde</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Estado

</label>

<select
name="estado"
class="form-select"
required>

<option>Activo</option>

<option>Inactivo</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Acudiente

</label>

<input
type="text"
name="acudiente"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Teléfono

</label>

<input
type="text"
name="telefono"
class="form-control"
required>

</div>

</div>

<div class="d-flex gap-2 mt-4">

<button
type="submit"
class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Guardar

</button>

<a
href="<?= BASE_URL ?>index.php?url=estudiantes"
class="btn btn-secondary">

Cancelar

</a>

</div>

</form>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
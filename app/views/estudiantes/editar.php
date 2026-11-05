<?php

$titulo = 'Editar Estudiante';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Editar Estudiante</h2>

        <p>Actualiza la información del estudiante.</p>

    </div>

    <a href="<?= BASE_URL ?>index.php?url=estudiantes" class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left"></i>

        Volver

    </a>

</div>

<div class="form-card">

<form action="<?= BASE_URL ?>index.php?url=estudiantes/actualizar/<?= $estudiante['id'] ?>" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Documento

</label>

<input
type="text"
name="documento"
class="form-control"
value="<?= htmlspecialchars($estudiante['documento']) ?>"
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

<option <?= $estudiante['grado']=='6°'?'selected':'' ?>>6°</option>
<option <?= $estudiante['grado']=='7°'?'selected':'' ?>>7°</option>
<option <?= $estudiante['grado']=='8°'?'selected':'' ?>>8°</option>
<option <?= $estudiante['grado']=='9°'?'selected':'' ?>>9°</option>
<option <?= $estudiante['grado']=='10°'?'selected':'' ?>>10°</option>
<option <?= $estudiante['grado']=='11°'?'selected':'' ?>>11°</option>

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
value="<?= htmlspecialchars($estudiante['nombres']) ?>"
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
value="<?= htmlspecialchars($estudiante['apellidos']) ?>"
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

<option <?= $estudiante['jornada']=='Mañana'?'selected':'' ?>>Mañana</option>
<option <?= $estudiante['jornada']=='Tarde'?'selected':'' ?>>Tarde</option>

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

<option <?= $estudiante['estado']=='Activo'?'selected':'' ?>>Activo</option>
<option <?= $estudiante['estado']=='Inactivo'?'selected':'' ?>>Inactivo</option>

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
value="<?= htmlspecialchars($estudiante['acudiente']) ?>"
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
value="<?= htmlspecialchars($estudiante['telefono']) ?>"
required>

</div>

</div>

<div class="d-flex gap-2 mt-4">

<button
type="submit"
class="btn btn-warning">

<i class="fa-solid fa-pen"></i>

Actualizar

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
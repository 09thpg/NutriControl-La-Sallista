<?php

$titulo = 'Detalle del Estudiante';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Detalle del Estudiante</h2>

        <p>Información completa del estudiante.</p>

    </div>

    <a href="<?= BASE_URL ?>index.php?url=estudiantes" class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left"></i>

        Volver

    </a>

</div>

<div class="detalle-card">

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">

Documento

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($estudiante['documento']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Grado

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($estudiante['grado']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Nombres

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($estudiante['nombres']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Apellidos

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($estudiante['apellidos']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Jornada

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($estudiante['jornada']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Estado

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($estudiante['estado']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Acudiente

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($estudiante['acudiente']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Teléfono

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($estudiante['telefono']) ?>"
readonly>

</div>

</div>

<div class="mt-4">

<a
href="<?= BASE_URL ?>index.php?url=estudiantes/editar/<?= $estudiante['id'] ?>"
class="btn btn-warning">

<i class="fa-solid fa-pen"></i>

Editar

</a>

<a
href="<?= BASE_URL ?>index.php?url=estudiantes"
class="btn btn-secondary">

Volver

</a>

</div>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
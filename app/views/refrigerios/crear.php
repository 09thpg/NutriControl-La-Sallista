<?php

$titulo = 'Nuevo Refrigerio';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Registrar Refrigerio</h2>

        <p>Completa la información del refrigerio.</p>

    </div>

    <a href="<?= BASE_URL ?>index.php?url=refrigerios" class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left"></i>

        Volver

    </a>

</div>

<div class="form-card">

<form action="<?= BASE_URL ?>index.php?url=refrigerios/guardar" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Refrigerio

</label>

<input
type="text"
name="nombre"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Fecha

</label>

<input
type="date"
name="fecha"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Fecha de vencimiento

</label>

<input
type="date"
name="fecha_vencimiento"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Cantidad disponible

</label>

<input
type="number"
name="cantidad"
class="form-control"
min="0"
value="0"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Stock mínimo

</label>

<input
type="number"
name="stock_minimo"
class="form-control"
min="0"
value="1"
required>

</div>

<div class="col-12 mb-3">

<label class="form-label">

Descripción

</label>

<textarea
name="descripcion"
class="form-control"
rows="4"></textarea>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Estado

</label>

<select
name="estado"
class="form-select"
required>

<option value="Activo">Activo</option>

<option value="Inactivo">Inactivo</option>

</select>

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
href="<?= BASE_URL ?>index.php?url=refrigerios"
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
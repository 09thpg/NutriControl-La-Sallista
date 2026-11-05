<?php

$titulo = 'Detalle del Refrigerio';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Detalle del Refrigerio</h2>

        <p>Información completa del refrigerio.</p>

    </div>

    <a href="<?= BASE_URL ?>index.php?url=refrigerios" class="btn btn-secondary">

        <i class="fa-solid fa-arrow-left"></i>

        Volver

    </a>

</div>

<div class="detalle-card">

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">

Nombre

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($refrigerio['nombre']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Fecha

</label>

<input
type="text"
class="form-control"
value="<?= date('d/m/Y', strtotime($refrigerio['fecha'])) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Fecha de Vencimiento

</label>

<input
type="text"
class="form-control"
value="<?= !empty($refrigerio['fecha_vencimiento']) ? date('d/m/Y', strtotime($refrigerio['fecha_vencimiento'])) : 'Sin fecha' ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Cantidad Disponible

</label>

<input
type="text"
class="form-control"
value="<?= (int) ($refrigerio['cantidad'] ?? 0) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Stock Mínimo

</label>

<input
type="text"
class="form-control"
value="<?= (int) ($refrigerio['stock_minimo'] ?? 0) ?>"
readonly>

</div>

<div class="col-12 mb-4">

<label class="form-label">

Descripción

</label>

<textarea
class="form-control"
rows="4"
readonly><?= htmlspecialchars($refrigerio['descripcion']) ?></textarea>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Estado

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($refrigerio['estado']) ?>"
readonly>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Fecha de Registro

</label>

<input
type="text"
class="form-control"
value="<?= date('d/m/Y H:i', strtotime($refrigerio['fecha_registro'])) ?>"
readonly>

</div>

</div>

<div class="mt-4">

<a
href="<?= BASE_URL ?>index.php?url=refrigerios/editar/<?= $refrigerio['id'] ?>"
class="btn btn-warning">

<i class="fa-solid fa-pen"></i>

Editar

</a>

<a
href="<?= BASE_URL ?>index.php?url=refrigerios"
class="btn btn-secondary">

Volver

</a>

</div>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
<?php

$titulo = 'Detalle del Usuario';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content fade-in">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Detalle del Usuario</h2>

        <p>Información completa del usuario seleccionado.</p>

    </div>

</div>

<div class="detail-card">

<div class="row align-items-center">

<div class="col-md-4 text-center">

<img
src="<?= BASE_URL ?>public/img/avatars/<?= htmlspecialchars($usuario['avatar']) ?>"
class="detail-avatar"
alt="Avatar">

<h3 class="detail-title mt-3">

<?= htmlspecialchars($usuario['nombre']) ?>

<?= htmlspecialchars($usuario['apellido']) ?>

</h3>

<p class="detail-subtitle">

<?= htmlspecialchars($usuario['rol']) ?>

</p>

</div>

<div class="col-md-8">

<table class="detail-table">

<tr>

<th>ID</th>

<td><?= $usuario['id'] ?></td>

</tr>

<tr>

<th>Documento</th>

<td><?= htmlspecialchars($usuario['documento']) ?></td>

</tr>

<tr>

<th>Nombre</th>

<td><?= htmlspecialchars($usuario['nombre']) ?></td>

</tr>

<tr>

<th>Apellido</th>

<td><?= htmlspecialchars($usuario['apellido']) ?></td>

</tr>

<tr>

<th>Correo</th>

<td><?= htmlspecialchars($usuario['correo']) ?></td>

</tr>

<tr>

<th>Usuario</th>

<td><?= htmlspecialchars($usuario['usuario']) ?></td>

</tr>

<tr>

<th>Rol</th>

<td><?= htmlspecialchars($usuario['rol']) ?></td>

</tr>

<tr>

<th>Fecha de Registro</th>

<td><?= date('d/m/Y H:i', strtotime($usuario['fecha_registro'])) ?></td>

</tr>

</table>

<div class="mt-4 d-flex gap-2">

<a
href="<?= BASE_URL ?>index.php?url=usuarios/editar/<?= $usuario['id'] ?>"
class="btn btn-warning">

<i class="fa-solid fa-pen"></i>

Editar

</a>

<a
href="<?= BASE_URL ?>index.php?url=usuarios"
class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Volver

</a>

</div>

</div>

</div>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
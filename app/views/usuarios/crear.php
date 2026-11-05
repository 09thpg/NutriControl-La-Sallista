<?php

$titulo = 'Nuevo Usuario';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content fade-in">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Nuevo Usuario</h2>

        <p>Complete la información para registrar un nuevo usuario.</p>

    </div>

</div>

<div class="form-card">

<form action="<?= BASE_URL ?>index.php?url=usuarios/guardar" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Nombre</label>

<input
type="text"
name="nombre"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Apellido</label>

<input
type="text"
name="apellido"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Documento</label>

<input
type="text"
name="documento"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Correo</label>

<input
type="email"
name="correo"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Usuario</label>

<input
type="text"
name="usuario"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Contraseña</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Rol</label>

<?php if ($esSuperAdministrador): ?>

<select name="rol" class="form-control" required>
    <option value="Supervisor">Supervisor</option>
    <option value="Administrador">Administrador</option>
    <option value="Super Administrador">Super Administrador</option>
</select>

<small class="text-muted">Solo el Super Administrador puede asignar este rol.</small>

<?php else: ?>

<input type="text" class="form-control" value="Supervisor" readonly>
<input type="hidden" name="rol" value="Supervisor">
<small class="text-muted">Los nuevos usuarios creados por un Administrador quedan como Supervisor.</small>

<?php endif; ?>

</div>

</div>

<h4 class="mt-4 mb-3">

Seleccione un Avatar

</h4>

<div class="avatar-selector">

<?php for($i=1;$i<=6;$i++): ?>

<label>

<input
type="radio"
name="avatar"
value="avatar<?= $i ?>.png"
<?= $i==1 ? 'checked' : '' ?>>

<img
src="<?= BASE_URL ?>public/img/avatars/avatar<?= $i ?>.png">

</label>

<?php endfor; ?>

</div>

<div class="mt-4 d-flex gap-2">

<button
type="submit"
class="btn btn-success">

<i class="fa-solid fa-floppy-disk"></i>

Guardar

</button>

<a
href="<?= BASE_URL ?>index.php?url=usuarios"
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
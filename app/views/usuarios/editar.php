<?php

$titulo = 'Editar Usuario';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content fade-in">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Editar Usuario</h2>

        <p>Actualice la información del usuario.</p>

    </div>

</div>

<div class="form-card">

<form action="<?= BASE_URL ?>index.php?url=usuarios/actualizar/<?= $usuario['id'] ?>" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Nombre</label>

<input
type="text"
name="nombre"
class="form-control"
value="<?= htmlspecialchars($usuario['nombre']) ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Apellido</label>

<input
type="text"
name="apellido"
class="form-control"
value="<?= htmlspecialchars($usuario['apellido']) ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Documento</label>

<input
type="text"
name="documento"
class="form-control"
value="<?= htmlspecialchars($usuario['documento']) ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Correo</label>

<input
type="email"
name="correo"
class="form-control"
value="<?= htmlspecialchars($usuario['correo']) ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Usuario</label>

<input
type="text"
name="usuario"
class="form-control"
value="<?= htmlspecialchars($usuario['usuario']) ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Rol</label>

<?php if ($puedeCambiarRol): ?>

<select name="rol" class="form-control" required>
    <option value="Supervisor" <?= $usuario['rol'] === 'Supervisor' ? 'selected' : '' ?>>Supervisor</option>
    <option value="Administrador" <?= $usuario['rol'] === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
    <option value="Super Administrador" <?= $usuario['rol'] === 'Super Administrador' ? 'selected' : '' ?>>Super Administrador</option>
</select>

<small class="text-muted">Solo el Super Administrador puede cambiar el rol de otro usuario.</small>

<?php else: ?>

<input type="text" class="form-control" value="<?= htmlspecialchars($usuario['rol'] ?? 'Supervisor') ?>" readonly>
<small class="text-muted">El rol solo puede ser modificado por el Super Administrador.</small>

<?php endif; ?>

</div>

</div>

<div class="mt-4 d-flex gap-2">

<button
type="submit"
class="btn btn-warning">

<i class="fa-solid fa-floppy-disk"></i>

Actualizar

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
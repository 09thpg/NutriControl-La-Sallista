<?php

$titulo = 'Mi Perfil';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content fade-in">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>Mi Perfil</h2>

        <p>
            Administra tu información personal y tu cuenta.
        </p>

    </div>

</div>

<?php if (!empty($_SESSION['error'])): ?>

<div class="alert alert-danger">

    <?= htmlspecialchars($_SESSION['error']) ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>

<div class="alert alert-success">

    <?= htmlspecialchars($_SESSION['success']) ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>

<div class="form-card">

<form
    action="<?= BASE_URL ?>index.php?url=perfil/actualizar"
    method="POST"
    enctype="multipart/form-data">

<div class="perfil-foto">

    <?php

    $avatar = $usuario['avatar'] ?? 'avatar1.png';

    ?>

    <div
    class="foto-preview-wrapper"
    style="
        width:120px !important;
        height:120px !important;
        min-width:120px !important;
        min-height:120px !important;
        max-width:120px !important;
        max-height:120px !important;
        border-radius:50%;
        overflow:hidden;
        border:3px solid #2563eb;
        margin:0 auto 15px auto;
        display:block;
    ">

    <img
        id="foto-perfil-preview"
        src="<?= BASE_URL ?>public/img/avatars/<?= htmlspecialchars($avatar) ?>"
        alt="Foto de perfil"
        style="
            width:120px !important;
            height:120px !important;
            min-width:120px !important;
            min-height:120px !important;
            max-width:120px !important;
            max-height:120px !important;
            object-fit:cover !important;
            border-radius:50% !important;
            display:block !important;
            margin:0 !important;
            padding:0 !important;
        ">

</div>  

    <label
        for="foto_perfil"
        class="btn btn-primary btn-cambiar-foto">

        <i class="fa-solid fa-camera"></i>

        Cambiar foto

    </label>

    <input
        type="file"
        name="foto_perfil"
        id="foto_perfil"
        accept="image/jpeg,image/png,image/webp"
        hidden>

    <p>
        JPG, PNG o WEBP · Máximo 2 MB
    </p>

</div>

<hr class="my-4">

<h4 class="mb-3">

    Información personal

</h4>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
    Nombre
</label>

<input
    type="text"
    name="nombre"
    class="form-control"
    value="<?= htmlspecialchars($usuario['nombre']) ?>"
    required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
    Apellido
</label>

<input
    type="text"
    name="apellido"
    class="form-control"
    value="<?= htmlspecialchars($usuario['apellido']) ?>"
    required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
    Rol
</label>

<input
    type="text"
    class="form-control"
    value="<?= htmlspecialchars($usuario['rol'] ?? 'Sin rol') ?>"
    readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
    Documento
</label>

<input
    type="text"
    name="documento"
    class="form-control"
    value="<?= htmlspecialchars($usuario['documento']) ?>"
    required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
    Correo electrónico
</label>

<input
    type="email"
    name="correo"
    class="form-control"
    value="<?= htmlspecialchars($usuario['correo']) ?>"
    required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
    Nombre de usuario
</label>

<input
    type="text"
    name="usuario"
    class="form-control"
    value="<?= htmlspecialchars($usuario['usuario']) ?>"
    required>

</div>

</div>

<hr class="my-4">

<h4 class="mb-2">

    Cambiar contraseña

</h4>

<p class="text-secondary mb-4">

    Si no deseas cambiarla, deja estos campos vacíos.

</p>

<div class="row">

<div class="col-md-4 mb-3">

<label class="form-label">
    Contraseña actual
</label>

<input
    type="password"
    name="password_actual"
    class="form-control"
    autocomplete="current-password">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
    Nueva contraseña
</label>

<input
    type="password"
    name="password_nueva"
    class="form-control"
    autocomplete="new-password">

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
    Confirmar nueva contraseña
</label>

<input
    type="password"
    name="confirmar_password"
    class="form-control"
    autocomplete="new-password">

</div>

</div>

<hr class="my-4">

<h4 class="mb-3">

    Avatar predeterminado

</h4>

<div class="avatar-selector">

<?php for($i = 1; $i <= 6; $i++): ?>

<label>

<input
    type="radio"
    name="avatar"
    value="avatar<?= $i ?>.png"
    <?= $usuario['avatar'] === "avatar{$i}.png" ? 'checked' : '' ?>>

<img
    src="<?= BASE_URL ?>public/img/avatars/avatar<?= $i ?>.png"
    alt="Avatar <?= $i ?>">

</label>

<?php endfor; ?>

</div>

<div class="mt-4 d-flex gap-2">

<button
    type="submit"
    class="btn btn-success">

    <i class="fa-solid fa-floppy-disk"></i>

    Guardar cambios

</button>

<a
    href="<?= BASE_URL ?>index.php?url=dashboard"
    class="btn btn-secondary">

    Cancelar

</a>

</div>

</form>

</div>

</div>

<script src="<?= BASE_URL ?>public/js/perfil.js"></script>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
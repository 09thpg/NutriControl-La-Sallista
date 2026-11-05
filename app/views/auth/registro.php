<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= APP_NAME ?> | Registro</title>

    <link rel="icon" href="<?= BASE_URL ?>public/img/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/registro.css">

    <style>

.foto-personal{
    width:100%;
    margin-top:25px;
}

.upload-area{
    width:100%;
    min-height:150px;
    border:2px dashed #475569;
    border-radius:15px;
    background:#334155;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    gap:8px;
    cursor:pointer;
    transition:0.25s;
    text-align:center;
    padding:20px;
}

.upload-area:hover{
    border-color:#2563eb;
    background:#3b4a61;
}

.upload-icon{
    width:45px;
    height:45px;
    border-radius:50%;
    background:#2563eb;
    color:#ffffff;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:30px;
    line-height:1;
}

.upload-area strong{
    color:#ffffff;
    font-size:16px;
}

.upload-area span{
    color:#94a3b8;
    font-size:13px;
}

.preview-container{
    display:none;
    margin-top:20px;
    text-align:center;
}

.preview-container img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:50%;
    border:4px solid #2563eb;
    box-shadow:0 0 20px rgba(37,99,235,0.35);
}

</style>

</head>

<body>

<div class="registro-container">

    <div class="registro-card">

        <div class="text-center mb-4">

            <img
                src="<?= BASE_URL ?>public/img/logo.png"
                class="logo"
                alt="Logo">

            <h2><?= APP_NAME ?></h2>

            <p>Crear una cuenta</p>

        </div>

        <?php if(isset($_SESSION['error'])): ?>

            <div class="alert alert-danger">

                <?= $_SESSION['error']; ?>

            </div>

            <?php unset($_SESSION['error']); ?>

        <?php endif; ?>

        <form
    action="<?= BASE_URL ?>index.php?url=auth/registrar"
    method="POST"
    enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Nombre</label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Apellido</label>

                    <input
                        type="text"
                        name="apellido"
                        class="form-control"
                        required>

                </div>


            </div>

            <div class="mb-3">

                <label>Documento</label>

                <input
                    type="text"
                    name="documento"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label>Correo electrónico</label>

                <input
                    type="email"
                    name="correo"
                    class="form-control"
                    required>

            </div>

            <div class="mb-3">

                <label>Usuario</label>

                <input
                    type="text"
                    name="usuario"
                    class="form-control"
                    required>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">

                    <label>Contraseña</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-6 mb-3">

                    <label>Confirmar contraseña</label>

                    <input
                        type="password"
                        name="confirmar_password"
                        class="form-control"
                        required>

                </div>

            </div>

            <div class="mb-4">

    <label class="mb-3 d-block">
        Foto de perfil
    </label>

    <p class="texto-foto">
        Elige uno de nuestros avatares o sube tu propia foto.
    </p>

    <div class="avatar-grid">

        <?php for($i = 1; $i <= 6; $i++): ?>

            <label class="avatar-item">

                <input
                    type="radio"
                    name="avatar"
                    value="avatar<?= $i ?>.png">

                <img
                    src="<?= BASE_URL ?>public/img/avatars/avatar<?= $i ?>.png"
                    alt="Avatar <?= $i ?>">

            </label>

        <?php endfor; ?>

    </div>

    <div class="foto-personal">

    <label
        for="foto_perfil"
        class="upload-area">

        <div class="upload-icon">
            +
        </div>

        <strong>
            Subir mi propia foto
        </strong>

        <span>
            JPG, PNG o WEBP · Máximo 2 MB
        </span>

    </label>

    <input
        type="file"
        name="foto_perfil"
        id="foto_perfil"
        accept="image/jpeg,image/png,image/webp"
        hidden>

    <div
        id="preview-container"
        class="preview-container">

        <img
            id="preview-foto"
            alt="Vista previa">

    </div>

</div>

</div>

            <button
                type="submit"
                class="btn btn-success w-100">

                Crear cuenta

            </button>

        </form>

        <div class="text-center mt-4">

            <a href="<?= BASE_URL ?>index.php">

                Volver al inicio de sesión

            </a>

        </div>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const fotoInput = document.getElementById("foto_perfil");
    const previewContainer = document.getElementById("preview-container");
    const previewFoto = document.getElementById("preview-foto");

    const avatares = document.querySelectorAll(".avatar-item");

    if (!fotoInput) {
        console.error("No se encontró el campo foto_perfil.");
        return;
    }

    fotoInput.addEventListener("change", function () {

        const archivo = this.files[0];

        if (!archivo) {
            previewContainer.style.display = "none";
            previewFoto.removeAttribute("src");
            return;
        }

        const tiposPermitidos = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];

        if (!tiposPermitidos.includes(archivo.type)) {

            alert("Solo puedes subir imágenes JPG, PNG o WEBP.");

            this.value = "";

            previewContainer.style.display = "none";

            return;
        }

        if (archivo.size > 2 * 1024 * 1024) {

            alert("La imagen no puede superar los 2 MB.");

            this.value = "";

            previewContainer.style.display = "none";

            return;
        }

        avatares.forEach(function (avatar) {
            avatar.style.borderColor = "transparent";
        });

        const lector = new FileReader();

        lector.onload = function (evento) {

            previewFoto.src = evento.target.result;

            previewContainer.style.display = "block";

        };

        lector.onerror = function () {

            alert("No se pudo leer la imagen.");

        };

        lector.readAsDataURL(archivo);

    });

    avatares.forEach(function (avatar) {

        avatar.addEventListener("click", function () {

            avatares.forEach(function (item) {
                item.style.borderColor = "transparent";
            });

            this.style.borderColor = "#2563eb";

            fotoInput.value = "";

            previewFoto.removeAttribute("src");

            previewContainer.style.display = "none";

        });

    });

});

</script>

</body>

</html>

</body>

</html>
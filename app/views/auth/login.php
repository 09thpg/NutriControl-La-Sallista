<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= APP_NAME ?> | Iniciar Sesión</title>

    <link rel="icon" href="<?= BASE_URL ?>public/img/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/login.css">

</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="text-center mb-4">

            <img
                src="<?= BASE_URL ?>public/img/logo.png"
                class="logo"
                alt="Logo">

            <h2 class="titulo">

                <?= APP_NAME ?>

            </h2>

            <p class="subtitulo">

                Inicia sesión para continuar

            </p>

        </div>

        <?php if(isset($_SESSION['error'])): ?>

            <div class="alert alert-danger">

                <?= $_SESSION['error']; ?>

            </div>

            <?php unset($_SESSION['error']); ?>

        <?php endif; ?>

        <?php if(isset($_SESSION['success'])): ?>

            <div class="alert alert-success">

                <?= $_SESSION['success']; ?>

            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>

        <form
            action="<?= BASE_URL ?>index.php?url=auth/login"
            method="POST">

            <div class="mb-3">

                <label class="form-label">

                    Usuario

                </label>

                <input
                    type="text"
                    name="usuario"
                    class="form-control"
                    required>

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Contraseña

                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required>

            </div>

            <button
                type="submit"
                class="btn btn-primary w-100">

                Iniciar Sesión

            </button>

        </form>

        <div class="text-center mt-4">

            <a href="<?= BASE_URL ?>index.php?url=auth/registro">

                Crear una cuenta

            </a>

            <br><br>

            <a href="<?= BASE_URL ?>index.php?url=auth/recuperar">

                ¿Olvidaste tu contraseña?

            </a>

        </div>

    </div>

</div>

<script src="<?= BASE_URL ?>public/js/login.js"></script>

</body>

</html>
<?php

$titulo = 'Ver estudiante';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

$avatar = $estudiante['avatar'] ?? 'avatar1.png';

$avatarUrl =
    BASE_URL .
    'public/img/avatars/' .
    $avatar;

?>

<div class="main-content fade-in">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="page-header">

    <div>

        <h2>
            Perfil del estudiante
        </h2>

        <p>
            Información completa del estudiante.
        </p>

    </div>

</div>


<div class="perfil-estudiante">

    <div class="perfil-estudiante-header">

        <img
            src="<?= htmlspecialchars($avatarUrl) ?>"
            alt="Avatar"
            class="perfil-estudiante-avatar"
        >

        <div>

            <h2>

                <?= htmlspecialchars(
                    trim(
                        $estudiante['nombre'] .
                        ' ' .
                        $estudiante['apellido']
                    )
                ) ?>

            </h2>

            <span class="badge estudiante">
                Estudiante
            </span>

        </div>

    </div>


    <div class="perfil-datos">

        <div class="dato-perfil">

            <span>
                Documento
            </span>

            <strong>
                <?= htmlspecialchars($estudiante['documento']) ?>
            </strong>

        </div>


        <div class="dato-perfil">

            <span>
                Grado
            </span>

            <strong>
                <?= htmlspecialchars($estudiante['grado']) ?>
            </strong>

        </div>


        <div class="dato-perfil">

            <span>
                Correo electrónico
            </span>

            <strong>
                <?= htmlspecialchars($estudiante['correo']) ?>
            </strong>

        </div>


        <div class="dato-perfil">

            <span>
                Nombre de usuario
            </span>

            <strong>
                <?= htmlspecialchars($estudiante['usuario']) ?>
            </strong>

        </div>


        <div class="dato-perfil">

            <span>
                Rol
            </span>

            <strong>
                Estudiante
            </strong>

        </div>


        <div class="dato-perfil">

            <span>
                Fecha de registro
            </span>

            <strong>

                <?= htmlspecialchars(
                    $estudiante['fecha_registro'] ?? 'No disponible'
                ) ?>

            </strong>

        </div>

    </div>


    <div class="perfil-acciones">

        <a
            href="<?= BASE_URL ?>index.php?url=estudiantes/editar&id=<?= (int) $estudiante['id'] ?>"
            class="btn btn-warning"
        >

            <i class="fa-solid fa-pen"></i>

            Editar estudiante

        </a>


        <a
            href="<?= BASE_URL ?>index.php?url=estudiantes"
            class="btn btn-secondary"
        >

            Volver

        </a>

    </div>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
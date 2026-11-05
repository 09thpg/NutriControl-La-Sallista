<?php

$titulo = 'Estudiantes';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content fade-in">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>


<div class="page-header">

    <div>

        <h2>
            Estudiantes
        </h2>

        <p>
            Administra los estudiantes registrados en el sistema.
        </p>

    </div>

</div>


<!-- =========================================================
     SELECTOR DE GRADOS
========================================================= -->

<div class="grados-container">

    <div class="grados-header">

        <div>

            <h3>
                Seleccionar grado
            </h3>

            <p>
                Selecciona un grado para mostrar sus estudiantes.
            </p>

        </div>


        <?php if (!empty($gradoSeleccionado)): ?>

            <div class="grado-seleccionado">

                <?= htmlspecialchars($gradoSeleccionado) ?>

            </div>

        <?php endif; ?>

    </div>


    <div class="grados-grid">


        <!-- TODOS -->

        <a
    href="<?= BASE_URL ?>index.php?url=estudiantes"
    class="grado-btn <?= empty($gradoSeleccionado) ? 'activo' : '' ?>"
>

            <i class="fa-solid fa-users"></i>

            <span>
                Todos
            </span>

        </a>


        <!-- GRADOS -->

        <?php foreach ($grados as $grado): ?>

            <a
    href="<?= BASE_URL ?>index.php?url=estudiantes&grado=<?= urlencode($grado) ?>"
    class="grado-btn <?= $gradoSeleccionado === $grado ? 'activo' : '' ?>"
>

                <i class="fa-solid fa-graduation-cap"></i>

                <span>
                    <?= htmlspecialchars($grado) ?>
                </span>

            </a>

        <?php endforeach; ?>


    </div>

</div>


<!-- =========================================================
     TABLA DE ESTUDIANTES
========================================================= -->

<div class="table-container">


    <div class="table-header">

        <div>

            <h3>

                <?php if (!empty($gradoSeleccionado)): ?>

                    Estudiantes de <?= htmlspecialchars($gradoSeleccionado) ?>

                <?php else: ?>

                    Todos los estudiantes

                <?php endif; ?>

            </h3>

            <p>

                <?= count($estudiantes) ?>

                estudiante<?= count($estudiantes) === 1 ? '' : 's' ?>

                encontrado<?= count($estudiantes) === 1 ? '' : 's' ?>

            </p>

        </div>


        <?php if ($esAdministrador): ?>

<a
    href="<?= BASE_URL ?>index.php?url=auth/registro"
    class="btn btn-success"
>

    <i class="fa-solid fa-user-plus"></i>

    Nuevo Estudiante

</a>

<?php endif; ?>

    </div>


    <div class="dashboard-table-wrapper">

        <table class="dashboard-table">


            <thead>

                <tr>

                    <th>
                        Estudiante
                    </th>

                    <th>
                        Documento
                    </th>

                    <th>
                        Grado
                    </th>

                    <th>
                        Correo
                    </th>

                    <th>
                        Usuario
                    </th>

                    <th>
                        Rol
                    </th>
                    
                    <th>
    Acciones
</th>

                </tr>

            </thead>


            <tbody>


            <?php if (!empty($estudiantes)): ?>


                <?php foreach ($estudiantes as $estudiante): ?>

                    <tr>


                        <!-- ESTUDIANTE -->

                        <td>

                            <div class="estudiante-info">


                                <?php

                                $avatar = $estudiante['avatar'] ?? 'avatar1.png';

                                if (
                                    str_starts_with(
                                        $avatar,
                                        'usuarios/'
                                    )
                                ) {

                                    $avatarUrl =
                                        BASE_URL .
                                        'public/img/avatars/' .
                                        $avatar;

                                } else {

                                    $avatarUrl =
                                        BASE_URL .
                                        'public/img/avatars/' .
                                        $avatar;

                                }

                                ?>


                                <img
                                    src="<?= htmlspecialchars($avatarUrl) ?>"
                                    alt="Avatar"
                                    class="estudiante-avatar"
                                >


                                <div>

                                    <strong>

                                        <?= htmlspecialchars(
                                            trim(
                                                ($estudiante['nombre'] ?? '') .
                                                ' ' .
                                                ($estudiante['apellido'] ?? '')
                                            )
                                        ) ?>

                                    </strong>

                                </div>


                            </div>

                        </td>


                        <!-- DOCUMENTO -->

                        <td>

                            <?= htmlspecialchars(
                                $estudiante['documento'] ?? ''
                            ) ?>

                        </td>


                        <!-- GRADO -->

                        <td>

                            <span class="grado-badge">

                                <?= htmlspecialchars(
                                    $estudiante['grado'] ?? ''
                                ) ?>

                            </span>

                        </td>


                        <!-- CORREO -->

                        <td>

                            <?= htmlspecialchars(
                                $estudiante['correo'] ?? ''
                            ) ?>

                        </td>


                        <!-- USUARIO -->

                        <td>

                            <?= htmlspecialchars(
                                $estudiante['usuario'] ?? ''
                            ) ?>

                        </td>


                        <!-- ROL -->

                        <td>

                            <span class="badge estudiante">

                                Estudiante

                            </span>

                        </td>

                        <td>

    <div class="acciones-estudiante">

        <a
            href="<?= BASE_URL ?>index.php?url=estudiantes/ver&id=<?= (int) $estudiante['id'] ?>"
            class="btn-accion btn-ver"
            title="Ver estudiante"
        >

            <i class="fa-solid fa-eye"></i>

        </a>

        <?php if ($esAdministrador): ?>

<a
    href="<?= BASE_URL ?>index.php?url=estudiantes/editar&id=<?= (int) $estudiante['id'] ?>"
    class="btn-accion btn-editar"
    title="Editar estudiante"
>

    <i class="fa-solid fa-pen"></i>

</a>

<?php endif; ?>

    </div>

</td>


                    </tr>

                <?php endforeach; ?>


            <?php else: ?>


                <tr>

                    <td
                        colspan="7"
                        class="empty-state"
                    >

                        <i class="fa-solid fa-user-graduate"></i>

                        <h3>
                            No hay estudiantes
                        </h3>

                        <p>

                            <?php if (!empty($gradoSeleccionado)): ?>

                                No hay estudiantes registrados en
                                <?= htmlspecialchars($gradoSeleccionado) ?>.

                            <?php else: ?>

                                Todavía no hay estudiantes registrados.

                            <?php endif; ?>

                        </p>

                    </td>

                </tr>


            <?php endif; ?>


            </tbody>

        </table>

    </div>

</div>


</div>


<?php

require APP_PATH . '/views/layouts/footer.php';

?>
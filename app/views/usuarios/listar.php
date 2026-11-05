<?php

$titulo = 'Usuarios';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

    <?php require APP_PATH . '/views/layouts/topbar.php'; ?>

    <div class="page-header">

        <div>

            <h2>Gestión de Usuarios</h2>

            <p>Administra los usuarios registrados en el sistema.</p>

        </div>

        <?php if ($esAdministrador): ?>

            <a
                href="<?= BASE_URL ?>index.php?url=usuarios/crear"
                class="btn btn-success">

                <i class="fa-solid fa-user-plus"></i>

                Nuevo Usuario

            </a>

        <?php endif; ?>

    </div>

    <div class="table-container">

        <table class="table">

            <thead>

                <tr>

                    <th>Avatar</th>
                    <th>Documento</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Registro</th>
                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

                <?php if (empty($usuarios)): ?>

                    <tr>

                        <td colspan="8">

                            No hay usuarios registrados.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach ($usuarios as $u): ?>

                        <tr>

                            <td>

                                <img
                                    src="<?= BASE_URL ?>public/img/avatars/<?= htmlspecialchars($u['avatar'] ?? 'avatar1.png') ?>"
                                    class="avatar-table"
                                    alt="Avatar">

                            </td>

                            <td>

                                <?= htmlspecialchars($u['documento']) ?>

                            </td>

                            <td>

                                <strong>

                                    <?= htmlspecialchars($u['nombre']) ?>

                                    <?= htmlspecialchars($u['apellido']) ?>

                                </strong>

                            </td>

                            <td>

                                <?= htmlspecialchars($u['usuario']) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($u['correo']) ?>

                            </td>

                            <td>

                                <?php if ($u['rol'] === 'Super Administrador'): ?>

                                    <span class="badge badge-super-administrador">

                                        Super Administrador

                                    </span>

                                <?php elseif ($u['rol'] === 'Administrador'): ?>

                                    <span class="badge badge-administrador">

                                        Administrador

                                    </span>

                                <?php elseif ($u['rol'] === 'Supervisor'): ?>

                                    <span class="badge badge-supervisor">

                                        Supervisor

                                    </span>

                                <?php else: ?>

                                    <span class="badge badge-supervisor">

                                        <?= htmlspecialchars($u['rol']) ?>

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <?= date(
                                    'd/m/Y',
                                    strtotime($u['fecha_registro'])
                                ) ?>

                            </td>

                            <td>

                                <div class="acciones">

                                    <!-- VER -->

                                    <a
                                        href="<?= BASE_URL ?>index.php?url=usuarios/detalle/<?= (int) $u['id'] ?>"
                                        class="btn-info"
                                        title="Ver usuario">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>


                                    <!-- EDITAR -->

                                    <?php if ($esAdministrador): ?>

                                        <a
                                            href="<?= BASE_URL ?>index.php?url=usuarios/editar/<?= (int) $u['id'] ?>"
                                            class="btn-warning"
                                            title="Editar usuario">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                    <?php endif; ?>


                                    <!-- ELIMINAR -->

                                    <?php if ($esSuperAdministrador): ?>

                                        <a
                                            href="<?= BASE_URL ?>index.php?url=usuarios/eliminar/<?= (int) $u['id'] ?>"
                                            class="btn-danger"
                                            title="Eliminar usuario">

                                            <i class="fa-solid fa-trash"></i>

                                        </a>

                                    <?php endif; ?>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
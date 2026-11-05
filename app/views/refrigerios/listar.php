<?php

$titulo = 'Refrigerios';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

    <?php require APP_PATH . '/views/layouts/topbar.php'; ?>

    <div class="page-header">

        <div>

            <h2>Gestión de Refrigerios</h2>

            <p>Administra los refrigerios registrados en el sistema.</p>

        </div>

        <?php if ($esAdministrador): ?>

            <a
                href="<?= BASE_URL ?>index.php?url=refrigerios/crear"
                class="btn btn-success"
            >

                <i class="fa-solid fa-plus"></i>

                Nuevo Refrigerio

            </a>

        <?php endif; ?>

    </div>


    <div class="table-container">

        <table class="table">

            <thead>

                <tr>

                    <th>Nombre</th>

                    <th>Descripción</th>

                    <th>Fecha</th>

                    <th>Vencimiento</th>

                    <th>Cantidad</th>

                    <th>Estado</th>

                    <th>Registro</th>

                    <th>Acciones</th>

                </tr>

            </thead>


            <tbody>

                <?php if (empty($refrigerios)): ?>

                    <tr>

                        <td colspan="8">

                            No hay refrigerios registrados.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach ($refrigerios as $r): ?>

                        <tr>

                            <td>

                                <strong>

                                    <?= htmlspecialchars(
                                        $r['nombre']
                                    ) ?>

                                </strong>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $r['descripcion']
                                ) ?>

                            </td>


                            <td>

                                <?= !empty($r['fecha'])
                                    ? date(
                                        'd/m/Y',
                                        strtotime($r['fecha'])
                                    )
                                    : 'Sin fecha'
                                ?>

                            </td>


                            <td>

                                <?= !empty($r['fecha_vencimiento'])
                                    ? date(
                                        'd/m/Y',
                                        strtotime($r['fecha_vencimiento'])
                                    )
                                    : 'Sin fecha'
                                ?>

                            </td>

                            <td>

                                <?= (int) ($r['cantidad'] ?? 0) ?>

                            </td>


                            <td>

                                <?php if (
                                    $r['estado'] === 'Activo'
                                ): ?>

                                    <span class="badge usuario">

                                        Activo

                                    </span>

                                <?php else: ?>

                                    <span class="badge administrador">

                                        Inactivo

                                    </span>

                                <?php endif; ?>

                            </td>


                            <td>

                                <?= !empty($r['fecha_registro'])
                                    ? date(
                                        'd/m/Y',
                                        strtotime($r['fecha_registro'])
                                    )
                                    : 'Sin fecha'
                                ?>

                            </td>


                            <td>

                                <div class="acciones">


                                    <!-- VER -->
                                    <a
                                        href="<?= BASE_URL ?>index.php?url=refrigerios/detalle/<?= (int) $r['id'] ?>"
                                        class="btn-info"
                                        title="Ver refrigerio"
                                    >

                                        <i class="fa-solid fa-eye"></i>

                                    </a>


                                    <!-- EDITAR -->
                                    <?php if ($esAdministrador): ?>

                                        <a
                                            href="<?= BASE_URL ?>index.php?url=refrigerios/editar/<?= (int) $r['id'] ?>"
                                            class="btn-warning"
                                            title="Editar refrigerio"
                                        >

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                    <?php endif; ?>


                                    <!-- ELIMINAR -->
                                    <?php if ($esSuperAdministrador): ?>

                                        <a
                                            href="<?= BASE_URL ?>index.php?url=refrigerios/eliminar/<?= (int) $r['id'] ?>"
                                            class="btn-danger"
                                            title="Eliminar refrigerio"
                                        >

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
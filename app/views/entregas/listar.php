<?php

$titulo = 'Entregas';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

    <?php require APP_PATH . '/views/layouts/topbar.php'; ?>


    <?php if (!empty($_SESSION['success'])): ?>

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check"></i>

            <?= htmlspecialchars($_SESSION['success']) ?>

        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>


    <?php if (!empty($_SESSION['error'])): ?>

        <div class="alert alert-danger">

            <i class="fa-solid fa-circle-exclamation"></i>

            <?= htmlspecialchars($_SESSION['error']) ?>

        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>



    <div class="page-header">

        <div>

            <h2>Gestión de Entregas</h2>

            <p>
                Consulta y administra las entregas de
                refrigerios por grado.
            </p>

        </div>


        <?php if ($esAdministrador): ?>

            <a
                href="<?= BASE_URL ?>index.php?url=entregas/crear"
                class="btn btn-success"
            >

                <i class="fa-solid fa-plus"></i>

                Nueva Entrega

            </a>

        <?php endif; ?>

    </div>



    <div class="table-container">


        <table class="table">


            <thead>

                <tr>

                    <!-- GRADO -->

                    <th>Grado</th>


                    <!-- REFRIGERIO -->

                    <th>Refrigerio</th>


                    <!-- CANTIDAD -->

                    <th>Cantidad entregada</th>


                    <!-- FECHA -->

                    <th>Fecha</th>


                    <!-- HORA -->

                    <th>Hora</th>


                    <!-- USUARIO -->

                    <th>Entregado por</th>


                    <!-- ACCIONES -->

                    <th>Acciones</th>

                </tr>

            </thead>



            <tbody>


                <?php if (empty($entregas)): ?>

                    <tr>

                        <td colspan="7">

                            No hay entregas registradas.

                        </td>

                    </tr>


                <?php else: ?>


                    <?php foreach ($entregas as $e): ?>

                        <tr>


                            <!-- GRADO -->

                            <td>

                                <strong>

                                    <?= htmlspecialchars(
                                        $e['grado']
                                    ) ?>

                                </strong>

                            </td>



                            <!-- REFRIGERIO -->

                            <td>

                                <?php if (!empty($e['refrigerio'])): ?>

                                    <strong>

                                        <?= htmlspecialchars(
                                            $e['refrigerio']
                                        ) ?>

                                    </strong>

                                <?php else: ?>

                                    <span>
                                        Sin refrigerio
                                    </span>

                                <?php endif; ?>

                            </td>



                            <!-- CANTIDAD -->

                            <td>

                                <strong>

                                    <?= (int)
                                        $e['cantidad_entregada'] ?>

                                </strong>

                                refrigerios

                            </td>



                            <!-- FECHA -->

                            <td>

                                <?= !empty($e['fecha'])
                                    ? date(
                                        'd/m/Y',
                                        strtotime($e['fecha'])
                                    )
                                    : 'Sin fecha'
                                ?>

                            </td>



                            <!-- HORA -->

                            <td>

                                <?= !empty($e['hora'])
                                    ? htmlspecialchars($e['hora'])
                                    : 'Sin hora'
                                ?>

                            </td>



                            <!-- ENTREGADO POR -->

                            <td>

                                <?= !empty($e['usuario'])
                                    ? htmlspecialchars($e['usuario'])
                                    : 'Sin usuario'
                                ?>

                            </td>



                            <!-- ACCIONES -->

                            <td>

                                <div class="acciones">


                                    <!-- VER -->

                                    <a
                                        href="<?= BASE_URL ?>index.php?url=entregas/detalle/<?= (int) $e['id'] ?>"
                                        class="btn-info"
                                        title="Ver entrega"
                                    >

                                        <i class="fa-solid fa-eye"></i>

                                    </a>



                                    <!-- EDITAR -->

                                    <?php if ($esAdministrador): ?>

                                        <a
                                            href="<?= BASE_URL ?>index.php?url=entregas/editar/<?= (int) $e['id'] ?>"
                                            class="btn-warning"
                                            title="Editar entrega"
                                        >

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                    <?php endif; ?>



                                    <!-- ELIMINAR -->

                                    <?php if ($esSuperAdministrador): ?>

                                        <a
                                            href="<?= BASE_URL ?>index.php?url=entregas/eliminar/<?= (int) $e['id'] ?>"
                                            class="btn-danger"
                                            title="Eliminar entrega"
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
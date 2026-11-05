<?php

$titulo = 'Detalle de la Entrega';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

    <?php require APP_PATH . '/views/layouts/topbar.php'; ?>


    <div class="page-header">

        <div>

            <h2>Detalle de la Entrega</h2>

            <p>
                Información completa de la entrega registrada.
            </p>

        </div>


        <a
            href="<?= BASE_URL ?>index.php?url=entregas"
            class="btn btn-secondary"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Volver

        </a>

    </div>



    <div class="detalle-card">


        <div class="row">


            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Grado
                </label>


                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars(
                        $entrega['grado']
                    ) ?>"
                    readonly
                >

            </div>



            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Cantidad entregada
                </label>


                <input
                    type="text"
                    class="form-control"
                    value="<?= (int)
                        $entrega['cantidad_entregada'] ?>"
                    readonly
                >

            </div>



            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Fecha
                </label>


                <input
                    type="text"
                    class="form-control"
                    value="<?= date(
                        'd/m/Y',
                        strtotime(
                            $entrega['fecha']
                        )
                    ) ?>"
                    readonly
                >

            </div>



            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Hora
                </label>


                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars(
                        $entrega['hora']
                    ) ?>"
                    readonly
                >

            </div>



            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Usuario que registró
                </label>


                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars(
                        $entrega['usuario']
                    ) ?>"
                    readonly
                >

            </div>



            <div class="col-md-6 mb-4">

                <label class="form-label">
                    Fecha de Registro
                </label>


                <input
                    type="text"
                    class="form-control"
                    value="<?= date(
                        'd/m/Y H:i',
                        strtotime(
                            $entrega['fecha_registro']
                        )
                    ) ?>"
                    readonly
                >

            </div>


        </div>



        <div class="mt-4">


            <a
                href="<?= BASE_URL ?>index.php?url=entregas/editar/<?= (int) $entrega['id'] ?>"
                class="btn btn-warning"
            >

                <i class="fa-solid fa-pen"></i>

                Editar

            </a>


            <a
                href="<?= BASE_URL ?>index.php?url=entregas"
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
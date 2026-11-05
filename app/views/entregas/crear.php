<?php

$titulo = 'Nueva Entrega';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>


<div class="page-header">

    <div>

        <h2>Nueva Entrega</h2>

        <p>
            Registra los refrigerios entregados por grado.
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



<?php if (!empty($_SESSION['error'])): ?>

    <div class="alert alert-danger">

        <i class="fa-solid fa-circle-exclamation"></i>

        <?= htmlspecialchars($_SESSION['error']) ?>

    </div>

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>



<div class="form-card">


<form
    action="<?= BASE_URL ?>index.php?url=entregas/guardar"
    method="POST"
>


<div class="row">


    <!-- GRADO -->

    <div class="col-md-6 mb-3">

        <label
            class="form-label"
            for="grado"
        >

            Grado

        </label>


        <select
            name="grado"
            id="grado"
            class="form-select"
            required
        >

            <option value="">
                Seleccione grado...
            </option>


            <?php

            $grados = [

                '6A','6B','6C',
                '7A','7B','7C',
                '8A','8B','8C',
                '9A','9B','9C',
                '10A','10B','10C',
                '11A','11B','11C'

            ];

            ?>


            <?php foreach ($grados as $grado): ?>

                <option value="<?= $grado ?>">

                    <?= $grado ?>

                </option>

            <?php endforeach; ?>


        </select>

    </div>



    <!-- REFRIGERIO -->

    <div class="col-md-6 mb-3">

        <label
            class="form-label"
            for="refrigerio_id"
        >

            Refrigerio

        </label>


        <select
            name="refrigerio_id"
            id="refrigerio_id"
            class="form-select"
            required
        >

            <option value="">
                Seleccione refrigerio...
            </option>


            <?php foreach ($refrigerios as $refrigerio): ?>

                <option
                    value="<?= (int) $refrigerio['id'] ?>"
                >

                    <?= htmlspecialchars(
                        $refrigerio['nombre']
                    ) ?>

                </option>

            <?php endforeach; ?>


        </select>


        <?php if (empty($refrigerios)): ?>

            <small class="text-danger">

                No hay refrigerios activos disponibles.

            </small>

        <?php endif; ?>


    </div>



    <!-- CANTIDAD -->

    <div class="col-md-6 mb-3">

        <label
            class="form-label"
            for="cantidad_entregada"
        >

            Cantidad entregada

        </label>


        <input
            type="number"
            name="cantidad_entregada"
            id="cantidad_entregada"
            class="form-control"
            min="1"
            placeholder="Ejemplo: 50"
            required
        >


        <small class="form-text">

            Cantidad de refrigerios entregados
            a este grado.

        </small>

    </div>



    <!-- FECHA -->

    <div class="col-md-6 mb-3">

        <label
            class="form-label"
            for="fecha"
        >

            Fecha

        </label>


        <input
            type="date"
            name="fecha"
            id="fecha"
            class="form-control"
            value="<?= date('Y-m-d') ?>"
            required
        >

    </div>



    <!-- HORA -->

    <div class="col-md-6 mb-3">

        <label
            class="form-label"
            for="hora"
        >

            Hora

        </label>


        <input
            type="time"
            name="hora"
            id="hora"
            class="form-control"
            value="<?= date('H:i') ?>"
            required
        >

    </div>


</div>



<div class="d-flex gap-2 mt-4">


    <button
        type="submit"
        class="btn btn-success"
        <?= empty($refrigerios)
            ? 'disabled'
            : '' ?>
    >

        <i class="fa-solid fa-floppy-disk"></i>

        Guardar

    </button>


    <a
        href="<?= BASE_URL ?>index.php?url=entregas"
        class="btn btn-secondary"
    >

        Cancelar

    </a>


</div>


</form>


</div>

</div>


<?php

require APP_PATH . '/views/layouts/footer.php';

?>
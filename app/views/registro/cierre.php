<?php

$titulo = 'Cierre del día';

$rolUsuario = $_SESSION['usuario']['rol'] ?? '';

$puedeModificar = in_array(
    $rolUsuario,
    [
        'Administrador',
        'Super Administrador'
    ],
    true
);

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

    <?php require APP_PATH . '/views/layouts/topbar.php'; ?>


    <!-- MENSAJE DE ÉXITO -->

    <?php if (!empty($_SESSION['success'])): ?>

        <div class="registro-alert registro-alert-success">

            <i class="fa-solid fa-circle-check"></i>

            <?= htmlspecialchars(
                $_SESSION['success']
            ) ?>

        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>


    <!-- MENSAJE DE ERROR -->

    <?php if (!empty($_SESSION['error'])): ?>

        <div class="registro-alert registro-alert-error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <?= htmlspecialchars(
                $_SESSION['error']
            ) ?>

        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>


    <!-- ENCABEZADO -->

    <div class="page-header">

        <div>

            <h2>Cierre del día</h2>

            <p>
                Registra cuántos refrigerios quedaron al finalizar
                el día y guarda una fotografía como evidencia.
            </p>

        </div>


        <a
    href="<?= BASE_URL ?>index.php?url=registro/llegada"
    class="registro-nav-button registro-nav-button-llegada"
    title="Volver al registro de llegada"
>

    <i class="fa-solid fa-truck-ramp-box"></i>

    <span>Registro de llegada</span>

</a>

    </div>



    <!-- CONSULTAR FECHA -->

    <div class="registro-date-card">

        <form
            method="GET"
            action="<?= BASE_URL ?>index.php"
            class="registro-date-form"
        >

            <input
                type="hidden"
                name="url"
                value="registro/cierre"
            >


            <div>

                <label class="form-label">
                    Consultar fecha
                </label>

                <input
                    type="date"
                    name="fecha"
                    class="form-control"
                    value="<?= htmlspecialchars($fecha) ?>"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >

                <i class="fa-solid fa-magnifying-glass"></i>

                Consultar

            </button>

        </form>

    </div>



    <!-- RESUMEN DEL DÍA -->

    <div class="registro-summary-grid">


        <!-- RECIBIDOS -->

        <div class="registro-summary-card">

            <div class="registro-summary-icon received">

                <i class="fa-solid fa-truck-ramp-box"></i>

            </div>


            <div>

                <span>
                    Refrigerios recibidos
                </span>

                <strong>
                    <?= (int) $resumen['cantidad_recibida'] ?>
                </strong>

            </div>

        </div>



        <!-- ENTREGADOS -->

        <div class="registro-summary-card">

            <div class="registro-summary-icon delivered">

                <i class="fa-solid fa-hand-holding-heart"></i>

            </div>


            <div>

                <span>
                    Refrigerios entregados
                </span>

                <strong>
                    <?= (int) $resumen['cantidad_entregada'] ?>
                </strong>

            </div>

        </div>



        <!-- SOBRANTES -->

        <div class="registro-summary-card highlight">

            <div class="registro-summary-icon leftover">

                <i class="fa-solid fa-box-open"></i>

            </div>


            <div>

                <span>
                    Refrigerios restantes
                </span>

                <strong>
                    <?= (int) $resumen['cantidad_sobrante'] ?>
                </strong>

            </div>

        </div>


    </div>



    <!-- CONTENIDO -->

    <div class="registro-grid">


        <!-- FORMULARIO -->

        <div class="registro-card">


            <div class="registro-card-header">

                <div class="registro-icon">

                    <i class="fa-solid fa-clipboard-check"></i>

                </div>


                <div>

                    <h3>
                        Registrar cierre
                    </h3>

                    <p>
                        Guarda la fotografía de los refrigerios
                        que quedaron al finalizar el día.
                    </p>

                </div>

            </div>



            <form
                action="<?= BASE_URL ?>index.php?url=registro/guardarCierre"
                method="POST"
                enctype="multipart/form-data"
                id="formRegistroCierre"
            >


                <!-- FECHA REAL QUE SE ENVÍA -->

                <input
                    type="hidden"
                    name="fecha"
                    value="<?= htmlspecialchars($fecha) ?>"
                >


                <div class="row">


                    <!-- FECHA -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Fecha
                        </label>


                        <input
                            type="date"
                            class="form-control"
                            value="<?= htmlspecialchars($fecha) ?>"
                            disabled
                        >

                    </div>



                    <!-- HORA -->

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Hora del cierre
                        </label>


                        <input
                            type="time"
                            name="hora"
                            class="form-control"
                            value="<?= date('H:i') ?>"
                            required
                        >

                    </div>



                    <!-- RECIBIDOS -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Recibidos
                        </label>


                        <input
                            type="text"
                            class="form-control registro-readonly"
                            value="<?= (int) $resumen['cantidad_recibida'] ?>"
                            readonly
                        >

                    </div>



                    <!-- ENTREGADOS -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Entregados
                        </label>


                        <input
                            type="text"
                            class="form-control registro-readonly"
                            value="<?= (int) $resumen['cantidad_entregada'] ?>"
                            readonly
                        >

                    </div>



                    <!-- SOBRANTES -->

                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Refrigerios sobrantes
                        </label>


                        <input
                            type="text"
                            class="form-control registro-readonly registro-sobrante"
                            value="<?= (int) $resumen['cantidad_sobrante'] ?>"
                            readonly
                        >

                    </div>



                    <!-- FOTO -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Fotografía del sobrante
                        </label>


                        <label
                            class="registro-upload"
                            for="fotoCierre"
                        >

                            <i class="fa-solid fa-camera"></i>


                            <strong>
                                Tomar o seleccionar fotografía
                            </strong>


                            <span>
                                JPG, PNG o WEBP — máximo 5 MB
                            </span>

                        </label>



                        <input
                            type="file"
                            name="foto"
                            id="fotoCierre"
                            accept="image/jpeg,image/png,image/webp"
                            capture="environment"
                            class="registro-file-input"
                            required
                        >



                        <!-- PREVISUALIZACIÓN -->

                        <div
                            id="previewCierre"
                            class="registro-preview"
                            style="display:none;"
                        >

                            <img
                                id="previewCierreImagen"
                                src=""
                                alt="Vista previa"
                            >


                            <div>

                                <strong id="nombreFotoCierre">
                                    Fotografía seleccionada
                                </strong>


                                <button
                                    type="button"
                                    id="quitarFotoCierre"
                                    class="registro-remove-photo"
                                >

                                    <i class="fa-solid fa-xmark"></i>

                                    Cambiar

                                </button>

                            </div>

                        </div>

                    </div>



                    <!-- OBSERVACIONES -->

                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Observaciones
                        </label>


                        <textarea
                            name="observaciones"
                            class="form-control"
                            rows="4"
                            placeholder="Escribe alguna observación del cierre..."
                        ></textarea>

                    </div>


                </div>



                <!-- BOTONES -->

                <div class="registro-form-actions">


                    <button
                        type="submit"
                        class="btn btn-success"
                        <?= $resumen['cantidad_recibida'] <= 0
                            ? 'disabled title="Primero registra la llegada de los refrigerios."'
                            : '' ?>
                    >

                        <i class="fa-solid fa-cloud-arrow-up"></i>

                        Guardar cierre

                    </button>


                    <a
                        href="<?= BASE_URL ?>index.php?url=dashboard"
                        class="btn btn-secondary"
                    >

                        Cancelar

                    </a>


                </div>


            </form>


        </div>



        <!-- INFORMACIÓN -->

        <div class="registro-info-card">


            <div class="registro-info-icon">

                <i class="fa-solid fa-calculator"></i>

            </div>


            <h3>
                Resumen del día
            </h3>


            <p>

                El sistema calcula automáticamente los refrigerios
                restantes utilizando la cantidad recibida y las
                entregas registradas.

            </p>



            <div class="registro-formula">

                <span>
                    Recibidos
                </span>


                <i class="fa-solid fa-minus"></i>


                <span>
                    Entregados
                </span>


                <i class="fa-solid fa-equals"></i>


                <strong>
                    Sobrantes
                </strong>

            </div>



            <div class="registro-info-item">

                <i class="fa-solid fa-truck-ramp-box"></i>


                <span>

                    Recibidos:

                    <strong>
                        <?= (int) $resumen['cantidad_recibida'] ?>
                    </strong>

                </span>

            </div>



            <div class="registro-info-item">

                <i class="fa-solid fa-hand-holding-heart"></i>


                <span>

                    Entregados:

                    <strong>
                        <?= (int) $resumen['cantidad_entregada'] ?>
                    </strong>

                </span>

            </div>



            <div class="registro-info-item">

                <i class="fa-solid fa-box-open"></i>


                <span>

                    Sobrantes:

                    <strong>
                        <?= (int) $resumen['cantidad_sobrante'] ?>
                    </strong>

                </span>

            </div>


        </div>


    </div>



    <!-- HISTORIAL -->

    <div class="registro-history">


        <div class="registro-history-header">

            <div>

                <h3>
                    Historial de cierres
                </h3>


                <p>
                    Fotografías de los refrigerios sobrantes
                    registradas anteriormente.
                </p>

            </div>


            <span class="registro-count">

                <?= count($cierres) ?>

                cierre(s)

            </span>

        </div>



        <div class="registro-table-wrapper">


            <table class="table registro-table">


                <thead>

                    <tr>

                        <th>
                            Fotografía
                        </th>


                        <th>
                            Fecha
                        </th>


                        <th>
                            Hora
                        </th>


                        <th>
                            Recibidos
                        </th>


                        <th>
                            Entregados
                        </th>


                        <th>
                            Sobrantes
                        </th>


                        <th>
                            Registrado por
                        </th>


                        <?php if ($puedeModificar): ?>

                            <th>
                                Acciones
                            </th>

                        <?php endif; ?>


                    </tr>

                </thead>



                <tbody>


                    <?php if (empty($cierres)): ?>


                        <tr>

                            <td
                                colspan="<?= $puedeModificar ? 8 : 7 ?>"
                                class="registro-empty"
                            >

                                <i class="fa-solid fa-box-open"></i>


                                <span>
                                    Todavía no hay cierres registrados.
                                </span>

                            </td>

                        </tr>


                    <?php else: ?>


                        <?php foreach ($cierres as $cierre): ?>


                            <tr>


                                <!-- FOTO -->

                                <td>

                                    <a
                                        href="<?= BASE_URL ?>index.php?url=registro/foto/<?= (int) $cierre['id'] ?>"
                                        target="_blank"
                                        title="Ver fotografía"
                                    >

                                        <img
                                            src="<?= BASE_URL ?>index.php?url=registro/foto/<?= (int) $cierre['id'] ?>"
                                            class="registro-thumbnail"
                                            alt="Foto del cierre"
                                        >

                                    </a>

                                </td>



                                <!-- FECHA -->

                                <td>

                                    <?= !empty($cierre['fecha'])
                                        ? date(
                                            'd/m/Y',
                                            strtotime($cierre['fecha'])
                                        )
                                        : 'Sin fecha'
                                    ?>

                                </td>



                                <!-- HORA -->

                                <td>

                                    <?= htmlspecialchars(
                                        $cierre['hora'] ?? ''
                                    ) ?>

                                </td>



                                <!-- RECIBIDOS -->

                                <td>

                                    <?= (int) (
                                        $cierre['cantidad_recibida']
                                        ?? 0
                                    ) ?>

                                </td>



                                <!-- ENTREGADOS -->

                                <td>

                                    <?= (int) (
                                        $cierre['cantidad_entregada']
                                        ?? 0
                                    ) ?>

                                </td>



                                <!-- SOBRANTES -->

                                <td>

                                    <strong class="registro-number">

                                        <?= (int) (
                                            $cierre['cantidad_sobrante']
                                            ?? 0
                                        ) ?>

                                    </strong>

                                </td>



                                <!-- USUARIO -->

                                <td>

                                    <?= htmlspecialchars(
                                        $cierre['usuario']
                                        ?? 'Usuario eliminado'
                                    ) ?>

                                </td>



                                <!-- ACCIONES -->

                                <?php if ($puedeModificar): ?>

                                    <td>

                                        <div class="acciones">


                                            <!-- EDITAR -->

                                            <a
                                                href="<?= BASE_URL ?>index.php?url=registro/editar/<?= (int) $cierre['id'] ?>"
                                                class="btn-warning"
                                                title="Editar cierre"
                                            >

                                                <i class="fa-solid fa-pen"></i>

                                            </a>



                                            <!-- ELIMINAR -->

                                            <a
                                                href="<?= BASE_URL ?>index.php?url=registro/eliminar/<?= (int) $cierre['id'] ?>"
                                                class="btn-danger"
                                                title="Eliminar cierre"
                                            >

                                                <i class="fa-solid fa-trash"></i>

                                            </a>


                                        </div>

                                    </td>

                                <?php endif; ?>


                            </tr>


                        <?php endforeach; ?>


                    <?php endif; ?>


                </tbody>


            </table>


        </div>


    </div>


</div>



<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const input =
            document.getElementById(
                'fotoCierre'
            );


        const preview =
            document.getElementById(
                'previewCierre'
            );


        const previewImagen =
            document.getElementById(
                'previewCierreImagen'
            );


        const nombre =
            document.getElementById(
                'nombreFotoCierre'
            );


        const quitar =
            document.getElementById(
                'quitarFotoCierre'
            );


        const form =
            document.getElementById(
                'formRegistroCierre'
            );


        if (
            !input ||
            !preview ||
            !previewImagen
        ) {

            return;

        }



        input.addEventListener(
            'change',
            function () {


                const archivo =
                    this.files[0];


                if (!archivo) {

                    preview.style.display =
                        'none';

                    previewImagen.src =
                        '';

                    return;

                }



                /* VALIDAR TAMAÑO */

                if (
                    archivo.size >
                    5 * 1024 * 1024
                ) {

                    alert(
                        'La fotografía no puede superar los 5 MB.'
                    );


                    this.value =
                        '';


                    preview.style.display =
                        'none';


                    previewImagen.src =
                        '';


                    return;

                }



                /* VALIDAR TIPO */

                const tiposPermitidos = [

                    'image/jpeg',

                    'image/png',

                    'image/webp'

                ];


                if (
                    !tiposPermitidos.includes(
                        archivo.type
                    )
                ) {

                    alert(
                        'Solo se permiten fotografías JPG, PNG o WEBP.'
                    );


                    this.value =
                        '';


                    preview.style.display =
                        'none';


                    previewImagen.src =
                        '';


                    return;

                }



                /* PREVISUALIZACIÓN */

                const lector =
                    new FileReader();


                lector.onload =
                    function (event) {


                        previewImagen.src =
                            event.target.result;


                        if (nombre) {

                            nombre.textContent =
                                archivo.name;

                        }


                        preview.style.display =
                            'flex';

                    };


                lector.readAsDataURL(
                    archivo
                );


            }
        );



        /* CAMBIAR FOTO */

        if (quitar) {

            quitar.addEventListener(
                'click',
                function () {


                    input.value =
                        '';


                    previewImagen.src =
                        '';


                    preview.style.display =
                        'none';

                }
            );

        }



        /* VALIDAR FORMULARIO */

        if (form) {

            form.addEventListener(
                'submit',
                function (event) {


                    if (
                        !input.files.length
                    ) {

                        event.preventDefault();


                        alert(
                            'Debes tomar o seleccionar una fotografía.'
                        );

                    }

                }
            );

        }


    }
);

</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formRegistroCierre');
    if (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm('¿Confirmas que deseas guardar el cierre del día? Verifica las cantidades y la fotografía antes de continuar.')) {
                event.preventDefault();
            }
        });
    }
});
</script>

<?php require APP_PATH . '/views/layouts/footer.php'; ?>
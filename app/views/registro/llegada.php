<?php

$titulo = 'Registro llegada';

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

            <?= htmlspecialchars($_SESSION['success']) ?>

        </div>

        <?php unset($_SESSION['success']); ?>

    <?php endif; ?>


    <!-- MENSAJE DE ERROR -->

    <?php if (!empty($_SESSION['error'])): ?>

        <div class="registro-alert registro-alert-error">

            <i class="fa-solid fa-circle-exclamation"></i>

            <?= htmlspecialchars($_SESSION['error']) ?>

        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>


    <!-- ENCABEZADO -->

    <div class="page-header">

        <div>

            <h2>Registro de llegada</h2>

            <p>
                Consulta y registra la llegada de los
                refrigerios con evidencia fotográfica.
            </p>

        </div>


        <a
    href="<?= BASE_URL ?>index.php?url=registro/cierre"
    class="registro-nav-button registro-nav-button-cierre"
    title="Ir al cierre del día"
>

    <i class="fa-solid fa-box-open"></i>

    <span>Cierre del día</span>

</a>

    </div>



    <!-- ===================================================== -->
    <!-- FORMULARIO DE REGISTRO -->
    <!-- SOLO ADMINISTRADOR Y SUPER ADMINISTRADOR -->
    <!-- ===================================================== -->

    <?php if ($puedeModificar): ?>

        <div class="registro-grid">


            <!-- FORMULARIO -->

            <div class="registro-card">

                <div class="registro-card-header">

                    <div class="registro-icon">

                        <i class="fa-solid fa-camera"></i>

                    </div>

                    <div>

                        <h3>
                            Registrar llegada
                        </h3>

                        <p>
                            La fotografía quedará
                            almacenada como evidencia.
                        </p>

                    </div>

                </div>


                <form
                    action="<?= BASE_URL ?>index.php?url=registro/guardarLlegada"
                    method="POST"
                    enctype="multipart/form-data"
                    id="formRegistroLlegada"
                >

                    <div class="row">


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
                                Hora de llegada
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



                        <!-- CANTIDAD -->

                        <div class="col-md-12 mb-3">

                            <label
                                class="form-label"
                                for="cantidad_recibida"
                            >
                                Cantidad de refrigerios recibidos
                            </label>

                            <input
                                type="number"
                                name="cantidad_recibida"
                                id="cantidad_recibida"
                                class="form-control"
                                min="0"
                                step="1"
                                placeholder="Ejemplo: 150"
                                required
                            >

                            <small class="registro-help">

                                Esta cantidad se utilizará para
                                calcular el sobrante al finalizar
                                el día.

                            </small>

                        </div>



                        <!-- FOTOGRAFÍA -->

                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Fotografía de llegada

                            </label>


                            <label
                                class="registro-upload"
                                for="fotoLlegada"
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
                                id="fotoLlegada"
                                accept="image/jpeg,image/png,image/webp"
                                capture="environment"
                                class="registro-file-input"
                                required
                            >


                            <!-- VISTA PREVIA -->

                            <div
                                id="previewLlegada"
                                class="registro-preview"
                                style="display: none;"
                            >

                                <img
                                    id="previewLlegadaImagen"
                                    src=""
                                    alt="Vista previa"
                                >

                                <div>

                                    <strong
                                        id="nombreFotoLlegada"
                                    >
                                        Fotografía seleccionada
                                    </strong>

                                    <button
                                        type="button"
                                        id="quitarFotoLlegada"
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

                            <label
                                class="form-label"
                                for="observaciones"
                            >

                                Observaciones

                            </label>

                            <textarea
                                name="observaciones"
                                id="observaciones"
                                class="form-control"
                                rows="4"
                                placeholder="Escribe alguna observación..."
                            ></textarea>

                        </div>

                    </div>



                    <!-- BOTONES -->

                    <div class="registro-form-actions">

                        <button
                            type="submit"
                            class="btn btn-success"
                        >

                            <i class="fa-solid fa-cloud-arrow-up"></i>

                            Guardar registro

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

                    <i class="fa-solid fa-database"></i>

                </div>

                <h3>
                    Registro fotográfico
                </h3>

                <p>

                    Cada fotografía queda asociada
                    a la fecha, hora, cantidad recibida
                    y usuario que realizó el registro.

                </p>


                <div class="registro-info-item">

                    <i class="fa-solid fa-image"></i>

                    <span>
                        Fotografía almacenada en MariaDB
                    </span>

                </div>


                <div class="registro-info-item">

                    <i class="fa-solid fa-calendar"></i>

                    <span>
                        Fecha y hora de llegada
                    </span>

                </div>


                <div class="registro-info-item">

                    <i class="fa-solid fa-boxes-stacked"></i>

                    <span>
                        Cantidad recibida
                    </span>

                </div>


                <div class="registro-info-item">

                    <i class="fa-solid fa-user"></i>

                    <span>
                        Usuario responsable
                    </span>

                </div>

            </div>

        </div>


    <?php else: ?>

        <!-- ================================================= -->
        <!-- VISTA PARA SUPERVISOR -->
        <!-- ================================================= -->

        <div class="registro-info-card">

            <div class="registro-info-icon">

                <i class="fa-solid fa-eye"></i>

            </div>

            <h3>
                Consulta de registros
            </h3>

            <p>

                Tu rol de Supervisor tiene permisos
                únicamente para consultar los registros
                de llegada.

            </p>

            <div class="registro-info-item">

                <i class="fa-solid fa-eye"></i>

                <span>
                    Puedes visualizar los registros.
                </span>

            </div>

            <div class="registro-info-item">

                <i class="fa-solid fa-ban"></i>

                <span>
                    No puedes crear, editar ni eliminar registros.
                </span>

            </div>

        </div>

    <?php endif; ?>



    <!-- ===================================================== -->
    <!-- HISTORIAL -->
    <!-- ===================================================== -->

    <div class="registro-history">

        <div class="registro-history-header">

            <div>

                <h3>
                    Historial de llegadas
                </h3>

                <p>
                    Fotografías y registros guardados.
                </p>

            </div>


            <span class="registro-count">

                <?= count($llegadas ?? []) ?>

                registro(s)

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
                            Registrado por
                        </th>

                        <th>
                            Observaciones
                        </th>


                        <?php if ($puedeModificar): ?>

                            <th>
                                Acciones
                            </th>

                        <?php endif; ?>

                    </tr>

                </thead>



                <tbody>

                    <?php if (empty($llegadas)): ?>

                        <tr>

                            <td
                                colspan="<?= $puedeModificar ? 7 : 6 ?>"
                                class="registro-empty"
                            >

                                <i class="fa-solid fa-camera"></i>

                                No hay registros de llegada.

                            </td>

                        </tr>


                    <?php else: ?>


                        <?php foreach ($llegadas as $llegada): ?>

                            <tr>


                                <!-- FOTO -->

                                <td>

                                    <?php if (!empty($llegada['id'])): ?>

                                        <a
                                            href="<?= BASE_URL ?>index.php?url=registro/foto/<?= (int) $llegada['id'] ?>"
                                            target="_blank"
                                        >

                                            <img
                                                src="<?= BASE_URL ?>index.php?url=registro/foto/<?= (int) $llegada['id'] ?>"
                                                class="registro-thumbnail"
                                                alt="Foto de llegada"
                                            >

                                        </a>

                                    <?php else: ?>

                                        Sin fotografía

                                    <?php endif; ?>

                                </td>



                                <!-- FECHA -->

                                <td>

                                    <?php if (!empty($llegada['fecha'])): ?>

                                        <?= date(
                                            'd/m/Y',
                                            strtotime(
                                                $llegada['fecha']
                                            )
                                        ) ?>

                                    <?php else: ?>

                                        Sin fecha

                                    <?php endif; ?>

                                </td>



                                <!-- HORA -->

                                <td>

                                    <?= !empty($llegada['hora'])
                                        ? htmlspecialchars(
                                            $llegada['hora']
                                        )
                                        : 'Sin hora'
                                    ?>

                                </td>



                                <!-- CANTIDAD -->

                                <td>

                                    <strong class="registro-number">

                                        <?= (int) (
                                            $llegada['cantidad_recibida'] ?? 0
                                        ) ?>

                                    </strong>

                                </td>



                                <!-- USUARIO -->

                                <td>

                                    <?= !empty($llegada['usuario'])
                                        ? htmlspecialchars(
                                            $llegada['usuario']
                                        )
                                        : 'Usuario eliminado'
                                    ?>

                                </td>



                                <!-- OBSERVACIONES -->

                                <td>

                                    <?php if (
                                        !empty(
                                            $llegada['observaciones']
                                        )
                                    ): ?>

                                        <?= htmlspecialchars(
                                            $llegada['observaciones']
                                        ) ?>

                                    <?php else: ?>

                                        Sin observaciones

                                    <?php endif; ?>

                                </td>



                                <!-- ACCIONES -->

                                <?php if ($puedeModificar): ?>

                                    <td>

                                        <div class="acciones">


                                            <!-- EDITAR -->

                                            <a
                                                href="<?= BASE_URL ?>index.php?url=registro/editar/<?= (int) $llegada['id'] ?>"
                                                class="btn-warning"
                                                title="Editar registro"
                                            >

                                                <i class="fa-solid fa-pen"></i>

                                            </a>



                                            <!-- ELIMINAR -->

                                            <a
                                                href="<?= BASE_URL ?>index.php?url=registro/eliminar/<?= (int) $llegada['id'] ?>"
                                                class="btn-danger"
                                                title="Eliminar registro"
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



<!-- ========================================================= -->
<!-- JAVASCRIPT -->
<!-- ========================================================= -->

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const input =
            document.getElementById(
                'fotoLlegada'
            );

        const preview =
            document.getElementById(
                'previewLlegada'
            );

        const previewImagen =
            document.getElementById(
                'previewLlegadaImagen'
            );

        const nombre =
            document.getElementById(
                'nombreFotoLlegada'
            );

        const quitar =
            document.getElementById(
                'quitarFotoLlegada'
            );

        const form =
            document.getElementById(
                'formRegistroLlegada'
            );


        /*
         * Si el usuario es Supervisor
         * no existe el formulario.
         */
        if (
            !input ||
            !preview ||
            !previewImagen
        ) {

            return;

        }


        <!-- CAMBIO DE FOTO -->

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


                /*
                 * VALIDAR TAMAÑO
                 */

                if (
                    archivo.size >
                    5 * 1024 * 1024
                ) {

                    alert(
                        'La fotografía no puede superar los 5 MB.'
                    );

                    this.value = '';

                    preview.style.display =
                        'none';

                    return;

                }


                /*
                 * VALIDAR TIPO
                 */

                const tipos = [

                    'image/jpeg',

                    'image/png',

                    'image/webp'

                ];


                if (
                    !tipos.includes(
                        archivo.type
                    )
                ) {

                    alert(
                        'Solo se permiten fotografías JPG, PNG o WEBP.'
                    );

                    this.value = '';

                    preview.style.display =
                        'none';

                    return;

                }


                /*
                 * VISTA PREVIA
                 */

                const lector =
                    new FileReader();


                lector.onload =
                    function (event) {

                        previewImagen.src =
                            event.target.result;

                        nombre.textContent =
                            archivo.name;

                        preview.style.display =
                            'flex';

                    };


                lector.readAsDataURL(
                    archivo
                );

            }
        );


        /*
         * CAMBIAR FOTO
         */

        if (quitar) {

            quitar.addEventListener(
                'click',
                function () {

                    input.value = '';

                    previewImagen.src =
                        '';

                    preview.style.display =
                        'none';

                }
            );

        }


        /*
         * VALIDAR FORMULARIO
         */

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
    const form = document.getElementById('formRegistroLlegada');
    if (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm('¿Confirmas que deseas guardar este registro de llegada? Verifica que la fecha, la cantidad y la fotografía sean correctas.')) {
                event.preventDefault();
            }
        });
    }
});
</script>

<?php require APP_PATH . '/views/layouts/footer.php'; ?>
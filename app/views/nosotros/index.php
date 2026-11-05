<?php

$titulo = '¿Quiénes Somos?';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="form-card">

    <div class="row align-items-center">

        <div class="col-md-7">

            <h3>NutriControl La Sallista</h3>

            <p>
                NutriControl La Sallista es una plataforma desarrollada
                para facilitar la administración y el control de los
                refrigerios escolares dentro de la institución.
            </p>

            <p>
                Nuestro objetivo es organizar de manera sencilla y
                eficiente la información relacionada con los estudiantes,
                los refrigerios y las entregas.
            </p>

            <p>
                La plataforma permite llevar un mejor control de los
                procesos, reducir errores en el manejo de la información
                y facilitar el trabajo administrativo.
            </p>

            <cite>Developer: Polanco</cite>

        </div>

        <div class="col-md-5 text-center">

            <i
                class="fa-solid fa-utensils"
                style="font-size: 100px; margin-bottom: 20px;">
            </i>

            <h4>NutriControl</h4>

            <p>
                Organización, control y bienestar escolar.
            </p>

        </div>

    </div>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
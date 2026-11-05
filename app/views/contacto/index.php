<?php

$titulo = 'Información de contacto';

require APP_PATH . '/views/layouts/header.php';
require APP_PATH . '/views/layouts/sidebar.php';

?>

<div class="main-content">

<?php require APP_PATH . '/views/layouts/topbar.php'; ?>

<div class="form-card">

    <div class="row">

        <div class="col-md-6">

            <h3>Contáctanos</h3>

            <p>
                Si tienes alguna pregunta, sugerencia o necesitas
                información sobre NutriControl La Sallista, puedes
                comunicarte con nosotros mediante los siguientes medios.
            </p>
            <cite>Developer: Polanco</cite>

            <div class="mt-4">

                <p>
                    <i class="fa-solid fa-school me-3"></i>
                    <strong>Institución:</strong>
                    San Juan Bautista De La Salle
                </p>

                <p>
                    <i class="fa-solid fa-location-dot me-3"></i>
                    <strong>Ubicación:</strong>
                    Medellín, Antioquia, Colombia
                </p>

                <p>
                    <i class="fa-solid fa-envelope me-3"></i>
                    <strong>Correo:</strong>
                    nutricontrollasallista@gmail.com
                </p>

                <p>
                    <i class="fa-solid fa-phone me-3"></i>
                    <strong>Teléfono:</strong>
                    +57 3234207659
                </p>

            </div>

        </div>

        <div class="col-md-6 text-center">

            <i
                class="fa-solid fa-address-book"
                style="font-size: 100px; margin-bottom: 25px;">
            </i>

            <h3>NutriControl La Sallista</h3>

            <p>
                Estamos para ayudarte.
            </p>

           <div class="mt-4">

    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=nutricontrollasallista@gmail.com"
   target="_blank"
   class="btn btn-primary me-2">
    <i class="fa-solid fa-envelope"></i>
    Correo
</a>

    <a href="tel:+573234207659"
   class="btn btn-success">
    <i class="fa-solid fa-phone"></i>
    Llamar
</a>

</div>

        </div>

    </div>

</div>

</div>

<?php

require APP_PATH . '/views/layouts/footer.php';

?>
</div>


<!-- BOOTSTRAP -->

<script
    src="<?= BASE_URL ?>public/js/app.js"
></script>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
></script>


<!-- SIDEBAR -->

<script
    src="<?= BASE_URL ?>public/js/sidebar.js"
></script>


<!-- DASHBOARD -->

<script
    src="<?= BASE_URL ?>public/js/dashboard.js"
></script>


<?php

if (
    file_exists(
        PUBLIC_PATH .
        '/js/' .
        strtolower($titulo ?? '') .
        '.js'
    )
) {

?>

<script
    src="<?= BASE_URL ?>public/js/<?= strtolower($titulo) ?>.js"
></script>

<?php

}

?>


<!-- =========================================================
     AYUDA FLOTANTE
========================================================= -->
<?php if (isset($_SESSION['usuario'])): ?>

<button
    type="button"
    class="help-floating-button"
    id="help-floating-button"
    aria-label="Abrir ayuda"
    title="Ayuda"
>
    <i class="fa-solid fa-question"></i>
</button>

<div
    class="help-panel"
    id="help-panel"
    role="dialog"
    aria-modal="false"
    aria-labelledby="help-panel-heading"
>
    <div class="help-panel-header">
        <div class="help-panel-title">
            <i class="fa-solid fa-circle-question"></i>
            <div>
                <h3 id="help-panel-heading">Ayuda de NutriControl</h3>
                <p>Guía rápida para utilizar cada apartado.</p>
            </div>
        </div>

        <button
            type="button"
            class="help-close"
            id="help-close"
            aria-label="Cerrar ayuda"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="help-current" id="help-current"></div>

    <p class="help-all-title">Indicaciones de cada apartado</p>

    <div class="help-section-list" id="help-section-list"></div>
</div>

<!-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN -->
<div
    class="delete-modal-backdrop"
    id="delete-modal-backdrop"
    aria-hidden="true"
>
    <div
        class="delete-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="delete-modal-title"
    >
        <div class="delete-modal-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>

        <h3 id="delete-modal-title">¿Eliminar este registro?</h3>

        <p id="delete-modal-message">
            Esta acción no se puede deshacer. ¿Deseas continuar?
        </p>

        <div class="delete-modal-actions">
            <button type="button" class="delete-cancel" id="delete-cancel">
                Cancelar
            </button>

            <button type="button" class="delete-confirm" id="delete-confirm">
                Eliminar
            </button>
        </div>
    </div>
</div>

<?php endif; ?>

</body>
</html>

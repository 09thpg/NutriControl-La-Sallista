<div class="topbar">

    <div class="topbar-left">

        <h1><?= $titulo ?? APP_NAME ?></h1>

        <span>

            Bienvenido,

            <strong>

                <?= $_SESSION['usuario']['nombre'] ?>

                <?= $_SESSION['usuario']['apellido'] ?>

            </strong>

        </span>

    </div>

    <div class="topbar-right">

        <div class="topbar-date">

            <i class="fa-solid fa-calendar-days"></i>

            <?= date('d/m/Y') ?>

        </div>

        <div class="topbar-user-container">

    <button
        type="button"
        class="topbar-user"
        id="topbar-user-button">

        <img
            src="<?= BASE_URL ?>public/img/avatars/<?= htmlspecialchars($_SESSION['usuario']['avatar'] ?? 'avatar1.png') ?>"
            alt="Foto de perfil">

        <div class="topbar-user-info">

            <h4>
                <?= htmlspecialchars($_SESSION['usuario']['nombre'] ?? 'Usuario') ?>
            </h4>

            <span>
                <?= htmlspecialchars($_SESSION['usuario']['rol'] ?? 'Usuario') ?>
            </span>

        </div>

        <i
            class="fa-solid fa-chevron-down topbar-user-arrow">
        </i>

    </button>

    <div
    class="topbar-user-menu"
    id="topbar-user-menu"
    hidden>

    <a
        href="<?= BASE_URL ?>index.php?url=perfil"
        class="topbar-menu-item">

        <i class="fa-solid fa-user"></i>

        <span>
            Mi perfil
        </span>

    </a>

    <a
        href="<?= BASE_URL ?>index.php?url=auth/logout"
        class="topbar-menu-item logout">

        <i class="fa-solid fa-right-from-bracket"></i>

        <span>
            Cerrar sesión
        </span>

    </a>

</div>

</div>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const container = document.querySelector(".topbar-user-container");
    const button = document.getElementById("topbar-user-button");
    const menu = document.getElementById("topbar-user-menu");

    if (!container || !button || !menu) {
        console.error("No se encontró el menú del usuario.");
        return;
    }

    button.addEventListener("click", function (event) {

        event.preventDefault();
        event.stopPropagation();

        if (menu.hidden) {

            menu.hidden = false;

            container.classList.add("active");

        } else {

            menu.hidden = true;

            container.classList.remove("active");

        }

    });

    menu.addEventListener("click", function (event) {

        event.stopPropagation();

    });

    document.addEventListener("click", function () {

        menu.hidden = true;

        container.classList.remove("active");

    });

});

</script>
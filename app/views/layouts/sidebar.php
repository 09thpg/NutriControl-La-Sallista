<?php

$rolUsuario = $_SESSION['usuario']['rol'] ?? '';

?>

<div class="sidebar" id="sidebar">

    <!-- LOGO -->
    <div class="sidebar-logo">
        <img src="<?= BASE_URL ?>public/img/logo.png" alt="Logo">
        <h2>NutriControl</h2>
        <span>La Sallista</span>
    </div>

    <!-- MENÚ -->
    <ul class="sidebar-menu">

        <!-- 1. DASHBOARD -->
        <li>
            <a href="<?= BASE_URL ?>index.php?url=dashboard" title="Dashboard">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- 2. REGISTRO: LLEGADA Y CIERRE DEL DÍA -->
        <?php
        $rolesRegistro = [
            'Supervisor',
            'Administrador',
            'Super Administrador'
        ];

        $puedeVerRegistro = in_array($rolUsuario, $rolesRegistro, true);
        $urlActual = $_GET['url'] ?? '';
        $registroAbierto = strpos($urlActual, 'registro') === 0;
        ?>

        <?php if ($puedeVerRegistro): ?>
            <li class="registro-dropdown <?= $registroAbierto ? 'open' : '' ?>">
                <button
                    type="button"
                    class="registro-dropdown-toggle"
                    id="registroDropdownToggle"
                    title="Registro"
                    aria-expanded="<?= $registroAbierto ? 'true' : 'false' ?>"
                >
                    <i class="fa-solid fa-camera"></i>
                    <span>Registro</span>
                    <i class="fa-solid fa-chevron-down registro-chevron"></i>
                </button>

                <ul class="registro-submenu">
                    <li>
                        <a href="<?= BASE_URL ?>index.php?url=registro/llegada" title="Registro llegada">
                            <i class="fa-solid fa-truck-ramp-box"></i>
                            <span>Registro llegada</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>index.php?url=registro/cierre" title="Cierre del día">
                            <i class="fa-solid fa-box-open"></i>
                            <span>Cierre del día</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php endif; ?>

        <!-- 3. REFRIGERIOS -->
        <li>
            <a href="<?= BASE_URL ?>index.php?url=refrigerios" title="Refrigerios">
                <i class="fa-solid fa-utensils"></i>
                <span>Refrigerios</span>
            </a>
        </li>

        <!-- 4. ENTREGAS -->
        <li>
            <a href="<?= BASE_URL ?>index.php?url=entregas" title="Entregas">
                <i class="fa-solid fa-clipboard-check"></i>
                <span>Entregas</span>
            </a>
        </li>

        <!-- 5. REPORTES -->
        <li>
            <a href="<?= BASE_URL ?>index.php?url=reportes" title="Reportes">
                <i class="fa-solid fa-chart-column"></i>
                <span>Reportes</span>
            </a>
        </li>

        <!-- 6. USUARIOS -->
        <li>
            <a href="<?= BASE_URL ?>index.php?url=usuarios" title="Usuarios">
                <i class="fa-solid fa-users"></i>
                <span>Usuarios</span>
            </a>
        </li>
<!-- CONFIGURACIÓN -->
        <li>
            <a href="<?= BASE_URL ?>index.php?url=configuracion" title="Configuración">
                <i class="fa-solid fa-gear"></i>
                <span>Configuración</span>
            </a>
        </li>

        <!-- ¿QUIÉNES SOMOS? -->
        <li>
            <a href="<?= BASE_URL ?>index.php?url=nosotros" title="¿Quiénes Somos?">
                <i class="fa-solid fa-circle-info"></i>
                <span>¿Quiénes Somos?</span>
            </a>
        </li>

        <!-- INFORMACIÓN DE CONTACTO -->
        <li>
            <a href="<?= BASE_URL ?>index.php?url=contacto" title="Información de contacto">
                <i class="fa-solid fa-address-book"></i>
                <span>Información de contacto</span>
            </a>
        </li>

        <!-- MODO MANTENIMIENTO: SOLO SUPER ADMINISTRADOR -->
        <?php if ($rolUsuario === 'Super Administrador'): ?>
            <li>
                <a href="<?= BASE_URL ?>index.php?url=mantenimiento" title="Modo mantenimiento">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span>Modo mantenimiento</span>
                </a>
            </li>
        <?php endif; ?>

    </ul>

    <!-- CERRAR SESIÓN -->
    <div class="sidebar-footer">
        <a
            href="<?= BASE_URL ?>index.php?url=auth/logout"
            title="Cerrar sesión"
        >
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Cerrar sesión</span>
        </a>
    </div>

</div>

<?php

class Router
{
    public function ejecutar(): void
    {
        $url = $_GET['url'] ?? '';

        $url = trim($url, '/');

        if ($url === '') {

            $controlador = 'AuthController';
            $metodo = 'index';
            $parametros = [];

        } else {

            $partes = explode('/', $url);

            $controlador = ucfirst(strtolower($partes[0])) . 'Controller';

            $metodo = $partes[1] ?? 'index';

            $parametros = array_slice($partes, 2);

        }

        // Si el modo mantenimiento está activo, los usuarios que no sean
        // Super Administradores solo pueden ver la pantalla de mantenimiento.
        // Las rutas de autenticación y la propia pantalla de mantenimiento
        // permanecen disponibles para permitir cerrar sesión y administrar el modo.
        if (
            isset($_SESSION['usuario']) &&
            $controlador !== 'AuthController' &&
            $controlador !== 'MantenimientoController'
        ) {
            require_once MODEL_PATH . '/Mantenimiento.php';

            try {
                $mantenimiento = new Mantenimiento();

                $esSuperAdministrador =
                    ($_SESSION['usuario']['rol'] ?? '') === 'Super Administrador';

                if ($mantenimiento->estaActivo() && !$esSuperAdministrador) {
                    header('Location: ' . BASE_URL . 'index.php?url=mantenimiento');
                    exit;
                }
            } catch (Throwable $e) {
                // Si la migración aún no se ha ejecutado, no bloquear el sistema.
            }
        }

        $archivoControlador = CONTROLLER_PATH . '/' . $controlador . '.php';

        if (!file_exists($archivoControlador)) {

            die(
                "No existe el controlador: <b>" .
                $archivoControlador .
                "</b>"
            );

        }

        require_once $archivoControlador;

        if (!class_exists($controlador)) {

            die(
                "No existe la clase: <b>" .
                $controlador .
                "</b>"
            );

        }

        $objeto = new $controlador();

        if (!method_exists($objeto, $metodo)) {

            die(
                "No existe el método: <b>" .
                $metodo .
                "</b>"
            );

        }

        call_user_func_array(
            [$objeto, $metodo],
            $parametros
        );
    }
}
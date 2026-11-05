<?php

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        $archivo = VIEW_PATH . '/' . $view . '.php';

        if (!file_exists($archivo)) {

            http_response_code(404);

            require VIEW_PATH . '/errors/404.php';

            exit;
        }

        require $archivo;
    }

    protected function redirect(string $ruta = ''): void
    {
        if ($ruta === '') {

            header('Location: ' . BASE_URL);

        } else {

            header('Location: ' . BASE_URL . 'index.php?url=' . $ruta);
        }

        exit;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function esAdministrador(): bool
    {
        return isset($_SESSION['usuario']['rol'])
            && in_array(
                $_SESSION['usuario']['rol'],
                ['Administrador', 'Super Administrador'],
                true
            );
    }

    protected function esSuperAdministrador(): bool
    {
        return isset($_SESSION['usuario']['rol'])
            && $_SESSION['usuario']['rol'] === 'Super Administrador';
    }

    protected function esSupervisor(): bool
    {
        return isset($_SESSION['usuario']['rol'])
            && $_SESSION['usuario']['rol'] === 'Supervisor';
    }

    protected function requiereAdministrador(string $ruta = 'dashboard'): void
    {
        if (!$this->esAdministrador()) {

            $_SESSION['error'] =
                'No tienes permisos para modificar esta información.';

            $this->redirect($ruta);
        }
    }

    protected function requiereSuperAdministrador(string $ruta = 'dashboard'): void
    {
        if (!$this->esSuperAdministrador()) {

            $_SESSION['error'] =
                'Solo el Super Administrador puede realizar esta acción.';

            $this->redirect($ruta);
        }
    }

    protected function json(array $datos): void
    {
        header('Content-Type: application/json');

        echo json_encode($datos);

        exit;
    }
}
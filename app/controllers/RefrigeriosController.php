<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Refrigerio.php';

class RefrigeriosController extends Controller
{
    private Refrigerio $refrigerioModel;

    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect();
        }

        $this->refrigerioModel = new Refrigerio();
    }

    public function index(): void
    {
        $this->listar();
    }

    public function listar(): void
    {
        $refrigerios = $this->refrigerioModel->listar();

        $this->view('refrigerios/listar', [
            'refrigerios' => $refrigerios,
            'esAdministrador' => $this->esAdministrador(),
            'esSuperAdministrador' => $this->esSuperAdministrador()
        ]);
    }

    public function crear(): void
    {
        $this->requiereAdministrador('refrigerios');

        $this->view('refrigerios/crear');
    }

    public function guardar(): void
    {
        $this->requiereAdministrador('refrigerios');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('refrigerios');
            return;
        }

        $datos = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'fecha' => $_POST['fecha'] ?? '',
            'fecha_vencimiento' => $_POST['fecha_vencimiento'] ?? '',
            'cantidad' => max(0, (int) ($_POST['cantidad'] ?? 0)),
            'stock_minimo' => max(0, (int) ($_POST['stock_minimo'] ?? 0)),
            'estado' => $_POST['estado'] ?? 'Activo'
        ];

        if ($this->refrigerioModel->registrar($datos)) {
            $_SESSION['success'] = 'Refrigerio registrado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible registrar el refrigerio.';
        }

        $this->redirect('refrigerios');
    }

    public function detalle(int $id): void
    {
        $refrigerio = $this->refrigerioModel->obtenerPorId($id);

        if (!$refrigerio) {
            $this->redirect('refrigerios');
            return;
        }

        $this->view('refrigerios/detalle', [
            'refrigerio' => $refrigerio
        ]);
    }

    public function editar(int $id): void
    {
        $this->requiereAdministrador('refrigerios');

        $refrigerio = $this->refrigerioModel->obtenerPorId($id);

        if (!$refrigerio) {
            $this->redirect('refrigerios');
            return;
        }

        $this->view('refrigerios/editar', [
            'refrigerio' => $refrigerio
        ]);
    }

    public function actualizar(int $id): void
    {
        $this->requiereAdministrador('refrigerios');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('refrigerios');
            return;
        }

        $datos = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'fecha' => $_POST['fecha'] ?? '',
            'fecha_vencimiento' => $_POST['fecha_vencimiento'] ?? '',
            'cantidad' => max(0, (int) ($_POST['cantidad'] ?? 0)),
            'stock_minimo' => max(0, (int) ($_POST['stock_minimo'] ?? 0)),
            'estado' => $_POST['estado'] ?? 'Activo'
        ];

        if ($this->refrigerioModel->actualizar($id, $datos)) {
            $_SESSION['success'] = 'Refrigerio actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible actualizar el refrigerio.';
        }

        $this->redirect('refrigerios');
    }

    public function eliminar(int $id): void
    {
        $this->requiereSuperAdministrador('refrigerios');

        if ($this->refrigerioModel->eliminar($id)) {
            $_SESSION['success'] = 'Refrigerio eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible eliminar el refrigerio.';
        }

        $this->redirect('refrigerios');
    }
}
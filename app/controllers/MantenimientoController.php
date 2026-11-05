<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Mantenimiento.php';

class MantenimientoController extends Controller
{
    private Mantenimiento $mantenimientoModel;

    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect();
        }

        $this->mantenimientoModel = new Mantenimiento();
    }

    public function index(): void
    {
        $estado = $this->mantenimientoModel->obtener();
        $esSuperAdministrador = $this->esSuperAdministrador();

        // Si el mantenimiento está apagado, esta sección es exclusiva
        // del Super Administrador. Si está encendido, los demás usuarios
        // pueden verla únicamente como pantalla informativa.
        if (!$esSuperAdministrador && !(bool) ($estado['activo'] ?? false)) {
            $this->redirect('dashboard');
        }

        $this->view('mantenimiento/index', [
            'estado' => $estado,
            'esSuperAdministrador' => $esSuperAdministrador
        ]);
    }

    public function guardar(): void
    {
        $this->requiereSuperAdministrador('mantenimiento');

        if (!$this->isPost()) {
            $this->redirect('mantenimiento');
        }

        $activo = isset($_POST['activo']) && $_POST['activo'] === '1';
        $mensaje = trim($_POST['mensaje'] ?? '');

        if ($this->mantenimientoModel->actualizar($activo, $mensaje)) {
            $_SESSION['success'] = $activo
                ? 'Modo mantenimiento activado correctamente.'
                : 'Modo mantenimiento desactivado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible actualizar el modo mantenimiento.';
        }

        $this->redirect('mantenimiento');
    }
}

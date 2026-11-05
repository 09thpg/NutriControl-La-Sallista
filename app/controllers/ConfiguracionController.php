<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Configuracion.php';

class ConfiguracionController extends Controller
{
    private Configuracion $configuracionModel;

    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect();
        }

        $this->configuracionModel = new Configuracion();
    }

    public function index(): void
    {
        $configuracion = $this->configuracionModel->obtener();

        $this->view('configuracion/index', [
            'configuracion' => $configuracion,
            'esAdministrador' => $this->esAdministrador()
        ]);
    }

    public function guardar(): void
    {
        $this->requiereAdministrador('configuracion');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $this->redirect('configuracion');

            return;
        }

        $datos = [

            'nombre_sistema' => trim($_POST['nombre_sistema'] ?? ''),

            'nombre_institucion' => trim($_POST['nombre_institucion'] ?? ''),

            'refrigerio_dia' => trim($_POST['refrigerio_dia'] ?? ''),

            'horario_entrega' => trim($_POST['horario_entrega'] ?? ''),

            'mensaje_inicio' => trim($_POST['mensaje_inicio'] ?? '')

        ];

        if ($this->configuracionModel->actualizar($datos)) {

            $_SESSION['success'] = 'Configuración actualizada correctamente.';

        } else {

            $_SESSION['error'] = 'No fue posible actualizar la configuración.';

        }

        $this->redirect('configuracion');
    }
}
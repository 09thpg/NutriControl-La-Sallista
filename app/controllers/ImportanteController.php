<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Configuracion.php';

class ImportanteController extends Controller
{
    private Configuracion $configuracionModel;

    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect();
        }

        if (
            !isset($_SESSION['usuario']['rol']) ||
            strtolower($_SESSION['usuario']['rol']) !== 'estudiante'
        ) {
            $this->redirect('dashboard');
        }

        $this->configuracionModel = new Configuracion();
    }

    public function index(): void
    {
        $configuracion = $this->configuracionModel->obtener();

        $this->view('importante/index', [
            'configuracion' => $configuracion
        ]);
    }
}
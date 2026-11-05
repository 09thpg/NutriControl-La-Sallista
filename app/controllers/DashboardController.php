<?php

require_once APP_PATH . '/core/Controller.php';

require_once MODEL_PATH . '/Usuario.php';
require_once MODEL_PATH . '/Estudiante.php';
require_once MODEL_PATH . '/Refrigerio.php';
require_once MODEL_PATH . '/Entrega.php';
require_once MODEL_PATH . '/Reporte.php';

class DashboardController extends Controller
{
    private Usuario $usuarioModel;
    private Estudiante $estudianteModel;
    private Refrigerio $refrigerioModel;
    private Entrega $entregaModel;
    private Reporte $reporteModel;

    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect();
        }

        $this->usuarioModel = new Usuario();
        $this->estudianteModel = new Estudiante();
        $this->refrigerioModel = new Refrigerio();
        $this->entregaModel = new Entrega();
        $this->reporteModel = new Reporte();
    }

    public function index(): void
    {
        $this->view('dashboard/index', [

            'usuario' =>
                $_SESSION['usuario'],

            'totalAdministradores' =>
                $this->usuarioModel
                    ->totalAdministradores(),

            'totalSupervisores' =>
                $this->usuarioModel
                    ->totalSupervisores(),

            'totalRefrigerios' =>
                $this->refrigerioModel
                    ->total(),

            'totalEntregas' =>
                $this->entregaModel
                    ->total(),

            'administradoresRecientes' =>
                $this->usuarioModel
                    ->ultimosAdministradores(),

            'estudiantesRecientes' =>
                $this->estudianteModel
                    ->ultimos(),

            'entregasRecientes' =>
                $this->entregaModel
                    ->ultimas(),

            'entregasUltimos7Dias' =>
                $this->reporteModel
                    ->entregasUltimos7Dias(),

            'refrigeriosMasEntregados' =>
                $this->reporteModel
                    ->refrigeriosMasEntregados()

        ]);
    }
}
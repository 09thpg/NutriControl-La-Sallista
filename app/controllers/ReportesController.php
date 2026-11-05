<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Reporte.php';

class ReportesController extends Controller
{
    private Reporte $reporteModel;

    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect();
        }

        $this->reporteModel = new Reporte();
    }

    public function index(): void
    {
        // Estadísticas generales
        $estadisticas =
            $this->reporteModel
                ->obtenerEstadisticas();

        // Últimas entregas
        $ultimasEntregas =
            $this->reporteModel
                ->ultimasEntregas();

        // Refrigerios con bajo stock
        $refrigeriosStock =
            $this->reporteModel
                ->refrigeriosStock();

        // Refrigerios próximos a vencer
        $refrigeriosVencer =
            $this->reporteModel
                ->refrigeriosVencer(30);

        // Enviar todos los datos a la vista
        $this->view('reportes/index', [

            'estadisticas' =>
                $estadisticas,

            'ultimasEntregas' =>
                $ultimasEntregas,

            'refrigeriosStock' =>
                $refrigeriosStock,

            'refrigeriosVencer' =>
                $refrigeriosVencer
        ]);
    }

    /**
     * Vista preparada para imprimir y guardar el reporte como PDF.
     */
    public function pdf(): void
    {
        $estadisticas =
            $this->reporteModel
                ->obtenerEstadisticas();

        $ultimasEntregas =
            $this->reporteModel
                ->ultimasEntregas();

        $refrigeriosStock =
            $this->reporteModel
                ->refrigeriosStock();

        $refrigeriosVencer =
            $this->reporteModel
                ->refrigeriosVencer(30);

        $this->view('reportes/pdf', [
            'estadisticas' => $estadisticas,
            'ultimasEntregas' => $ultimasEntregas,
            'refrigeriosStock' => $refrigeriosStock,
            'refrigeriosVencer' => $refrigeriosVencer
        ]);
    }

}
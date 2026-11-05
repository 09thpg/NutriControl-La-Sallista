<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Entrega.php';
require_once MODEL_PATH . '/Refrigerio.php';

class EntregasController extends Controller
{
    private Entrega $entregaModel;
    private Refrigerio $refrigerioModel;


    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect();
        }

        $this->entregaModel = new Entrega();
        $this->refrigerioModel = new Refrigerio();
    }


    public function index(): void
    {
        $this->listar();
    }


    public function listar(): void
    {
        $entregas =
            $this->entregaModel->listar();

        $this->view(
            'entregas/listar',
            [
                'entregas' =>
                    $entregas,

                'esAdministrador' =>
                    $this->esAdministrador(),

                'esSuperAdministrador' =>
                    $this->esSuperAdministrador()
            ]
        );
    }


    public function crear(): void
    {
        $this->requiereAdministrador(
            'entregas'
        );

        /*
         * Solo mostramos refrigerios activos.
         */

        $refrigerios =
            $this->refrigerioModel
                ->listarDisponibles();


        $this->view(
            'entregas/crear',
            [
                'refrigerios' =>
                    $refrigerios
            ]
        );
    }


    public function guardar(): void
    {
        $this->requiereAdministrador(
            'entregas'
        );


        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {

            $this->redirect(
                'entregas'
            );

            return;
        }


        $grado =
            trim(
                $_POST['grado'] ?? ''
            );


        $refrigerioId =
            filter_var(
                $_POST['refrigerio_id'] ?? null,
                FILTER_VALIDATE_INT
            );


        $cantidad =
            filter_var(
                $_POST['cantidad_entregada'] ?? null,
                FILTER_VALIDATE_INT
            );


        $fecha =
            trim(
                $_POST['fecha'] ?? ''
            );


        $hora =
            trim(
                $_POST['hora'] ?? ''
            );


        $gradosPermitidos = [

            '6A',
            '6B',
            '6C',

            '7A',
            '7B',
            '7C',

            '8A',
            '8B',
            '8C',

            '9A',
            '9B',
            '9C',

            '10A',
            '10B',
            '10C',

            '11A',
            '11B',
            '11C'

        ];


        if (
            !in_array(
                $grado,
                $gradosPermitidos,
                true
            )
        ) {

            $_SESSION['error'] =
                'Debes seleccionar un grado válido.';

            $this->redirect(
                'entregas/crear'
            );

            return;
        }


        /*
         * Verificar que el refrigerio exista
         * y esté activo.
         */

        $refrigerio =
            $this->refrigerioModel
                ->obtenerPorId(
                    (int) $refrigerioId
                );


        if (
            !$refrigerio ||
            $refrigerio['estado'] !== 'Activo'
        ) {

            $_SESSION['error'] =
                'El refrigerio seleccionado no está disponible.';

            $this->redirect(
                'entregas/crear'
            );

            return;
        }


        if (
            $cantidad === false ||
            $cantidad <= 0
        ) {

            $_SESSION['error'] =
                'La cantidad entregada debe ser mayor a 0.';

            $this->redirect(
                'entregas/crear'
            );

            return;
        }


        $fechaObj =
            DateTime::createFromFormat(
                'Y-m-d',
                $fecha
            );


        if (
            !$fechaObj ||
            $fechaObj->format('Y-m-d')
                !== $fecha
        ) {

            $_SESSION['error'] =
                'La fecha indicada no es válida.';

            $this->redirect(
                'entregas/crear'
            );

            return;
        }


        $horaObj =
            DateTime::createFromFormat(
                'H:i',
                $hora
            );


        if (
            !$horaObj ||
            $horaObj->format('H:i')
                !== $hora
        ) {

            $_SESSION['error'] =
                'La hora indicada no es válida.';

            $this->redirect(
                'entregas/crear'
            );

            return;
        }


        $datos = [

            'grado' =>
                $grado,

            'refrigerio_id' =>
                (int) $refrigerioId,

            'cantidad_entregada' =>
                $cantidad,

            'usuario_id' =>
                $_SESSION['usuario']['id'],

            'fecha' =>
                $fecha,

            'hora' =>
                $hora

        ];


        if (
            $this->entregaModel
                ->registrar($datos)
        ) {

            $_SESSION['success'] =
                'Entrega registrada correctamente.';

        } else {

            $_SESSION['error'] =
                'No fue posible registrar la entrega.';
        }


        $this->redirect(
            'entregas'
        );
    }


    public function detalle(int $id): void
    {
        $entrega =
            $this->entregaModel
                ->obtenerPorId($id);


        if (!$entrega) {

            $this->redirect(
                'entregas'
            );

            return;
        }


        $this->view(
            'entregas/detalle',
            [
                'entrega' =>
                    $entrega
            ]
        );
    }


    public function editar(int $id): void
    {
        $this->requiereAdministrador(
            'entregas'
        );


        $entrega =
            $this->entregaModel
                ->obtenerPorId($id);


        if (!$entrega) {

            $this->redirect(
                'entregas'
            );

            return;
        }


        $refrigerios =
            $this->refrigerioModel
                ->listarDisponibles();


        $this->view(
            'entregas/editar',
            [
                'entrega' =>
                    $entrega,

                'refrigerios' =>
                    $refrigerios
            ]
        );
    }


    public function actualizar(int $id): void
    {
        $this->requiereAdministrador(
            'entregas'
        );


        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {

            $this->redirect(
                'entregas'
            );

            return;
        }


        $grado =
            trim(
                $_POST['grado'] ?? ''
            );


        $refrigerioId =
            filter_var(
                $_POST['refrigerio_id'] ?? null,
                FILTER_VALIDATE_INT
            );


        $cantidad =
            filter_var(
                $_POST['cantidad_entregada'] ?? null,
                FILTER_VALIDATE_INT
            );


        $fecha =
            trim(
                $_POST['fecha'] ?? ''
            );


        $hora =
            trim(
                $_POST['hora'] ?? ''
            );


        $refrigerio =
            $this->refrigerioModel
                ->obtenerPorId(
                    (int) $refrigerioId
                );


        if (
            !$refrigerio ||
            $refrigerio['estado'] !== 'Activo'
        ) {

            $_SESSION['error'] =
                'El refrigerio seleccionado no está disponible.';

            $this->redirect(
                'entregas/editar/' . $id
            );

            return;
        }


        if (
            $cantidad === false ||
            $cantidad <= 0
        ) {

            $_SESSION['error'] =
                'La cantidad debe ser mayor a 0.';

            $this->redirect(
                'entregas/editar/' . $id
            );

            return;
        }


        $datos = [

            'grado' =>
                $grado,

            'refrigerio_id' =>
                (int) $refrigerioId,

            'cantidad_entregada' =>
                $cantidad,

            'usuario_id' =>
                $_SESSION['usuario']['id'],

            'fecha' =>
                $fecha,

            'hora' =>
                $hora

        ];


        if (
            $this->entregaModel
                ->actualizar(
                    $id,
                    $datos
                )
        ) {

            $_SESSION['success'] =
                'Entrega actualizada correctamente.';

        } else {

            $_SESSION['error'] =
                'No fue posible actualizar la entrega.';
        }


        $this->redirect(
            'entregas'
        );
    }


    public function eliminar(int $id): void
    {
        $this->requiereSuperAdministrador(
            'entregas'
        );


        if (
            $this->entregaModel
                ->eliminar($id)
        ) {

            $_SESSION['success'] =
                'Entrega eliminada correctamente.';

        } else {

            $_SESSION['error'] =
                'No fue posible eliminar la entrega.';
        }


        $this->redirect(
            'entregas'
        );
    }
}
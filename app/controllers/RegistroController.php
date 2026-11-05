<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Registro.php';

class RegistroController extends Controller
{
    private Registro $registroModel;


    /**
     * Constructor.
     */
    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {

            $this->redirect();

            return;
        }

        $this->registroModel = new Registro();
    }


    /**
     * Verifica que el usuario pueda acceder al módulo Registro.
     *
     * Pueden entrar:
     * - Supervisor
     * - Administrador
     * - Super Administrador
     */
    private function requiereAccesoRegistro(
        string $ruta = 'registro/llegada'
    ): void {

        if (!isset($_SESSION['usuario'])) {

            $this->redirect();

            return;
        }


        $rol = $_SESSION['usuario']['rol'] ?? '';


        if (
            !in_array(
                $rol,
                [
                    'Supervisor',
                    'Administrador',
                    'Super Administrador'
                ],
                true
            )
        ) {

            $_SESSION['error'] =
                'No tienes permisos para acceder al Registro Fotográfico.';

            $this->redirect('dashboard');

            return;
        }
    }


    /**
     * Verifica que el usuario pueda modificar registros.
     *
     * Pueden modificar:
     * - Administrador
     * - Super Administrador
     *
     * El Supervisor solamente puede visualizar.
     */
    /**
 * Verifica que el usuario pueda modificar registros.
 *
 * Pueden modificar:
 * - Administrador
 * - Super Administrador
 *
 * El Supervisor solamente puede visualizar.
 */
protected function requiereAdministrador(
    string $ruta = 'registro/llegada'
): void {

    if (!isset($_SESSION['usuario'])) {

        $this->redirect();

        return;
    }


    $rol = $_SESSION['usuario']['rol'] ?? '';


    if (
        !in_array(
            $rol,
            [
                'Administrador',
                'Super Administrador'
            ],
            true
        )
    ) {

        $_SESSION['error'] =
            'No tienes permisos para realizar esta acción.';

        $this->redirect($ruta);

        return;
    }
}


    /**
     * Página principal del módulo.
     */
    public function index(): void
    {
        $this->requiereAccesoRegistro();

        $this->redirect(
            'registro/llegada'
        );
    }


    /**
     * Registro de llegada.
     *
     * Todos los roles autorizados pueden VER.
     */
    public function llegada(): void
    {
        $this->requiereAccesoRegistro();


        $llegadas =
            $this->registroModel
                ->listarLlegadas();


        $this->view(
            'registro/llegada',
            [
                'llegadas' => $llegadas
            ]
        );
    }


    /**
     * Guardar llegada.
     *
     * SOLO:
     * - Administrador
     * - Super Administrador
     */
    public function guardarLlegada(): void
    {
        $this->requiereAdministrador(
            'registro/llegada'
        );


        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {

            $this->redirect(
                'registro/llegada'
            );

            return;
        }


        $fecha =
            trim(
                $_POST['fecha'] ?? ''
            );


        $hora =
            trim(
                $_POST['hora'] ?? ''
            );


        $cantidad =
            filter_var(
                $_POST['cantidad_recibida'] ?? null,
                FILTER_VALIDATE_INT
            );


        $observaciones =
            trim(
                $_POST['observaciones'] ?? ''
            );


        /*
         * VALIDAR FECHA
         */
        if (
            !$this->fechaValida(
                $fecha
            )
        ) {

            $_SESSION['error'] =
                'La fecha indicada no es válida.';

            $this->redirect(
                'registro/llegada'
            );

            return;
        }


        /*
         * VALIDAR HORA
         */
        if (
            !$this->horaValida(
                $hora
            )
        ) {

            $_SESSION['error'] =
                'La hora indicada no es válida.';

            $this->redirect(
                'registro/llegada'
            );

            return;
        }


        /*
         * VALIDAR CANTIDAD
         */
        if (
            $cantidad === false ||
            $cantidad < 0
        ) {

            $_SESSION['error'] =
                'La cantidad recibida debe ser un número igual o mayor a 0.';

            $this->redirect(
                'registro/llegada'
            );

            return;
        }


        /*
         * PROCESAR FOTO
         */
        $foto =
            $this->procesarFoto(
                'foto'
            );


        if ($foto === false) {

            $this->redirect(
                'registro/llegada'
            );

            return;
        }


        /*
         * DATOS
         */
        $datos = [

            'fecha' =>
                $fecha,

            'hora' =>
                $hora,

            'cantidad_recibida' =>
                $cantidad,

            'observaciones' =>
                $observaciones !== ''
                    ? $observaciones
                    : null,

            'foto' =>
                $foto['contenido'],

            'foto_tipo' =>
                $foto['tipo'],

            'foto_nombre' =>
                $foto['nombre'],

            'usuario_id' =>
                (int)
                $_SESSION['usuario']['id']

        ];


        /*
         * GUARDAR
         */
        try {

            $guardado =
                $this->registroModel
                    ->registrarLlegada(
                        $datos
                    );

        } catch (PDOException $e) {

            $guardado = false;
        }


        if ($guardado) {

            $_SESSION['success'] =
                'Registro de llegada guardado correctamente junto con la fotografía.';

        } else {

            $_SESSION['error'] =
                'No fue posible guardar el registro de llegada.';
        }


        $this->redirect(
            'registro/llegada'
        );
    }


    /**
     * Cierre del día.
     *
     * Todos los roles autorizados pueden VER.
     */
    public function cierre(): void
    {
        $this->requiereAccesoRegistro(
            'registro/cierre'
        );


        $fecha =
            $_GET['fecha']
            ?? date('Y-m-d');


        if (
            !$this->fechaValida(
                $fecha
            )
        ) {

            $fecha =
                date('Y-m-d');
        }


        $resumen =
            $this->registroModel
                ->obtenerResumenDia(
                    $fecha
                );


        $cierres =
            $this->registroModel
                ->listarCierres();


        $this->view(
            'registro/cierre',
            [

                'fecha' =>
                    $fecha,

                'resumen' =>
                    $resumen,

                'cierres' =>
                    $cierres

            ]
        );
    }


    /**
     * Guardar cierre.
     *
     * SOLO:
     * - Administrador
     * - Super Administrador
     */
    public function guardarCierre(): void
    {
        $this->requiereAdministrador(
            'registro/cierre'
        );


        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {

            $this->redirect(
                'registro/cierre'
            );

            return;
        }


        $fecha =
            trim(
                $_POST['fecha'] ?? ''
            );


        $hora =
            trim(
                $_POST['hora'] ?? ''
            );


        $observaciones =
            trim(
                $_POST['observaciones'] ?? ''
            );


        /*
         * VALIDAR FECHA
         */
        if (
            !$this->fechaValida(
                $fecha
            )
        ) {

            $_SESSION['error'] =
                'La fecha indicada no es válida.';

            $this->redirect(
                'registro/cierre'
            );

            return;
        }


        /*
         * VALIDAR HORA
         */
        if (
            !$this->horaValida(
                $hora
            )
        ) {

            $_SESSION['error'] =
                'La hora indicada no es válida.';

            $this->redirect(
                'registro/cierre'
            );

            return;
        }


        /*
         * OBTENER RESUMEN DEL DÍA
         */
        $resumen =
            $this->registroModel
                ->obtenerResumenDia(
                    $fecha
                );


        if (
            (int)
            ($resumen['cantidad_recibida'] ?? 0)
            <= 0
        ) {

            $_SESSION['error'] =
                'No hay una cantidad de refrigerios recibidos registrada para esa fecha.';

            $this->redirect(
                'registro/cierre'
            );

            return;
        }


        /*
         * PROCESAR FOTO
         */
        $foto =
            $this->procesarFoto(
                'foto'
            );


        if ($foto === false) {

            $this->redirect(
                'registro/cierre'
            );

            return;
        }


        /*
         * DATOS
         */
        $datos = [

            'fecha' =>
                $fecha,

            'hora' =>
                $hora,

            'cantidad_recibida' =>
                (int)
                ($resumen['cantidad_recibida'] ?? 0),

            'cantidad_entregada' =>
                (int)
                ($resumen['cantidad_entregada'] ?? 0),

            'cantidad_sobrante' =>
                (int)
                ($resumen['cantidad_sobrante'] ?? 0),

            'observaciones' =>
                $observaciones !== ''
                    ? $observaciones
                    : null,

            'foto' =>
                $foto['contenido'],

            'foto_tipo' =>
                $foto['tipo'],

            'foto_nombre' =>
                $foto['nombre'],

            'usuario_id' =>
                (int)
                $_SESSION['usuario']['id']

        ];


        /*
         * GUARDAR
         */
        try {

            $guardado =
                $this->registroModel
                    ->registrarCierre(
                        $datos
                    );

        } catch (PDOException $e) {

            $guardado = false;
        }


        if ($guardado) {

            $_SESSION['success'] =
                'Cierre del día guardado correctamente junto con la fotografía.';

        } else {

            $_SESSION['error'] =
                'No fue posible guardar el cierre del día.';
        }


        /*
         * IMPORTANTE:
         * No usamos ?fecha= aquí porque el Router
         * interpreta todo como nombre del método.
         */
        $this->redirect(
            'registro/cierre'
        );
    }


    /**
     * Mostrar formulario de edición.
     *
     * SOLO:
     * - Administrador
     * - Super Administrador
     */
    public function editar(
        int $id
    ): void {

        $this->requiereAdministrador(
            'registro/llegada'
        );


        $registro =
            $this->registroModel
                ->obtenerPorId(
                    $id
                );


        if (!$registro) {

            $_SESSION['error'] =
                'El registro que intentas editar no existe.';

            $this->redirect(
                'registro/llegada'
            );

            return;
        }


        $this->view(
            'registro/editar',
            [
                'registro' =>
                    $registro
            ]
        );
    }


    /**
     * Actualizar registro.
     *
     * SOLO:
     * - Administrador
     * - Super Administrador
     */
    public function actualizar(
        int $id
    ): void {

        $this->requiereAdministrador(
            'registro/llegada'
        );


        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {

            $this->redirect(
                'registro/editar/' .
                $id
            );

            return;
        }


        $registro =
            $this->registroModel
                ->obtenerPorId(
                    $id
                );


        if (!$registro) {

            $_SESSION['error'] =
                'El registro que intentas actualizar no existe.';

            $this->redirect(
                'registro/llegada'
            );

            return;
        }


        $fecha =
            trim(
                $_POST['fecha'] ?? ''
            );


        $hora =
            trim(
                $_POST['hora'] ?? ''
            );


        $observaciones =
            trim(
                $_POST['observaciones'] ?? ''
            );


        /*
         * VALIDAR FECHA
         */
        if (
            !$this->fechaValida(
                $fecha
            )
        ) {

            $_SESSION['error'] =
                'La fecha indicada no es válida.';

            $this->redirect(
                'registro/editar/' .
                $id
            );

            return;
        }


        /*
         * VALIDAR HORA
         */
        if (
            !$this->horaValida(
                $hora
            )
        ) {

            $_SESSION['error'] =
                'La hora indicada no es válida.';

            $this->redirect(
                'registro/editar/' .
                $id
            );

            return;
        }


        /*
         * CANTIDAD RECIBIDA
         */
        $cantidadRecibida =
            filter_var(
                $_POST['cantidad_recibida'] ?? null,
                FILTER_VALIDATE_INT
            );


        if (
            $cantidadRecibida === false ||
            $cantidadRecibida < 0
        ) {

            $_SESSION['error'] =
                'La cantidad recibida debe ser un número igual o mayor a 0.';

            $this->redirect(
                'registro/editar/' .
                $id
            );

            return;
        }


        /*
         * DATOS BASE
         */
        $datos = [

            'id' =>
                $id,

            'fecha' =>
                $fecha,

            'hora' =>
                $hora,

            'cantidad_recibida' =>
                $cantidadRecibida,

            'observaciones' =>
                $observaciones !== ''
                    ? $observaciones
                    : null

        ];


        /*
         * SI ES CIERRE
         */
        if (
            ($registro['tipo'] ?? '')
            === 'cierre'
        ) {

            $cantidadEntregada =
                filter_var(
                    $_POST['cantidad_entregada'] ?? null,
                    FILTER_VALIDATE_INT
                );


            $cantidadSobrante =
                filter_var(
                    $_POST['cantidad_sobrante'] ?? null,
                    FILTER_VALIDATE_INT
                );


            if (
                $cantidadEntregada === false ||
                $cantidadEntregada < 0
            ) {

                $_SESSION['error'] =
                    'La cantidad entregada no es válida.';

                $this->redirect(
                    'registro/editar/' .
                    $id
                );

                return;
            }


            if (
                $cantidadSobrante === false ||
                $cantidadSobrante < 0
            ) {

                $_SESSION['error'] =
                    'La cantidad sobrante no es válida.';

                $this->redirect(
                    'registro/editar/' .
                    $id
                );

                return;
            }


            $datos[
                'cantidad_entregada'
            ] =
                $cantidadEntregada;


            $datos[
                'cantidad_sobrante'
            ] =
                $cantidadSobrante;
        }


        /*
         * NUEVA FOTO
         *
         * Es opcional.
         */
        if (
            isset($_FILES['foto'])
            &&
            is_array($_FILES['foto'])
            &&
            (
                $_FILES['foto']['error']
                ??
                UPLOAD_ERR_NO_FILE
            )
            !==
            UPLOAD_ERR_NO_FILE
        ) {

            $foto =
                $this->procesarFoto(
                    'foto'
                );


            if ($foto === false) {

                $this->redirect(
                    'registro/editar/' .
                    $id
                );

                return;
            }


            $datos['foto'] =
                $foto['contenido'];


            $datos['foto_tipo'] =
                $foto['tipo'];


            $datos['foto_nombre'] =
                $foto['nombre'];
        }


        /*
         * ACTUALIZAR
         */
        try {

            $actualizado =
                $this->registroModel
                    ->actualizar(
                        $datos
                    );

        } catch (PDOException $e) {

            $actualizado = false;
        }


        if ($actualizado) {

            $_SESSION['success'] =
                'Registro actualizado correctamente.';

        } else {

            $_SESSION['error'] =
                'No fue posible actualizar el registro.';
        }


        /*
         * VOLVER A LA PÁGINA CORRESPONDIENTE
         */
        if (
            ($registro['tipo'] ?? '')
            === 'cierre'
        ) {

            $this->redirect(
                'registro/cierre'
            );

            return;
        }


        $this->redirect(
            'registro/llegada'
        );
    }


    /**
     * Eliminar registro.
     *
     * SOLO:
     * - Administrador
     * - Super Administrador
     */
    public function eliminar(
        int $id
    ): void {

        $this->requiereAdministrador(
            'registro/llegada'
        );


        $registro =
            $this->registroModel
                ->obtenerPorId(
                    $id
                );


        if (!$registro) {

            $_SESSION['error'] =
                'El registro que intentas eliminar no existe.';

            $this->redirect(
                'registro/llegada'
            );

            return;
        }


        try {

            $eliminado =
                $this->registroModel
                    ->eliminar(
                        $id
                    );

        } catch (PDOException $e) {

            $eliminado = false;
        }


        if ($eliminado) {

            $_SESSION['success'] =
                'Registro eliminado correctamente.';

        } else {

            $_SESSION['error'] =
                'No fue posible eliminar el registro.';
        }


        /*
         * VOLVER SEGÚN EL TIPO
         */
        if (
            ($registro['tipo'] ?? '')
            === 'cierre'
        ) {

            $this->redirect(
                'registro/cierre'
            );

            return;
        }


        $this->redirect(
            'registro/llegada'
        );
    }


    /**
     * Mostrar fotografía almacenada.
     *
     * Todos los roles autorizados pueden verla.
     */
    public function foto(
        int $id
    ): void {

        if (
            !isset(
                $_SESSION['usuario']
            )
        ) {

            http_response_code(403);

            exit(
                'Acceso no autorizado.'
            );
        }


        $rol =
            $_SESSION['usuario']['rol']
            ?? '';


        if (
            !in_array(
                $rol,
                [
                    'Supervisor',
                    'Administrador',
                    'Super Administrador'
                ],
                true
            )
        ) {

            http_response_code(403);

            exit(
                'Acceso no autorizado.'
            );
        }


        $registro =
            $this->registroModel
                ->obtenerPorId(
                    $id
                );


        if (
            !$registro ||
            empty(
                $registro['foto']
            )
        ) {

            http_response_code(404);

            exit(
                'Fotografía no encontrada.'
            );
        }


        $tipo =
            $registro['foto_tipo']
            ?? 'image/jpeg';


        header(
            'Content-Type: ' .
            $tipo
        );


        header(
            'Content-Length: ' .
            strlen(
                $registro['foto']
            )
        );


        echo $registro['foto'];

        exit;
    }


    /**
     * Procesar fotografía subida.
     */
    private function procesarFoto(
        string $campo
    ): array|false {

        if (
            !isset(
                $_FILES[$campo]
            )
        ) {

            $_SESSION['error'] =
                'Debes seleccionar una fotografía.';

            return false;
        }


        $archivo =
            $_FILES[$campo];


        if (
            $archivo['error']
            !==
            UPLOAD_ERR_OK
        ) {

            $_SESSION['error'] =
                'No fue posible cargar la fotografía.';

            return false;
        }


        /*
         * Máximo 5 MB
         */
        if (
            $archivo['size']
            >
            5 * 1024 * 1024
        ) {

            $_SESSION['error'] =
                'La fotografía no puede superar los 5 MB.';

            return false;
        }


        $tiposPermitidos = [

            'image/jpeg',

            'image/png',

            'image/webp'

        ];


        $tipo =
            mime_content_type(
                $archivo['tmp_name']
            );


        if (
            !in_array(
                $tipo,
                $tiposPermitidos,
                true
            )
        ) {

            $_SESSION['error'] =
                'Solo se permiten fotografías JPG, PNG o WEBP.';

            return false;
        }


        $contenido =
            file_get_contents(
                $archivo['tmp_name']
            );


        if (
            $contenido === false
        ) {

            $_SESSION['error'] =
                'No fue posible leer la fotografía.';

            return false;
        }


        return [

            'contenido' =>
                $contenido,

            'tipo' =>
                $tipo,

            'nombre' =>
                basename(
                    $archivo['name']
                )

        ];
    }


    /**
     * Validar fecha.
     */
    private function fechaValida(
        string $fecha
    ): bool {

        $fechaObjeto =
            DateTime::createFromFormat(
                'Y-m-d',
                $fecha
            );


        return
            $fechaObjeto !== false
            &&
            $fechaObjeto->format(
                'Y-m-d'
            ) === $fecha;
    }


    /**
     * Validar hora.
     */
    private function horaValida(
        string $hora
    ): bool {

        $horaObjeto =
            DateTime::createFromFormat(
                'H:i',
                $hora
            );


        return
            $horaObjeto !== false
            &&
            $horaObjeto->format(
                'H:i'
            ) === $hora;
    }
}
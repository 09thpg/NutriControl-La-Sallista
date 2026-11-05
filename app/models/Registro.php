<?php

require_once APP_PATH . '/core/Model.php';

class Registro extends Model
{
    /**
     * =========================================================
     * REGISTRAR LLEGADA
     * =========================================================
     */
    public function registrarLlegada(array $datos): bool
    {
        $stmt = $this->prepare("
            INSERT INTO registros_fotograficos
            (
                tipo,
                fecha,
                hora,
                cantidad_recibida,
                cantidad_entregada,
                cantidad_sobrante,
                observaciones,
                foto,
                foto_tipo,
                foto_nombre,
                usuario_id
            )
            VALUES
            (
                'llegada',
                :fecha,
                :hora,
                :cantidad_recibida,
                0,
                0,
                :observaciones,
                :foto,
                :foto_tipo,
                :foto_nombre,
                :usuario_id
            )
        ");

        return $this->execute($stmt, [

            ':fecha' =>
                $datos['fecha'],

            ':hora' =>
                $datos['hora'],

            ':cantidad_recibida' =>
                $datos['cantidad_recibida'],

            ':observaciones' =>
                $datos['observaciones'],

            ':foto' =>
                $datos['foto'],

            ':foto_tipo' =>
                $datos['foto_tipo'],

            ':foto_nombre' =>
                $datos['foto_nombre'],

            ':usuario_id' =>
                $datos['usuario_id']

        ]);
    }


    /**
     * =========================================================
     * REGISTRAR CIERRE
     * =========================================================
     */
    public function registrarCierre(array $datos): bool
    {
        $stmt = $this->prepare("
            INSERT INTO registros_fotograficos
            (
                tipo,
                fecha,
                hora,
                cantidad_recibida,
                cantidad_entregada,
                cantidad_sobrante,
                observaciones,
                foto,
                foto_tipo,
                foto_nombre,
                usuario_id
            )
            VALUES
            (
                'cierre',
                :fecha,
                :hora,
                :cantidad_recibida,
                :cantidad_entregada,
                :cantidad_sobrante,
                :observaciones,
                :foto,
                :foto_tipo,
                :foto_nombre,
                :usuario_id
            )
        ");

        return $this->execute($stmt, [

            ':fecha' =>
                $datos['fecha'],

            ':hora' =>
                $datos['hora'],

            ':cantidad_recibida' =>
                $datos['cantidad_recibida'],

            ':cantidad_entregada' =>
                $datos['cantidad_entregada'],

            ':cantidad_sobrante' =>
                $datos['cantidad_sobrante'],

            ':observaciones' =>
                $datos['observaciones'],

            ':foto' =>
                $datos['foto'],

            ':foto_tipo' =>
                $datos['foto_tipo'],

            ':foto_nombre' =>
                $datos['foto_nombre'],

            ':usuario_id' =>
                $datos['usuario_id']

        ]);
    }


    /**
     * =========================================================
     * LISTAR LLEGADAS
     * =========================================================
     */
    public function listarLlegadas(): array
    {
        $stmt = $this->query("
            SELECT
                rf.*,
                CONCAT(u.nombre, ' ', u.apellido) AS usuario
            FROM registros_fotograficos rf
            LEFT JOIN usuarios u
                ON u.id = rf.usuario_id
            WHERE rf.tipo = 'llegada'
            ORDER BY
                rf.fecha DESC,
                rf.hora DESC,
                rf.id DESC
        ");

        return $this->fetchAll($stmt);
    }


    /**
     * =========================================================
     * LISTAR CIERRES
     * =========================================================
     */
    public function listarCierres(): array
    {
        $stmt = $this->query("
            SELECT
                rf.*,
                CONCAT(u.nombre, ' ', u.apellido) AS usuario
            FROM registros_fotograficos rf
            LEFT JOIN usuarios u
                ON u.id = rf.usuario_id
            WHERE rf.tipo = 'cierre'
            ORDER BY
                rf.fecha DESC,
                rf.hora DESC,
                rf.id DESC
        ");

        return $this->fetchAll($stmt);
    }


    /**
     * =========================================================
     * RESUMEN DEL DÍA
     * =========================================================
     */
    public function obtenerResumenDia(string $fecha): array
    {
        $stmt = $this->prepare("
            SELECT

                COALESCE(
                    (
                        SELECT SUM(cantidad_recibida)
                        FROM registros_fotograficos
                        WHERE tipo = 'llegada'
                        AND fecha = :fecha_recibida
                    ),
                    0
                ) AS cantidad_recibida,

                COALESCE(
                    (
                        SELECT SUM(cantidad_entregada)
                        FROM entregas
                        WHERE fecha = :fecha_entregada
                        AND estado = 'Entregado'
                    ),
                    0
                ) AS cantidad_entregada
        ");

        $this->execute($stmt, [

            ':fecha_recibida' =>
                $fecha,

            ':fecha_entregada' =>
                $fecha

        ]);

        $resumen = $this->fetch($stmt);

        $recibidos =
            (int) (
                $resumen['cantidad_recibida']
                ?? 0
            );

        $entregados =
            (int) (
                $resumen['cantidad_entregada']
                ?? 0
            );

        return [

            'cantidad_recibida' =>
                $recibidos,

            'cantidad_entregada' =>
                $entregados,

            'cantidad_sobrante' =>
                max(
                    0,
                    $recibidos - $entregados
                )

        ];
    }


    /**
     * =========================================================
     * OBTENER REGISTRO POR ID
     * =========================================================
     */
    public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->prepare("
            SELECT
                rf.*,
                CONCAT(u.nombre, ' ', u.apellido) AS usuario
            FROM registros_fotograficos rf
            LEFT JOIN usuarios u
                ON u.id = rf.usuario_id
            WHERE rf.id = :id
            LIMIT 1
        ");

        $this->execute($stmt, [

            ':id' =>
                $id

        ]);

        return $this->fetch($stmt);
    }


    /**
     * =========================================================
     * ACTUALIZAR REGISTRO
     *
     * Sirve tanto para:
     * - llegada
     * - cierre
     *
     * Si no se envía una fotografía nueva,
     * conserva la fotografía anterior.
     * =========================================================
     */
    public function actualizar(array $datos): bool
    {
        $campos = [

            'fecha = :fecha',

            'hora = :hora',

            'cantidad_recibida = :cantidad_recibida',

            'observaciones = :observaciones'

        ];

        $parametros = [

            ':fecha' =>
                $datos['fecha'],

            ':hora' =>
                $datos['hora'],

            ':cantidad_recibida' =>
                $datos['cantidad_recibida'],

            ':observaciones' =>
                $datos['observaciones'],

            ':id' =>
                $datos['id']

        ];


        /*
         * Si es un cierre actualizamos
         * las cantidades correspondientes.
         */
        if (
            isset(
                $datos['cantidad_entregada']
            )
        ) {

            $campos[] =
                'cantidad_entregada = :cantidad_entregada';

            $parametros[':cantidad_entregada'] =
                $datos['cantidad_entregada'];
        }


        if (
            isset(
                $datos['cantidad_sobrante']
            )
        ) {

            $campos[] =
                'cantidad_sobrante = :cantidad_sobrante';

            $parametros[':cantidad_sobrante'] =
                $datos['cantidad_sobrante'];
        }


        /*
         * Si se subió una nueva fotografía,
         * reemplazamos la anterior.
         */
        if (
            isset($datos['foto']) &&
            isset($datos['foto_tipo']) &&
            isset($datos['foto_nombre'])
        ) {

            $campos[] =
                'foto = :foto';

            $campos[] =
                'foto_tipo = :foto_tipo';

            $campos[] =
                'foto_nombre = :foto_nombre';


            $parametros[':foto'] =
                $datos['foto'];

            $parametros[':foto_tipo'] =
                $datos['foto_tipo'];

            $parametros[':foto_nombre'] =
                $datos['foto_nombre'];
        }


        $sql = "
            UPDATE registros_fotograficos
            SET
                " . implode(
                    ", ",
                    $campos
                ) . "
            WHERE id = :id
        ";


        $stmt =
            $this->prepare($sql);


        return $this->execute(
            $stmt,
            $parametros
        );
    }


    /**
     * =========================================================
     * ELIMINAR REGISTRO
     * =========================================================
     */
    public function eliminar(int $id): bool
    {
        $stmt = $this->prepare("
            DELETE FROM registros_fotograficos
            WHERE id = :id
        ");

        return $this->execute($stmt, [

            ':id' =>
                $id

        ]);
    }


    /**
     * =========================================================
     * OBTENER FOTO
     * =========================================================
     */
    public function obtenerFoto(int $id): array|false
    {
        $stmt = $this->prepare("
            SELECT
                foto,
                foto_tipo
            FROM registros_fotograficos
            WHERE id = :id
            LIMIT 1
        ");

        $this->execute($stmt, [

            ':id' =>
                $id

        ]);

        return $this->fetch($stmt);
    }
}
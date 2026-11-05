<?php

require_once APP_PATH . '/core/Model.php';

class Reporte extends Model
{
    /**
     * Obtiene las estadísticas generales del sistema.
     */
    public function obtenerEstadisticas(): array
    {
        return [

            'usuarios' =>
                $this->contar('usuarios'),

            'refrigerios' =>
                $this->contar('refrigerios'),

            'entregas' =>
                $this->contar('entregas')
        ];
    }


    /**
     * Cuenta registros de una tabla.
     */
    private function contar(string $tabla): int
    {
        $stmt = $this->query("
            SELECT COUNT(*) AS total
            FROM {$tabla}
        ");

        $fila = $this->fetch($stmt);

        return (int) ($fila['total'] ?? 0);
    }


    /**
     * Últimas entregas realizadas.
     */
    public function ultimasEntregas(): array
    {
        $stmt = $this->query("
            SELECT

                en.id,

                en.grado,

                en.cantidad_entregada,

                en.fecha,

                en.hora,

                r.nombre AS refrigerio,

                CONCAT(
                    u.nombre,
                    ' ',
                    u.apellido
                ) AS usuario

            FROM entregas en

            INNER JOIN refrigerios r
                ON r.id = en.refrigerio_id

            LEFT JOIN usuarios u
                ON u.id = en.usuario_id

            ORDER BY
                en.fecha DESC,
                en.hora DESC,
                en.id DESC

            LIMIT 10
        ");

        return $this->fetchAll($stmt);
    }


    /**
     * Refrigerios que tienen bajo stock.
     */
    public function refrigeriosStock(): array
    {
        $stmt = $this->query("
            SELECT
                id,
                nombre,
                cantidad,
                stock_minimo
            FROM refrigerios
            WHERE cantidad <= stock_minimo
            AND estado = 'Activo'
            ORDER BY cantidad ASC, nombre ASC
        ");

        return $this->fetchAll($stmt);
    }


    /**
     * Refrigerios próximos a vencer.
     * Por defecto se consideran los próximos 30 días.
     */
    public function refrigeriosVencer(int $dias = 30): array
    {
        $stmt = $this->prepare("
            SELECT
                id,
                nombre,
                fecha_vencimiento
            FROM refrigerios
            WHERE fecha_vencimiento IS NOT NULL
            AND estado = 'Activo'
            AND fecha_vencimiento BETWEEN CURDATE()
            AND DATE_ADD(CURDATE(), INTERVAL :dias DAY)
            ORDER BY fecha_vencimiento ASC, nombre ASC
        ");

        $stmt->bindValue(
            ':dias',
            $dias,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Cantidad total de refrigerios entregados durante los últimos 7 días.
     */
    public function entregasUltimos7Dias(): array
    {
        $stmt = $this->query("
            SELECT
                DATE(fecha) AS dia,
                SUM(cantidad_entregada) AS total
            FROM entregas
            WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY DATE(fecha)
            ORDER BY dia ASC
        ");

        return $this->fetchAll($stmt);
    }


    /**
     * Refrigerios más entregados históricamente.
     */
    public function refrigeriosMasEntregados(int $limite = 5): array
    {
        $stmt = $this->prepare("
            SELECT
                r.nombre,
                SUM(e.cantidad_entregada) AS total
            FROM entregas e
            INNER JOIN refrigerios r
                ON r.id = e.refrigerio_id
            GROUP BY r.id, r.nombre
            ORDER BY total DESC, r.nombre ASC
            LIMIT :limite
        ");

        $stmt->bindValue(
            ':limite',
            $limite,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
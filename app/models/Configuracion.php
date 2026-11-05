<?php

require_once APP_PATH . '/core/Model.php';

class Configuracion extends Model
{
    public function obtener(): array|false
    {
        $stmt = $this->query("
            SELECT *
            FROM configuracion
            LIMIT 1
        ");

        return $this->fetch($stmt);
    }

    public function actualizar(array $datos): bool
    {
        $stmt = $this->prepare("
            UPDATE configuracion
            SET
                nombre_sistema = :nombre_sistema,
                nombre_institucion = :nombre_institucion,
                refrigerio_dia = :refrigerio_dia,
                horario_entrega = :horario_entrega,
                mensaje_inicio = :mensaje_inicio
            WHERE id = 1
        ");

        return $this->execute($stmt, [

            ':nombre_sistema' => $datos['nombre_sistema'],
            ':nombre_institucion' => $datos['nombre_institucion'],
            ':refrigerio_dia' => $datos['refrigerio_dia'],
            ':horario_entrega' => $datos['horario_entrega'],
            ':mensaje_inicio' => $datos['mensaje_inicio']

        ]);
    }
}
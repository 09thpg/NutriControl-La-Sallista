<?php

require_once APP_PATH . '/core/Model.php';

class Entrega extends Model
{
    public function listar(): array
    {
        $stmt = $this->query("
            SELECT
                e.*,
                r.nombre AS refrigerio,
                CONCAT(u.nombre,' ',u.apellido) AS usuario
            FROM entregas e
            INNER JOIN refrigerios r
                ON r.id = e.refrigerio_id
            INNER JOIN usuarios u
                ON u.id = e.usuario_id
            ORDER BY e.fecha DESC, e.hora DESC, e.id DESC
        ");

        return $this->fetchAll($stmt);
    }


    public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->prepare("
            SELECT
                e.*,
                r.nombre AS refrigerio,
                CONCAT(u.nombre,' ',u.apellido) AS usuario
            FROM entregas e
            INNER JOIN refrigerios r
                ON r.id = e.refrigerio_id
            INNER JOIN usuarios u
                ON u.id = e.usuario_id
            WHERE e.id = :id
            LIMIT 1
        ");

        $this->execute($stmt, [
            ':id' => $id
        ]);

        return $this->fetch($stmt);
    }


    public function registrar(array $datos): bool
    {
        $stmt = $this->prepare("
            INSERT INTO entregas
            (
                grado,
                refrigerio_id,
                cantidad_entregada,
                usuario_id,
                fecha,
                hora
            )
            VALUES
            (
                :grado,
                :refrigerio,
                :cantidad,
                :usuario,
                :fecha,
                :hora
            )
        ");

        return $this->execute($stmt, [

            ':grado' =>
                $datos['grado'],

            ':refrigerio' =>
                $datos['refrigerio_id'],

            ':cantidad' =>
                $datos['cantidad_entregada'],

            ':usuario' =>
                $datos['usuario_id'],

            ':fecha' =>
                $datos['fecha'],

            ':hora' =>
                $datos['hora']

        ]);
    }


    public function actualizar(
        int $id,
        array $datos
    ): bool {

        $stmt = $this->prepare("
            UPDATE entregas
            SET
                grado = :grado,
                refrigerio_id = :refrigerio,
                cantidad_entregada = :cantidad,
                usuario_id = :usuario,
                fecha = :fecha,
                hora = :hora
            WHERE id = :id
        ");

        return $this->execute($stmt, [

            ':grado' =>
                $datos['grado'],

            ':refrigerio' =>
                $datos['refrigerio_id'],

            ':cantidad' =>
                $datos['cantidad_entregada'],

            ':usuario' =>
                $datos['usuario_id'],

            ':fecha' =>
                $datos['fecha'],

            ':hora' =>
                $datos['hora'],

            ':id' =>
                $id

        ]);
    }


    public function eliminar(int $id): bool
    {
        $stmt = $this->prepare("
            DELETE FROM entregas
            WHERE id = :id
        ");

        return $this->execute($stmt, [
            ':id' => $id
        ]);
    }


    public function total(): int
    {
        $stmt = $this->query("
            SELECT COUNT(*) AS total
            FROM entregas
        ");

        $datos = $this->fetch($stmt);

        return (int) $datos['total'];
    }


    public function ultimas(int $limite = 5): array
    {
        $stmt = $this->prepare("
            SELECT
                e.*,
                r.nombre AS refrigerio,
                CONCAT(u.nombre,' ',u.apellido) AS usuario
            FROM entregas e
            INNER JOIN refrigerios r
                ON r.id = e.refrigerio_id
            INNER JOIN usuarios u
                ON u.id = e.usuario_id
            ORDER BY e.fecha DESC, e.hora DESC, e.id DESC
            LIMIT :limite
        ");

        $stmt->bindValue(
            ':limite',
            $limite,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );
    }
}
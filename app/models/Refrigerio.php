<?php

require_once APP_PATH . '/core/Model.php';

class Refrigerio extends Model
{
    /**
     * Lista todos los refrigerios.
     */
    public function listar(): array
    {
        $stmt = $this->query("
            SELECT *
            FROM refrigerios
            ORDER BY fecha DESC, id DESC
        ");

        return $this->fetchAll($stmt);
    }


    /**
     * Lista únicamente los refrigerios disponibles/activos.
     *
     * Se utiliza en:
     * - Nueva Entrega
     * - Editar Entrega
     */
    public function listarDisponibles(): array
    {
        $stmt = $this->query("
            SELECT *
            FROM refrigerios
            WHERE estado = 'Activo'
            ORDER BY nombre ASC
        ");

        return $this->fetchAll($stmt);
    }


    /**
     * Obtiene un refrigerio por su ID.
     */
    public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->prepare("
            SELECT *
            FROM refrigerios
            WHERE id = :id
            LIMIT 1
        ");

        $this->execute($stmt, [
            ':id' => $id
        ]);

        return $this->fetch($stmt);
    }


    /**
     * Registra un nuevo refrigerio.
     */
    public function registrar(array $datos): bool
    {
        $stmt = $this->prepare("
            INSERT INTO refrigerios
            (
                nombre,
                descripcion,
                fecha,
                fecha_vencimiento,
                cantidad,
                stock_minimo,
                estado
            )
            VALUES
            (
                :nombre,
                :descripcion,
                :fecha,
                :fecha_vencimiento,
                :cantidad,
                :stock_minimo,
                :estado
            )
        ");

        return $this->execute($stmt, [

            ':nombre' =>
                $datos['nombre'],

            ':descripcion' =>
                $datos['descripcion'],

            ':fecha' =>
                $datos['fecha'],

            ':fecha_vencimiento' =>
                $datos['fecha_vencimiento'],

            ':cantidad' =>
                $datos['cantidad'],

            ':stock_minimo' =>
                $datos['stock_minimo'],

            ':estado' =>
                $datos['estado']

        ]);
    }


    /**
     * Actualiza un refrigerio.
     */
    public function actualizar(
        int $id,
        array $datos
    ): bool {

        $stmt = $this->prepare("
            UPDATE refrigerios
            SET
                nombre = :nombre,
                descripcion = :descripcion,
                fecha = :fecha,
                fecha_vencimiento = :fecha_vencimiento,
                cantidad = :cantidad,
                stock_minimo = :stock_minimo,
                estado = :estado
            WHERE id = :id
        ");

        return $this->execute($stmt, [

            ':nombre' =>
                $datos['nombre'],

            ':descripcion' =>
                $datos['descripcion'],

            ':fecha' =>
                $datos['fecha'],

            ':fecha_vencimiento' =>
                $datos['fecha_vencimiento'],

            ':cantidad' =>
                $datos['cantidad'],

            ':stock_minimo' =>
                $datos['stock_minimo'],

            ':estado' =>
                $datos['estado'],

            ':id' =>
                $id

        ]);
    }


    /**
     * Elimina un refrigerio.
     */
    public function eliminar(int $id): bool
    {
        $stmt = $this->prepare("
            DELETE
            FROM refrigerios
            WHERE id = :id
        ");

        return $this->execute($stmt, [

            ':id' =>
                $id

        ]);
    }


    /**
     * Obtiene el último ID insertado.
     */
    public function obtenerUltimoId(): int
    {
        return (int) $this->lastInsertId();
    }


    /**
     * Obtiene el total de refrigerios.
     */
    public function total(): int
    {
        $stmt = $this->query("
            SELECT COUNT(*) AS total
            FROM refrigerios
        ");

        $datos = $this->fetch($stmt);

        return (int) $datos['total'];
    }


    /**
     * Obtiene los últimos refrigerios registrados.
     */
    public function ultimos(
        int $limite = 5
    ): array {

        $stmt = $this->prepare("
            SELECT *
            FROM refrigerios
            ORDER BY fecha DESC, id DESC
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
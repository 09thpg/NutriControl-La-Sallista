<?php

require_once APP_PATH . '/core/Model.php';

class Estudiante extends Model
{
    public function listar(): array
    {
        $stmt = $this->query("
            SELECT *
            FROM estudiantes
            ORDER BY id DESC
        ");

        return $this->fetchAll($stmt);
    }

    public function listarPorGrado(string $grado): array
    {
        $stmt = $this->prepare("
            SELECT *
            FROM estudiantes
            WHERE grado = :grado
            ORDER BY id DESC
        ");

        $this->execute($stmt, [
            ':grado' => $grado
        ]);

        return $this->fetchAll($stmt);
    }

    public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->prepare("
            SELECT *
            FROM estudiantes
            WHERE id = :id
        ");

        $this->execute($stmt, [
            ':id' => $id
        ]);

        return $this->fetch($stmt);
    }

    public function registrar(array $datos): bool
    {
        $stmt = $this->prepare("
            INSERT INTO estudiantes
            (
                documento,
                nombres,
                apellidos,
                grado,
                jornada,
                acudiente,
                telefono,
                estado
            )
            VALUES
            (
                :documento,
                :nombres,
                :apellidos,
                :grado,
                :jornada,
                :acudiente,
                :telefono,
                :estado
            )
        ");

        return $this->execute($stmt, [
            ':documento' => $datos['documento'],
            ':nombres' => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':grado' => $datos['grado'],
            ':jornada' => $datos['jornada'],
            ':acudiente' => $datos['acudiente'],
            ':telefono' => $datos['telefono'],
            ':estado' => $datos['estado']
        ]);
    }

    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->prepare("
            UPDATE estudiantes
            SET
                documento = :documento,
                nombres = :nombres,
                apellidos = :apellidos,
                grado = :grado,
                jornada = :jornada,
                acudiente = :acudiente,
                telefono = :telefono,
                estado = :estado
            WHERE id = :id
        ");

        return $this->execute($stmt, [
            ':documento' => $datos['documento'],
            ':nombres' => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':grado' => $datos['grado'],
            ':jornada' => $datos['jornada'],
            ':acudiente' => $datos['acudiente'],
            ':telefono' => $datos['telefono'],
            ':estado' => $datos['estado'],
            ':id' => $id
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->prepare("
            DELETE
            FROM estudiantes
            WHERE id = :id
        ");

        return $this->execute($stmt, [
            ':id' => $id
        ]);
    }

    public function existeDocumento(string $documento): bool
    {
        $stmt = $this->prepare("
            SELECT id
            FROM estudiantes
            WHERE documento = :documento
        ");

        $this->execute($stmt, [
            ':documento' => $documento
        ]);

        return $this->fetch($stmt) !== false;
    }

    public function total(): int
    {
        $stmt = $this->query("
            SELECT COUNT(*) AS total
            FROM estudiantes
        ");

        $datos = $this->fetch($stmt);

        return (int) $datos['total'];
    }

    public function ultimos(int $limite = 5): array
    {
        $stmt = $this->prepare("
            SELECT *
            FROM estudiantes
            ORDER BY id DESC
            LIMIT :limite
        ");

        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
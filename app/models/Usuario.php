<?php

require_once APP_PATH . '/core/Model.php';

class Usuario extends Model
{
    public function login(string $usuario, string $password): array|false
    {
        $stmt = $this->prepare("
            SELECT *
            FROM usuarios
            WHERE usuario = :usuario
            LIMIT 1
        ");

        $this->execute($stmt, [
            ':usuario' => $usuario
        ]);

        $usuarioDB = $this->fetch($stmt);

        if (!$usuarioDB) {
            return false;
        }

        if (!password_verify($password, $usuarioDB['password'])) {
            return false;
        }

        return $usuarioDB;
    }

    public function listar(): array
    {
        $stmt = $this->query("
            SELECT *
            FROM usuarios
            ORDER BY id DESC
        ");

        return $this->fetchAll($stmt);
    }

    public function listarCompleto(): array
    {
        return $this->listar();
    }

    public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->prepare("
            SELECT *
            FROM usuarios
            WHERE id = :id
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
            INSERT INTO usuarios
            (
                nombre,
                apellido,
                grado,
                documento,
                correo,
                usuario,
                password,
                avatar,
                rol
            )
            VALUES
            (
                :nombre,
                :apellido,
                :grado,
                :documento,
                :correo,
                :usuario,
                :password,
                :avatar,
                :rol
            )
        ");

        return $this->execute($stmt, [
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':grado' => $datos['grado'],
            ':documento' => $datos['documento'],
            ':correo' => $datos['correo'],
            ':usuario' => $datos['usuario'],
            ':password' => password_hash(
                $datos['password'],
                PASSWORD_DEFAULT
            ),
            ':avatar' => $datos['avatar'],
            ':rol' => $datos['rol'] ?? 'Supervisor'
        ]);
    }

    public function actualizar(int $id, array $datos): bool
    {
        $stmt = $this->prepare("
            UPDATE usuarios
            SET
                nombre = :nombre,
                apellido = :apellido,
                grado = :grado,
                documento = :documento,
                correo = :correo,
                usuario = :usuario,
                avatar = :avatar
            WHERE id = :id
        ");

        return $this->execute($stmt, [
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':grado' => $datos['grado'],
            ':documento' => $datos['documento'],
            ':correo' => $datos['correo'],
            ':usuario' => $datos['usuario'],
            ':avatar' => $datos['avatar'],
            ':id' => $id
        ]);
    }

    public function actualizarRol(int $id, string $rol): bool
    {
        $rolesPermitidos = [
            'Supervisor',
            'Administrador',
            'Super Administrador'
        ];

        if (!in_array($rol, $rolesPermitidos, true)) {
            return false;
        }

        $stmt = $this->prepare("
            UPDATE usuarios
            SET rol = :rol
            WHERE id = :id
        ");

        return $this->execute($stmt, [
            ':rol' => $rol,
            ':id' => $id
        ]);
    }

    public function eliminar(int $id): bool
    {
        $stmt = $this->prepare("
            DELETE FROM usuarios
            WHERE id = :id
        ");

        return $this->execute($stmt, [
            ':id' => $id
        ]);
    }

    public function existeDocumento(string $documento): bool
    {
        $stmt = $this->prepare("
            SELECT COUNT(*)
            FROM usuarios
            WHERE documento = :documento
        ");

        $this->execute($stmt, [
            ':documento' => $documento
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function existeUsuario(string $usuario): bool
    {
        $stmt = $this->prepare("
            SELECT id
            FROM usuarios
            WHERE usuario = :usuario
            LIMIT 1
        ");

        $this->execute($stmt, [
            ':usuario' => $usuario
        ]);

        return $this->fetch($stmt) !== false;
    }

    public function existeCorreo(string $correo): bool
    {
        $stmt = $this->prepare("
            SELECT id
            FROM usuarios
            WHERE correo = :correo
            LIMIT 1
        ");

        $this->execute($stmt, [
            ':correo' => $correo
        ]);

        return $this->fetch($stmt) !== false;
    }

    public function total(): int
    {
        $stmt = $this->query("
            SELECT COUNT(*) AS total
            FROM usuarios
        ");

        $datos = $this->fetch($stmt);

        return (int) $datos['total'];
    }

    public function ultimos(int $limite = 5): array
    {
        $stmt = $this->prepare("
            SELECT *
            FROM usuarios
            ORDER BY fecha_registro DESC
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

    public function existeDocumentoOtro(
        string $documento,
        int $id
    ): bool {
        $stmt = $this->prepare("
            SELECT id
            FROM usuarios
            WHERE documento = :documento
            AND id != :id
            LIMIT 1
        ");

        $this->execute($stmt, [
            ':documento' => $documento,
            ':id' => $id
        ]);

        return $this->fetch($stmt) !== false;
    }

    public function existeUsuarioOtro(
        string $usuario,
        int $id
    ): bool {
        $stmt = $this->prepare("
            SELECT id
            FROM usuarios
            WHERE usuario = :usuario
            AND id != :id
            LIMIT 1
        ");

        $this->execute($stmt, [
            ':usuario' => $usuario,
            ':id' => $id
        ]);

        return $this->fetch($stmt) !== false;
    }

    public function existeCorreoOtro(
        string $correo,
        int $id
    ): bool {
        $stmt = $this->prepare("
            SELECT id
            FROM usuarios
            WHERE correo = :correo
            AND id != :id
            LIMIT 1
        ");

        $this->execute($stmt, [
            ':correo' => $correo,
            ':id' => $id
        ]);

        return $this->fetch($stmt) !== false;
    }

    public function actualizarPerfil(
        int $id,
        array $datos
    ): bool {
        if (isset($datos['password'])) {

            $stmt = $this->prepare("
                UPDATE usuarios
                SET
                    nombre = :nombre,
                    apellido = :apellido,
                    documento = :documento,
                    correo = :correo,
                    usuario = :usuario,
                    password = :password,
                    avatar = :avatar
                WHERE id = :id
            ");

            return $this->execute($stmt, [
                ':nombre' => $datos['nombre'],
                ':apellido' => $datos['apellido'],
                    ':documento' => $datos['documento'],
                ':correo' => $datos['correo'],
                ':usuario' => $datos['usuario'],
                ':password' => $datos['password'],
                ':avatar' => $datos['avatar'],
                ':id' => $id
            ]);
        }

        $stmt = $this->prepare("
            UPDATE usuarios
            SET
                nombre = :nombre,
                apellido = :apellido,
                documento = :documento,
                correo = :correo,
                usuario = :usuario,
                avatar = :avatar
            WHERE id = :id
        ");

        return $this->execute($stmt, [
            ':nombre' => $datos['nombre'],
            ':apellido' => $datos['apellido'],
            ':documento' => $datos['documento'],
            ':correo' => $datos['correo'],
            ':usuario' => $datos['usuario'],
            ':avatar' => $datos['avatar'],
            ':id' => $id
        ]);
    }

    public function totalAdministradores(): int
    {
        $stmt = $this->query("
            SELECT COUNT(*) AS total
            FROM usuarios
            WHERE LOWER(TRIM(rol)) = 'administrador'
        ");

        $datos = $this->fetch($stmt);

        return (int) $datos['total'];
    }

    public function totalSupervisores(): int
    {
        $stmt = $this->query("
            SELECT COUNT(*) AS total
            FROM usuarios
            WHERE LOWER(TRIM(rol)) = 'supervisor'
        ");

        $datos = $this->fetch($stmt);

        return (int) $datos['total'];
    }

    public function ultimosAdministradores(int $limite = 8): array
    {
        $stmt = $this->prepare("
            SELECT *
            FROM usuarios
            WHERE LOWER(TRIM(rol)) = 'administrador'
            ORDER BY fecha_registro DESC
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

    public function listarEstudiantes(): array
    {
        $stmt = $this->prepare("
            SELECT *
            FROM usuarios
            WHERE LOWER(TRIM(rol)) = 'estudiante'
            ORDER BY id DESC
        ");

        $this->execute($stmt);

        return $this->fetchAll($stmt);
    }

    public function listarEstudiantesPorGrado(string $grado): array
    {
        $stmt = $this->prepare("
            SELECT *
            FROM usuarios
            WHERE LOWER(TRIM(rol)) = 'estudiante'
            AND grado = :grado
            ORDER BY id DESC
        ");

        $this->execute($stmt, [
            ':grado' => $grado
        ]);

        return $this->fetchAll($stmt);
    }
}
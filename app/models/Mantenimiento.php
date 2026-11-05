<?php

require_once APP_PATH . '/core/Model.php';

class Mantenimiento extends Model
{
    public function obtener(): array
    {
        $stmt = $this->query("SELECT id, activo, mensaje, actualizado_en FROM mantenimiento_sistema WHERE id = 1 LIMIT 1");
        $datos = $this->fetch($stmt);

        return $datos ?: [
            'id' => 1,
            'activo' => 0,
            'mensaje' => 'NutriControl se encuentra temporalmente en mantenimiento.',
            'actualizado_en' => null
        ];
    }

    public function estaActivo(): bool
    {
        return (bool) ($this->obtener()['activo'] ?? false);
    }

    public function actualizar(bool $activo, string $mensaje): bool
    {
        $stmt = $this->prepare("UPDATE mantenimiento_sistema SET activo = :activo, mensaje = :mensaje, actualizado_en = NOW() WHERE id = 1");

        return $this->execute($stmt, [
            ':activo' => $activo ? 1 : 0,
            ':mensaje' => $mensaje !== ''
                ? $mensaje
                : 'NutriControl se encuentra temporalmente en mantenimiento.'
        ]);
    }
}

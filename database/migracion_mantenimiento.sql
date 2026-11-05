CREATE TABLE IF NOT EXISTS mantenimiento_sistema (
    id INT NOT NULL PRIMARY KEY,
    activo TINYINT(1) NOT NULL DEFAULT 0,
    mensaje VARCHAR(500) NOT NULL DEFAULT 'NutriControl se encuentra temporalmente en mantenimiento.',
    actualizado_en DATETIME NULL
);

INSERT INTO mantenimiento_sistema (id, activo, mensaje)
VALUES (1, 0, 'NutriControl se encuentra temporalmente en mantenimiento.')
ON DUPLICATE KEY UPDATE id = id;

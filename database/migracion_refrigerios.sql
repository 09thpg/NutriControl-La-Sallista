-- Migración para que los refrigerios manejen vencimiento y stock.
-- Ejecuta este script UNA SOLA VEZ en phpMyAdmin sobre la base de datos de NutriControl.

ALTER TABLE refrigerios
    ADD COLUMN fecha_vencimiento DATE NULL AFTER fecha,
    ADD COLUMN cantidad INT NOT NULL DEFAULT 0 AFTER fecha_vencimiento,
    ADD COLUMN stock_minimo INT NOT NULL DEFAULT 1 AFTER cantidad;

-- Opcional: si ya tienes refrigerios registrados y quieres evitar que aparezcan
-- inmediatamente como "bajo stock", puedes ajustar sus cantidades desde phpMyAdmin.

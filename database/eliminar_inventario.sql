-- Limpieza de NutriControl: eliminar definitivamente el módulo Inventario.
-- Ejecuta este script UNA SOLA VEZ en phpMyAdmin.
-- Recomendación: realiza una copia de seguridad de la base de datos antes de ejecutarlo.

-- Primero se elimina la tabla de relación, si existe.
DROP TABLE IF EXISTS refrigerio_productos;

-- Después se elimina la tabla de inventario, si existe.
DROP TABLE IF EXISTS inventario;

-- Desde este punto, el stock y el vencimiento se administran únicamente
-- desde la tabla refrigerios mediante: cantidad, stock_minimo y fecha_vencimiento.

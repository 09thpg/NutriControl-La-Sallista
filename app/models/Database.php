<?php


class Database
{
    private static ?PDO $conexion = null;

    public static function conectar(): PDO
    {
        if (self::$conexion === null) {

            $dsn = "mysql:host=" . DB_HOST .
                   ";dbname=" . DB_NAME .
                   ";charset=" . DB_CHARSET;

            try {

                self::$conexion = new PDO(
                    $dsn,
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );

            } catch (PDOException $e) {

                exit('Error de conexión: ' . $e->getMessage());

            }
        }

        return self::$conexion;
    }
}
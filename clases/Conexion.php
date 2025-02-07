<?php

class Conexion
{
    // Definimos las constantes de la conexión.
    //private const DB_HOST = "127.0.0.1";
    // Si es necesario especificar un puerto, descomentar la línea siguiente:
    private const DB_HOST = "127.0.0.1:8889";
    private const DB_USER = "root";
    private const DB_PASS = "root";
    private const DB_NAME = "dw3_repossi_martina";

    /**
     * Obtiene la conexión a la base de datos.
     *
     * @return PDO
     * @throws PDOException Si no se puede conectar con la base de datos.
     */
    public static function obtenerConexion(): PDO
    {
        // Construimos el DSN (Data Source Name) para PDO.
        $dsn = "mysql:host=" . self::DB_HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";

        try {
            // Creamos y retornamos la conexión.
            $db = new PDO($dsn, self::DB_USER, self::DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            // Manejo de errores, mejor que usar die().
            error_log("Error al conectar con la base de datos: " . $e->getMessage());
            throw new Exception("No se puede conectar con la base de datos.");
        }
    }
}

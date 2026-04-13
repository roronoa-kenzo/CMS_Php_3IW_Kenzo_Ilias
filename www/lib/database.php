<?php

namespace Application\Lib\Database;

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private ?\PDO $database = null;

    // empêche new DatabaseConnection()
    private function __construct() {}
    //  point d’entrée unique
    public static function getInstance(): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }

        return self::$instance;
    }

    public function getConnection(): \PDO
    {
        if ($this->database === null) {

            $this->database = new \PDO(
                'mysql:host=db;dbname=' . MARIADB_DATABASE . ';charset=utf8',
                MARIADB_USER,
                MARIADB_PASSWORD
            );

            $this->database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }

        return $this->database;
    }
}
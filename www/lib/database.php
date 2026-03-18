<?php
namespace Application\Lib\Database;

class DatabaseConnection
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if ($this->database === null) {

            // Les constantes sont définies dans index.php via le fichier .env
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
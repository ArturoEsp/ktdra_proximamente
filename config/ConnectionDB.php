<?php

class ConnectionDB extends PDO
{

    static function getConnection()
    {
        require('../vendor/autoload.php');
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        
        $dotenv->load();

        $username = $_ENV['DDBB_USER'];
        $password = $_ENV['DDBB_PASSWORD'];
        $host = $_ENV['DDBB_HOST'];
        $db = $_ENV['DDBB_NAME'];
        $charset = $_ENV['DDBB_CHARSET'];

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            return $pdo = new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}

<?php

namespace Api\Database;

/**
 * Classe: Connection
 * =============================================================================
 * Objectivo:
 * 
 * 
 * 
 * =============================================================================
 * @author Alexandre Bezerra Barbosa <alxbbarbosa@hotmail.com>
 * 
 * @copyright 2015-2019 AB Babosa Serviços e Desenvolvimento ME
 * =============================================================================
 */
class Connection
{
    private static $conn     = null;
    private static $host     = 'localhost';
    private static $dbname   = 'api_estoque_1';
    private static $username = 'vagrant';
    private static $password = 'P@ssw0rd';

    private function __construct()
    {
        
    }

    private static function connect()
    {
        try {
            $dsn        = 'mysql:host='.self::$host.';dbname='.self::$dbname;
            self::$conn = new \PDO($dsn, self::$username, self::$password,
                [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getConnection()
    {

        if (is_null(self::$conn)) self::connect();
        return self::$conn;
    }

    public static function begin()
    {
        if (is_null(self::$conn)) self::getConnection();

        self::$conn->beginTransaction();

        return self::$conn;
    }

    public static function commit()
    {
        self::$conn->commit();
    }

    public static function rollback()
    {
        self::$conn->rollBack();
    }
}
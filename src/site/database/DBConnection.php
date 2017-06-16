<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 11.05.17
 * Time: 17:55
 */
class DBConnection
{
    public static $connection = null;

    private function __construct()
    {
    }

    public static function getConnection()
    {
        $connection = null;
        try {
            if ($connection === null) {
                $connection = new PDO("pgsql:host=localhost dbname=hello", "postgres", "123456");
            }
        } catch (PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        return $connection;
    }
}
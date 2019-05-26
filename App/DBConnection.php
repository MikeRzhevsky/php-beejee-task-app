<?php

namespace App;
use Config\DbConfig;
class DBConnection
{
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection == null) {
            $params = DbConfig::getDbConfig();
            self::$connection = new \PDO("mysql:host={$params['host']};dbname={$params['dbname']}", $params['user'], $params['password']);
        }
        return self::$connection;
    }

}
<?php

namespace App\Libraries;

use \PDO;

class Database {

    private static $connection;

    public static function getConnection()
    {
        if(empty(self::$connection)) {
            return self::createConnection();
        }
        return self::$connection;
    }

    private static function createConnection()
    {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function query($query, $params = [], $stdClass = 'stdClass')
    {
        $stmt = self::getConnection()->prepare($query);
        $stmt->execute($params);
        $data = $stmt->fetchAll(PDO::FETCH_CLASS, $stdClass);
        return $data;
    }

    public static function execute($sql)
    {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute();

        return $result;
    }

}
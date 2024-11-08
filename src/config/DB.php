<?php
namespace Vendor\AppReceitas\src\Config;

use PDO;
use PDOException;

class DB {
    private static $conn;

    private function __construct() {} 

    public static function getConnection() {
        if (!self::$conn) {
            $host = 'localhost';
            $dbname = 'receitas';
            $user = 'root';
            $password = '';

            try {
                self::$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }

        return self::$conn;
    }
}

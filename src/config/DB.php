<?php
namespace Vendor\AppReceitas\Config;

use PDO;
use PDOException;

class db {

    static $host = 'localhost';
    static $dbname = 'receitas';
    static $user = 'root';
    static $password = '';

    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $host = 'localhost';
            $dbname = 'receitas';
            $user = 'root';
            $password = '';

            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password,[PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
            } catch (PDOException $e) {
                echo "Erro na conexão: " . $e->getMessage();
            }
        }

        return self::$instance;
    }
}






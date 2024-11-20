<?php

namespace Vendor\AppReceitas\api;

class Router
{
    static $INSTANCE;
    var $routes = [];

    public function add($method, $path, $handler) {
        self::getInstance()->routes[$path][$method] = $handler;
    }

    public function process() {
        header("Content-Type: application/json");

        $path = isset($_SERVER["PATH_INFO"]) 
            ? $_SERVER["PATH_INFO"] 
            : parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        $basePath = '/src/api';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        $method = $_SERVER["REQUEST_METHOD"];
        $handler = self::getInstance()->routes[$path][$method] ?? null;

        if ($handler == null) {
            http_response_code(404);
            echo json_encode([
                "error" => "NOT_FOUND",
                "msg" => "Path '$path' not found for method $method"
            ]);
            return;
        }

        $handler();
    }

    /**
     * Retorna uma instância única do Router
     * @return Router
     */
    public static function getInstance() {
        if (self::$INSTANCE == null) {
            self::$INSTANCE = new Router();
        }
        return self::$INSTANCE;
    }
}

<?php

namespace Vendor\AppReceitas\Config;

class Router {

    private $routes = [];

    public function add($method, $uri, $action) {
        $this->routes[] = [
            'method' => $method, 
            'uri' => $uri, 
            'action' => $action 
        ];
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
    
        $uri = str_replace("/App-de-receitas/public", "", $uri);
        $uri = strtok($uri, '?'); 
    
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['uri'] === $uri) {
                list($controller, $action) = explode('@', $route['action']);
                
                $controller = "Vendor\\AppReceitas\\Controllers\\" . $controller;
                
                if (class_exists($controller)) {
                    $controllerInstance = new $controller();
    
                    if (method_exists($controllerInstance, $action)) {
                        $controllerInstance->$action();
                        return;
                    } else {
                        echo json_encode(["error" => "Método não encontrado"]);
                        http_response_code(404);
                        return;
                    }
                } else {
                    echo json_encode(["error" => "Controlador não encontrado"]);
                    http_response_code(404);
                    return;
                }
            }
        }
    
        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada"]);
    }
}    

<?php

use Vendor\AppReceitas\api\Router;
use Vendor\AppReceitas\Controllers\ReceitaController;
use Vendor\AppReceitas\Controllers\UserController;

require_once '../config/db.php'; 
require_once __DIR__ . '/../vendor/autoload.php';


$router = Router::getInstance();

// Rotas de Usuários
$router->add('GET', '/user', function () { 
    if(isset($_GET["id"])){
        UserController::getInstance()->getById($_GET["id"]);
    } else {
        UserController::getInstance()->list();
    }
});
$router->add('POST', '/user', function () { UserController::getInstance()->create();});
$router->add('DELETE', '/user', function () { UserController::getInstance()->delete();});
$router->add('PUT', '/user', function () { UserController::getInstance()->update();});

$router->add('POST', '/login', function () {
    $controller = new LoginController();
    $controller->login();
});

// Rotas de Receitas
$router->add('GET', '/receita', function () { 
    if(isset($_GET["id"])){
        ReceitaController::getInstance()->getById($_GET["id"]);
    } else {
        ReceitaController::getInstance()->list();
    }
});

$router->add('GET', '/receita/user', function () { 
    if(isset($_GET["id"])){
        ReceitaController::getInstance()->getByUserId($_GET["id"]);
    }else {
        echo json_encode([
            "msg" => "Parametro Id do usuario não presente"
        ]);
    }
});


$router->add('POST', '/receita', function () { ReceitaController::getInstance()->create();});
$router->add('DELETE', '/receita', function () { ReceitaController::getInstance()->delete();});
$router->add('PUT', '/receita', function () { ReceitaController::getInstance()->update();});

Router::getInstance()->process();
<?php

use Vendor\AppReceitas\api\Router;
use Vendor\AppReceitas\Controllers\ReceitaController;
use Vendor\AppReceitas\Controllers\UserController;


require_once '../config/db.php'; 
require_once '../Router.php';
require_once '../Controllers/ReceitaController.php';
require_once '../Controllers/UserController.php';

// Configuração CORS
header("Access-Control-Allow-Origin: *"); // Permite todas as origens
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Permite os métodos HTTP necessários
header("Access-Control-Allow-Headers: Content-Type"); // Permite o cabeçalho Content-Type

// Para lidar com a requisição de "preflight" (opções)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}


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
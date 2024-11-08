<?php

use Vendor\AppReceitas\Routes\Router;

require '../src/Controllers/ReceitaController.php';
require '../src/Controllers/UserController.php';

$router = new Router();

// Rotas de Receitas
$router->add('GET', '/api/receitas', ['ReceitaController', 'list']);  
$router->add('POST', '/api/receitas', ['ReceitaController', 'create']); 
$router->add('GET', '/api/receitas/{id}', ['ReceitaController', 'show']); 
$router->add('PUT', '/api/receitas/{id}', ['ReceitaController', 'update']); 
$router->add('DELETE', '/api/receitas/{id}', ['ReceitaController', 'delete']); 

// Rotas de Usuários
$router->add('GET', '/api/usuarios', ['UserController', 'list']); 
$router->add('POST', '/api/usuarios', ['UserController', 'create']); 
$router->add('POST', '/api/usuarios/login', ['UserController', 'login']); 
$router->add('GET', '/api/usuarios/{id}', ['UserController', 'show']); 
$router->add('PUT', '/api/usuarios/{id}', ['UserController', 'update']); 
$router->add('DELETE', '/api/usuarios/{id}', ['UserController', 'delete']); 

// Despachante de rotas
$router->dispatch();

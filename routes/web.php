<?php

require '../App-de-receitas/src/Controllers/ReceitaController.php';
require '../App-de-receitas/src/Controllers/UserController.php';

$router = new Vendor\AppReceitas\Config\Router();

// Rotas de Receitas
$router->add('GET', '/api/receitas', 'ReceitaController@index'); 
$router->add('POST', '/api/receitas', 'ReceitaController@store'); 
$router->add('GET', '/api/receitas/{id}', 'ReceitaController@show'); 
$router->add('PUT', '/api/receitas/{id}', 'ReceitaController@update'); 
$router->add('DELETE', '/api/receitas/{id}', 'ReceitaController@destroy'); 

// Rotas de Usuários
$router->add('GET', '/api/usuarios', 'UserControllerr@index'); 
$router->add('POST', '/api/usuarios', 'UserController@store');
$router->add('POST', '/api/usuarios/login', 'UserController@login');
$router->add('GET', '/api/usuarios/{id}', 'UserController@show');
$router->add('PUT', '/api/usuarios/{id}', 'UserController@update');
$router->add('DELETE', '/api/usuarios/{id}', 'UserController@destroy');

// Despachante de rotas
$router->dispatch();

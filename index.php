<?php

require_once '../App-de-receitas/vendor/autoload.php'; 

require_once '../App-de-receitas/routes/web.php';

use Vendor\AppReceitas\Config\Router;

$router = new Router();

$router->dispatch();

<?php
// Rota para a página inicial com listagem de receitas
$router->get('/', 'ReceitaController@index');

// Rota para criar uma nova receita
$router->get('/receita/nova', 'ReceitaController@create');
$router->post('/receita/store', 'ReceitaController@store');

// Rota para visualizar uma receita específica
$router->get('/receita/{id}', 'ReceitaController@show');

// Rota para editar uma receita
$router->get('/receita/{id}/edit', 'ReceitaController@edit');
$router->post('/receita/{id}/update', 'ReceitaController@update');

// Rota para excluir uma receita
$router->post('/receita/{id}/delete', 'ReceitaController@destroy');
?>

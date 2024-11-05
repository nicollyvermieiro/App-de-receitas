<?php
session_start(); // Inicia a sessão

// Conexão com o banco de dados
require 'db.php'; // Inclua seu arquivo de conexão ao banco de dados

// Função para redirecionar
function redirect($url) {
    header("Location: $url");
    exit();
}

// Verifica a rota e executa a ação apropriada
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0]; // Obtém a URI da requisição

switch ($request_uri) {
    case '/':
        echo "Bem-vindo ao Aplicativo de Receitas!"; // Página inicial
        break;

    case '/login':
        require 'login.php'; // Roteia para a página de login
        break;

    case '/receitas':
        require 'receitas.php'; // Roteia para o gerenciamento de receitas
        break;

    case '/publicar-receita':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Código para publicar a receita
            // Aqui você pode processar o formulário de envio de receita
            require 'publicar_receita.php'; // Script para processar a publicação
        } else {
            echo "Método não permitido."; // Método não permitido
        }
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada."; // Caso não encontre a rota
        break;
}

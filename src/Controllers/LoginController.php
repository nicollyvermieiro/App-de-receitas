<?php

namespace Vendor\AppReceitas\Controllers;

use Vendor\AppReceitas\Config\Database;
use Vendor\AppReceitas\Models\User;

class LoginController 
{
    private $user;

    public function __construct()
    {
        $this->user = new User(Database::getInstance());
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->email) && isset($data->senha)) {
            try {
                $user = $this->user->getByEmail($data->email);

                if ($user && password_verify($data->senha, $user['senha'])) {
                    $token = bin2hex(random_bytes(16));
                    
                    http_response_code(200);
                    echo json_encode([
                        "message" => "Login bem-sucedido",
                        "token" => $token,
                        "user" => [
                            "id" => $user['id'],
                            "nome" => $user['nome'],
                            "email" => $user['email']
                        ]
                    ]);
                } else {
                    http_response_code(401);
                    echo json_encode(["message" => "E-mail ou senha incorretos."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao processar o login."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}

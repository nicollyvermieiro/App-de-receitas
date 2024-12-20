<?php

namespace Vendor\AppReceitas\Controllers;

use Vendor\AppReceitas\Config\db;
use Vendor\AppReceitas\Models\User;

require_once __DIR__ . '/../Models/User.php'; 

class UserController 
{
	private $user;

	private static $INSTANCE;

    public static function getInstance(){
        if(!isset(self::$INSTANCE)){
            self::$INSTANCE = new UserController();
        }
        return self::$INSTANCE;
    }

	public function __construct()
    {
        $this->user = new User(db::getInstance());
    }

	public function list()
    {
        $user = $this->user->list();
        echo json_encode($user);
    }

	public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->name) && isset($data->email) && isset($data->password)) {
            try {
                $this->user->create($data->name, $data->email, $data->password);

                http_response_code(201);
                echo json_encode(["message" => "Usuário cadastrado com sucesso"]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao cadastrar usuario"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

	public function getById($id)
    {
        if (isset($id)) {
            try {
                $user = $this->user->getById($id);
                if ($user) {
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Cadastro não encontrado"]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar cadastro"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

	public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
		if (isset($data->name) && isset($data->email) && isset($data->id)) {
            try {
                $count = $this->user->update( $data->id, $data->name, $data->email);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Cadastro atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao cadastrar usuario"]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar cadastro"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

	public function delete()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id)) {
            try {
                $count = $this->user->delete($data->id);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Cadastro deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar Cadastro"]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar Cadastro"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}
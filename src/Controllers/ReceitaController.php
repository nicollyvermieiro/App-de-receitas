<?php

namespace Vendor\AppReceitas\Controllers;

use SebastianBergmann\Environment\Console;
use Vendor\AppReceitas\Config\Database;
use Vendor\AppReceitas\Models\Receita;

class ReceitaController 
{
    private $receita;

    private static $INSTANCE;

    public static function getInstance(){
        if(!isset(self::$INSTANCE)){
            self::$INSTANCE = new ReceitaController();
        }
        return self::$INSTANCE;
    }

    public function __construct()
    {
        $this->receita = new Receita(Database::getInstance());
    }

    public function list()
    {
        $receita = $this->receita->list();
        echo json_encode($receita);
    }

    public function create() 
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->usuario_id) && isset($data->titulo) && isset($data->ingredientes) && isset($data->descricao) && isset($data->modo_preparo) && isset($data->categoria) && isset($data->dataCriacao)) {
            try {
                $this->receita->create($data->usuario_id, $data->titulo, $data->ingredientes, $data->descricao, $data->modo_preparo, $data->categoria, $data->dataCriacao);

                http_response_code(201);
                echo json_encode(["message" => "Receita cadastrada com sucesso"]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao cadastrar receita"]);
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
                $receita = $this->receita->getById($id);
                if ($receita) {
                    echo json_encode($receita);
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

    public function getByUserId($id)
    {
        if (isset($id)) {
            try {
                $receita = $this->receita->getByUserId($id);
                if ($receita) {
                    echo json_encode($receita);
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
        if (isset($data->usuario_id) && isset($data->titulo) && isset($data->ingredientes) && isset($data->descricao) && isset($data->modo_preparo) && isset($data->categoria) && isset($data->dataCriacao)) {
            try {
                $count = $this->receita->update($data->usuario_id, $data->titulo, $data->ingredientes, $data->descricao, $data->modo_preparo, $data->categoria, $data->dataCriacao);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Cadastro atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao cadastrar receita"]);
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
                $count = $this->receita->delete($data->id);

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
?>

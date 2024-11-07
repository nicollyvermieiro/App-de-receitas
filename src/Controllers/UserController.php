<?php
namespace Vendor\AppReceitas\Controllers;

use Vendor\AppReceitas\Models\User;

class UserController {

    public function list() {
        try {
            $usuarios = User::listarTodos(); 

            if ($usuarios) {
                echo json_encode($usuarios);  
            } else {
                echo json_encode(["error" => "Nenhum usuário encontrado"]); 
            }
        } catch (\Exception $e) {
            echo json_encode(["error" => "Erro ao listar usuários: " . $e->getMessage()]);
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['nome']) || empty($data['email']) || empty($data['senha'])) {
            echo json_encode(["error" => "Todos os campos são obrigatórios"]);
            return;
        }

        if (User::findByEmail($data['email'])) {
            echo json_encode(["error" => "Já existe um usuário com esse email"]);
            return;
        }

        $data['senha'] = password_hash($data['senha'], PASSWORD_BCRYPT);

        try {
            $user = new User($data['nome'], $data['email'], $data['senha']);
            $user->salvar();
            echo json_encode(["message" => "Usuário criado com sucesso"]);
        } catch (\Exception $e) {
            echo json_encode(["error" => "Erro ao criar usuário: " . $e->getMessage()]);
        }
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['email']) || empty($data['senha'])) {
            echo json_encode(["error" => "Email e senha são obrigatórios"]);
            return;
        }

        try {
            $user = User::autenticar($data['email'], $data['senha']);
            
            if ($user) {
                $userData = [
                    'id' => $user->getId(),
                    'nome' => $user->getNome(),
                    'email' => $user->getEmail(),
                    'dataCriacao' => $user->getDataCriacao()
                ];
                echo json_encode(["message" => "Login bem-sucedido", "user" => $userData]);
            } else {
                echo json_encode(["error" => "Email ou senha inválidos"]);
            }
        } catch (\Exception $e) {
            echo json_encode(["error" => "Erro ao realizar login: " . $e->getMessage()]);
        }
    }

    public function show($id) {
        try {
            $user = User::find($id);
            
            if ($user) {
                echo json_encode($user);
            } else {
                echo json_encode(["error" => "Usuário não encontrado"]);
            }
        } catch (\Exception $e) {
            echo json_encode(["error" => "Erro ao buscar usuário: " . $e->getMessage()]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        try {
            $user = User::find($id);

            if (!$user) {
                echo json_encode(["error" => "Usuário não encontrado"]);
                return;
            }

            if (!empty($data['nome'])) $user->setNome($data['nome']);
            if (!empty($data['email'])) $user->setEmail($data['email']);
            if (!empty($data['senha'])) $user->setSenha(password_hash($data['senha'], PASSWORD_BCRYPT)); 

            $user->atualizar();
            echo json_encode(["message" => "Usuário atualizado com sucesso"]);
        } catch (\Exception $e) {
            echo json_encode(["error" => "Erro ao atualizar usuário: " . $e->getMessage()]);
        }
    }

    public function delete($id) {
        try {
            $user = User::find($id);

            if ($user) {
                $user->deletar();
                echo json_encode(["message" => "Usuário excluído com sucesso"]);
            } else {
                echo json_encode(["error" => "Usuário não encontrado"]);
            }
        } catch (\Exception $e) {
            echo json_encode(["error" => "Erro ao excluir usuário: " . $e->getMessage()]);
        }
    }
}

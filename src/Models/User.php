<?php
namespace Vendor\AppReceitas\Models;

use PDO;
use Vendor\AppReceitas\Config\DB;

class User {
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $dataCriacao;
    private $conn;

    public function __construct($nome = null, $email = null, $senha = null) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT); 
        $this->dataCriacao = date("Y-m-d H:i:s");
        $this->conn = DB::getConnection(); 
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = password_hash($senha, PASSWORD_BCRYPT);  
    }

    public function getDataCriacao() {
        return $this->dataCriacao;
    }

    public function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    // Métodos CRUD

    public function salvar() {
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nome, email, senha, dataCriacao) VALUES (:nome, :email, :senha, :dataCriacao)");
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':dataCriacao', $this->dataCriacao);
        $stmt->execute();

        $this->id = $this->conn->lastInsertId(); 
    }

    public static function autenticar($email, $senha) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            $userObj = new User($user['nome'], $user['email'], $user['senha']);
            $userObj->setId($user['id']);
            return $userObj;
        }

        return null; 
    }

    public static function find($id) {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userObj = new User($user['nome'], $user['email'], $user['senha']);
            $userObj->setId($user['id']);
            $userObj->setDataCriacao($user['dataCriacao']);
            return $userObj;
        }

        return null;
    }

    public function atualizar() {
        $stmt = $this->conn->prepare("UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id");
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function deletar() {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }
    
    public static function listarTodos() {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM usuarios");
        $stmt->execute();

        $usuarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row['nome'], $row['email']);
            $user->setId($row['id']);
            $user->setDataCriacao($row['dataCriacao']);

            $usuarios[] = [
                'id' => $user->getId(),
                'nome' => $user->getNome(),
                'email' => $user->getEmail(),
                'dataCriacao' => $user->getDataCriacao()
            ];
        }

        return $usuarios;
    }
}

<?php
require_once '../config/db.php';

use PDO;

class Receita 
{
  
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    

    public function create($usuario_id, $categoria, $titulo, $ingredientes, $descricao, $modo_preparo, $dataCriacao) 
    {
        $sql = "INSERT INTO receitas (usuario_id, categoria, titulo, ingredientes, descricao, modo_preparo, data_criacao) 
                            VALUES (:usuario_id, :categoria, :titulo, :ingredientes, :descricao, :modo_preparo, :dataCriacao)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':ingredientes', $ingredientes);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':modo_preparo', $modo_preparo);
        $stmt->bindParam(':dataCriacao', $dataCriacao);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT * FROM receitas";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM receitas WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserId($id)
    {
        $sql = "SELECT * FROM receitas WHERE usuario_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($titulo, $categoria, $ingredientes, $descricao, $modo_preparo, $id) 
    {
        $sql = "UPDATE receitas SET titulo = :titulo, categoria = :categoria, ingredientes = :ingredientes, descricao = :descricao, modo_preparo = :modo_preparo WHERE id = :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':ingredientes', $ingredientes);
        $stmt->bindParam(':descricao', $descricao); 
        $stmt->bindParam(':modo_preparo', $modo_preparo); 
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM receitas WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}

<?php

namespace Vendor\AppReceitas\Models;

use PDO;

require_once '../config/db.php';

class Receita 
{
  
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    

    public function create($category, $title, $ingredients, $description, $preparation_mode, $user_id) 
    {
        $sql = "INSERT INTO receitas (category, title, ingredients, description, preparation_mode, user_id) 
                            VALUES (:category, :title, :ingredients, :description, :preparation_mode, :user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':ingredients', $ingredients);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':preparation_mode', $preparation_mode);
        $stmt->bindParam(':user_id', $user_id);
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
        $sql = "SELECT * FROM receitas WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($title, $category, $ingredients, $description, $preparation_mode, $id) 
    {
        $sql = "UPDATE receitas SET title = :title, category = :category, ingredients = :ingredients, description = :description, preparation_mode = :preparation_mode WHERE id = :id";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':ingredients', $ingredients);
        $stmt->bindParam(':description', $description); 
        $stmt->bindParam(':preparation_mode', $preparation_mode); 
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

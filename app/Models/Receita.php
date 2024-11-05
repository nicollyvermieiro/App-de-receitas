<?php
namespace App\Models;
use DB;
use PDO;

class Receita {
    public static function all() {
        $sql = "SELECT * FROM receitas";
        $stmt = DB::getInstance()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $sql = "SELECT * FROM receitas WHERE id = :id";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save() {
        $sql = "INSERT INTO receitas (titulo, ingredientes, instrucoes) VALUES (:titulo, :ingredientes, :instrucoes)";
        $stmt = DB::getInstance()->prepare($sql);
        $stmt->execute([':titulo' => $this->titulo, ':ingredientes' => $this->ingredientes, ':instrucoes' => $this->instrucoes]);
    }

    public function update($dados) {
        // Lógica para atualizar
    }

    public function delete() {
        // Lógica para deletar
    }
}
?>

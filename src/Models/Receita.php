<?php
namespace Vendor\AppReceitas\Models;

use PDO;
use PDOException;
use Vendor\AppReceitas\Config\DB;

class Receita {
    private $id;
    private $usuario_id;
    private $titulo;
    private $ingredientes;
    private $descricao; // Alterado para descricao
    private $modo_preparo; 
    private $foto;
    private $dataCriacao;
    private $conn;

    public function __construct($usuario_id = null, $titulo = null, $ingredientes = null, $descricao = null, $modo_preparo = null, $foto = null) {
        $this->usuario_id = $usuario_id;
        $this->titulo = $titulo;
        $this->ingredientes = $ingredientes;
        $this->descricao = $descricao; // Alterado para descricao
        $this->modo_preparo = $modo_preparo; 
        $this->foto = $foto;
        $this->dataCriacao = date("Y-m-d H:i:s"); 
        $this->conn = DB::getConnection(); 
    }

    public function getDescricao() {
        return $this->descricao; // Alterado para descricao
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao; // Alterado para descricao
    }

    public function getModoPreparo() {
        return $this->modo_preparo;
    }

    public function setModoPreparo($modo_preparo) {
        $this->modo_preparo = $modo_preparo;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getIngredientes() {
        return $this->ingredientes;
    }

    public function setIngredientes($ingredientes) {
        $this->ingredientes = $ingredientes;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getDataCriacao() {
        return $this->dataCriacao;
    }

    public function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    // Métodos CRUD

    public function salvar() {
        try {
            $stmt = $this->conn->prepare("INSERT INTO receitas (usuario_id, titulo, ingredientes, descricao, modo_preparo, foto, dataCriacao) 
                                         VALUES (:usuario_id, :titulo, :ingredientes, :descricao, :modo_preparo, :foto, :dataCriacao)");
            $stmt->bindParam(':usuario_id', $this->usuario_id);
            $stmt->bindParam(':titulo', $this->titulo);
            $stmt->bindParam(':ingredientes', $this->ingredientes);
            $stmt->bindParam(':descricao', $this->descricao); // Alterado para descricao
            $stmt->bindParam(':modo_preparo', $this->modo_preparo); 
            $stmt->bindParam(':foto', $this->foto);
            $stmt->bindParam(':dataCriacao', $this->dataCriacao);
            $stmt->execute();

            $this->id = $this->conn->lastInsertId(); 
        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro ao salvar a receita: " . $e->getMessage()]);
        }
    }

    public static function find($id) {
        try {
            $conn = DB::getConnection(); 
            $stmt = $conn->prepare("SELECT * FROM receitas WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $receita = new Receita($data['usuario_id'], $data['titulo'], $data['ingredientes'], $data['descricao'], $data['modo_preparo'], $data['foto']);
                $receita->setId($data['id']);
                $receita->setDataCriacao($data['dataCriacao']);
                return $receita;
            }
        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro ao buscar a receita: " . $e->getMessage()]);
        }
        return null; 
    }

    public function atualizar() {
        try {
            $stmt = $this->conn->prepare("UPDATE receitas SET titulo = :titulo, ingredientes = :ingredientes, descricao = :descricao, modo_preparo = :modo_preparo, foto = :foto WHERE id = :id");
            $stmt->bindParam(':titulo', $this->titulo);
            $stmt->bindParam(':ingredientes', $this->ingredientes);
            $stmt->bindParam(':descricao', $this->descricao); // Alterado para descricao
            $stmt->bindParam(':modo_preparo', $this->modo_preparo); 
            $stmt->bindParam(':foto', $this->foto);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro ao atualizar a receita: " . $e->getMessage()]);
        }
    }

    public function deletar() {
        try {
            $stmt = $this->conn->prepare("DELETE FROM receitas WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro ao excluir a receita: " . $e->getMessage()]);
        }
    }

    public static function listarTodas() {
        try {
            $conn = DB::getConnection();
            $stmt = $conn->query("SELECT * FROM receitas");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $receitas = [];
            foreach ($result as $row) {
                $receita = new Receita();
                $receita->setId($row['id']);
                $receita->setUsuarioId($row['usuario_id']);
                $receita->setTitulo($row['titulo']);
                $receita->setIngredientes($row['ingredientes']);
                $receita->setDescricao($row['descricao']); // Alterado para descricao
                $receita->setModoPreparo($row['modo_preparo']); 
                $receita->setFoto($row['foto']);
                $receita->setDataCriacao($row['dataCriacao']);
                $receitas[] = $receita;
            }
            return $receitas;
        } catch (PDOException $e) {
            echo json_encode(["error" => "Erro ao listar as receitas: " . $e->getMessage()]);
        }
    }
}
<?php
namespace Vendor\AppReceitas\Models;

use PDO;
use Vendor\AppReceitas\Config\DB;

class Receita {
    private $id;
    private $usuario_id;
    private $titulo;
    private $ingredientes;
    private $instrucoes;
    private $modo_preparo; 
    private $foto;
    private $dataCriacao;
    private $conn;

    public function __construct($usuario_id = null, $titulo = null, $ingredientes = null, $instrucoes = null, $modo_preparo = null, $foto = null) {
        $this->usuario_id = $usuario_id;
        $this->titulo = $titulo;
        $this->ingredientes = $ingredientes;
        $this->instrucoes = $instrucoes;
        $this->modo_preparo = $modo_preparo; 
        $this->foto = $foto;
        $this->dataCriacao = date("Y-m-d H:i:s"); 
        $this->conn = DB::getConnection(); 
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

    public function getInstrucoes() {
        return $this->instrucoes;
    }

    public function setInstrucoes($instrucoes) {
        $this->instrucoes = $instrucoes;
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
        $stmt = $this->conn->prepare("INSERT INTO receitas (usuario_id, titulo, ingredientes, instrucoes, modo_preparo, foto, dataCriacao) 
                                     VALUES (:usuario_id, :titulo, :ingredientes, :instrucoes, :modo_preparo, :foto, :dataCriacao)");
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':instrucoes', $this->instrucoes);
        $stmt->bindParam(':modo_preparo', $this->modo_preparo); 
        $stmt->bindParam(':foto', $this->foto);
        $stmt->bindParam(':dataCriacao', $this->dataCriacao);
        $stmt->execute();

        $this->id = $this->conn->lastInsertId(); 
    }

    public static function find($id) {
        $conn = DB::getConnection(); 
        $stmt = $conn->prepare("SELECT * FROM receitas WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $receita = new Receita($data['usuario_id'], $data['titulo'], $data['ingredientes'], $data['instrucoes'], $data['modo_preparo'], $data['foto']);
            $receita->setId($data['id']);
            $receita->setDataCriacao($data['dataCriacao']);
            return $receita;
        }

        return null; 
    }

    public function atualizar() {
        $stmt = $this->conn->prepare("UPDATE receitas SET titulo = :titulo, ingredientes = :ingredientes, instrucoes = :instrucoes, modo_preparo = :modo_preparo, foto = :foto WHERE id = :id");
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':instrucoes', $this->instrucoes);
        $stmt->bindParam(':modo_preparo', $this->modo_preparo); 
        $stmt->bindParam(':foto', $this->foto);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function deletar() {
        $stmt = $this->conn->prepare("DELETE FROM receitas WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public static function listarTodas() {
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
            $receita->setInstrucoes($row['instrucoes']);
            $receita->setModoPreparo($row['modo_preparo']); 
            $receita->setFoto($row['foto']);
            $receita->setDataCriacao($row['dataCriacao']);
            $receitas[] = $receita;
        }

        return $receitas;
    }
}

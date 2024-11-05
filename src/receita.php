<?php

class Receita {
    private $id;
    private $titulo;
    private $ingredientes;
    private $instrucoes;
    private $foto;
    private $dataCriacao;

    public function __construct($titulo, $ingredientes, $instrucoes, $foto) {
        $this->titulo = $titulo;
        $this->ingredientes = $ingredientes;
        $this->instrucoes = $instrucoes;
        $this->foto = $foto;
        $this->dataCriacao = date("Y-m-d H:i:s"); 
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
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

    public function salvar() {
        // Aqui você pode implementar a lógica para inserir a receita no banco
        // utilizando PDO ou MySQLi, por exemplo.
    }
}
?>

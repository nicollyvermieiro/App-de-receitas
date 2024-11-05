<?php
namespace App\Controllers;
use App\Models\Receita;

class ReceitaController {
    public function index() {
        $receitas = Receita::all(); // Pega todas as receitas
        include '../app/Views/receitas/index.php';
    }

    public function create() {
        include '../app/Views/receitas/create.php';
    }

    public function store($dados) {
        $receita = new Receita();
        $receita->titulo = $dados['titulo'];
        $receita->ingredientes = $dados['ingredientes'];
        $receita->instrucoes = $dados['instrucoes'];
        $receita->save();
    }

    public function show($id) {
        $receita = Receita::find($id);
        include '../app/Views/receitas/show.php';
    }

    public function edit($id) {
        $receita = Receita::find($id);
        include '../app/Views/receitas/edit.php';
    }

    public function update($id, $dados) {
        $receita = Receita::find($id);
        $receita->update($dados);
    }

    public function destroy($id) {
        $receita = Receita::find($id);
        $receita->delete();
    }
}
?>

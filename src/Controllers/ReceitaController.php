<?php
namespace Vendor\AppReceitas\Controllers;

use Vendor\AppReceitas\Models\Receita;

class ReceitaController {

    public function list() {
        $receitas = Receita::listarTodas(); 

        if ($receitas) {
            echo json_encode($receitas);  
        } else {
            echo json_encode(["error" => "Nenhuma receita encontrada"]); 
        }
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        // if (empty($data['titulo']) || empty($data['categoria']) || empty($data['ingredientes']) || empty($data['descricao']) || empty($data['modo_preparo']) ) {
        //     echo json_encode(["error" => "Todos os campos são obrigatórios"]);
        //     return;
        // }

        $usuario_id = 1; 

        $receita = new Receita(
            $usuario_id,
            $data['titulo'],
            $data['ingredientes'],
            $data['descricao'],
            $data['modo_preparo'],
            $data['categoria'] ?? null
        );
        $receita->salvar(); 
        echo json_encode(["message" => "Receita criada com sucesso"]);
    }

    public function show($id) {
        $receita = Receita::find($id);
        
        if ($receita) {
            echo json_encode($receita);
        } else {
            echo json_encode(["error" => "Receita não encontrada"]);
        }
    }

    public function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        $receita = Receita::find($id);

        if (!$receita) {
            echo json_encode(["error" => "Receita não encontrada"]);
            return;
        }

        if (!empty($data['categoria'])) $receita->setCategoria($data['categoria']);
        if (!empty($data['titulo'])) $receita->setTitulo($data['titulo']);
        if (!empty($data['ingredientes'])) $receita->setIngredientes($data['ingredientes']);
        if (!empty($data['descricao'])) $receita->setDescricao($data['descricao']);
        if (!empty($data['modo_preparo'])) $receita->setModoPreparo($data['modo_preparo']);

        $receita->atualizar(); 
        echo json_encode(["message" => "Receita atualizada com sucesso"]);
    }

    public function delete($id) {
        $receita = Receita::find($id);

        if ($receita) {
            $receita->deletar(); 
            echo json_encode(["message" => "Receita excluída com sucesso"]);
        } else {
            echo json_encode(["error" => "Receita não encontrada"]);
        }
    }
}
?>

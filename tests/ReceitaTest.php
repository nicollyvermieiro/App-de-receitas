<?php

namespace Tests;

use Vendor\AppReceitas\Models\Receita;
use PHPUnit\Framework\TestCase;
use PDO;

class ReceitaTest extends TestCase
{
    private $db;
    private $receita;

    protected function setUp(): void
    {
        // Estabelecer a conexão com o banco de dados para os testes
        $this->db = new PDO('mysql:host=localhost;dbname=test_app_receitas', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Inserir o usuário de teste se ainda não existir (evita duplicação)
        $stmt = $this->db->prepare("INSERT IGNORE INTO usuarios (name, email, password) VALUES ('Usuario Teste', 'teste@exemplo.com', 'senha123')");
        $stmt->execute();
        
        // Criar a instância da classe Receita
        $this->receita = new Receita($this->db);
    }

    public function testCreate()
    {
        $result = $this->receita->create('Sobremesa', 'Pave', 'Leite condensado, ovos, açúcar...', 'Misture tudo...', 'Cozinhe por 30 minutos...', 5);
        $this->assertTrue($result);  
    }

    public function testGetById()
    {
        $receita = $this->receita->getById(6); //da erro se não existir no banco, mas se existir OK
        $this->assertNotNull($receita);  
        $this->assertEquals('Pudim', $receita['title']);  
    }

    public function testUpdate()
    {
        $result = $this->receita->update('Macarrão com frango', 'Prato Principal', 'Macarrão, frango, molho...', 'Cozinhe o frango e misture...', 'Cozinhe por 20 minutos...', 16);
        
        // Verificar se a atualização foi aplicada
        $receita = $this->receita->getById(16);
        $this->assertEquals('Macarrão com frango', $receita['title']);
    }

    public function testDelete()
{    
    // Excluir a receita
    $result = $this->receita->delete(15);
    
    // Verificar se a receita foi realmente excluída
    $stmt = $this->db->prepare("SELECT * FROM receitas WHERE id = 15");
    $stmt->execute();
    $receita = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // A receita deve ser nula (não encontrada) após a exclusão
    $this->assertFalse($receita);  // Se a receita não for encontrada, o fetch retorna false
}

    

    // Método para limpar dados após execução dos testes, caso necessário
    protected function tearDown(): void
    {
        // Limpeza após os testes (opcional)
        // $this->db->query('DELETE FROM receitas');
        // $this->db->query('DELETE FROM usuarios');
    }
}

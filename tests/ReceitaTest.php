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
        $this->db = new PDO('mysql:host=localhost;dbname=test_app_receitas', 'root', '');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $this->db->prepare("INSERT IGNORE INTO usuarios (name, email, password) VALUES ('Usuario Teste', 'teste@exemplo.com', 'senha123')");
        $stmt->execute();
      
        $this->receita = new Receita($this->db);
    }

    public function testCreate()
    {
        $result = $this->receita->create('Lanche', 'X-tudo', 'Pão, hamburger, tomate...', 'Saboroso e te deixa satisfeito', 'frite o hamburger e coloque no pão', 5);
        $this->assertTrue($result);  
    }

    public function testGetById()
    {
        $receita = $this->receita->getById(18); //da erro se não existir no banco, mas se existir OK
        $this->assertNotNull($receita);  
        $this->assertEquals('Pave', $receita['title']);  
    }

    public function testUpdate()
    {
        $result = $this->receita->update('Macarrão com frango', 'Prato Principal', 'Macarrão, frango, molho...', 'Cozinhe o frango e misture...', 'Cozinhe por 20 minutos...', 12);
        
        $receita = $this->receita->getById(12);
        $this->assertEquals('Macarrão com frango', $receita['title']);
    }

    public function testDelete()
    {    

        $result = $this->receita->delete(14);
        
        // Verificar se a receita foi realmente excluída
        $stmt = $this->db->prepare("SELECT * FROM receitas WHERE id = 14");
        $stmt->execute();
        $receita = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->assertFalse($receita);  
    }

}

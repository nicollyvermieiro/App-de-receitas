<?php
use PHPUnit\Framework\TestCase;
use Vendor\AppReceitas\Controllers\UserController;

class UserControllerTest extends TestCase {

    public function testCreateUser() {
        $controller = new UserController();
        
        // Mock de dados para criar usuário
        $_POST['nome'] = "Usuário Teste";
        $_POST['email'] = "test@exemplo.com";
        $_POST['senha'] = "senha123";

        ob_start();
        $controller->create();
        $output = ob_get_clean();

        $this->assertStringContainsString("Usuário criado com sucesso", $output);
    }
}

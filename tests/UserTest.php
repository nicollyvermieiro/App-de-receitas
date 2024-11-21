<?php
      
    namespace Tests;
        
    use Vendor\AppReceitas\Models\User;
    use PHPUnit\Framework\TestCase;
    use PDO;
        
    class UserTest extends TestCase
    {
        private $db;
        private $user;
        
            protected function setUp(): void
            {
                // Configuração inicial do banco de dados para os testes
                $this->db = new PDO('mysql:host=localhost;dbname=test_app_receitas', 'root', '');
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                // Criar a instância da classe User
                $this->user = new User($this->db);
            }
        
            public function testCreate()
            {
                $result = $this->user->create('joana', 'joana@example.com', 'password123');
                $this->assertTrue($result);
        
                // Verificar se o usuário foi criado
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
                $stmt->bindValue(':email', 'joana@example.com');
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
                $this->assertNotNull($user);
                $this->assertEquals('joana', $user['name']);
            }
        
            public function testGetById()
            {
                $user = $this->user->getById(50); //da erro se não existir no banco, mas se existir OK
                $this->assertNotNull($user);  
                $this->assertEquals('User Test', $user['name']); 
        
                // $stmt = $this->db->prepare("INSERT INTO usuarios (name, email, password) VALUES ('User Test', 'usertest@example.com', 'password')");
                // $stmt->execute();
                // $userId = $this->db->lastInsertId();
        
                // $user = $this->user->getById($userId);
        
                // $this->assertNotNull($user);
                // $this->assertEquals('User Test', $user['name']);
            }
        
            public function testGetByEmail()
            {
                $user = $this->user->getByEmail('emailtest@example.com'); //da erro se não existir no banco, mas se existir OK
                $this->assertNotNull($user);  
                $this->assertEquals('Email Test', $user['name']); 
        
        
                // $stmt = $this->db->prepare("INSERT INTO usuarios (name, email, password) VALUES ('Email Test', 'emailtest@example.com', 'password')");
                // $stmt->execute();
        
                // $user = $this->user->getByEmail('emailtest@example.com');
        
                // $this->assertNotNull($user);
                // $this->assertEquals('Email Test', $user['name']);
            }
        
            public function testUpdate()
            {
                $result = $this->user->update(46, 'felipe', 'fefe@example.com'); //definir um id que existe no banco para atualizar
                // Verificar se a atualização foi aplicada
                $user = $this->user->getById(46);
                $this->assertEquals('felipe', $user['name']);
        
        
                // $stmt = $this->db->prepare("INSERT INTO usuarios (name, email, password) VALUES ('Old Name', 'oldemail@example.com', 'password')");
                // $stmt->execute();
                // $userId = $this->db->lastInsertId();
        
                // $result = $this->user->update($userId, 'Updated Name', 'newemail@example.com');
                // $this->assertTrue($result);
        
                // $user = $this->user->getById($userId);
                // $this->assertEquals('Updated Name', $user['name']);
                // $this->assertEquals('newemail@example.com', $user['email']);
            }
        
            public function testDelete()
            {
                // Excluir usuário
                $result = $this->user->delete(62);
                
                // Verificar se o usuário foi realmente excluído
                $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE id = 62");
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // // o usuário deve ser nulo (não encontrado) após a exclusão
                $this->assertFalse($user);  
        
            }
    }
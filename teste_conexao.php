<?php
require_once 'src/Config/db.php'; 

use Vendor\AppReceitas\Config\db;

try {
    $conexao = db::getInstance();
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

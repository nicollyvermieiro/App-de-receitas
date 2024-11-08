<?php
require_once 'src/Config/DB.php'; 

use Vendor\AppReceitas\Config\DB;

try {
    $conexao = DB::getConnection();
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

<?php
$host = 'localhost';
$user = 'root';
$password = ''; 
$dbname = 'receitas'; 

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida ao banco de dados!";
}

$conn->close();
?>

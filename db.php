<?php
$host = 'localhost'; // ou IP do servidor de banco de dados
$user = 'root'; // seu usuário do MySQL
$password = ''; // sua senha do MySQL
$dbname = 'sistema_acesso'; // nome do banco de dados

// Cria a conexão
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
} else {
    echo "Conexão bem-sucedida!";
}
?>


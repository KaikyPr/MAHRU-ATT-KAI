<?php
$host = 'localhost';  // Ou IP do seu servidor de banco
$dbname = 'MAHRU';    // Nome do banco de dados
$username = 'root';   // Usuário do banco de dados (alterar conforme seu banco)
$password = '';       // Senha do banco de dados (alterar conforme seu banco)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

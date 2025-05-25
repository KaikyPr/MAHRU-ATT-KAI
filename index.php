<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

include('db/conexao.php');

// Obter todos os hacks cadastrados
$sql = "SELECT * FROM hacks ORDER BY piso, tipo";
$stmt = $pdo->query($sql);

// Exibir os hacks
echo "<h1>MAHRU - Mapeamento de Hacks de Rede UNESC</h1>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<div class='hack'>";
    echo "<h2>" . $row['nome'] . "</h2>";
    echo "<p>" . $row['descricao'] . "</p>";
    echo "<p><strong>Piso:</strong> Piso " . $row['piso'] . "</p>";
    echo "<p><strong>Tipo:</strong> " . ucfirst($row['tipo']) . "</p>";
    echo "<img src='uploads/" . $row['imagem'] . "' alt='" . $row['nome'] . "' />";
    echo "</div>";
}
?>

<?php
session_start();

// Verificar se o usuário está logado e tem nível de "admin"
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nivel'] !== 'admin') {
    // Se não for admin, exibe uma mensagem e redireciona
    echo "Você não tem permissão para acessar esta página.";
    header('Location: login.php');  // Redireciona para o login
    exit;  // Impede a execução do resto do código
}

include('db/conexao.php');  // Incluindo a conexão com o banco de dados

// Lógica para cadastrar o novo usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];

    // Hash da senha para segurança
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Prevenir SQL Injection com consultas preparadas
    $sql = "INSERT INTO usuarios (nome, email, senha, nivel) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $senhaHash, $nivel]);

    echo "Usuário cadastrado com sucesso!";
}
?>

<h1>Cadastro de Usuário - Somente Administrador</h1>
<form method="POST">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" required><br>

    <label for="email">E-mail:</label>
    <input type="email" name="email" required><br>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" required><br>

    <label for="nivel">Nível:</label>
    <select name="nivel" required>
        <option value="admin">Admin</option>
        <option value="editor">Editor</option>
        <option value="visualizador">Visualizador</option>
    </select><br>

    <button type="submit">Cadastrar</button>
</form>

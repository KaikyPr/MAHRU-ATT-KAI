<?php
session_start();
include('db/conexao.php');  // Incluindo a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consultar o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        // Senha correta, cria a sessão
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_nivel'] = $usuario['nivel'];

        echo "Login realizado com sucesso!";
        header('Location: index.php');  // Redireciona para a página principal
    } else {
        echo "E-mail ou senha incorretos!";
    }
}
?>

<h1>Login</h1>
<form method="POST">
    <label for="email">E-mail:</label>
    <input type="email" name="email" required><br>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" required><br>

    <button type="submit">Entrar</button>
</form>


<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_nivel'] != 'admin' && $_SESSION['usuario_nivel'] != 'editor')) {
    header('Location: login.php');
    exit;
}

include('db/conexao.php');  // Incluindo a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagem'])) {
    $imagem = $_FILES['imagem'];
    
    // Definir o diretório de upload
    $diretorio = "uploads/";  // Diretório onde as imagens serão salvas
    $nomeImagem = basename($imagem['name']);
    $caminhoImagem = $diretorio . $nomeImagem;
    
    // Verificar se o arquivo é uma imagem válida
    $tipoImagem = pathinfo($caminhoImagem, PATHINFO_EXTENSION);
    if (in_array(strtolower($tipoImagem), ['jpg', 'jpeg', 'png', 'gif'])) {
        if (move_uploaded_file($imagem['tmp_name'], $caminhoImagem)) {
            // Salvar os dados no banco de dados
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $tipo = $_POST['tipo'];
            $piso = $_POST['piso'];
            
            // Prevenir SQL Injection com consultas preparadas
            $sql = "INSERT INTO hacks (nome, descricao, tipo, piso, imagem) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $descricao, $tipo, $piso, $nomeImagem]);

            echo "Hack cadastrado com sucesso!";
        } else {
            echo "Erro ao enviar a imagem.";
        }
    } else {
        echo "Somente arquivos de imagem são permitidos.";
    }
}
?>

<h1>Cadastro de Hacks</h1>
<form method="POST" enctype="multipart/form-data">
    <label for="nome">Nome do Hack:</label>
    <input type="text" name="nome" required><br>

    <label for="descricao">Descrição:</label>
    <textarea name="descricao" required></textarea><br>

    <label for="tipo">Tipo:</label>
    <select name="tipo" required>
        <option value="interno">Interno</option>
        <option value="externo">Externo</option>
    </select><br>

    <label for="piso">Piso:</label>
    <select name="piso" required>
        <option value="1">Piso 1</option>
        <option value="2">Piso 2</option>
        <option value="3">Piso 3</option>
    </select><br>

    <label for="imagem">Imagem:</label>
    <input type="file" name="imagem" accept="image/*" required><br>

    <button type="submit">Cadastrar Hack</button>
</form>

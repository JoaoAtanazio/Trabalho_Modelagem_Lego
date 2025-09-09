<?php
require_once 'conexao.php';

// Verifica se o formulário foi enviado e se não está vazio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterar_usuario'])) {
    // Coleta de dados
    $id = $_POST['id_usuario'];
    // TRIM retira os espaços de uma string
    $nome = trim($_POST['nome_usuario']);
    $email = trim($_POST['email']);
    
    // Verifica se o email já existe para outro usuário
    $sql_check = "SELECT id_usuario FROM usuario WHERE email = :email AND id_usuario != :id";
    // Prepara a variável sql
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':email', $email);
    $stmt_check->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_check->execute();
    
    // Verifica se a consulta retornou algum resultado
    if ($stmt_check->rowCount() > 0) {
        echo "<script>alert('Este e-mail já está em uso por outro usuário!');window.history.back();</script>";
        exit();
    }
    
    // Construir a query de atualização
    $sql = "UPDATE usuario SET nome_usuario = :nome, email = :email";
    $params = [':nome' => $nome, ':email' => $email, ':id' => $id];
    
    // Se uma nova senha foi fornecida, adicionar à query
    if (!empty($_POST['senha'])) {
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sql .= ", senha = :senha";
        $params[':senha'] = $senha_hash;
    }
    // Adiciona uma condição á variável sql
    $sql .= " WHERE id_usuario = :id";
    
    // Executar a atualização
    $stmt = $pdo->prepare($sql);
    
    // Percorre a variável params
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    // Executa a query preparada e retorna mensagens
    if ($stmt->execute()) {
        echo "<script>alert('Usuário atualizado com sucesso!');window.location.href='gestao_usuario.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o usuário!');window.history.back();</script>";
    }
} else {
    header("Location: gestao_usuario.php");
    exit();
}
?>
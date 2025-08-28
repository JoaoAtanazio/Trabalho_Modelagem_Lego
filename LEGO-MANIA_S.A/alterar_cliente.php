<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['alterar_cliente'])) {
    $id = $_POST['id_cliente'];
    $nome = trim($_POST['nome_cliente']);
    $cpf_cnpj = trim($_POST['cpf_cnpj']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['endereco']);
    $bairro = trim($_POST['bairro']);
    $cep = trim($_POST['cep']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    
    // Verificar se o CPF/CNPJ já existe para outro cliente
    $sql_check = "SELECT id_cliente FROM cliente WHERE cpf_cnpj = :cpf_cnpj AND id_cliente != :id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->bindParam(':cpf_cnpj', $cpf_cnpj);
    $stmt_check->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_check->execute();
    
    if ($stmt_check->rowCount() > 0) {
        echo "<script>alert('Este CPF/CNPJ já está em uso por outro cliente!');window.history.back();</script>";
        exit();
    }
    
    // Construir a query de atualização
    $sql = "UPDATE cliente SET 
            nome_cliente = :nome, 
            cpf_cnpj = :cpf_cnpj, 
            telefone = :telefone, 
            email = :email,
            endereco = :endereco,
            bairro = :bairro,
            cep = :cep,
            cidade = :cidade,
            estado = :estado
            WHERE id_cliente = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf_cnpj', $cpf_cnpj);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "<script>alert('Cliente atualizado com sucesso!');window.location.href='gestao_cliente.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o cliente!');window.history.back();</script>";
    }
} else {
    header("Location: gestao_cliente.php");
    exit();
}
?>
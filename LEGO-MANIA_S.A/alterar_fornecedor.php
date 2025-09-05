<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter o ID do fornecedor (deve vir de um campo hidden no formulário)
    $id_fornecedor = $_POST['id_fornecedor'];
    
    $nome_fornecedor = trim($_POST['nome_fornecedor']);
    $cpf_cnpj = preg_replace('/[^0-9]/', '', $_POST['cpf_cnpj']);
    $ramo_atividade = trim($_POST['ramo_atividade']);
    $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);
    $endereco = trim($_POST['endereco']);
    $bairro = trim($_POST['bairro']);
    $cep = preg_replace('/[^0-9]/', '', $_POST['cep']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $email = trim($_POST['email']);
    
    // Construir a query de atualização
    $sql = "UPDATE fornecedor SET 
            nome_fornecedor = :nome_fornecedor, 
            cpf_cnpj = :cpf_cnpj, 
            ramo_atividade = :ramo_atividade, 
            telefone = :telefone,
            endereco = :endereco,
            bairro = :bairro,
            cep = :cep,
            cidade = :cidade,
            estado = :estado,
            email = :email
            WHERE id_fornecedor = :id_fornecedor";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_fornecedor', $nome_fornecedor);
    $stmt->bindParam(':cpf_cnpj', $cpf_cnpj);
    $stmt->bindParam(':ramo_atividade', $ramo_atividade);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "<script>alert('Fornecedor atualizado com sucesso!');window.location.href='gestao_fornecedor.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o fornecedor!');window.history.back();</script>";
    }
} else {
    header("Location: gestao_fornecedor.php");
    exit();
}
?>
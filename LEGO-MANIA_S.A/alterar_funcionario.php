<?php
session_start();
require_once 'conexao.php';

// Verificar permissão
if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3){
    echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}

if(isset($_POST['alterar_funcionario'])) {
    $id = $_POST['id_funcionario'];
    $nome = $_POST['nome_funcionario'];
    $cpf = $_POST['cpf_funcionario'];
    $salario = $_POST['salario'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    $dt_nascimento = $_POST['dt_nascimento'];
    
    $sql = "UPDATE funcionario SET 
            nome_funcionario = :nome, 
            cpf_funcionario = :cpf, 
            salario = :salario, 
            email = :email, 
            endereco = :endereco, 
            bairro = :bairro, 
            cidade = :cidade, 
            estado = :estado, 
            cep = :cep, 
            dt_nascimento = :dt_nascimento 
            WHERE id_funcionario = :id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':salario', $salario);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':dt_nascimento', $dt_nascimento);
    $stmt->bindParam(':id', $id);
    
    if($stmt->execute()) {
        echo "<script>alert('Funcionário atualizado com sucesso!');window.location.href='gestao_funcionario.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar funcionário!');window.history.back();</script>";
    }
} else {
    header('Location: gestao_funcionario.php');
}
?>
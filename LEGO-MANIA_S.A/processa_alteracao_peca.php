<?php
    session_start();
    require_once 'conexao.php';
    require_once 'php/permissoes.php';

    if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2 && $_SESSION['perfil']!=4){
        echo "<script> alert ('Acesso negado!');window.location.href='principal.php';</script>";
        exit();
    }
    
    if ($_SERVER['REQUEST_METHOD']=="POST"){
        $id_peca = $_POST['id_peca_est'];
        $nome_peca = trim($_POST['nome_peca']);
        $tipo = trim($_POST['tipo']);
        $fornecedor = trim($_POST['id_fornecedor']);
        $quantidade = (int)$_POST['quantidade'];
        $quantidade_minima = isset($_POST['quantidade_minima']) ? (int)$_POST['quantidade_minima'] : 0;
// ATUALIZA OS DADOS DO USUÁRIO

        $sql="UPDATE peca_estoque SET nome_peca = :nome_peca,tipo=:tipo,id_fornecedor=:fornecedor,qtde=:quantidade,qtde_minima=:quantidade_minima WHERE id_peca_est = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_peca',$nome_peca);
        $stmt->bindParam(':tipo',$tipo);
        $stmt->bindParam(':fornecedor',$fornecedor);
        $stmt->bindParam(':quantidade',$quantidade);
        $stmt->bindParam(':quantidade_minima',$quantidade_minima);
        $stmt->bindParam(':id',$id_peca);

    if($stmt->execute()){
        echo "<script>alert('Peça atualizado com sucesso!');window.location.href='relatorio_pecas_estoque.php';</script>";
    } else{
        echo "<script>alert('Erro ao atualizar peça');window.location.href='relatorio_pecas_estoque.php?id=$id_peca';</script>";
    }
    }
    
        
?>
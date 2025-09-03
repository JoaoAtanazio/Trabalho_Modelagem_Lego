<?php
session_start();
require_once 'conexao.php';
require_once 'php/permissoes.php';

if ($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2 && $_SESSION['perfil']!=4) {
    echo "<script>alert('Acesso negado!');window.location.href='relatorio_pecas_estoque.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['id_peca_est'])) {
    $id = (int)$_POST['id_peca_est'];
    $stmt = $pdo->prepare("DELETE FROM peca_estoque WHERE id_peca_est = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Peça excluída com sucesso!');window.location.href='relatorio_pecas_estoque.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir peça!');window.location.href='relatorio_pecas_estoque.php';</script>";
    }
} else {
    header('Location: relatorio_pecas_estoque.php');
    exit();
}
?>
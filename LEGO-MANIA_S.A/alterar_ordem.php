<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso Negado! Faça login primeiro.'); window.location.href='index.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_ordem'])) {
    $id_ordem      = $_POST['id_ordem'];
    $nome_cliente  = $_POST['nome_cliente'];
    $tecnico       = $_POST['tecnico'];
    $marca         = $_POST['marca_aparelho'];
    $prioridade    = $_POST['prioridade'];
    $problema      = $_POST['problema'];
    $dt_receb      = $_POST['dt_recebimento'];
    $valor_total   = $_POST['valor_total'];
    $observacao    = $_POST['observacao'];

    try {
        $sql = "UPDATE nova_ordem 
                SET nome_client_ordem = :nome_cliente,
                    tecnico = :tecnico,
                    marca_aparelho = :marca,
                    prioridade = :prioridade,
                    problema = :problema,
                    dt_recebimento = :dt_receb,
                    valor_total = :valor_total,
                    observacao = :observacao
                WHERE id_ordem = :id_ordem";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_cliente', $nome_cliente);
        $stmt->bindParam(':tecnico', $tecnico);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':prioridade', $prioridade);
        $stmt->bindParam(':problema', $problema);
        $stmt->bindParam(':dt_receb', $dt_receb);
        $stmt->bindParam(':valor_total', $valor_total);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':id_ordem', $id_ordem);

        if ($stmt->execute()) {
            echo "<script>alert('Ordem alterada com sucesso!'); window.location.href='consultar_ordem.php';</script>";
        } else {
            echo "<script>alert('Erro ao alterar a ordem!'); window.history.back();</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Erro: " . $e->getMessage() . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Dados inválidos.'); window.location.href='consultar_ordem.php';</script>";
}

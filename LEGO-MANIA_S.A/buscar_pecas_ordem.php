<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['id_usuario'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['error' => 'Não autorizado']);
    exit();
}

if (isset($_GET['id_ordem']) && is_numeric($_GET['id_ordem'])) {
    $id_ordem = $_GET['id_ordem'];
    
    // Verificar se a tabela existe
    $tableExists = $pdo->query("SHOW TABLES LIKE 'ordem_servico_pecas'")->rowCount() > 0;
    
    if ($tableExists) {
        $sql = "SELECT op.id_peca_est, op.quantidade 
                FROM ordem_servico_pecas op 
                WHERE op.id_ordem = :id_ordem";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_ordem' => $id_ordem]);
        $pecas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $pecas = [];
    }
    
    header('Content-Type: application/json');
    echo json_encode($pecas);
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'ID da ordem não especificado']);
}
?>
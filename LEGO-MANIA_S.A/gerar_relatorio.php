<?php
session_start();
require_once 'conexao.php';

// Verificar permissões
if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3){
    header("Location: principal.php");
    exit();
}

// Obter o tipo de relatório
$tipo = $_GET['tipo'] ?? '';

// Buscar dados dos usuários
$sql = "SELECT u.*, p.nome_perfil, m.descricao as motivo_inatividade 
        FROM usuario u 
        LEFT JOIN perfil p ON u.id_perfil = p.id_perfil 
        LEFT JOIN motivo_inatividade m ON u.id_motivo_inatividade = m.id_motivo
        ORDER BY u.nome_usuario ASC";
        
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular estatísticas
$total_usuarios = count($usuarios);
$ativos = count(array_filter($usuarios, fn($u) => $u['status'] === 'Ativo'));
$inativos = $total_usuarios - $ativos;

// Distribuição por perfil
$perfis = [];
foreach ($usuarios as $usuario) {
    $perfil = $usuario['nome_perfil'];
    if (!isset($perfis[$perfil])) {
        $perfis[$perfil] = 0;
    }
    $perfis[$perfil]++;
}

// Gerar o relatório conforme o tipo solicitado
switch ($tipo) {
    case 'estatisticas':
        gerarRelatorioEstatisticas($usuarios, $total_usuarios, $ativos, $inativos, $perfis);
        break;
    case 'pdf':
        gerarPDF($usuarios, $total_usuarios, $ativos, $inativos, $perfis);
        break;
    case 'excel':
        gerarExcel($usuarios);
        break;
    case 'csv':
        gerarCSV($usuarios);
        break;
    default:
        header("Location: gestao_usuario.php");
        exit();
}

function gerarRelatorioEstatisticas($usuarios, $total, $ativos, $inativos, $perfis) {
    // Para este exemplo, vamos gerar um PDF simples com estatísticas
    // Em um sistema real, você poderia usar uma biblioteca como TCPDF ou Dompdf
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="estatisticas_usuarios.pdf"');
    
    // Conteúdo simples do PDF (em um caso real, use uma biblioteca PDF)
    $conteudo = "%PDF-1.4\n\n1 0 obj\n<<\n/Type /Catalog\n/Pages 2 0 R\n>>\nendobj\n\n2 0 obj\n<<\n/Type /Pages\n/Kids [3 0 R]\n/Count 1\n>>\nendobj\n\n3 0 obj\n<<\n/Type /Page\n/Parent 2 0 R\n/MediaBox [0 0 612 792]\n/Contents 4 0 R\n>>\nendobj\n\n4 0 obj\n<<\n/Length 200\n>>\nstream\nBT\n/F1 12 Tf\n50 750 Td\n(Relatório de Estatísticas de Usuários) Tj\n0 -20 Td\n(Data: " . date('d/m/Y H:i:s') . ") Tj\n0 -40 Td\n(Total de Usuários: $total) Tj\n0 -20 Td\n(Usuários Ativos: $ativos) Tj\n0 -20 Td\n(Usuários Inativos: $inativos) Tj\n0 -40 Td\n(Distribuição por Perfil:) Tj\n";
    
    $y = 550;
    foreach ($perfis as $perfil => $quantidade) {
        $conteudo .= "0 -20 Td\n($perfil: $quantidade) Tj\n";
        $y -= 20;
        if ($y < 50) break;
    }
    
    $conteudo .= "ET\nendstream\nendobj\n\nxref\n0 5\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \n0000000115 00000 n \n0000000239 00000 n \ntrailer\n<<\n/Size 5\n/Root 1 0 R\n>>\nstartxref\n" . strlen($conteudo) . "\n%%EOF";
    
    echo $conteudo;
    exit();
}

function gerarPDF($usuarios, $total, $ativos, $inativos, $perfis) {
    // Carregar a biblioteca TCPDF
    require_once('tcpdf/tcpdf.php');
    
    // Criar novo documento PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Configurar documento
    $pdf->SetCreator('Lego Mania');
    $pdf->SetAuthor('Sistema Lego Mania');
    $pdf->SetTitle('Lista de Usuários');
    $pdf->SetSubject('Relatório de Usuários');
    
    // Adicionar uma página
    $pdf->AddPage();
    
    // Configurar fonte
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Lista de Usuários - Lego Mania', 0, 1, 'C');
    
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 10, 'Data: ' . date('d/m/Y H:i:s'), 0, 1);
    $pdf->Ln(5);
    
    // Criar tabela
    $html = '<table border="1" cellpadding="4">
        <tr style="background-color:#f2f2f2;">
            <th width="8%">ID</th>
            <th width="25%">Nome</th>
            <th width="30%">Email</th>
            <th width="17%">Perfil</th>
            <th width="10%">Status</th>
        </tr>';
    
    foreach ($usuarios as $usuario) {
        $html .= '<tr>
            <td>' . $usuario['id_usuario'] . '</td>
            <td>' . htmlspecialchars($usuario['nome_usuario']) . '</td>
            <td>' . htmlspecialchars($usuario['email']) . '</td>
            <td>' . htmlspecialchars($usuario['nome_perfil']) . '</td>
            <td>' . $usuario['status'] . '</td>
        </tr>';
    }
    
    $html .= '</table>';
    
    // Escrever o HTML no PDF
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Gerar o PDF e forçar download
    $pdf->Output('lista_usuarios.pdf', 'D');
    exit();
}

function gerarExcel($usuarios) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="lista_usuarios.xls"');
    
    echo "ID\tNome\tEmail\tPerfil\tStatus\tData Inatividade\tMotivo Inatividade\n";
    
    foreach ($usuarios as $usuario) {
        echo $usuario['id_usuario'] . "\t";
        echo $usuario['nome_usuario'] . "\t";
        echo $usuario['email'] . "\t";
        echo $usuario['nome_perfil'] . "\t";
        echo $usuario['status'] . "\t";
        echo $usuario['data_inatividade'] . "\t";
        echo $usuario['motivo_inatividade'] . "\n";
    }
    
    exit();
}

function gerarCSV($usuarios) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="lista_usuarios.csv"');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Nome', 'Email', 'Perfil', 'Status', 'Data Inatividade', 'Motivo Inatividade'], ';');
    
    foreach ($usuarios as $usuario) {
        fputcsv($output, [
            $usuario['id_usuario'],
            $usuario['nome_usuario'],
            $usuario['email'],
            $usuario['nome_perfil'],
            $usuario['status'],
            $usuario['data_inatividade'],
            $usuario['motivo_inatividade']
        ], ';');
    }
    
    fclose($output);
    exit();
}
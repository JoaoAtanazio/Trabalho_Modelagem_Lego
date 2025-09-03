<?php
session_start();
require_once 'php/permissoes.php';
require_once 'conexao.php';

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2 && $_SESSION['perfil']!=4){
    echo "<script> alert ('Acesso negado!');window.location.href='principal.php';</script>";
    exit();
}
$fornecedores = [];
try {
    $stmt = $pdo->prepare("SELECT id_fornecedor, nome_fornecedor FROM fornecedor WHERE status = 'Ativo' ORDER BY nome_fornecedor");
    $stmt->execute();
    $fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erro ao buscar fornecedores: " . $e->getMessage());
};
$peca_estoque = [];

if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST['busca'])){
    $busca = trim($_POST['busca']);

    // VERIFICA SE A BUSCA É UM numero OU UM nome
    if(is_numeric($busca)){
        $sql="SELECT id_peca_est,nome_peca,descricao_peca,qtde,preco,qtde_minima,descricao_peca,tipo,dt_cadastro,preco,nome_funcionario,nome_fornecedor
                from peca_estoque
                join funcionario on peca_estoque.id_funcionario = funcionario.id_funcionario
                join fornecedor on peca_estoque.id_fornecedor = fornecedor.id_fornecedor
                where id_peca_est = :busca";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    }else{
        $sql="SELECT id_peca_est,nome_peca,descricao_peca,qtde,preco,descricao_peca,qtde_minima,tipo,dt_cadastro,preco,nome_funcionario,nome_fornecedor
                from peca_estoque
                join funcionario on peca_estoque.id_funcionario = funcionario.id_funcionario
                join fornecedor on peca_estoque.id_fornecedor = fornecedor.id_fornecedor
                where nome_peca LIKE :busca_nome";

        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
    }
} else{
    $sql="SELECT id_peca_est,nome_peca,descricao_peca,qtde,preco,descricao_peca,qtde_minima,tipo,dt_cadastro,preco, nome_funcionario,nome_fornecedor
          from peca_estoque
          join funcionario on peca_estoque.id_funcionario = funcionario.id_funcionario
          join fornecedor on peca_estoque.id_fornecedor = fornecedor.id_fornecedor";

    $stmt=$pdo->prepare($sql);
}
$stmt->execute();
$pecas_estoque = $stmt->fetchALL(PDO::FETCH_ASSOC);

function estoqueStatus($rawQtde): array {
    // normaliza: garante número inteiro (remove qualquer coisa que não seja dígito ou sinal)
    $qtde = (int)preg_replace('/[^\d\-]/', '', (string)$rawQtde);

    if ($qtde < 5) {
        return ['Baixo', 'bg-danger'];
    } elseif ($qtde <= 10) { // 5..10
        return ['Médio', 'bg-warning text-dark'];
    } else { // > 10
        return ['Alto', 'bg-success'];
    }
}

// Buscar todas as peças do estoque
$stmtIndicadores = $pdo->prepare("SELECT qtde FROM peca_estoque");
$stmtIndicadores->execute();
$pecas = $stmtIndicadores->fetchAll(PDO::FETCH_ASSOC);

$totalPecas = count($pecas);
$emEstoque = 0;
$estoqueMedio = 0;
$estoqueBaixo = 0;

foreach ($pecas as $peca) {
    $qtde = (int)$peca['qtde'];
    if ($qtde < 5) {
        $estoqueBaixo++;
    } elseif ($qtde <= 10) {
        $estoqueMedio++;
    } else {
        $emEstoque++;
    }
}
$categorias = ['hardware' => 0, 'perifericos' => 0, 'cabos' => 0, 'outros' => 0];
if (!empty($pecas_estoque)) {
    foreach ($pecas_estoque as $peca) {
        $tipo = strtolower($peca['tipo']);
        if (isset($categorias[$tipo])) {
            $categorias[$tipo]++;
        }
    }
}
?>
<?php
// Filtro por categoria
if (!empty($_POST['categoria'])) {
    $pecas_estoque = array_filter($pecas_estoque, function($peca) {
        return $peca['tipo'] == $_POST['categoria'];
    });
}

// Filtro por status
if (!empty($_POST['status'])) {
    $pecas_estoque = array_filter($pecas_estoque, function($peca) {
        if ($_POST['status'] == 'baixo') return $peca['qtde'] < 5;
        if ($_POST['status'] == 'medio') return $peca['qtde'] >= 5 && $peca['qtde'] <= 10;
        if ($_POST['status'] == 'disponivel') return $peca['qtde'] > 10;
        return true;
    });
}

// Ordenação
if (!empty($_POST['ordenacao'])) {
    if ($_POST['ordenacao'] == 'nome_desc') {
        usort($pecas_estoque, fn($a, $b) => strcmp($b['nome_peca'], $a['nome_peca']));
    } elseif ($_POST['ordenacao'] == 'nome_asc') {
        usort($pecas_estoque, fn($a, $b) => strcmp($a['nome_peca'], $b['nome_peca']));
    } elseif ($_POST['ordenacao'] == 'estoque_desc') {
        usort($pecas_estoque, fn($a, $b) => $b['qtde'] - $a['qtde']);
    } elseif ($_POST['ordenacao'] == 'estoque_asc') {
        usort($pecas_estoque, fn($a, $b) => $a['qtde'] - $b['qtde']);
    }
}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro - Lego Mania</title>
    <script src="js/validacoes_form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script src="js/ExportaRelatorios.js"></script>
    <script src="js/Exclusoes.js"></script>
    <script src="js/oculta.js"></script>
</head>
<body class="bg-light">
    <div class="d-flex vh-100 bg-light">
         <!-- Sidebar -->
       <?php exibirMenu(); ?>


        <!-- Conteúdo principal -->
        <div class="flex-grow-1 d-flex flex-column" style="margin-left:250px; padding:20px;">
            <!-- Header -->
            <nav class="navbar navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-dark" id="menu-toggle"><i class="bi bi-list"></i></button>
                    <!-- Botão voltar -->
                    <button class="btn btn-outline-dark" style="position: absolute; margin-left: 60px;" onclick="history.back()">Voltar</button>
                    <span class="navbar-brand mb-0 h1">
                        <small class="text-muted">Horário atual:</small>
                        <span id="liveClock" class="badge bg-secondary"></span>
                    </span>
                </div>
            </nav>

            <!-- Conteúdo - Formulário -->
            <!DOCTYPE php>
<php lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Peças no Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-dashboard {
            transition: transform 0.2s;
        }
        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15) !important;
        }
        .btn-action {
            width: 30px;
            height: 30px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .status-badge {
            font-size: 0.75rem;
        }
        .table th {
            border-top: none;
            font-weight: 600;
        }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh; /* altura total da tela */
            width: 250px;  /* ajuste para o tamanho da sua sidebar */
            background-color: #f8f9fa; /* cor de fundo */
        }
    </style>
</head>
<body>
    <div class="flex-grow-1 p-3" style="overflow-y: auto;">
        <div class="container-fluid">
            <!-- Cabeçalho -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-boxes me-2"></i>Relatório de Peças no Estoque</h5>
                <div>
                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="generatePDF()">
                        <i class="bi bi-download me-1"></i> Exportar
                    </button>
                    <button class="btn btn-primary btn-sm" onclick="window.location.href='cadastro_pecas.php'">
                        <i class="bi bi-plus-circle me-1"></i> Nova Peça
                    </button>
                </div>
            </div>

            <!-- Cards de resumo -->
            <div class="row mb-4">
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 card-dashboard">
                        <div class="card-body text-center">
                            <div class="text-primary mb-2">
                                <i class="bi bi-box-seam fs-1"></i>
                            </div>
                            <h3><?= $totalPecas ?></h3>
                            <p class="card-text text-muted">Total de Peças</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 card-dashboard">
                        <div class="card-body text-center">
                            <div class="text-success mb-2">
                                <i class="bi bi-check-circle fs-1"></i>
                            </div>
                            <h3><?= $emEstoque ?></h3>

                            <p class="card-text text-muted">Em Estoque</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 card-dashboard">
                        <div class="card-body text-center">
                            <div class="text-warning mb-2">
                                <i class="bi bi-exclamation-triangle fs-1"></i>
                            </div>
                            <h3><?= $estoqueMedio ?></h3>
                            <p class="card-text text-muted">Estoque Médio</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 card-dashboard">
                        <div class="card-body text-center">
                            <div class="text-danger mb-2">
                                <i class="bi bi-x-circle fs-1"></i>
                            </div>
                            <h3><?= $estoqueBaixo ?></h3>
                            <p class="card-text text-muted">Estoque Baixo</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos e Tabela -->
            <div class="row mb-4">
                <!-- Espaço para Gráficos (lado esquerdo) -->
                <div class="col-lg-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Distribuição de Peças por Categoria</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="graficoCategorias" height="250"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Tabela de Peças (lado direito) -->
                <div class="col-lg-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0"><i class="bi bi-table me-2"></i>Últimas Peças Adicionadas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="ultimas-pecas-table">
                                    <thead>
                                        <tr>
                                            <th>Peça</th>
                                            <th>Categoria</th>
                                            <th>Estoque</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Buscar as 5 últimas peças adicionadas
                                            $stmtUltimas = $pdo->prepare("
                                                SELECT nome_peca, tipo, qtde, qtde_minima
                                                FROM peca_estoque
                                                ORDER BY dt_cadastro DESC
                                                LIMIT 5
                                            ");
                                            $stmtUltimas->execute();
                                            $ultimasPecas = $stmtUltimas->fetchAll(PDO::FETCH_ASSOC);

                                            foreach ($ultimasPecas as $peca) {
                                                [$statusTxt, $statusClass] = estoqueStatus($peca['qtde']);
                                                echo '<tr>';
                                                echo '<td>' . htmlspecialchars($peca['nome_peca']) . '</td>';
                                                echo '<td>' . htmlspecialchars($peca['tipo']) . '</td>';
                                                echo '<td>' . htmlspecialchars($peca['qtde']) . '</td>';
                                                echo '<td><span class="badge ' . $statusClass . ' status-badge">' . $statusTxt . '</span></td>';
                                                echo '</tr>';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barra de pesquisa e filtros -->
            <div class="card shadow-sm mb-3">
                <div class="card-body py-2">
                    <form method="POST" class="row g-2">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" placeholder="Pesquisar peças..." name="busca" value="<?= htmlspecialchars($_POST['busca'] ?? '') ?>">
                                <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="filtroCategoria" name="categoria" onchange="this.form.submit()">>
                                <option value="" selected>Todas categorias</option>
                                <option value="hardware" <?= ($_POST['categoria'] ?? '') == 'hardware' ? 'selected' : '' ?>>Hardware</option>
                                <option value="perifericos" <?= ($_POST['categoria'] ?? '') == 'perifericos' ? 'selected' : '' ?>>Periféricos</option>
                                <option value="cabos" <?= ($_POST['categoria'] ?? '') == 'cabos' ? 'selected' : '' ?>>Cabos</option>
                                <option value="outros" <?= ($_POST['categoria'] ?? '') == 'outros' ? 'selected' : '' ?>>Outros</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="filtroStatus" name="status" onchange="this.form.submit()">>
                                <option value="" selected>Todos status</option>
                                <option value="disponivel" <?= ($_POST['status'] ?? '') == 'disponivel' ? 'selected' : '' ?>>Disponível</option>
                                <option value="medio" <?= ($_POST['status'] ?? '') == 'medio' ? 'selected' : '' ?>>Estoque Médio</option>
                                <option value="baixo" <?= ($_POST['status'] ?? '') == 'baixo' ? 'selected' : '' ?>>Estoque baixo</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="ordenacaoPecas" name="ordenacao" onchange="this.form.submit()">>
                                <option value="nome_asc"<?= ($_POST['ordenacao'] ?? '') == 'nome_asc' ? 'selected' : '' ?>>Nome (A-Z)</option>
                                <option value="nome_desc" <?= ($_POST['ordenacao'] ?? '') == 'nome_desc' ? 'selected' : '' ?>>Nome (Z-A)</option>
                                <option value="estoque_desc" <?= ($_POST['ordenacao'] ?? '') == 'estoque_desc' ? 'selected' : '' ?>>Maior Estoque</option>
                                <option value="estoque_asc" <?= ($_POST['ordenacao'] ?? '') == 'estoque_asc' ? 'selected' : '' ?>>Menor Estoque</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary btn-sm w-100" id="btnLimparFiltros" type="button" onclick="limparFiltros()">
                                <i class="bi bi-arrow-clockwise me-1"></i> Limpar
                            </button>
                            <script>
                                function limparFiltros() {
                                    document.querySelector('input[name="busca"]').value = '';
                                    document.querySelector('select[name="categoria"]').value = '';
                                    document.querySelector('select[name="status"]').value = '';
                                    document.querySelector('select[name="ordenacao"]').value = 'nome_asc';
                                    document.querySelector('form').submit();
                                }
                            </script>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Tabela de peças -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                    <?php if(!empty($pecas_estoque)):?>
                        <table class="table table-hover table-striped mb-0" id="report-table">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" style="width: 60px;">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Preço</th>
                                    <th scope="col">Fornecedor</th>
                                    <th scope="col">Estoque Atual</th>
                                    <th scope="col">Estoque Mínimo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($pecas_estoque as $peca_estoque): ?>
                                 <tr data-id="<?= $peca_estoque['id_peca_est'] ?>">
                                 <td><?= htmlspecialchars($peca_estoque['id_peca_est']) ?></td>
                                 <td><?= htmlspecialchars($peca_estoque['nome_peca']) ?></td>
                                 <td><?= htmlspecialchars($peca_estoque['tipo']) ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="toggleDescricao(this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <span class="descricao-texto d-none"><?= htmlspecialchars($peca_estoque['descricao_peca']) ?></span>
                                    </td>
                                 <td>R$ <?= number_format($peca_estoque['preco'], 2, ',', '.') ?></td>
                                 <td><?= htmlspecialchars($peca_estoque['nome_fornecedor']) ?></td>
                                 <td><?= htmlspecialchars($peca_estoque['qtde']) ?></td>
                                 <td><?= htmlspecialchars($peca_estoque['qtde_minima']) ?></td>
                                 <td><?php
                                         [$txt, $cls] = estoqueStatus($peca_estoque['qtde'] ?? 0);
                                         echo "<span class='badge $cls'>$txt</span>";?>
                                 </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary btn-action" title="Alterar"
                                            onclick="editarPeca(
                                                <?= $peca_estoque['id_peca_est'] ?>,
                                                '<?= htmlspecialchars($peca_estoque['nome_peca'], ENT_QUOTES) ?>',
                                                '<?= htmlspecialchars($peca_estoque['tipo'], ENT_QUOTES) ?>',
                                                <?= $peca_estoque['id_fornecedor'] ?? 0 ?>,
                                                <?= $peca_estoque['qtde'] ?>,
                                                <?= $peca_estoque['qtde_minima'] ?>
                                            )">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" title="Excluir" onclick="excluirPeca(<?= $peca_estoque['id_peca_est'] ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                            </tbody>
                            <?php endforeach;?>  
                        </table>
                        <?php else:?>
                        <p> Nenhuma peça encontrada.</p>
                        <?php endif;?>
                    </div>
                </div>
                <div class="card-footer py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted">Mostrando 5 de 128 peças</span>
                        </div>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar/editar peça -->
    <div class="modal fade" id="modalAdicionarPeca" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar peça</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="processa_alteracao_peca.php" method="POST" id="formPeca">
                        <div class="mb-3">
                            <input type="hidden" name="id_peca_est" value="">
                            <label for="nome_peca" class="form-label">Nome da Peça</label>
                            <input type="text" class="form-control" id="nome_peca" name="nome_peca" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Categoria</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="" selected disabled>Selecione uma categoria</option>
                                <option value="hardware" <?=$peca_estoque['tipo'] == 1 ? 'select':''?>>Hardware</option>
                                <option value="perifericos" <?=$peca_estoque['tipo'] == 2 ? 'select':''?>>Periféricos</option>
                                <option value="cabos" <?=$peca_estoque['tipo'] == 3 ? 'select':''?>>Cabos</option>
                                <option value="outros" <?=$peca_estoque['tipo'] == 4 ? 'select':''?>>Outros</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-select select2-fornecedor" id="id_fornecedor" name="id_fornecedor" required>
                                <option value="" selected disabled>Selecione um fornecedor</option>
                                    <?php foreach ($fornecedores as $fornecedor): ?>
                                        <option value="<?= $fornecedor['id_fornecedor'] ?>"><?= htmlspecialchars($fornecedor['nome_fornecedor']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="quantidade" class="form-label">Estoque Atual</label>
                                <input type="number" class="form-control" id="quantidade" name="quantidade" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantidade_minima" class="form-label">Estoque Mínimo</label>
                                <input type="number" class="form-control" id="quantidade_minima" name="quantidade_minima" min="0" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnSalvarPeca">Salvar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Gráfico de distribuição de categorias
        const ctxCategorias = document.getElementById('graficoCategorias').getContext('2d');
    new Chart(ctxCategorias, {
        type: 'doughnut',
        data: {
            labels: ['Hardware', 'Periféricos', 'Cabos', 'Outros'],
            datasets: [{
                data: [
                    <?= $categorias['hardware'] ?>,
                    <?= $categorias['perifericos'] ?>,
                    <?= $categorias['cabos'] ?>,
                    <?= $categorias['outros'] ?>
                ],
                backgroundColor: ['#0d6efd', '#6f42c1', '#20c997', '#fd7e14']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

        // Funções para integração futura com PHP
       function editarPeca(id, nome, tipo, id_fornecedor, qtde, qtde_minima) {
    document.getElementById('modalAdicionarPeca').querySelector('.modal-title').textContent = 'Editar Peça';
    document.querySelector('#formPeca input[name="id_peca_est"]').value = id;
    document.querySelector('#formPeca input[name="nome_peca"]').value = nome;
    document.querySelector('#formPeca select[name="tipo"]').value = '';
    document.querySelector('#formPeca select[name="id_fornecedor"]').value = '';
    document.querySelector('#formPeca input[name="quantidade"]').value = qtde;
    document.querySelector('#formPeca input[name="quantidade_minima"]').value = qtde_minima;
    const modal = new bootstrap.Modal(document.getElementById('modalAdicionarPeca'));
    modal.show();
}
        
        // Event listeners para filtros
        document.getElementById('btnPesquisarPecas').addEventListener('click', function() {
            const termo = document.getElementById('pesquisaPecas').value;
            console.log('Pesquisando peças por:', termo);
        });
        
        
        // Outros event listeners para filtros
        
        
        // Event listener para salvar peça
        document.getElementById('btnSalvarPeca').addEventListener('click', function() {
            const nome = document.getElementById('nomePeca').value;
            const categoria = document.getElementById('categoriaPeca').value;
            const peca$peca_estoque = document.getElementById('peca$peca_estoquePeca').value;
            const estoqueAtual = document.getElementById('estoqueAtual').value;
            const estoqueMinimo = document.getElementById('estoqueMinimo').value;
            
            console.log('Salvando peça:', { nome, categoria, peca$peca_estoque, estoqueAtual, estoqueMinimo });
            
            // Futuramente: enviar dados para backend PHP
            // Após sucesso, fechar o modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAdicionarPeca'));
            modal.hide();
        });
    </script>
</body>
</php>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Alternar exibição do menu
        document.getElementById("menu-toggle").addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("d-none");
        });

        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('pt-BR');
            document.getElementById('liveClock').textContent = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock(); // Inicializa imediatamente
    </script>

</body>
</html>
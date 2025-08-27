<?php
    session_start();
    require_once 'conexao.php';

    // VERIFICA SE O USUARIO TEM PERMISSÃO DE ADM OU SECRETARIA
    if($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3){
        echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
        exit();
    } 

    // INICIALIZA VARIÁVEIS
    $filtro_status = '';
    $filtro_ramo = '';
    $busca = '';
    $fornecedores = [];

    // VERIFICA SE HÁ FILTRO POR STATUS (GET)
    if(isset($_GET['status']) && !empty($_GET['status'])) {
        $filtro_status = $_GET['status'];
    }

    // VERIFICA SE HÁ FILTRO POR RAMO (GET)
    if(isset($_GET['ramo']) && !empty($_GET['ramo'])) {
        $filtro_ramo = $_GET['ramo'];
    }

    // VERIFICA SE HÁ BUSCA POR TEXTO (GET)
    if(isset($_GET['busca']) && !empty($_GET['busca'])){
        $busca = trim($_GET['busca']);
    }

    // CONSTRUIR A QUERY BASE
    $sql = "SELECT * FROM fornecedor";
    $where_conditions = [];
    $params = [];

    // ADICIONAR FILTRO POR STATUS SE EXISTIR
    if(!empty($filtro_status)) {
        $where_conditions[] = "status = :status";
        $params[':status'] = $filtro_status;
    }

    // ADICIONAR FILTRO POR RAMO SE EXISTIR
    if(!empty($filtro_ramo)) {
        $where_conditions[] = "ramo_atividade = :ramo";
        $params[':ramo'] = $filtro_ramo;
    }

    // ADICIONAR FILTRO POR BUSCA SE EXISTIR
    if(!empty($busca)) {
        if(is_numeric($busca)){
            $where_conditions[] = "id_fornecedor = :busca";
            $params[':busca'] = $busca;
        } else {
            $where_conditions[] = "(nome_fornecedor LIKE :busca_nome OR cpf_cnpj LIKE :busca_cpf)";
            $params[':busca_nome'] = "%$busca%";
            $params[':busca_cpf'] = "%$busca%";
        }
    }

    // COMBINAR CONDITIONS SE HOUVER
    if (!empty($where_conditions)) {
        $sql .= " WHERE " . implode(" AND ", $where_conditions);
    }

    $sql .= " ORDER BY nome_fornecedor ASC";

    // PREPARAR E EXECUTAR A QUERY
    $stmt = $pdo->prepare($sql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    $fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    // ALTERAR STATUS FORNECEDOR //
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id_fornecedor = $_GET['id'];
        
        // Verificar se está alterando status
        if(isset($_GET['status'])) {
            $novo_status = $_GET['status'];
            
            $sql = "UPDATE fornecedor SET status = :status WHERE id_fornecedor = :id";
            $mensagem = 'Status do fornecedor alterado com sucesso!';
        
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':status', $novo_status);
            $stmt->bindParam(':id', $id_fornecedor, PDO::PARAM_INT);

            if($stmt->execute()){
                echo "<script>alert('$mensagem');window.location.href='gestao_fornecedor.php';</script>";
            } else{
                echo "<script>alert('Erro ao alterar status do fornecedor!');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro - Lego Mania</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex vh-100 bg-light">
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-dark text-white p-3" style="width: 250px;">
            <h4 class="mb-4">Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="principal.php" class="nav-link text-white"><i class="bi bi-house-door me-2"></i> Início</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="perfil.php" class="nav-link text-white"><i class="bi bi-person me-2"></i> Perfil</a>
                </li>
                <li class="nav-item mb-2 dropdown">
                    <a class="nav-link text-white dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-plus me-2"></i> Cadastro 
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="cadastroDropdown">
                        <li><a class="dropdown-item" href="cadastro_usuario.php">Usuario</a></li>
                        <li><a class="dropdown-item" href="cadastro_cliente.php">Cliente</a></li>
                        <li><a class="dropdown-item" href="cadastro_funcionario.php">Funcionário</a></li>
                        <li><a class="dropdown-item" href="cadastro_fornecedor.php">Fornecedor</a></li>
                        <li><a class="dropdown-item" href="cadastro_pecas.php">Peças no estoque</a></li>
                    </ul>
                </li>
                <li class="nav-item mb-2 dropdown">
                    <a class="nav-link text-white dropdown-toggle" href="#" id="gestaoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-people me-2"></i> Gestão de Pessoas
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="gestaoDropdown">
                        <li><a class="dropdown-item" href="gestao_usuario.php">Usuarios</a></li>
                        <li><a class="dropdown-item" href="gestao_cliente.php">Clientes</a></li>
                        <li><a class="dropdown-item" href="gestao_funcionario.php">Funcionários</a></li>
                        <li><a class="dropdown-item" href="gestao_fornecedor.php">Fornecedores</a></li>
                    </ul>
                </li>
                <li class="nav-item mb-2 dropdown">
                    <a class="nav-link text-white dropdown-toggle" href="#" id="ordemDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-tools me-2"></i> Ordem de Serviços 
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="ordemDropdown">
                        <li><a class="dropdown-item" href="nova_ordem.php">Nova O.S</a></li>
                        <li><a class="dropdown-item" href="consultar_ordem.php">Consultar</a></li>
                        <li><a class="dropdown-item" href="pagamento.php">Pagamento</a></li>
                    </ul>
                </li>
                <li class="nav-item mb-2 dropdown">
                    <a class="nav-link text-white dropdown-toggle" href="#" id="financiasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-graph-up me-2"></i> Relatório de Financias
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="financiasDropdown">
                        <li><a class="dropdown-item" href="relatorio_despesas.php">Despesas</a></li>
                        <li><a class="dropdown-item" href="relatorio_lucro.php">Ganho Bruto</a></li>
                    </ul>
                </li>
                <li class="nav-item mb-2 dropdown">
                    <a class="nav-link text-white dropdown-toggle" href="#" id="estoqueDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-boxes me-2"></i> Relatório de Estoque
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="estoqueDropdown">
                        <li><a class="dropdown-item" href="relatorio_saida.php">Saída de Peças</a></li>
                        <li><a class="dropdown-item" href="relatorio_pecas_estoque.php">Peças no Estoque</a></li>
                        <li><a class="dropdown-item" href="relatorio_uso.php">Relatório de Uso</a></li>
                    </ul>
                </li>
                <li class="nav-item mb-2">
                    <a href="logs.php" class="nav-link text-white">
                        <i class="bi bi-clock-history me-2"></i> Logs
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-white"><i class="bi bi-box-arrow-right me-2"></i> Sair</a>
                </li>
            </ul>
        </nav>

        <!-- Conteúdo principal -->
        <div class="flex-grow-1 d-flex flex-column">
            <!-- Header -->
            <nav class="navbar navbar-light bg-white shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-dark" id="menu-toggle"><i class="bi bi-list"></i></button>
                    <span class="navbar-brand mb-0 h1">
                        <small class="text-muted">Horário atual:</small>
                        <span id="liveClock" class="badge bg-secondary"></span>
                    </span>
                </div>
            </nav>

            <!-- Conteúdo - Formulário -->
            <div class="flex-grow-1 p-3" style="overflow-y: auto;">
                <div class="container-fluid">
                    <!-- Cabeçalho com título and botão de novo fornecedor -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-truck me-2"></i>Gestão de Fornecedores</h5>
                        <a href="cadastro_fornecedor.php" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Novo Fornecedor
                        </a>
                    </div>
                    
                    <!-- Barra de pesquisa e filtros -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body py-2">
                            <form method="GET" action="gestao_fornecedor.php" id="filterForm">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" id="busca" name="busca" class="form-control" 
                                                placeholder="Pesquisar por ID, nome ou CPF/CNPJ..." 
                                                value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>">
                                            <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status" id="status" class="form-select form-select-sm">
                                            <option value="">Todos os status</option>
                                            <option value="Ativo" <?= (isset($_GET['status']) && $_GET['status'] == 'Ativo') ? 'selected' : '' ?>>Ativo</option>
                                            <option value="Inativo" <?= (isset($_GET['status']) && $_GET['status'] == 'Inativo') ? 'selected' : '' ?>>Inativo</option>
                                            <option value="Pendente" <?= (isset($_GET['status']) && $_GET['status'] == 'Pendente') ? 'selected' : '' ?>>Pendente</option>
                                            <option value="Bloqueado" <?= (isset($_GET['status']) && $_GET['status'] == 'Bloqueado') ? 'selected' : '' ?>>Bloqueado</option>
                                            <option value="Suspenso" <?= (isset($_GET['status']) && $_GET['status'] == 'Suspenso') ? 'selected' : '' ?>>Suspenso</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="ramo" id="ramo" class="form-select form-select-sm">
                                            <option value="">Todos os ramos</option>
                                            <option value="Eletrônicos" <?= (isset($_GET['ramo']) && $_GET['ramo'] == 'Eletrônicos') ? 'selected' : '' ?>>Eletrônicos</option>
                                            <option value="Peças Mecânicas" <?= (isset($_GET['ramo']) && $_GET['ramo'] == 'Peças Mecânicas') ? 'selected' : '' ?>>Peças Mecânicas</option>
                                            <option value="Plásticos" <?= (isset($_GET['ramo']) && $_GET['ramo'] == 'Plásticos') ? 'selected' : '' ?>>Plásticos</option>
                                            <option value="Metais" <?= (isset($_GET['ramo']) && $_GET['ramo'] == 'Metais') ? 'selected' : '' ?>>Metais</option>
                                            <option value="Embalagens" <?= (isset($_GET['ramo']) && $_GET['ramo'] == 'Embalagens') ? 'selected' : '' ?>>Embalagens</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <?php if(isset($_GET['busca']) || isset($_GET['status']) || isset($_GET['ramo'])): ?>
                                            <a href="gestao_fornecedor.php" class="btn btn-outline-danger btn-sm">Limpar Filtros</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Tabela de Fornecedores -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <?php if(!empty($fornecedores)): ?>
                                    <table class="table table-striped table-hover table-bordered mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th><center>ID</center></th>
                                                <th><center>Fornecedor</center></th>
                                                <th><center>CPF/CNPJ</center></th>
                                                <th><center>Ramo</center></th>
                                                <th><center>Contato</center></th>
                                                <th><center>Status</center></th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($fornecedores as $fornecedor): ?>
                                                <tr>
                                                    <td><center><?=htmlspecialchars($fornecedor['id_fornecedor'])?></center></td>
                                                    <td><center><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></center></td>
                                                    <td><center><?=htmlspecialchars($fornecedor['cpf_cnpj'])?></center></td>
                                                    <td><center><?=htmlspecialchars($fornecedor['ramo_atividade'])?></center></td>
                                                    <td><center><?=htmlspecialchars($fornecedor['telefone'])?></center></td>
                                                    <td>
                                                        <center>
                                                            <?php 
                                                            $badge_class = '';
                                                            switch($fornecedor['status']) {
                                                                case 'Ativo': $badge_class = 'bg-success'; break;
                                                                case 'Inativo': $badge_class = 'bg-danger'; break;
                                                                case 'Pendente': $badge_class = 'bg-warning text-dark'; break;
                                                                case 'Bloqueado': $badge_class = 'bg-secondary'; break;
                                                                case 'Suspenso': $badge_class = 'bg-info'; break;
                                                                default: $badge_class = 'bg-secondary';
                                                            }
                                                            ?>
                                                            <span class="badge <?=$badge_class?>"><?=$fornecedor['status']?></span>
                                                        </center> 
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm btn-primary me-1" onclick="carregarDadosFornecedor(<?=htmlspecialchars($fornecedor['id_fornecedor'])?>)">Alterar</a> 
                                                        
                                                        <button type="button" class="btn btn-sm <?= $badge_class ?>" onclick="abrirModalStatus(<?=htmlspecialchars($fornecedor['id_fornecedor'])?>, '<?=$fornecedor['status']?>', '<?=htmlspecialchars($fornecedor['nome_fornecedor'])?>')">
                                                            <i class="bi bi-gear-fill me-1"></i> Status
                                                        </button>
                                                        
                                                        <button class="btn btn-sm btn-info" onclick="mostrarDetalhesFornecedor(<?=htmlspecialchars($fornecedor['id_fornecedor'])?>)">
                                                            <i class="bi bi-info-circle"></i> Detalhes
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                <?php else: ?><br>
                                    <center><p>Nenhum fornecedor encontrado.</p></center>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Mostrando <?= count($fornecedores) ?> de <?= count($fornecedores) ?> fornecedores</span>
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

            <!-- Modal para Alterar Fornecedor -->
            <div class="modal fade" id="modalFornecedor" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Alterar Fornecedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="alterar_fornecedor.php">
                            <div class="modal-body">
                                <input type="hidden" id="id_fornecedor" name="id_fornecedor">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nome_fornecedor" class="form-label">Nome do Fornecedor</label>
                                            <input type="text" class="form-control" id="nome_fornecedor" name="nome_fornecedor" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
                                            <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ramo_atividade" class="form-label">Ramo de Atividade</label>
                                            <input type="text" class="form-control" id="ramo_atividade" name="ramo_atividade">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telefone" class="form-label">Telefone</label>
                                            <input type="text" class="form-control" id="telefone" name="telefone">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="endereco" class="form-label">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco">
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="bairro" class="form-label">Bairro</label>
                                            <input type="text" class="form-control" id="bairro" name="bairro">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="cidade" class="form-label">Cidade</label>
                                            <input type="text" class="form-control" id="cidade" name="cidade">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="estado" class="form-label">Estado</label>
                                            <input type="text" class="form-control" id="estado" name="estado">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="cep" class="form-label">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" name="alterar_fornecedor" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal para Detalhes do Fornecedor -->
            <div class="modal fade" id="modalDetalhes" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalhes do Fornecedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="detalhesFornecedor">
                            <!-- Conteúdo será preenchido via JavaScript -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para Alterar Status -->
            <div class="modal fade" id="modalStatus" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Alterar Status do Fornecedor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Alterar status de: <strong id="nomeFornecedorStatus"></strong></p>
                            <p>Status atual: <span id="statusAtual" class="badge"></span></p>
                            
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Ativo')">
                                    <div>
                                        <span class="badge bg-success me-2"><i class="bi bi-check-circle"></i></span>
                                        Ativo
                                    </div>
                                    <small class="text-muted">Fornecedor ativo e operando</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Inativo')">
                                    <div>
                                        <span class="badge bg-danger me-2"><i class="bi bi-x-circle"></i></span>
                                        Inativo
                                    </div>
                                    <small class="text-muted">Fornecedor inoperante</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Pendente')">
                                    <div>
                                        <span class="badge bg-warning me-2"><i class="bi bi-clock"></i></span>
                                        Pendente
                                    </div>
                                    <small class="text-muted">Aguardando aprovação/documentação</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Bloqueado')">
                                    <div>
                                        <span class="badge bg-secondary me-2"><i class="bi bi-lock"></i></span>
                                        Bloqueado
                                    </div>
                                    <small class="text-muted">Fornecedor temporariamente bloqueado</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Suspenso')">
                                    <div>
                                        <span class="badge bg-info me-2"><i class="bi bi-pause-circle"></i></span>
                                        Suspenso
                                    </div>
                                    <small class="text-muted">Fornecedor suspenso por problemas</small>
                                </a>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="confirmarStatus">Confirmar Alteração</button>
                        </div>
                    </div>
                </div>
            </div>

    <!-- SCRIPTS -->
                                    
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

        // Função para carregar dados do fornecedor no modal
        function carregarDadosFornecedor(id) {
            fetch('buscar_fornecedor.php?id=' + id)
                .then(response => response.json())
                .then(fornecedor => {
                    document.getElementById('id_fornecedor').value = fornecedor.id_fornecedor;
                    document.getElementById('nome_fornecedor').value = fornecedor.nome_fornecedor;
                    document.getElementById('cpf_cnpj').value = fornecedor.cpf_cnpj;
                    document.getElementById('ramo_atividade').value = fornecedor.ramo_atividade || '';
                    document.getElementById('telefone').value = fornecedor.telefone || '';
                    document.getElementById('email').value = fornecedor.email || '';
                    document.getElementById('endereco').value = fornecedor.endereco || '';
                    document.getElementById('bairro').value = fornecedor.bairro || '';
                    document.getElementById('cidade').value = fornecedor.cidade || '';
                    document.getElementById('estado').value = fornecedor.estado || '';
                    document.getElementById('cep').value = fornecedor.cep || '';
                    
                    // Abre o modal
                    var modal = new bootstrap.Modal(document.getElementById('modalFornecedor'));
                    modal.show();
                })
                .catch(error => console.error('Erro:', error));
        }

        // Submeter formulário quando os filtros forem alterados
        document.getElementById('status').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
        
        document.getElementById('ramo').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Função para mostrar detalhes do fornecedor
        function mostrarDetalhesFornecedor(id) {
            fetch('buscar_fornecedor.php?id=' + id)
                .then(response => response.json())
                .then(fornecedor => {
                    let detalhesHTML = `
                        <div class="mb-3">
                            <strong>ID:</strong> ${fornecedor.id_fornecedor}
                        </div>
                        <div class="mb-3">
                            <strong>Nome:</strong> ${fornecedor.nome_fornecedor}
                        </div>
                        <div class="mb-3">
                            <strong>CPF/CNPJ:</strong> ${fornecedor.cpf_cnpj}
                        </div>
                        <div class="mb-3">
                            <strong>Ramo:</strong> ${fornecedor.ramo_atividade || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Telefone:</strong> ${fornecedor.telefone || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>E-mail:</strong> ${fornecedor.email || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Endereço:</strong> ${fornecedor.endereco || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Bairro:</strong> ${fornecedor.bairro || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Cidade:</strong> ${fornecedor.cidade || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Estado:</strong> ${fornecedor.estado || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>CEP:</strong> ${fornecedor.cep || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Status:</strong> 
                    `;
                    
                    // Adiciona badge de status
                    let badge_class = '';
                    switch(fornecedor.status) {
                        case 'Ativo': badge_class = 'bg-success'; break;
                        case 'Inativo': badge_class = 'bg-danger'; break;
                        case 'Pendente': badge_class = 'bg-warning text-dark'; break;
                        case 'Bloqueado': badge_class = 'bg-secondary'; break;
                        case 'Suspenso': badge_class = 'bg-info'; break;
                        default: badge_class = 'bg-secondary';
                    }
                    
                    detalhesHTML += `<span class="badge ${badge_class}">${fornecedor.status || 'Não definido'}</span></div>`;
                    
                    document.getElementById('detalhesFornecedor').innerHTML = detalhesHTML;
                    
                    // Abre o modal
                    var modal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
                    modal.show();
                })
                .catch(error => {
                    alert('Erro ao carregar dados do fornecedor');
                    console.error('Erro:', error);
                });
        }
        
        // Variáveis globais para controle do status
        let fornecedorIdStatus = null;
        let novoStatusSelecionado = null;

        // Função para abrir o modal de status
        function abrirModalStatus(id, statusAtual, nomeFornecedor) {
            fornecedorIdStatus = id;
            novoStatusSelecionado = statusAtual;
            
            // Atualizar informações no modal
            document.getElementById('nomeFornecedorStatus').textContent = nomeFornecedor;
            
            // Atualizar badge do status atual
            const statusAtualEl = document.getElementById('statusAtual');
            let badgeClass = '';
            switch(statusAtual) {
                case 'Ativo': badgeClass = 'bg-success'; break;
                case 'Inativo': badgeClass = 'bg-danger'; break;
                case 'Pendente': badgeClass = 'bg-warning'; break;
                case 'Bloqueado': badgeClass = 'bg-secondary'; break;
                case 'Suspenso': badgeClass = 'bg-info'; break;
                default: badgeClass = 'bg-secondary';
            }
            statusAtualEl.className = `badge ${badgeClass}`;
            statusAtualEl.textContent = statusAtual;
            
            // Destacar visualmente o status atual
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
                if (item.textContent.includes(statusAtual)) {
                    item.classList.add('active');
                }
            });
            
            // Abrir o modal
            var modal = new bootstrap.Modal(document.getElementById('modalStatus'));
            modal.show();
        }

        // Função para selecionar um status
        function selecionarStatus(status) {
            novoStatusSelecionado = status;
            
            // Destacar visualmente o item selecionado
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
                if (item.textContent.includes(status)) {
                    item.classList.add('active');
                }
            });
        }

        // Configurar o botão de confirmação
        document.getElementById('confirmarStatus').addEventListener('click', function() {
            if (novoStatusSelecionado && fornecedorIdStatus) {
                if (confirm(`Tem certeza que deseja alterar o status para ${novoStatusSelecionado}?`)) {
                    window.location.href = `gestao_fornecedor.php?id=${fornecedorIdStatus}&status=${novoStatusSelecionado}`;
                }
            }
        });
    </script>
</body>
</html>
<?php
session_start();
require_once 'conexao.php';

// VERIFICA SE O USUARIO ESTÁ LOGADO
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso Negado! Faça login primeiro.'); window.location.href='index.php';</script>";
    exit();
}

if (!isset($_SESSION['ordens_ocultas'])) {
    $_SESSION['ordens_ocultas'] = [];
}

// INICIALIZA VARIÁVEIS
$busca = '';
$ordens = [];

// VERIFICA SE HÁ BUSCA POR TEXTO (GET)
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $busca = trim($_GET['busca']);
}

// CONSTRUIR A QUERY BASE
$sql = "SELECT no.id_ordem, 
               no.nome_client_ordem, 
               no.tecnico, 
               no.problema, 
               no.dt_recebimento, 
               no.valor_total,
               no.marca_aparelho,
               no.prioridade,
               no.observacao,
               c.nome_cliente 
        FROM nova_ordem no
        LEFT JOIN cliente c ON no.id_cliente = c.id_cliente
        LEFT JOIN funcionario f ON no.id_funcionario = f.id_funcionario";

$where_conditions = [];
$params = [];

// ADICIONAR FILTRO POR BUSCA SE EXISTIR
if (!empty($busca)) {
    if (is_numeric($busca)) {
        $where_conditions[] = "no.id_ordem = :busca";
        $params[':busca'] = $busca;
    } else {
        $where_conditions[] = "(c.nome_cliente LIKE :busca_nome OR no.nome_client_ordem LIKE :busca_nome)";
        $params[':busca_nome'] = "%$busca%";
    }
}

// COMBINAR CONDITIONS SE HOUVER
if (!empty($where_conditions)) {
    $sql .= " WHERE " . implode(" AND ", $where_conditions);
}

$sql .= " ORDER BY no.id_ordem DESC";

// PREPARAR E EXECUTAR A QUERY
$stmt = $pdo->prepare($sql);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->execute();
$ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);

$filtro_oculto = isset($_GET['filtro_oculto']) ? $_GET['filtro_oculto'] : '0';

if ($filtro_oculto == '0') {
    // Mostrar apenas não ocultas
    $ordens = array_filter($ordens, function($ordem) {
        return !in_array($ordem['id_ordem'], $_SESSION['ordens_ocultas']);
    });
} else {
    // Mostrar apenas ocultas
    $ordens = array_filter($ordens, function($ordem) {
        return in_array($ordem['id_ordem'], $_SESSION['ordens_ocultas']);
    });
}

// Processar ações (excluir, ocultar)
if (isset($_GET['acao']) && isset($_GET['id'])) {
    $id_ordem = $_GET['id'];
    
    if ($_GET['acao'] == 'excluir') {
        // Excluir ordem
        $sql_excluir = "DELETE FROM nova_ordem WHERE id_ordem = :id";
        $stmt_excluir = $pdo->prepare($sql_excluir);
        $stmt_excluir->bindParam(':id', $id_ordem, PDO::PARAM_INT);
        
        if ($stmt_excluir->execute()) {
            echo "<script>alert('Ordem excluída com sucesso!'); window.location.href='consultar_ordem.php';</script>";
        } else {
            echo "<script>alert('Erro ao excluir ordem!');</script>";
        }
    }

    if ($_GET['acao'] == 'ocultar') {
        if (!in_array($id_ordem, $_SESSION['ordens_ocultas'])) {
            $_SESSION['ordens_ocultas'][] = $id_ordem;
        }
        echo "<script>alert('Ordem ocultada!'); window.location.href='consultar_ordem.php';</script>";
    }
    
    if ($_GET['acao'] == 'mostrar') {
        if (($key = array_search($id_ordem, $_SESSION['ordens_ocultas'])) !== false) {
            unset($_SESSION['ordens_ocultas'][$key]);
        }
        echo "<script>alert('Ordem reativada!'); window.location.href='consultar_ordem.php?filtro_oculto=1';</script>";
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
        <!-- Sidebar (mantida igual) -->
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
                    <!-- Cabeçalho com título and botão de nova solicitação -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Solicitações de Serviço</h5>
                        <a href="nova_ordem.php" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Nova Solicitação
                        </a>
                    </div>
                    
                    <!-- Barra de pesquisa e filtros -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body py-2">
                            <form method="GET" action="consultar_ordem.php" id="filterForm">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" id="busca" name="busca" class="form-control" 
                                                placeholder="Pesquisar por ID ou nome do cliente..." 
                                                value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>">
                                            <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select form-select-sm">
                                            <option selected>Ordenar por data</option>
                                            <option>Mais recentes</option>
                                            <option>Mais antigos</option>
                                            <option>Menor valor</option>
                                            <option>Maior valor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="filtro_oculto" id="filtro_oculto" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit();">
                                            <option value="0" <?= (isset($_GET['filtro_oculto']) && $_GET['filtro_oculto'] == '0') ? 'selected' : '' ?>>Ordens visíveis</option>
                                            <option value="1" <?= (isset($_GET['filtro_oculto']) && $_GET['filtro_oculto'] == '1') ? 'selected' : '' ?>>Ordens ocultas</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Tabela de solicitações -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <?php if(!empty($ordens)): ?>
                                    <table class="table table-hover table-striped mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Técnico</th>
                                                <th scope="col">Problema</th>
                                                <th scope="col">Data</th>
                                                <th scope="col">Valor (R$)</th>
                                                <th scope="col" class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($ordens as $ordem): ?>
                                                <tr>
                                                    <th scope="row"><?= htmlspecialchars($ordem['id_ordem']) ?></th>
                                                    <td><?= htmlspecialchars($ordem['nome_cliente'] ? $ordem['nome_cliente'] : $ordem['nome_client_ordem']) ?></td>
                                                    <td><?= htmlspecialchars($ordem['tecnico']) ?></td>
                                                    <td><?= htmlspecialchars(substr($ordem['problema'], 0, 30)) ?>...</td>
                                                    <td><?= htmlspecialchars($ordem['dt_recebimento']) ?></td>
                                                    <td>R$ <?= number_format($ordem['valor_total'], 2, ',', '.') ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary me-1" title="Alterar" onclick="carregarDadosOrdem(<?= htmlspecialchars($ordem['id_ordem']) ?>)">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <a href="consultar_ordem.php?acao=excluir&id=<?= htmlspecialchars($ordem['id_ordem']) ?>" 
                                                            class="btn btn-sm btn-outline-danger me-1" title="Excluir" 
                                                            onclick="return confirm('Tem certeza que deseja excluir esta ordem?')">
                                                                <i class="bi bi-trash"></i>
                                                        </a>

                                                        <?php if ($filtro_oculto == '0'): ?>
                                                            <a href="consultar_ordem.php?acao=ocultar&id=<?= htmlspecialchars($ordem['id_ordem']) ?>" 
                                                                class="btn btn-sm btn-outline-secondary" title="Ocultar" 
                                                                onclick="return confirm('Deseja ocultar esta ordem?')">
                                                                    <i class="bi bi-eye-slash"></i>
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="consultar_ordem.php?acao=mostrar&id=<?= htmlspecialchars($ordem['id_ordem']) ?>" 
                                                                class="btn btn-sm btn-outline-success" title="Reativar" 
                                                                onclick="return confirm('Deseja tornar esta ordem visível novamente?')">
                                                                    <i class="bi bi-eye"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <div class="p-3 text-center">
                                        <p>Nenhuma ordem de serviço encontrada.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Mostrando <?= count($ordens) ?> de <?= count($ordens) ?> registros</span>
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

            <!-- Modal para Alterar Ordem -->
            <div class="modal fade" id="modalOrdem" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Alterar Ordem de Serviço</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="alterar_ordem.php">
                            <div class="modal-body">
                                <input type="hidden" id="id_ordem" name="id_ordem">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nome_cliente" class="form-label">Nome do Cliente</label>
                                            <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tecnico" class="form-label">Técnico</label>
                                            <input type="text" class="form-control" id="tecnico" name="tecnico">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="marca_aparelho" class="form-label">Marca do Aparelho</label>
                                            <input type="text" class="form-control" id="marca_aparelho" name="marca_aparelho">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="prioridade" class="form-label">Prioridade</label>
                                            <select class="form-select" id="prioridade" name="prioridade">
                                                <option value="Baixa">Baixa</option>
                                                <option value="Média">Média</option>
                                                <option value="Alta">Alta</option>
                                                <option value="Urgente">Urgente</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="problema" class="form-label">Problema Relatado</label>
                                    <textarea class="form-control" id="problema" name="problema" rows="3"></textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dt_recebimento" class="form-label">Data de Recebimento</label>
                                            <input type="date" class="form-control" id="dt_recebimento" name="dt_recebimento">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="valor_total" class="form-label">Valor Total (R$)</label>
                                            <input type="number" step="0.01" class="form-control" id="valor_total" name="valor_total">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="observacao" class="form-label">Observações</label>
                                    <textarea class="form-control" id="observacao" name="observacao" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" name="alterar_ordem" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal para Detalhes da Ordem -->
            <div class="modal fade" id="modalDetalhes" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalhes da Ordem de Serviço</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="detalhesOrdem">
                            <!-- Conteúdo será preenchido via JavaScript -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

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

        // Função para carregar dados da ordem no modal
        function carregarDadosOrdem(id) {
            // Em uma implementação real, você faria uma requisição AJAX para buscar os dados
            // Aqui estou simulando com dados estáticos para demonstração
            const ordem = {
                id_ordem: id,
                nome_cliente: "Cliente " + id,
                tecnico: "Técnico " + id,
                marca_aparelho: "Marca " + id,
                prioridade: "Média",
                problema: "Problema descritivo da ordem " + id,
                dt_recebimento: "2023-03-15",
                valor_total: "120.00",
                observacao: "Observações sobre a ordem " + id
            };
            
            document.getElementById('id_ordem').value = ordem.id_ordem;
            document.getElementById('nome_cliente').value = ordem.nome_cliente;
            document.getElementById('tecnico').value = ordem.tecnico;
            document.getElementById('marca_aparelho').value = ordem.marca_aparelho;
            document.getElementById('prioridade').value = ordem.prioridade;
            document.getElementById('problema').value = ordem.problema;
            document.getElementById('dt_recebimento').value = ordem.dt_recebimento;
            document.getElementById('valor_total').value = ordem.valor_total;
            document.getElementById('observacao').value = ordem.observacao;
            
            // Abre o modal
            var modal = new bootstrap.Modal(document.getElementById('modalOrdem'));
            modal.show();
        }

        // Função para alternar visibilidade da ordem
        function alternarVisibilidadeOrdem(id) {
            if (confirm('Deseja alternar a visibilidade desta ordem?')) {
                // Em uma implementação real, você faria uma requisição AJAX
                alert('Visibilidade da ordem ' + id + ' alterada com sucesso!');
            }
        }

        // Função para mostrar detalhes da ordem
        function mostrarDetalhesOrdem(id) {
            // Em uma implementação real, você faria uma requisição AJAX
            const detalhesHTML = `
                <div class="mb-3">
                    <strong>ID:</strong> ${id}
                </div>
                <div class="mb-3">
                    <strong>Cliente:</strong> Cliente ${id}
                </div>
                <div class="mb-3">
                    <strong>Técnico:</strong> Técnico ${id}
                </div>
                <div class="mb-3">
                    <strong>Problema:</strong> Descrição detalhada do problema da ordem ${id}
                </div>
                <div class="mb-3">
                    <strong>Data de Recebimento:</strong> 15/03/2023
                </div>
                <div class="mb-3">
                    <strong>Valor:</strong> R$ 120,00
                </div>
            `;
            
            document.getElementById('detalhesOrdem').innerHTML = detalhesHTML;
            
            // Abre o modal
            var modal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
            modal.show();
        }
    </script>
</body>
</html>
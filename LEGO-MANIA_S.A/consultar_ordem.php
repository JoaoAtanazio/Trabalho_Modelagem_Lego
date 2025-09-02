<?php
    session_start();
    require_once 'conexao.php';
    require_once 'php/permissoes.php';

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

    // CONSTRUIR A QUERY BASE - CORRIGIDA PARA MOSTRAR NOME DO TÉCNICO
    $sql = "SELECT no.id_ordem, 
                   no.nome_client_ordem,
                   u.nome_usuario AS nome_tecnico,  
                   no.problema, 
                   no.dt_recebimento, 
                   no.valor_total,
                   no.marca_aparelho,
                   no.prioridade,
                   no.observacao,
                   no.status_ordem AS statuss,
                   c.nome_cliente,
                   no.id_cliente,
                   f.nome_funcionario
            FROM nova_ordem no
            LEFT JOIN cliente c ON no.id_cliente = c.id_cliente
            LEFT JOIN funcionario f ON no.id_funcionario = f.id_funcionario
            LEFT JOIN usuario u ON no.tecnico = u.id_usuario";

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
        $ordens = array_filter($ordens, function($ordem) {
            return !in_array($ordem['id_ordem'], $_SESSION['ordens_ocultas']);
        });
    } else {
        $ordens = array_filter($ordens, function($ordem) {
            return in_array($ordem['id_ordem'], $_SESSION['ordens_ocultas']);
        });
    }

    // ALTERAR STATUS ORDEM //
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id_ordem = $_GET['id'];
        
        if(isset($_GET['statuss'])) {
            $novo_status = $_GET['statuss'];
            
            $sql = "UPDATE nova_ordem SET status_ordem = :statuss WHERE id_ordem = :id";
            $mensagem = 'Status da ordem alterado com sucesso!';
        
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':statuss', $novo_status);
            $stmt->bindParam(':id', $id_ordem, PDO::PARAM_INT);

            if($stmt->execute()){
                echo "<script>alert('$mensagem');window.location.href='consultar_ordem.php';</script>";
            } else{
                echo "<script>alert('Erro ao alterar status da ordem!');</script>";
            }
        }
    }

    // Processar ações (excluir, ocultar, mostrar)
    if (isset($_GET['acao']) && isset($_GET['id'])) {
        $id_ordem = $_GET['id'];
        
        if ($_GET['acao'] == 'excluir') {
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

    // Buscar dados de uma ordem específica (AJAX)
    if (isset($_GET['carregar_ordem']) && isset($_GET['id_ordem'])) {
        $id_ordem = $_GET['id_ordem'];
        
        $sql_ordem = "SELECT no.*, c.nome_cliente, u.nome_usuario as nome_tecnico 
                      FROM nova_ordem no 
                      LEFT JOIN cliente c ON no.id_cliente = c.id_cliente 
                      LEFT JOIN usuario u ON no.tecnico = u.id_usuario
                      WHERE no.id_ordem = :id_ordem";
        
        $stmt_ordem = $pdo->prepare($sql_ordem);
        $stmt_ordem->bindParam(':id_ordem', $id_ordem, PDO::PARAM_INT);
        $stmt_ordem->execute();
        
        $ordem = $stmt_ordem->fetch(PDO::FETCH_ASSOC);
        
        if ($ordem) {
            header('Content-Type: application/json');
            echo json_encode($ordem);
            exit();
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Ordem não encontrada']);
            exit();
        }
    }

    // Buscar técnicos
    $sql_tecnicos = "SELECT id_usuario, nome_usuario FROM usuario WHERE id_perfil = 4 AND status = 'ativo' ORDER BY nome_usuario";
    $stmt_tecnicos = $pdo->query($sql_tecnicos);
    $tecnicos = $stmt_tecnicos->fetchAll(PDO::FETCH_ASSOC);
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
         <?php exibirMenu(); ?>

        <!-- Conteúdo principal -->
        <div class="flex-grow-1 d-flex flex-column">
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
                                    <div class="col-md-4">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" id="busca" name="busca" class="form-control" 
                                                placeholder="Pesquisar por ID ou nome do cliente..." 
                                                value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>">
                                            <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="filtro_oculto" id="filtro_oculto" class="form-select form-select-sm">
                                            <option value="0" <?= (isset($_GET['filtro_oculto']) && $_GET['filtro_oculto'] == '0') ? 'selected' : '' ?>>Ordens visíveis</option>
                                            <option value="1" <?= (isset($_GET['filtro_oculto']) && $_GET['filtro_oculto'] == '1') ? 'selected' : '' ?>>Ordens ocultas</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="statuss" id="statuss" class="form-select form-select-sm">
                                            <option value="">Todos os status</option>
                                            <option value="Aberta" <?= (isset($_GET['statuss']) && $_GET['statuss'] == 'Aberta') ? 'selected' : '' ?>>Aberta</option>
                                            <option value="Em Andamento" <?= (isset($_GET['statuss']) && $_GET['statuss'] == 'Em Andamento') ? 'selected' : '' ?>>Em Andamento</option>
                                            <option value="Aguardando Peças" <?= (isset($_GET['statuss']) && $_GET['statuss'] == 'Aguardando Peças') ? 'selected' : '' ?>>Aguardando Peças</option>
                                            <option value="Concluído" <?= (isset($_GET['statuss']) && $_GET['statuss'] == 'Concluído') ? 'selected' : '' ?>>Concluído</option>
                                            <option value="Cancelada" <?= (isset($_GET['statuss']) && $_GET['statuss'] == 'Cancelada') ? 'selected' : '' ?>>Cancelada</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <?php if(isset($_GET['busca']) || isset($_GET['filtro_oculto']) || isset($_GET['statuss'])): ?>
                                            <a href="consultar_ordem.php" class="btn btn-outline-danger btn-sm">Limpar Filtros</a>
                                        <?php endif; ?>
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
                                    <table class="table table-striped table-hover table-bordered mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th><center>ID</center></th>
                                                <th><center>Cliente</center></th>
                                                <th><center>Técnico</center></th>
                                                <th><center>Problema</center></th>
                                                <th><center>Data</center></th>
                                                <th><center>Valor (R$)</center></th>
                                                <th><center>Prioridade</center></th>
                                                <th><center>Status</center></th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($ordens as $ordem): ?>
                                                <tr>
                                                    <td><center><?= htmlspecialchars($ordem['id_ordem']) ?></center></td>
                                                    <td><center><?= htmlspecialchars($ordem['nome_cliente'] ? $ordem['nome_cliente'] : $ordem['nome_client_ordem']) ?></center></td>
                                                    <td><center><?= htmlspecialchars($ordem['nome_tecnico'] ? $ordem['nome_tecnico'] : 'Não atribuído') ?></center></td>
                                                    <td><center><?= htmlspecialchars(substr($ordem['problema'], 0, 30)) ?>...</center></td>
                                                    <td><center><?= htmlspecialchars($ordem['dt_recebimento']) ?></center></td>
                                                    <td><center>R$ <?= number_format($ordem['valor_total'], 2, ',', '.') ?></center></td>
                                                    <td><center><?= htmlspecialchars($ordem['prioridade']) ?></center></td>
                                                    <td>
                                                        <center>
                                                            <?php 
                                                            $badge_class = '';
                                                            switch($ordem['statuss']) {
                                                                case 'Aberta': $badge_class = 'bg-primary'; break;
                                                                case 'Em Andamento': $badge_class = 'bg-warning text-dark'; break;
                                                                case 'Aguardando Peças': $badge_class = 'bg-info'; break;
                                                                case 'Concluído': $badge_class = 'bg-success'; break;
                                                                case 'Cancelada': $badge_class = 'bg-danger'; break;
                                                                default: $badge_class = 'bg-secondary';
                                                            }
                                                            ?>
                                                            <span class="badge <?=$badge_class?>"><?=$ordem['statuss']?></span>
                                                        </center> 
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm btn-primary me-1" title="Alterar" onclick="carregarDadosOrdem(<?= htmlspecialchars($ordem['id_ordem']) ?>)">Alterar</a>

                                                        <?php if ($filtro_oculto == '0'): ?>
                                                            <a href="consultar_ordem.php?acao=ocultar&id=<?= htmlspecialchars($ordem['id_ordem']) ?>" 
                                                                class="btn btn-sm btn-danger me-1" title="Ocultar" 
                                                                onclick="return confirm('Deseja ocultar esta ordem?')">
                                                                Inativar
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="consultar_ordem.php?acao=mostrar&id=<?= htmlspecialchars($ordem['id_ordem']) ?>" 
                                                                class="btn btn-sm btn-success me-1" title="Reativar" 
                                                                onclick="return confirm('Deseja tornar esta ordem visível novamente?')">
                                                                Reativar
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <button type="button" class="btn btn-sm <?= $badge_class ?> me-1" onclick="abrirModalStatus(<?=htmlspecialchars($ordem['id_ordem'])?>, '<?=$ordem['statuss']?>', '<?=htmlspecialchars($ordem['id_ordem'])?>')">
                                                            <i class="bi bi-gear-fill me-1"></i> Status
                                                        </button>
                                                        
                                                        <button class="btn btn-sm btn-info" onclick="mostrarDetalhesOrdem(<?=htmlspecialchars($ordem['id_ordem'])?>)">
                                                            <i class="bi bi-info-circle"></i> Detalhes
                                                        </button>
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
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Alterar Ordem de Serviço</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="alterar_ordem.php">
                            <div class="modal-body">
                                <input type="hidden" id="id_ordem" name="id_ordem">
                                
                                <div class="mb-3">
                                    <label for="nome_cliente" class="form-label">Nome do Cliente</label>
                                    <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
                                </div>
                                
                                <!-- Técnico -->
                                <div class="mb-2">
                                    <label for="tecnico" class="form-label">Técnico</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i class="bi bi-person-gear"></i></span>
                                            <select class="form-select" id="tecnico" name="tecnico" required>
                                                <option value="" selected disabled>Selecione o técnico</option>
                                                <?php foreach ($tecnicos as $tecnico): ?>
                                                    <option value="<?= $tecnico['id_usuario'] ?>">
                                                        <?= htmlspecialchars($tecnico['nome_usuario']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                
                                <div class="mb-3">
                                    <label for="marca_aparelho" class="form-label">Marca do Aparelho</label>
                                    <input type="text" class="form-control" id="marca_aparelho" name="marca_aparelho">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="prioridade" class="form-label">Prioridade</label>
                                    <select class="form-select" id="prioridade" name="prioridade">
                                        <option value="Baixa">Baixa</option>
                                        <option value="Média">Média</option>
                                        <option value="Alta">Alta</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="problema" class="form-label">Problema Relatado</label>
                                    <textarea class="form-control" id="problema" name="problema" rows="3"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="dt_recebimento" class="form-label">Data de Recebimento</label>
                                    <input type="date" class="form-control" id="dt_recebimento" name="dt_recebimento">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="valor_total" class="form-label">Valor Total (R$)</label>
                                    <input type="number" step="0.01" class="form-control" id="valor_total" name="valor_total">
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
                <div class="modal-dialog">
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

            <!-- Modal para Alterar Status -->
            <div class="modal fade" id="modalStatus" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Alterar Status da Ordem</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Alterar status da ordem: <strong id="idOrdemStatus"></strong></p>
                            <p>Status atual: <span id="statusAtual" class="badge"></span></p>
                            
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Aberta')">
                                    <div>
                                        <span class="badge bg-primary me-2"><i class="bi bi-folder-plus"></i></span>
                                        Aberta
                                    </div>
                                    <small class="text-muted">Ordem recém-criada</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Em Andamento')">
                                    <div>
                                        <span class="badge bg-warning me-2"><i class="bi bi-tools"></i></span>
                                        Em Andamento
                                    </div>
                                    <small class="text-muted">Ordem em execução</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Aguardando Peças')">
                                    <div>
                                        <span class="badge bg-info me-2"><i class="bi bi-clock-history"></i></span>
                                        Aguardando Peças
                                    </div>
                                    <small class="text-muted">Aguardando peças para continuar</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Concluído')">
                                    <div>
                                        <span class="badge bg-success me-2"><i class="bi bi-check-circle"></i></span>
                                        Concluído
                                    </div>
                                    <small class="text-muted">Ordem finalizada com sucesso</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" onclick="selecionarStatus('Cancelada')">
                                    <div>
                                        <span class="badge bg-danger me-2"><i class="bi bi-x-circle"></i></span>
                                        Cancelada
                                    </div>
                                    <small class="text-muted">Ordem cancelada</small>
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

        // Submeter formulário quando os filtros forem alterados
        document.getElementById('filtro_oculto').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
        
        document.getElementById('statuss').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });

        // Função para carregar dados da ordem no modal via AJAX
        function carregarDadosOrdem(id) {
            // Mostrar loading no modal
            document.getElementById('id_ordem').value = id;
            document.getElementById('nome_cliente').value = 'Carregando...';
            document.getElementById('tecnico').value = 'Carregando...';
            document.getElementById('marca_aparelho').value = 'Carregando...';
            document.getElementById('problema').value = 'Carregando...';
            document.getElementById('dt_recebimento').value = '';
            document.getElementById('valor_total').value = '';
            document.getElementById('observacao').value = 'Carregando...';
            
            // Abre o modal primeiro
            var modal = new bootstrap.Modal(document.getElementById('modalOrdem'));
            modal.show();
            
            // Fazer requisição AJAX para buscar os dados reais
            fetch('consultar_ordem.php?carregar_ordem=true&id_ordem=' + id)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao carregar dados da ordem');
                    }
                    return response.json();
                })
                .then(ordem => {
                    // Preencher o formulário com os dados reais
                    document.getElementById('id_ordem').value = ordem.id_ordem;
                    document.getElementById('nome_cliente').value = ordem.nome_cliente || ordem.nome_client_ordem || '';
                    document.getElementById('tecnico').value = ordem.tecnico || '';
                    document.getElementById('marca_aparelho').value = ordem.marca_aparelho || '';
                    document.getElementById('prioridade').value = ordem.prioridade || 'Média';
                    document.getElementById('problema').value = ordem.problema || '';
                    
                    // Formatar data para o input type="date"
                    if (ordem.dt_recebimento) {
                        const data = new Date(ordem.dt_recebimento);
                        const dataFormatada = data.toISOString().split('T')[0];
                        document.getElementById('dt_recebimento').value = dataFormatada;
                    }
                    
                    document.getElementById('valor_total').value = ordem.valor_total || '';
                    document.getElementById('observacao').value = ordem.observacao || '';
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao carregar dados da ordem: ' + error.message);
                });
        }

        // Função para mostrar detalhes da ordem
        function mostrarDetalhesOrdem(id) {
            // Fazer requisição AJAX para buscar os dados reais
            fetch('consultar_ordem.php?carregar_ordem=true&id_ordem=' + id)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao carregar dados da ordem');
                    }
                    return response.json();
                })
                .then(ordem => {
                    const detalhesHTML = `
                        <div class="mb-3">
                            <strong>ID:</strong> ${ordem.id_ordem}
                        </div>
                        <div class="mb-3">
                            <strong>Cliente:</strong> ${ordem.nome_cliente || ordem.nome_client_ordem || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Técnico:</strong> ${ordem.nome_tecnico || ordem.tecnico || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Marca do Aparelho:</strong> ${ordem.marca_aparelho || 'Não informada'}
                        </div>
                        <div class="mb-3">
                            <strong>Prioridade:</strong> ${ordem.prioridade || 'Média'}
                        </div>
                        <div class="mb-3">
                            <strong>Status:</strong> 
                    `;
                    
                    // Adiciona badge de status
                    let badge_class = '';
                    switch(ordem.status) {
                        case 'Aberta': badge_class = 'bg-primary'; break;
                        case 'Em Andamento': badge_class = 'bg-warning text-dark'; break;
                        case 'Aguardando Peças': badge_class = 'bg-info'; break;
                        case 'Concluído': badge_class = 'bg-success'; break;
                        case 'Cancelada': badge_class = 'bg-danger'; break;
                        default: badge_class = 'bg-secondary';
                    }
                    
                    detalhesHTML += `<span class="badge ${badge_class}">${ordem.status || 'Não definido'}</span></div>
                        <div class="mb-3">
                            <strong>Problema:</strong> ${ordem.problema || 'Não informado'}
                        </div>
                        <div class="mb-3">
                            <strong>Data de Recebimento:</strong> ${ordem.dt_recebimento || 'Não informada'}
                        </div>
                        <div class="mb-3">
                            <strong>Valor Total:</strong> R$ ${ordem.valor_total ? parseFloat(ordem.valor_total).toFixed(2).replace('.', ',') : '0,00'}
                        </div>
                        <div class="mb-3">
                            <strong>Observações:</strong> ${ordem.observacao || 'Nenhuma observação'}
                        </div>
                    `;
                    
                    document.getElementById('detalhesOrdem').innerHTML = detalhesHTML;
                    
                    // Abre o modal
                    var modal = new bootstrap.Modal(document.getElementById('modalDetalhes'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao carregar detalhes da ordem: ' + error.message);
                });
        }
        
        // Variáveis globais para controle do status
        let ordemIdStatus = null;
        let novoStatusSelecionado = null;

        // Função para abrir o modal de status
        function abrirModalStatus(id, statusAtual, idOrdem) {
            ordemIdStatus = id;
            novoStatusSelecionado = statusAtual;
            
            // Atualizar informações no modal
            document.getElementById('idOrdemStatus').textContent = idOrdem;
            
            // Atualizar badge do status atual
            const statusAtualEl = document.getElementById('statusAtual');
            let badgeClass = '';
            switch(statusAtual) {
                case 'Aberta': badgeClass = 'bg-primary'; break;
                case 'Em Andamento': badgeClass = 'bg-warning text-dark'; break;
                case 'Aguardando Peças': badgeClass = 'bg-info'; break;
                case 'Concluído': badgeClass = 'bg-success'; break;
                case 'Cancelada': badgeClass = 'bg-danger'; break;
                default: badgeClass = 'bg-secondary';
            }
            statusAtualEl.className = `badge ${badgeClass}`;
            statusAtualEl.textContent = statusAtual;
            
            // Destacar o status atual na lista
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
            
            // Destacar o item selecionado
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
                if (item.textContent.includes(status)) {
                    item.classList.add('active');
                }
            });
        }

        // Configurar botão de confirmação
        document.getElementById('confirmarStatus').addEventListener('click', function() {
            if (novoStatusSelecionado && ordemIdStatus) {
                // Redirecionar para alterar o status
                window.location.href = `consultar_ordem.php?id=${ordemIdStatus}&statuss=${encodeURIComponent(novoStatusSelecionado)}`;
            }
        });
    </script>
</body>
</html>
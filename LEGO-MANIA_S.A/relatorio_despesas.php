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
                    <!-- Cabeçalho -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Relatório de Despesas - Ordens de Serviço</h5>
                        <div>
                            <button class="btn btn-outline-secondary btn-sm me-2">
                                <i class="bi bi-download me-1"></i> Exportar
                            </button>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Nova Despesa
                            </button>
                        </div>
                    </div>
            
                    <!-- Gráficos -->
                    <div class="row mb-4">
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-primary mb-2">
                                        <i class="bi bi-currency-dollar fs-1"></i>
                                    </div>
                                    <h4 class="card-title">R$ 28.750,00</h4>
                                    <p class="card-text text-muted">Despesas Totais</p>
                                    <span class="badge bg-danger">+8%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-success mb-2">
                                        <i class="bi bi-wrench fs-1"></i>
                                    </div>
                                    <h4 class="card-title">R$ 15.420,00</h4>
                                    <p class="card-text text-muted">Mão de Obra</p>
                                    <span class="badge bg-success">+5%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-warning mb-2">
                                        <i class="bi bi-box-seam fs-1"></i>
                                    </div>
                                    <h4 class="card-title">R$ 9.830,00</h4>
                                    <p class="card-text text-muted">Peças e Materiais</p>
                                    <span class="badge bg-warning text-dark">+12%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-info mb-2">
                                        <i class="bi bi-truck fs-1"></i>
                                    </div>
                                    <h4 class="card-title">R$ 3.500,00</h4>
                                    <p class="card-text text-muted">Transporte e Logística</p>
                                    <span class="badge bg-info">+3%</span>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Evolução de Despesas por Mês</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoEvolucaoDespesas" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Distribuição de Despesas</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoDistribuicao" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Novo gráfico para comparação de despesas por OS -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Despesas por Ordem de Serviço (Top 10)</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoDespesasPorOS" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Barra de pesquisa e filtros -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body py-2">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Pesquisar despesas..." id="pesquisaDespesas">
                                        <button class="btn btn-outline-secondary" type="button" id="btnPesquisarDespesas">
                                            Pesquisar
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm" id="filtroCategoria">
                                        <option value="" selected>Todas categorias</option>
                                        <option value="mao_obra">Mão de Obra</option>
                                        <option value="pecas">Peças</option>
                                        <option value="transportes">Transporte</option>
                                        <option value="outros">Outros</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm" id="filtroOS">
                                        <option value="" selected>Todas as OS</option>
                                        <option value="OS-2023-001">OS-2023-001</option>
                                        <option value="OS-2023-002">OS-2023-002</option>
                                        <option value="OS-2023-003">OS-2023-003</option>
                                        <option value="OS-2023-004">OS-2023-004</option>
                                        <option value="OS-2023-005">OS-2023-005</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="month" class="form-control form-control-sm" id="filtroMes">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm" id="ordenacaoDespesas">
                                        <option value="data_desc" selected>Mais recentes</option>
                                        <option value="data_asc">Mais antigas</option>
                                        <option value="valor_desc">Maior valor</option>
                                        <option value="valor_asc">Menor valor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabela de despesas -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0" id="tabelaDespesas">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Ordem Serviço</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Valor (R$)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">DESP-001</th>
                                            <td>OS-2023-002</td>
                                            <td>Placa de Vídeo RTX 3060</td>
                                            <td>Peças</td>
                                            <td>16/03/2023</td>
                                            <td>1.850,00</td>
                                            <td><span class="badge bg-success">Pago</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary" title="Alterar" onclick="editarDespesa('DESP-001')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Excluir" onclick="excluirDespesa('DESP-001')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Detalhes" onclick="detalhesDespesa('DESP-001')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">DESP-002</th>
                                            <td>OS-2023-001</td>
                                            <td>Mão de obra técnico especializado</td>
                                            <td>Mão de Obra</td>
                                            <td>15/03/2023</td>
                                            <td>650,00</td>
                                            <td><span class="badge bg-success">Pago</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary" title="Alterar" onclick="editarDespesa('DESP-002')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Excluir" onclick="excluirDespesa('DESP-002')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Detalhes" onclick="detalhesDespesa('DESP-002')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">DESP-003</th>
                                            <td>OS-2023-004</td>
                                            <td>Transporte urgente - frete</td>
                                            <td>Transporte</td>
                                            <td>20/03/2023</td>
                                            <td>280,00</td>
                                            <td><span class="badge bg-warning text-dark">Pendente</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary" title="Alterar" onclick="editarDespesa('DESP-003')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Excluir" onclick="excluirDespesa('DESP-003')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Detalhes" onclick="detalhesDespesa('DESP-003')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">DESP-004</th>
                                            <td>OS-2023-003</td>
                                            <td>Processador Intel i7-10700K</td>
                                            <td>Peças</td>
                                            <td>18/03/2023</td>
                                            <td>1.250,00</td>
                                            <td><span class="badge bg-success">Pago</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary" title="Alterar" onclick="editarDespesa('DESP-004')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Excluir" onclick="excluirDespesa('DESP-004')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Detalhes" onclick="detalhesDespesa('DESP-004')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">DESP-005</th>
                                            <td>OS-2023-002</td>
                                            <td>Hora extra técnico</td>
                                            <td>Mão de Obra</td>
                                            <td>17/03/2023</td>
                                            <td>320,00</td>
                                            <td><span class="badge bg-success">Pago</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary" title="Alterar" onclick="editarDespesa('DESP-005')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Excluir" onclick="excluirDespesa('DESP-005')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" title="Detalhes" onclick="detalhesDespesa('DESP-005')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Mostrando 5 de 78 despesas</span>
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
            
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Gráfico de evolução de despesas
                const ctxEvolucao = document.getElementById('graficoEvolucaoDespesas').getContext('2d');
                new Chart(ctxEvolucao, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                        datasets: [{
                            label: 'Mão de Obra',
                            data: [2200, 2450, 2800, 3120, 2950, 3200],
                            borderColor: '#198754',
                            backgroundColor: 'rgba(25, 135, 84, 0.1)',
                            fill: true,
                            tension: 0.3
                        }, {
                            label: 'Peças e Materiais',
                            data: [1800, 1950, 2200, 2450, 2600, 2850],
                            borderColor: '#ffc107',
                            backgroundColor: 'rgba(255, 193, 7, 0.1)',
                            fill: true,
                            tension: 0.3
                        }, {
                            label: 'Transporte',
                            data: [800, 750, 950, 1100, 1050, 1200],
                            borderColor: '#0dcaf0',
                            backgroundColor: 'rgba(13, 202, 240, 0.1)',
                            fill: true,
                            tension: 0.3
                        }, {
                            label: 'Outras Despesas',
                            data: [500, 600, 750, 800, 900, 950],
                            borderColor: '#6c757d',
                            backgroundColor: 'rgba(108, 117, 125, 0.1)',
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Valor (R$)'
                                }
                            }
                        }
                    }
                });
            
                // Gráfico de distribuição de despesas
                const ctxDistribuicao = document.getElementById('graficoDistribuicao').getContext('2d');
                new Chart(ctxDistribuicao, {
                    type: 'doughnut',
                    data: {
                        labels: ['Mão de Obra', 'Peças', 'Transporte', 'Outros'],
                        datasets: [{
                            data: [54, 34, 8, 4],
                            backgroundColor: ['#198754', '#ffc107', '#0dcaf0', '#6c757d']
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
            
                // Gráfico de despesas por OS
                const ctxDespesasOS = document.getElementById('graficoDespesasPorOS').getContext('2d');
                new Chart(ctxDespesasOS, {
                    type: 'bar',
                    data: {
                        labels: ['OS-2023-002', 'OS-2023-004', 'OS-2023-001', 'OS-2023-005', 'OS-2023-003'],
                        datasets: [{
                            label: 'Mão de Obra',
                            data: [1200, 850, 650, 420, 380],
                            backgroundColor: '#198754'
                        }, {
                            label: 'Peças',
                            data: [1850, 950, 320, 280, 1250],
                            backgroundColor: '#ffc107'
                        }, {
                            label: 'Transporte',
                            data: [180, 280, 120, 90, 150],
                            backgroundColor: '#0dcaf0'
                        }, {
                            label: 'Outros',
                            data: [120, 80, 60, 45, 90],
                            backgroundColor: '#6c757d'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Valor (R$)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            }
                        }
                    }
                });
            
                // Funções para integração futura com PHP
                function editarDespesa(id) {
                    console.log('Editando despesa:', id);
                    // Futuramente: redirecionar para página de edição
                }
                
                function excluirDespesa(id) {
                    console.log('Excluindo despesa:', id);
                    if (confirm('Tem certeza que deseja excluir esta despesa?')) {
                        // Futuramente: enviar requisição AJAX para exclusão
                    }
                }
                
                function detalhesDespesa(id) {
                    console.log('Visualizando detalhes da despesa:', id);
                    // Futuramente: abrir modal com detalhes
                }
                
                // Event listeners para filtros
                document.getElementById('btnPesquisarDespesas').addEventListener('click', function() {
                    const termo = document.getElementById('pesquisaDespesas').value;
                    console.log('Pesquisando despesas por:', termo);
                    // Futuramente: enviar requisição para backend PHP
                });
                
                // Outros event listeners para filtros
                document.getElementById('filtroCategoria').addEventListener('change', aplicarFiltros);
                document.getElementById('filtroOS').addEventListener('change', aplicarFiltros);
                document.getElementById('filtroMes').addEventListener('change', aplicarFiltros);
                document.getElementById('ordenacaoDespesas').addEventListener('change', aplicarFiltros);
                
                function aplicarFiltros() {
                    const categoria = document.getElementById('filtroCategoria').value;
                    const os = document.getElementById('filtroOS').value;
                    const mes = document.getElementById('filtroMes').value;
                    const ordem = document.getElementById('ordenacaoDespesas').value;
                    
                    console.log('Aplicando filtros:', { categoria, os, mes, ordem });
                    // Futuramente: enviar requisição para backend PHP com os filtros
                }
            </script>
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
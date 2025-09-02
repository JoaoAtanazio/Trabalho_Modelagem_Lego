<?php
session_start();
require_once 'php/permissoes.php';
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
                    <!-- Cabeçalho com título e botão de novo fornecedor -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-truck me-2"></i>Gestão de Fornecedores</h5>
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Novo Fornecedor
                        </button>
                    </div>
                    
                    <!-- Barra de pesquisa e filtros -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body py-2">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Pesquisar fornecedores...">
                                        <button class="btn btn-outline-secondary" type="button">Pesquisar</button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select form-select-sm">
                                        <option selected>Todos os ramos</option>
                                        <option>Eletrônicos</option>
                                        <option>Peças Mecânicas</option>
                                        <option>Plásticos</option>
                                        <option>Metais</option>
                                        <option>Embalagens</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select form-select-sm">
                                        <option selected>Status</option>
                                        <option>Ativo</option>
                                        <option>Inativo</option>
                                        <option>Suspenso</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabela de fornecedores -->
                    <div class="flex-grow-1 p-3" style="overflow-y: auto;">
                        <div class="container-fluid">
                            <!-- Cabeçalho -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Dashboard de Relatórios</h5>
                                <div>
                                    <button class="btn btn-outline-secondary btn-sm me-2">
                                        <i class="bi bi-download me-1"></i> Exportar
                                    </button>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i> Novo Registro
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
                                            <h4 class="card-title">R$ 12.850,00</h4>
                                            <p class="card-text text-muted">Faturamento Mensal</p>
                                            <span class="badge bg-success">+12%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body text-center">
                                            <div class="text-success mb-2">
                                                <i class="bi bi-cart-check fs-1"></i>
                                            </div>
                                            <h4 class="card-title">48</h4>
                                            <p class="card-text text-muted">Ordens Concluídas</p>
                                            <span class="badge bg-success">+8%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body text-center">
                                            <div class="text-warning mb-2">
                                                <i class="bi bi-people fs-1"></i>
                                            </div>
                                            <h4 class="card-title">23</h4>
                                            <p class="card-text text-muted">Novos Clientes</p>
                                            <span class="badge bg-success">+5%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body text-center">
                                            <div class="text-info mb-2">
                                                <i class="bi bi-gear fs-1"></i>
                                            </div>
                                            <h4 class="card-title">15</h4>
                                            <p class="card-text text-muted">Em Andamento</p>
                                            <span class="badge bg-danger">-3%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row mb-4">
                                <div class="col-lg-8 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Desempenho Mensal</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="graficoDesempenho" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Distribuição por Categoria</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="graficoCategorias" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Barra de pesquisa e filtros -->
                            <div class="card shadow-sm mb-3">
                                <div class="card-body py-2">
                                    <div class="row g-2">
                                        <div class="col-md-5">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                                <input type="text" class="form-control" placeholder="Pesquisar registros...">
                                                <button class="btn btn-outline-secondary" type="button">Pesquisar</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select form-select-sm">
                                                <option selected>Todas as categorias</option>
                                                <option>Eletrônicos</option>
                                                <option>Manutenção</option>
                                                <option>Consultoria</option>
                                                <option>Vendas</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select form-select-sm">
                                                <option selected>Status</option>
                                                <option>Ativo</option>
                                                <option>Concluído</option>
                                                <option>Pendente</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select form-select-sm">
                                                <option selected>Ordenar por</option>
                                                <option>Data</option>
                                                <option>Valor</option>
                                                <option>Nome</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tabela de gestão -->
                            <div class="card shadow-sm">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">ID</th>
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
                                                    <th scope="row">5001</th>
                                                    <td>Manutenção Preventiva</td>
                                                    <td>Manutenção</td>
                                                    <td>15/03/2023</td>
                                                    <td>350,00</td>
                                                    <td><span class="badge bg-success">Concluído</span></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary" title="Alterar">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-secondary" title="Ocultar">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5002</th>
                                                    <td>Venda de Componentes</td>
                                                    <td>Vendas</td>
                                                    <td>16/03/2023</td>
                                                    <td>890,00</td>
                                                    <td><span class="badge bg-success">Concluído</span></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary" title="Alterar">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-secondary" title="Ocultar">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5003</th>
                                                    <td>Reparo de Placa</td>
                                                    <td>Eletrônicos</td>
                                                    <td>18/03/2023</td>
                                                    <td>420,00</td>
                                                    <td><span class="badge bg-warning text-dark">Em Andamento</span></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary" title="Alterar">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-secondary" title="Ocultar">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5004</th>
                                                    <td>Consulta Técnica</td>
                                                    <td>Consultoria</td>
                                                    <td>20/03/2023</td>
                                                    <td>150,00</td>
                                                    <td><span class="badge bg-secondary">Pendente</span></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary" title="Alterar">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-secondary" title="Ocultar">
                                                            <i class="bi bi-eye-slash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">5005</th>
                                                    <td>Instalação de Sistema</td>
                                                    <td>Manutenção</td>
                                                    <td>22/03/2023</td>
                                                    <td>600,00</td>
                                                    <td><span class="badge bg-info">Aguardando</span></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary" title="Alterar">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-secondary" title="Ocultar">
                                                            <i class="bi bi-eye-slash"></i>
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
                                            <span class="text-muted">Mostrando 5 de 127 registros</span>
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
                        // Gráfico de desempenho mensal
                        const ctxDesempenho = document.getElementById('graficoDesempenho').getContext('2d');
                        new Chart(ctxDesempenho, {
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                                datasets: [{
                                    label: 'Faturamento (R$)',
                                    data: [8500, 9200, 10200, 9800, 11200, 12850],
                                    borderColor: '#0d6efd',
                                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
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
                                }
                            }
                        });
                    
                        // Gráfico de categorias
                        const ctxCategorias = document.getElementById('graficoCategorias').getContext('2d');
                        new Chart(ctxCategorias, {
                            type: 'doughnut',
                            data: {
                                labels: ['Eletrônicos', 'Manutenção', 'Consultoria', 'Vendas'],
                                datasets: [{
                                    data: [35, 25, 20, 20],
                                    backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545']
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
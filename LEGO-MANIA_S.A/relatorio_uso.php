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
                    <!-- Cabeçalho -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Dashboard de Gestão de Peças</h5>
                        <div>
                            <button class="btn btn-outline-secondary btn-sm me-2">
                                <i class="bi bi-download me-1"></i> Exportar
                            </button>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Nova Peça
                            </button>
                        </div>
                    </div>
            
                    <!-- Gráficos -->
                    <div class="row mb-4">
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-primary mb-2">
                                        <i class="bi bi-box-seam fs-1"></i>
                                    </div>
                                    <h4 class="card-title">1.248</h4>
                                    <p class="card-text text-muted">Peças em Estoque</p>
                                    <span class="badge bg-success">+5%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-success mb-2">
                                        <i class="bi bi-arrow-up-circle fs-1"></i>
                                    </div>
                                    <h4 class="card-title">327</h4>
                                    <p class="card-text text-muted">Peças Utilizadas/Mês</p>
                                    <span class="badge bg-success">+12%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-warning mb-2">
                                        <i class="bi bi-arrow-down-circle fs-1"></i>
                                    </div>
                                    <h4 class="card-title">28</h4>
                                    <p class="card-text text-muted">Peças Pouco Utilizadas</p>
                                    <span class="badge bg-danger">-8%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-info mb-2">
                                        <i class="bi bi-exclamation-triangle fs-1"></i>
                                    </div>
                                    <h4 class="card-title">15</h4>
                                    <p class="card-text text-muted">Peças Críticas</p>
                                    <span class="badge bg-warning text-dark">Atenção</span>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Utilização de Peças (Últimos 6 Meses)</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoUtilizacao" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Peças Mais Utilizadas</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoTopPecas" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <!-- Novo gráfico para comparação de peças -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="bi bi-bar-chart-steps me-2"></i>Comparativo: Peças Mais vs Menos Utilizadas</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoComparativo" height="300"></canvas>
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
                                        <input type="text" class="form-control" placeholder="Pesquisar peças...">
                                        <button class="btn btn-outline-secondary" type="button">Pesquisar</button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select form-select-sm">
                                        <option selected>Todas as categorias</option>
                                        <option>Processadores</option>
                                        <option>Placas de Vídeo</option>
                                        <option>Memórias RAM</option>
                                        <option>Placas-Mãe</option>
                                        <option>Armazenamento</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm">
                                        <option selected>Status</option>
                                        <option>Em Estoque</option>
                                        <option>Estoque Baixo</option>
                                        <option>Esgotado</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select form-select-sm">
                                        <option selected>Ordenar por</option>
                                        <option>Mais Utilizadas</option>
                                        <option>Menos Utilizadas</option>
                                        <option>Nome</option>
                                        <option>Data de Entrada</option>
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
                                            <th scope="col">Nome da Peça</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Data de Entrada</th>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Utilização/Mês</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">P001</th>
                                            <td>Processador Intel i7-10700K</td>
                                            <td>Processadores</td>
                                            <td>15/03/2023</td>
                                            <td>45</td>
                                            <td>28</td>
                                            <td><span class="badge bg-success">Em Estoque</span></td>
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
                                            <th scope="row">P002</th>
                                            <td>Placa de Vídeo RTX 3060</td>
                                            <td>Placas de Vídeo</td>
                                            <td>16/03/2023</td>
                                            <td>32</td>
                                            <td>25</td>
                                            <td><span class="badge bg-warning text-dark">Estoque Baixo</span></td>
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
                                            <th scope="row">P003</th>
                                            <td>Memória DDR4 8GB</td>
                                            <td>Memórias RAM</td>
                                            <td>18/03/2023</td>
                                            <td>120</td>
                                            <td>62</td>
                                            <td><span class="badge bg-success">Em Estoque</span></td>
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
                                            <th scope="row">P004</th>
                                            <td>SSD NVMe 1TB</td>
                                            <td>Armazenamento</td>
                                            <td>20/03/2023</td>
                                            <td>56</td>
                                            <td>38</td>
                                            <td><span class="badge bg-success">Em Estoque</span></td>
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
                                            <th scope="row">P005</th>
                                            <td>Placa-Mãe B460M</td>
                                            <td>Placas-Mãe</td>
                                            <td>22/03/2023</td>
                                            <td>18</td>
                                            <td>5</td>
                                            <td><span class="badge bg-danger">Esgotado</span></td>
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
                                    <span class="text-muted">Mostrando 5 de 78 registros</span>
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
                // Gráfico de utilização de peças
                const ctxUtilizacao = document.getElementById('graficoUtilizacao').getContext('2d');
                new Chart(ctxUtilizacao, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                        datasets: [{
                            label: 'Processadores',
                            data: [18, 22, 25, 24, 26, 28],
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            fill: true,
                            tension: 0.3
                        }, {
                            label: 'Placas de Vídeo',
                            data: [15, 18, 20, 22, 23, 25],
                            borderColor: '#198754',
                            backgroundColor: 'rgba(25, 135, 84, 0.1)',
                            fill: true,
                            tension: 0.3
                        }, {
                            label: 'Memórias RAM',
                            data: [45, 48, 52, 55, 58, 62],
                            borderColor: '#ffc107',
                            backgroundColor: 'rgba(255, 193, 7, 0.1)',
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
            
                // Gráfico de peças mais utilizadas
                const ctxTopPecas = document.getElementById('graficoTopPecas').getContext('2d');
                new Chart(ctxTopPecas, {
                    type: 'doughnut',
                    data: {
                        labels: ['Memórias RAM', 'Processadores', 'Armazenamento', 'Placas de Vídeo', 'Placas-Mãe'],
                        datasets: [{
                            data: [35, 28, 22, 10, 5],
                            backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1']
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
            
                // Gráfico comparativo (mais vs menos utilizadas)
                const ctxComparativo = document.getElementById('graficoComparativo').getContext('2d');
                new Chart(ctxComparativo, {
                    type: 'bar',
                    data: {
                        labels: ['Memória DDR4 8GB', 'Processador i7-10700K', 'SSD NVMe 1TB', 'Placa de Vídeo RTX 3060', 'Placa-Mãe B460M'],
                        datasets: [{
                            label: 'Peças Mais Utilizadas',
                            data: [62, 28, 38, 25, 5],
                            backgroundColor: '#0d6efd',
                            borderColor: '#0a58ca',
                            borderWidth: 1
                        }, {
                            label: 'Média de Utilização',
                            data: [35, 35, 35, 35, 35],
                            backgroundColor: '#6c757d',
                            borderColor: '#5c636a',
                            borderWidth: 1,
                            type: 'line',
                            fill: false,
                            pointStyle: false
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Quantidade Utilizada/Mês'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Comparativo de Utilização de Peças'
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
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
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Relatório de Lucros - Ordens de Serviço</h5>
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
            
                    <!-- Novos cards para lucros -->
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm border-0 bg-success bg-opacity-10">
                                <div class="card-body text-center">
                                    <div class="text-success mb-2">
                                        <i class="bi bi-currency-exchange fs-1"></i>
                                    </div>
                                    <h4 class="card-title">R$ 45.680,00</h4>
                                    <p class="card-text text-muted">Faturamento Total</p>
                                    <span class="badge bg-success">+15%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm border-0 bg-primary bg-opacity-10">
                                <div class="card-body text-center">
                                    <div class="text-primary mb-2">
                                        <i class="bi bi-graph-up-arrow fs-1"></i>
                                    </div>
                                    <h4 class="card-title">R$ 16.930,00</h4>
                                    <p class="card-text text-muted">Lucro Bruto</p>
                                    <span class="badge bg-primary">+22%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card shadow-sm border-0 bg-info bg-opacity-10">
                                <div class="card-body text-center">
                                    <div class="text-info mb-2">
                                        <i class="bi bi-percent fs-1"></i>
                                    </div>
                                    <h4 class="card-title">37,1%</h4>
                                    <p class="card-text text-muted">Margem de Lucro</p>
                                    <span class="badge bg-info">+4%</span>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Evolução de Despesas e Faturamento</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoEvolucaoDespesasFaturamento" height="250"></canvas>
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
            
                    <!-- Gráfico de lucro por OS -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="mb-0"><i class="bi bi-currency-dollar me-2"></i>Lucro por Ordem de Serviço (Top 10)</h6>
                                </div>
                                <div class="card-body">
                                    <canvas id="graficoLucroPorOS" height="300"></canvas>
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
                // Dados simulados para demonstração (serão substituídos por dados do PHP)
                const dadosParaPHP = {
                    meses: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                    despesasMaoObra: [2200, 2450, 2800, 3120, 2950, 3200],
                    despesasPecas: [1800, 1950, 2200, 2450, 2600, 2850],
                    despesasTransporte: [800, 750, 950, 1100, 1050, 1200],
                    despesasOutras: [500, 600, 750, 800, 900, 950],
                    faturamento: [5200, 5800, 6500, 7200, 6800, 7500],
                    lucro: [1900, 2150, 2400, 2730, 2300, 2650],
                    // Dados para o gráfico de lucro por OS
                    osLabels: ['OS-2023-002', 'OS-2023-004', 'OS-2023-001', 'OS-2023-005', 'OS-2023-003'],
                    osLucros: [3200, 1850, 1650, 1200, 950]
                };
            
                // Gráfico de evolução de despesas e faturamento
                const ctxEvolucao = document.getElementById('graficoEvolucaoDespesasFaturamento').getContext('2d');
                new Chart(ctxEvolucao, {
                    type: 'line',
                    data: {
                        labels: dadosParaPHP.meses,
                        datasets: [{
                            label: 'Faturamento',
                            data: dadosParaPHP.faturamento,
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2
                        }, {
                            label: 'Lucro',
                            data: dadosParaPHP.lucro,
                            borderColor: '#198754',
                            backgroundColor: 'rgba(25, 135, 84, 0.1)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2
                        }, {
                            label: 'Despesas Totais',
                            data: dadosParaPHP.despesasMaoObra.map((val, idx) => 
                                val + dadosParaPHP.despesasPecas[idx] + 
                                dadosParaPHP.despesasTransporte[idx] + 
                                dadosParaPHP.despesasOutras[idx]
                            ),
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            fill: true,
                            tension: 0.3,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.dataset.label + ': R$ ' + context.raw.toFixed(2).replace('.', ',');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Valor (R$)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'R$ ' + value.toFixed(0);
                                    }
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
            
                // Gráfico de lucro por OS
                const ctxLucroOS = document.getElementById('graficoLucroPorOS').getContext('2d');
                new Chart(ctxLucroOS, {
                    type: 'bar',
                    data: {
                        labels: dadosParaPHP.osLabels,
                        datasets: [{
                            label: 'Lucro por OS (R$)',
                            data: dadosParaPHP.osLucros,
                            backgroundColor: '#198754',
                            borderColor: 'rgba(25, 135, 84, 0.8)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Lucro: R$ ' + context.raw.toFixed(2).replace('.', ',');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Valor (R$)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'R$ ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            
                // Funções para integração futura com PHP
                function editarDespesa(id) {
                    console.log('Editando despesa:', id);
                    // Futuramente: redirecionar para página de edição com parâmetros PHP
                    // window.location.href = 'editar_despesa.php?id=' + id;
                }
                
                function excluirDespesa(id) {
                    console.log('Excluindo despesa:', id);
                    if (confirm('Tem certeza que deseja excluir esta despesa?')) {
                        // Futuramente: enviar requisição AJAX para exclusão no PHP
                        /*
                        fetch('excluir_despesa.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ id: id })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Erro ao excluir despesa: ' + data.message);
                            }
                        });
                        */
                    }
                }
                
                function detalhesDespesa(id) {
                    console.log('Visualizando detalhes da despesa:', id);
                    // Futuramente: abrir modal com detalhes via PHP
                    /*
                    fetch('detalhes_despesa.php?id=' + id)
                        .then(response => response.json())
                        .then(data => {
                            // Preencher e exibir modal com os dados
                        });
                    */
                }
                
                // Event listeners para filtros
                document.getElementById('btnPesquisarDespesas').addEventListener('click', function() {
                    const termo = document.getElementById('pesquisaDespesas').value;
                    console.log('Pesquisando despesas por:', termo);
                    // Futuramente: enviar requisição para backend PHP
                    // aplicarFiltros();
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
                    /*
                    const formData = new FormData();
                    formData.append('categoria', categoria);
                    formData.append('os', os);
                    formData.append('mes', mes);
                    formData.append('ordem', ordem);
                    
                    fetch('filtrar_despesas.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Atualizar tabela com os dados filtrados
                        atualizarTabela(data);
                    });
                    */
                }
                
                // Função para atualizar a tabela (será usada com retorno do PHP)
                function atualizarTabela(dados) {
                    console.log('Atualizando tabela com dados:', dados);
                    // Implementação futura para preencher a tabela com dados do PHP
                }
                
                // Simular carregamento de dados do PHP
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('Página carregada. Pronta para integração com PHP.');
                    // Aqui seria onde chamaríamos o PHP para carregar os dados iniciais
                    /*
                    fetch('carregar_dados.php')
                        .then(response => response.json())
                        .then(data => {
                            // Preencher gráficos e tabela com dados reais
                        });
                    */
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
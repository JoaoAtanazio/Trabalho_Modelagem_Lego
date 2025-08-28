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
    <script src="javascript/validacoes_form.js"></script>
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
    </style>
</head>
<body>
    <div class="flex-grow-1 p-3" style="overflow-y: auto;">
        <div class="container-fluid">
            <!-- Cabeçalho -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="bi bi-boxes me-2"></i>Relatório de Peças no Estoque</h5>
                <div>
                    <button class="btn btn-outline-secondary btn-sm me-2">
                        <i class="bi bi-download me-1"></i> Exportar
                    </button>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarPeca">
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
                            <h4 class="card-title">128</h4>
                            <p class="card-text text-muted">Total de Peças</p>
                            <span class="badge bg-success">+12%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 card-dashboard">
                        <div class="card-body text-center">
                            <div class="text-success mb-2">
                                <i class="bi bi-check-circle fs-1"></i>
                            </div>
                            <h4 class="card-title">94</h4>
                            <p class="card-text text-muted">Em Estoque</p>
                            <span class="badge bg-success">+8%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 card-dashboard">
                        <div class="card-body text-center">
                            <div class="text-warning mb-2">
                                <i class="bi bi-exclamation-triangle fs-1"></i>
                            </div>
                            <h4 class="card-title">22</h4>
                            <p class="card-text text-muted">Estoque Baixo</p>
                            <span class="badge bg-warning text-dark">+15%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card shadow-sm border-0 card-dashboard">
                        <div class="card-body text-center">
                            <div class="text-danger mb-2">
                                <i class="bi bi-x-circle fs-1"></i>
                            </div>
                            <h4 class="card-title">12</h4>
                            <p class="card-text text-muted">Fora de Estoque</p>
                            <span class="badge bg-danger">+5%</span>
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
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Peça</th>
                                            <th>Categoria</th>
                                            <th>Estoque</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Placa de Vídeo RTX 3060</td>
                                            <td>Hardware</td>
                                            <td>8</td>
                                            <td><span class="badge bg-success status-badge">Disponível</span></td>
                                        </tr>
                                        <tr>
                                            <td>Processador Intel i7-10700K</td>
                                            <td>Hardware</td>
                                            <td>3</td>
                                            <td><span class="badge bg-warning status-badge text-dark">Baixo</span></td>
                                        </tr>
                                        <tr>
                                            <td>Fonte 600W 80 Plus</td>
                                            <td>Hardware</td>
                                            <td>0</td>
                                            <td><span class="badge bg-danger status-badge">Esgotado</span></td>
                                        </tr>
                                        <tr>
                                            <td>Cabo HDMI 2.0</td>
                                            <td>Cabos</td>
                                            <td>25</td>
                                            <td><span class="badge bg-success status-badge">Disponível</span></td>
                                        </tr>
                                        <tr>
                                            <td>Teclado Mecânico</td>
                                            <td>Periféricos</td>
                                            <td>2</td>
                                            <td><span class="badge bg-warning status-badge text-dark">Baixo</span></td>
                                        </tr>
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
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" placeholder="Pesquisar peças..." id="pesquisaPecas">
                                <button class="btn btn-outline-secondary" type="button" id="btnPesquisarPecas">
                                    Pesquisar
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="filtroCategoria">
                                <option value="" selected>Todas categorias</option>
                                <option value="hardware">Hardware</option>
                                <option value="perifericos">Periféricos</option>
                                <option value="cabos">Cabos</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="filtroStatus">
                                <option value="" selected>Todos status</option>
                                <option value="disponivel">Disponível</option>
                                <option value="baixo">Estoque Baixo</option>
                                <option value="esgotado">Esgotado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm" id="ordenacaoPecas">
                                <option value="nome_asc" selected>Nome (A-Z)</option>
                                <option value="nome_desc">Nome (Z-A)</option>
                                <option value="estoque_desc">Maior Estoque</option>
                                <option value="estoque_asc">Menor Estoque</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary btn-sm w-100" id="btnLimparFiltros">
                                <i class="bi bi-arrow-clockwise me-1"></i> Limpar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tabela de peças -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" id="tabelaPecas">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Fornecedor</th>
                                    <th scope="col">Estoque Atual</th>
                                    <th scope="col">Estoque Mínimo</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">PÇ-001</th>
                                    <td>Placa de Vídeo RTX 3060</td>
                                    <td>Hardware</td>
                                    <td>TecnoParts</td>
                                    <td>8</td>
                                    <td>5</td>
                                    <td><span class="badge bg-success">Disponível</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary btn-action" title="Alterar" onclick="editarPeca('PÇ-001')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" title="Excluir" onclick="excluirPeca('PÇ-001')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">PÇ-002</th>
                                    <td>Processador Intel i7-10700K</td>
                                    <td>Hardware</td>
                                    <td>Chipset Brasil</td>
                                    <td>3</td>
                                    <td>4</td>
                                    <td><span class="badge bg-warning text-dark">Estoque Baixo</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary btn-action" title="Alterar" onclick="editarPeca('PÇ-002')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" title="Excluir" onclick="excluirPeca('PÇ-002')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">PÇ-003</th>
                                    <td>Fonte 600W 80 Plus</td>
                                    <td>Hardware</td>
                                    <td>EnergPower</td>
                                    <td>0</td>
                                    <td>3</td>
                                    <td><span class="badge bg-danger">Esgotado</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary btn-action" title="Alterar" onclick="editarPeca('PÇ-003')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" title="Excluir" onclick="excluirPeca('PÇ-003')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">PÇ-004</th>
                                    <td>Cabo HDMI 2.0</td>
                                    <td>Cabos</td>
                                    <td>ConectaMais</td>
                                    <td>25</td>
                                    <td>10</td>
                                    <td><span class="badge bg-success">Disponível</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary btn-action" title="Alterar" onclick="editarPeca('PÇ-004')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" title="Excluir" onclick="excluirPeca('PÇ-004')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">PÇ-005</th>
                                    <td>Teclado Mecânico</td>
                                    <td>Periféricos</td>
                                    <td>TypeTech</td>
                                    <td>2</td>
                                    <td>5</td>
                                    <td><span class="badge bg-warning text-dark">Estoque Baixo</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary btn-action" title="Alterar" onclick="editarPeca('PÇ-005')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-action" title="Excluir" onclick="excluirPeca('PÇ-005')">
                                            <i class="bi bi-trash"></i>
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
                    <h5 class="modal-title">Adicionar Nova Peça</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPeca">
                        <div class="mb-3">
                            <label for="nomePeca" class="form-label">Nome da Peça</label>
                            <input type="text" class="form-control" id="nomePeca" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoriaPeca" class="form-label">Categoria</label>
                            <select class="form-select" id="categoriaPeca" required>
                                <option value="" selected disabled>Selecione uma categoria</option>
                                <option value="hardware">Hardware</option>
                                <option value="perifericos">Periféricos</option>
                                <option value="cabos">Cabos</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fornecedorPeca" class="form-label">Fornecedor</label>
                            <input type="text" class="form-control" id="fornecedorPeca">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estoqueAtual" class="form-label">Estoque Atual</label>
                                <input type="number" class="form-control" id="estoqueAtual" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estoqueMinimo" class="form-label">Estoque Mínimo</label>
                                <input type="number" class="form-control" id="estoqueMinimo" min="0" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnSalvarPeca">Salvar</button>
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
                    data: [65, 20, 10, 5],
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
        function editarPeca(id) {
            console.log('Editando peça:', id);
            // Abrir modal de edição
            const modal = new bootstrap.Modal(document.getElementById('modalAdicionarPeca'));
            document.getElementById('modalAdicionarPeca').querySelector('.modal-title').textContent = 'Editar Peça';
            // Futuramente: carregar dados da peça via AJAX/PHP
            modal.show();
        }
        
        function excluirPeca(id) {
            console.log('Excluindo peça:', id);
            if (confirm('Tem certeza que deseja excluir esta peça?')) {
                // Futuramente: enviar requisição AJAX para exclusão
            }
        }
        
        // Event listeners para filtros
        document.getElementById('btnPesquisarPecas').addEventListener('click', function() {
            const termo = document.getElementById('pesquisaPecas').value;
            console.log('Pesquisando peças por:', termo);
            aplicarFiltros();
        });
        
        document.getElementById('btnLimparFiltros').addEventListener('click', function() {
            document.getElementById('pesquisaPecas').value = '';
            document.getElementById('filtroCategoria').value = '';
            document.getElementById('filtroStatus').value = '';
            document.getElementById('ordenacaoPecas').value = 'nome_asc';
            aplicarFiltros();
        });
        
        // Outros event listeners para filtros
        document.getElementById('filtroCategoria').addEventListener('change', aplicarFiltros);
        document.getElementById('filtroStatus').addEventListener('change', aplicarFiltros);
        document.getElementById('ordenacaoPecas').addEventListener('change', aplicarFiltros);
        
        function aplicarFiltros() {
            const categoria = document.getElementById('filtroCategoria').value;
            const status = document.getElementById('filtroStatus').value;
            const ordem = document.getElementById('ordenacaoPecas').value;
            const termo = document.getElementById('pesquisaPecas').value;
            
            console.log('Aplicando filtros:', { categoria, status, ordem, termo });
            // Futuramente: enviar requisição para backend PHP com os filtros
        }
        
        // Event listener para salvar peça
        document.getElementById('btnSalvarPeca').addEventListener('click', function() {
            const nome = document.getElementById('nomePeca').value;
            const categoria = document.getElementById('categoriaPeca').value;
            const fornecedor = document.getElementById('fornecedorPeca').value;
            const estoqueAtual = document.getElementById('estoqueAtual').value;
            const estoqueMinimo = document.getElementById('estoqueMinimo').value;
            
            console.log('Salvando peça:', { nome, categoria, fornecedor, estoqueAtual, estoqueMinimo });
            
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
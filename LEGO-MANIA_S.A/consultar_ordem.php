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
                    <!-- Cabeçalho com título e botão de nova solicitação -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Solicitações de Serviço</h5>
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Nova Solicitação
                        </button>
                    </div>
                    
                    <!-- Barra de pesquisa e filtros -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body py-2">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" placeholder="Pesquisar solicitações...">
                                        <button class="btn btn-outline-secondary" type="button">Pesquisar</button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select form-select-sm">
                                        <option selected>Todos os status</option>
                                        <option>Concluído</option>
                                        <option>Em Andamento</option>
                                        <option>Aguardando Peças</option>
                                        <option>Pendente</option>
                                        <option>Cancelado</option>
                                    </select>
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
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabela de solicitações -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Tipo Serviço</th>
                                            <th scope="col">Data</th>
                                            <th scope="col">Valor (R$)</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1025</th>
                                            <td>João Silva</td>
                                            <td>Manutenção Preventiva</td>
                                            <td>15/03/2023</td>
                                            <td>120,00</td>
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
                                            <th scope="row">1026</th>
                                            <td>Maria Santos</td>
                                            <td>Reparo Eletrônico</td>
                                            <td>17/03/2023</td>
                                            <td>85,50</td>
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
                                            <th scope="row">1027</th>
                                            <td>Pedro Costa</td>
                                            <td>Troca de Peças</td>
                                            <td>18/03/2023</td>
                                            <td>210,00</td>
                                            <td><span class="badge bg-info">Aguardando Peças</span></td>
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
                                            <th scope="row">1028</th>
                                            <td>Ana Oliveira</td>
                                            <td>Consulta Técnica</td>
                                            <td>20/03/2023</td>
                                            <td>50,00</td>
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
                                            <th scope="row">1029</th>
                                            <td>Carlos Mendes</td>
                                            <td>Manutenção Corretiva</td>
                                            <td>22/03/2023</td>
                                            <td>180,00</td>
                                            <td><span class="badge bg-danger">Cancelado</span></td>
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
                                    <span class="text-muted">Mostrando 5 de 28 registros</span>
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
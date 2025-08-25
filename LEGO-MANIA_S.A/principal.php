<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <!-- script para funcionar o menu dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <title>Home - Lego mania</title>
</head>
<body>
    
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
                <li><a class="dropdown-item" href="cadastro_usuario.php" id="cadastro_usuario">Usuario</a></li>
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
  <div class="flex-grow-1">
    <!-- Header -->
    <nav class="navbar navbar-light bg-white shadow-sm">
      <div class="container-fluid">
        <button class="btn btn-dark" id="menu-toggle"><i class="bi bi-list"></i></button>
        <span class="navbar-brand mb-0 h1">
          <!-- Contéudo que identifica as horas -->
          <small class="text-muted">Horário atual:</small>
          <span id="liveClock" class="badge bg-secondary"></span>
        </span>
      </div>
    </nav>

    <!-- Conteúdo -->
    <div class="p-4">
      <h3>Bem-vindo!</h3>
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>





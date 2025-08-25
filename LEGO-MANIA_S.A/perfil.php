<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body{
            overflow-y: hidden !important;
        }
    </style>
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
            <li><a class="dropdown-item" href="cadastro_usuario.php">Usuario</a></li>
            <li><a class="dropdown-item" href="cadastro_cliente.php">Cliente</a></li>
            <li><a class="dropdown-item" href="cadastro_funcionario.php">Funcionário</a></li>
            <li><a class="dropdown-item" href="cadastro_fornecedor.php">Fornecedor</a></li>
            <li><a class="dropdown-item" href="cadastro_pecas.php">Peças no estoque</a></li>
        </ul>
        </li>
        <li class="nav-item mb-2 dropdown">
          <a class="nav-link text-white dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
          <a class="nav-link text-white dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-tools me-2"></i> Ordem de Serviços 
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="cadastroDropdown">
              <li><a class="dropdown-item" href="nova_ordem.php">Nova O.S</a></li>
              <li><a class="dropdown-item" href="consultar_ordem.php">Consultar</a></li>
              <li><a class="dropdown-item" href="pagamento.php">Pagamento</a></li>
          </ul>
          </li>
          <li class="nav-item mb-2 dropdown">
            <a class="nav-link text-white dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-graph-up me-2"></i> Relatório de Financias
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="cadastroDropdown">
                <li><a class="dropdown-item" href="relatorio_despesas.php">Despesas</a></li>
                <li><a class="dropdown-item" href="relatorio_lucro.php">Ganho Bruto</a></li>
            </ul>
          </li>
          <li class="nav-item mb-2 dropdown">
            <a class="nav-link text-white dropdown-toggle" href="#" id="cadastroDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-boxes me-2"></i> Relatório de Estoque
            </a>
            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="cadastroDropdown">
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
    <div class="flex-grow-1 p-3" style="overflow-y: auto;">
      <div class="container-fluid">
          <!-- Cabeçalho -->
          <div class="d-flex justify-content-between align-items-center mb-4">
              <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Perfil do Usuário</h5>
              <div>
                  <button class="btn btn-outline-secondary btn-sm me-2">
                      <i class="bi bi-printer me-1"></i> Imprimir
                  </button>
              </div>
          </div>
  
          <div class="row">
              <!-- Coluna da foto e informações básicas -->
              <div class="col-lg-4 mb-4">
                  <div class="card shadow-sm h-100">
                      <div class="card-header bg-white py-3">
                          <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Foto de Perfil</h6>
                      </div>
                      <div class="card-body text-center">
                          <img src="/imagem//perfil_funcionario.png" 
                               class="rounded-circle mb-3 border border-3 border-dark shadow-sm" 
                               alt="Foto de Perfil" 
                               width="150" height="150">
                          
                          <h4 class="mb-1">João da Silva</h4>
                          <p class="text-muted mb-3">Usuário</p>
                          
                          <div class="d-grid gap-2">
                            <label class="btn btn-outline-dark btn-sm" style="cursor:pointer; margin:0;">
                                <i class="bi bi-camera me-1"></i> Alterar Foto
                                <input type="file" accept="image/*" style="display:none;">
                            </label>
                          </div> <br>
                          <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-check-circle me-1"></i> Salvar
                          </button>
                      </div>
                  </div>
              </div>
              
              <!-- Coluna das informações detalhadas -->
              <div class="col-lg-8 mb-4">
                  <div class="card shadow-sm h-100">
                      <div class="card-header bg-white py-3">
                          <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informações do Usuário</h6>
                      </div>
                      <div class="card-body">
                          <form>
                              <div class="row mb-3">
                                  <div class="col-md-6">
                                      <label for="nome" class="form-label">Nome Completo</label>
                                      <input type="text" class="form-control" id="nome" value="João da Silva" readonly>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="email" class="form-label">E-mail</label>
                                      <input type="email" class="form-control" id="email" value="joao.silva@exemplo.com" readonly>
                                  </div>
                              </div>
                              
                              <div class="row mb-3">
                                  <div class="col-md-6">
                                      <label for="usuario" class="form-label">Nome de Usuário</label>
                                      <input type="text" class="form-control" id="usuario" value="joao.silva" readonly>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="telefone" class="form-label">Telefone</label>
                                      <input type="tel" class="form-control" id="telefone" value="(11) 99999-9999" readonly>
                                  </div>
                              </div>
                              
                              <div class="row mb-3">
                                  <div class="col-md-6">
                                      <label for="departamento" class="form-label">Departamento</label>
                                      <input type="text" class="form-control" id="departamento" value="TI" readonly>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="cargo" class="form-label">Cargo</label>
                                      <input type="text" class="form-control" id="cargo" value="Analista de Sistemas" readonly>
                                  </div>
                              </div>
                              
                              <hr>
                              
                              <div class="row mb-3">
                                  <div class="col-md-6">
                                      <label for="senha" class="form-label">Senha</label>
                                      <div class="input-group">
                                          <input type="password" class="form-control" id="senha" value="minhasenha" readonly>
                                          <button class="btn btn-outline-secondary" type="button" id="toggleSenha">
                                              <i class="bi bi-eye"></i>
                                          </button>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <label for="ultimoAcesso" class="form-label">Último Acesso</label>
                                      <input type="text" class="form-control" id="ultimoAcesso" value="25/08/2023 14:32" readonly>
                                  </div>
                              </div>
                              
                              <div class="d-flex gap-2 mt-4">
                                  <button type="button" class="btn btn-dark">
                                      <i class="bi bi-pencil me-1"></i> Editar Perfil
                                  </button>
                                  <button type="button" class="btn btn-secondary">
                                      <i class="bi bi-key me-1"></i> Alterar Senha
                                  </button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  
  <script>
      // Alternar visibilidade da senha
      document.getElementById('toggleSenha').addEventListener('click', function() {
          const senhaInput = document.getElementById('senha');
          const tipo = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
          senhaInput.setAttribute('type', tipo);
          this.innerphp = tipo === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
      });
      
      // Funções para integração futura com PHP
      function editarPerfil() {
          console.log('Editando perfil');
          // Futuramente: habilitar edição dos campos
      }
      
      function alterarSenha() {
          console.log('Alterando senha');
          // Futuramente: abrir modal para alteração de senha
      }
  </script>

<!-- Bootstrap JS -->
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>


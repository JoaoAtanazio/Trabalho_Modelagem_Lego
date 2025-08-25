<?php
    session_start();
    require_once 'conexao.php';

    // VERIFICA SE O USUARIO TEM PERMISSÃO DE ADM OU SECRETARIA
    if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=3){
        echo "<script>alert('Acesso negado!');window.location.href='principal.php';</script>";
        exit();
    } 
    $usuario = []; // INICIALIZA A VARIAVEL PARA EVITAR ERROS

    // Buscar Usuario

    // SE O FORMULARIO FOR ENVIADO, BUSCA O USUARIO PELO ID OU NOME
    if($_SERVER["REQUEST_METHOD"]== "POST" && !empty($_POST['busca'])){
        $busca = trim($_POST['busca']);

        // VERIFICA SE A BUSCA É UM NUMERO OU UM NOME.
        if(is_numeric($busca)){
            $sql="SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome_usuario ASC";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca, PDO::PARAM_INT);
        } else {
            $sql="SELECT * FROM usuario WHERE nome_usuario LIKE :busca_nome ORDER BY nome_usuario ASC";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"%$busca%", PDO::PARAM_STR);
        }
    } else {
        $sql="SELECT * FROM usuario ORDER BY nome_usuario ASC";
        $stmt = $pdo->prepare($sql);
    }
        
    // Excluir Usuario

    // Se um id for passado via GET exclui o usuario
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id_usuario = $_GET['id'];

        // Exclui o usuario do banco de dados
        $sql = "DELETE FROM usuario WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id',$id_usuario,PDO::PARAM_INT);

        if($stmt->execute()){
            echo "<script>alert('Usuario excluido com sucesso!');window.location.href='gestao_usuario.php';</script>";
        } else{
            echo "<script>alert('Erro ao excluir o usuario!');</script>";
        }
    }

$stmt->execute();
$usuarios = $stmt->fetchALL(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="css/login.css">
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
                    <!-- Cabeçalho com título e botão de novo funcionário -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Gestão de Usuários</h5>
                        <button class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle me-1"><a href="cadastro_usuario.php" class="novo_usuario"> Novo Usuário</a></i>
                        </button>
                    </div>
                    
                    <!-- Barra de pesquisa e filtros -->
                    <div class="card shadow-sm mb-3">
                        <div class="card-body py-2">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <form action="gestao_usuario.php" method="POST">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" id="busca" name="busca" class="form-control" placeholder="Pesquisar usuários...">
                                            <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-3">
                                    <select name="id_perfil" id="id_perfil" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="">Todos os cargos</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Funcionário</option>
                                        <option value="3">Secretaria</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabela de Usuários -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <?php if(!empty($usuarios)): ?>
                                    <table class="table table-striped table-hover table-bordered mb-0">
                                        <thead class="table-dark">
                                            <tr>
                                                <th><center>ID</center></th>
                                                <th><center>Nome Usuário</center></th>
                                                <th><center>E-mail</center></th>
                                                <th><center>Perfil</center></th>
                                                <th><center>Status</center></th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($usuarios as $usuario): ?>
                                                <tr>
                                                    <td><center><?=htmlspecialchars($usuario['id_usuario'])?></center></td>
                                                    <td><center><?=htmlspecialchars($usuario['nome_usuario'])?></center></td>
                                                    <td><center><?=htmlspecialchars($usuario['email'])?></center></td>
                                                    <td><center><?=htmlspecialchars($usuario['id_perfil'])?></center></td>
                                                    <td><span class="badge bg-success">Ativo</span></td>
                                                    <td class="text-center">
                                                        <a href="#" class="btn btn-sm btn-primary me-1" onclick="carregarDadosUsuario(<?=htmlspecialchars($usuario['id_usuario'])?>)">Alterar</a>
                                                        <a href="gestao_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                                                        <a href="ocultar_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>" class="btn btn-sm btn-secondary">Ocultar</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>

                                <?php else: ?><br>
                                    <center><p>Nenhum usuário encontrado.</p></center>
                                <?php endif; ?>
  
                        </div>
                        <div class="card-footer py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Mostrando 5 de 18 funcionários</span>
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

            <!-- Modal para Alterar Usuário -->
            <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Alterar Usuário</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="alterar_usuario.php">
                            <div class="modal-body">
                                <input type="hidden" id="id_usuario" name="id_usuario">
                                
                                <div class="mb-3">
                                    <label for="nome_usuario" class="form-label">Nome do Usuário</label>
                                    <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="senha" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="senha" name="senha">
                                        <button type="button" class="btn btn-outline-secondary" id="toggleSenha">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" name="alterar_usuario" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
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

        // Função para carregar dados do usuário no modal
        function carregarDadosUsuario(id) {
            fetch('buscar_usuario.php?id=' + id)
                .then(response => response.json())
                .then(usuario => {
                    document.getElementById('id_usuario').value = usuario.id_usuario;
                    document.getElementById('nome_usuario').value = usuario.nome_usuario;
                    document.getElementById('email').value = usuario.email;
                    
                    // Abre o modal
                    var modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
                    modal.show();
                })
                .catch(error => console.error('Erro:', error));
        }

        // Alternar visibilidade da senha
        document.getElementById('toggleSenha').addEventListener('click', function() {
            const senhaInput = document.getElementById('senha');
            const tipo = senhaInput.getAttribute('type') === 'password' ? 'text' : 'password';
            senhaInput.setAttribute('type', tipo);
            this.innerHTML = tipo === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
        });
    </script>


</body>
</html>
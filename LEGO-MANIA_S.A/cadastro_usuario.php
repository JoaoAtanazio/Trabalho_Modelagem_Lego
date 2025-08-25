<?php
session_start();
require_once 'conexao.php';

// VERIFICA SE O USUARIO TEM PERMISSÃO
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso Negado!'); window.location.href='principal.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome_usuario = $_POST['nome_usuario'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $id_perfil = $_POST['id_perfil'];

    $sql = "INSERT INTO usuario(nome_usuario, email, senha, id_perfil) VALUES (:nome_usuario, :email, :senha, :id_perfil)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome_usuario', $nome_usuario);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':id_perfil', $id_perfil);

    if ($stmt->execute()) {
        // REGISTRAR LOG - APÓS INSERT BEM-SUCEDIDO
        $id_novo_usuario = $pdo->lastInsertId();
        
        // Descobrir o nome do perfil para incluir na ação
        $sql_perfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
        $stmt_perfil = $pdo->prepare($sql_perfil);
        $stmt_perfil->bindParam(':id_perfil', $id_perfil);
        $stmt_perfil->execute();
        $perfil = $stmt_perfil->fetch(PDO::FETCH_ASSOC);
        $nome_perfil = $perfil['nome_perfil'];
        
        // Incluir informações na ação
        $acao = "Cadastro de usuário: " . $nome_usuario . " (" . $email . ") como " . $nome_perfil;
        
        // Registrar o log
        if (function_exists('registrarLog')) {
            registrarLog($acao, "usuario", $id_novo_usuario);
        } else {
            error_log("Função registrarLog não encontrada!");
        }
        
        echo "<script>alert('Usuário cadastrado com sucesso!');</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuário!');</script>";
    }
}

// Buscar perfis para o dropdown
$sql_perfis = "SELECT * FROM perfil";
$stmt_perfis = $pdo->query($sql_perfis);
$perfis = $stmt_perfis->fetchAll(PDO::FETCH_ASSOC);


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
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white py-2">
                                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Cadastro de Usuario</h5>
                                </div>
                                <div class="card-body p-3">
                                    <form action="cadastro_usuario.php" method="POST">
                                        <!-- Nome -->
                                        <div class="mb-2">
                                            <label for="nome_usuario" class="form-label">Nome</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" class="form-control" id="nome_usuario" name="nome_usuario" placeholder="Digite o nome completo" required>
                                            </div>
                                        </div>
            
                                        <!-- Perfil -->
                                        <div class="mb-2">
                                            <label for="id_perfil" class="form-label">Perfil</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-person-rolodex"></i></span>
                                                <select class="form-select" id="id_perfil" name="id_perfil" required>
                                                    <option value="" selected disabled>Selecione o perfil</option>
                                                    <option value="1">Administrador</option>
                                                    <option value="2">Funcionario</option>
                                                    <option value="3">Secretaria</option>
                                                    <option value="4">Técnico</option>
                                                </select>
                                            </div>
                                        </div>
            
                                        <!-- Email -->
                                        <div class="mb-2">
                                            <label for="email" class="form-label">E-mail</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="funcionario@empresa.com" required>
                                            </div>
                                        </div>
            
                                        <!-- Senha -->
                                        <div class="mb-2">
                                            <label for="senha" class="form-label">Senha</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Crie uma senha" required>
                                            </div>
                                        </div>
            
                                        <!-- Botões -->
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="reset" class="btn btn-outline-secondary btn-sm me-md-2">
                                                <i class="bi bi-x-circle"></i> Limpar
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-check-circle"></i> Cadastrar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-muted text-center py-2">
                                    <small>Todos os campos são obrigatórios</small>
                                </div>
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


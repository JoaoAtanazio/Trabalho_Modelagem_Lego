<?php
session_start();
require_once 'conexao.php';

// VERIFICA SE O USUARIO ESTÁ LOGADO E TEM PERMISSÃO
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso Negado! Faça login primeiro.'); window.location.href='index.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Recebe e sanitiza os dados do formulário
    $nome_fornecedor = trim($_POST['nome_fornecedor']);
    $cpf_cnpj = preg_replace('/[^0-9]/', '', $_POST['cpf_cnpj']);
    $ramo_atividade = trim($_POST['ramo']);
    $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);
    $endereco = trim($_POST['endereco']);
    $bairro = trim($_POST['bairro']);
    $cep = preg_replace('/[^0-9]/', '', $_POST['cep']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $email = trim($_POST['email']);
    
    // ID do usuário que está cadastrando (para log)
    $id_usuario_cadastrante = $_SESSION['id_usuario'];

    // Validações básicas
    if (empty($nome_fornecedor) || empty($cpf_cnpj) || empty($telefone) || empty($email)) {
        echo "<script>alert('Preencha todos os campos obrigatórios!');</script>";
        exit();
    }

    // Validar CPF (11 dígitos) ou CNPJ (14 dígitos)
    if (strlen($cpf_cnpj) != 11 && strlen($cpf_cnpj) != 14) {
        echo "<script>alert('CPF/CNPJ inválido! Deve ter 11 ou 14 dígitos.');</script>";
        exit();
    }

    try {
        // Verificar se CPF/CNPJ já existe
        $verificaCPF = $pdo->prepare("SELECT COUNT(*) FROM fornecedor WHERE cpf_cnpj = :cpf_cnpj");
        $verificaCPF->bindParam(':cpf_cnpj', $cpf_cnpj, PDO::PARAM_STR);
        $verificaCPF->execute();

        if ($verificaCPF->fetchColumn() > 0) {
            echo "<script>alert('Erro: CPF/CNPJ já cadastrado no sistema!');</script>";
            exit();
        }

        // Prepara a query SQL para inserir na tabela fornecedor
        $sql = "INSERT INTO fornecedor (id_funcionario, nome_fornecedor, cpf_cnpj, ramo_atividade, telefone, endereco, bairro, cep, cidade, estado, email) 
                VALUES (:id_funcionario, :nome_fornecedor, :cpf_cnpj, :ramo_atividade, :telefone, :endereco, :bairro, :cep, :cidade, :estado, :email)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_funcionario', $id_usuario_cadastrante, PDO::PARAM_INT);
        $stmt->bindParam(':nome_fornecedor', $nome_fornecedor, PDO::PARAM_STR);
        $stmt->bindParam(':cpf_cnpj', $cpf_cnpj, PDO::PARAM_STR);
        $stmt->bindParam(':ramo_atividade', $ramo_atividade, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':cep', $cep, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // REGISTRAR LOG - APÓS INSERT BEM-SUCEDIDO
            $id_novo_fornecedor = $pdo->lastInsertId();
            
            // Incluir informações na ação
            $acao = "Cadastro de fornecedor: " . $nome_fornecedor . " (" . $cpf_cnpj . ")";
            
            // Registrar o log
            if (function_exists('registrarLog')) {
                registrarLog($id_usuario_cadastrante, $acao, "fornecedor", $id_novo_fornecedor);
            } else {
                error_log("Função registrarLog não encontrada! Ação: " . $acao);
            }
            
            echo "<script>
                alert('Fornecedor cadastrado com sucesso!');
                window.location.href = 'cadastro_fornecedor.php';
            </script>";
        } else {
            echo "<script>alert('Erro ao cadastrar fornecedor!');</script>";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Erro: CPF/CNPJ já cadastrado no sistema!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar fornecedor: " . addslashes($e->getMessage()) . "');</script>";
            error_log("Erro PDO: " . $e->getMessage());
        }
    }
}
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
                                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Cadastro de Fornecedor</h5>
                                </div>
                                <div class="card-body p-3">
                                    <form action="cadastro_fornecedor.php" method="POST">
                                        <!-- Nome do Fornecedor -->
                                        <div class="mb-2">
                                            <label for="nome_fornecedor" class="form-label">Nome do Fornecedor *</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                <input type="text" class="form-control" id="nome_fornecedor" name="nome_fornecedor" placeholder="Digite o nome do fornecedor" oninput="this.value=this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g,'')" required>
                                            </div>
                                        </div>
            
                                        <!-- CPF/CNPJ -->
                                        <div class="mb-2">
                                            <label for="cpf_cnpj" class="form-label">CPF ou CNPJ *</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-card-checklist"></i></span>
                                                <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" placeholder="000.000.000-00 ou 00.000.000/0000-00" required>
                                            </div>
                                            <div class="form-text">Digite apenas números</div>
                                        </div>
            
                                        <!-- Telefone -->
                                        <div class="mb-2">
                                            <label for="telefone" class="form-label">Telefone *</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
                                            </div>
                                        </div>
            
                                        <!-- Ramo de Atividade -->
                                        <div class="mb-2">
                                            <label for="ramo" class="form-label">Ramo de Atividade</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                                <input type="text" class="form-control" id="ramo" name="ramo" placeholder="Digite o ramo de atividade">
                                            </div>
                                        </div>
            
                                        <div class="mb-2">
                                            <label for="endereco" class="form-label">Endereço:</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Digite seu endereço">
                                            </div>
                                        </div>
                            
                                        <div class="row mb-2">
                                            <div class="col-md-8">
                                                <label for="bairro" class="form-label">Bairro:</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                                    <input type="text" class="form-control" id="bairro" name="bairro" placeholder="Digite seu bairro">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="cep" class="form-label">CEP:</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                                    <input type="text" class="form-control" id="cep" name="cep" placeholder="00000-000">
                                                    <button class="btn btn-outline-secondary" type="button" id="buscarCep" name="buscarCep">
                                                        <i class="bi bi-search"></i> Buscar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="row mb-2">
                                            <div class="col-md-8">
                                                <label for="cidade" class="form-label">Cidade:</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                                    <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Digite sua cidade">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="estado" class="form-label">Estado:</label>
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text"><i class="bi bi-geo"></i></span>
                                                    <select class="form-select" id="estado" name="estado">
                                                        <option value="" selected disabled>Selecione</option>
                                                        <option value="AC">AC</option>
                                                        <option value="AL">AL</option>
                                                        <option value="AM">AM</option>
                                                        <option value="AP">AP</option>
                                                        <option value="BA">BA</option>
                                                        <option value="CE">CE</option>
                                                        <option value="DF">DF</option>
                                                        <option value="ES">ES</option>
                                                        <option value="GO">GO</option>
                                                        <option value="MA">MA</option>
                                                        <option value="MG">MG</option>
                                                        <option value="MS">MS</option>
                                                        <option value="MT">MT</option>
                                                        <option value="PA">PA</option>
                                                        <option value="PB">PB</option>
                                                        <option value="PE">PE</option>
                                                        <option value="PI">PI</option>
                                                        <option value="PR">PR</option>
                                                        <option value="RJ">RJ</option>
                                                        <option value="RN">RN</option>
                                                        <option value="RO">RO</option>
                                                        <option value="RR">RR</option>
                                                        <option value="RS">RS</option>
                                                        <option value="SC">SC</option>
                                                        <option value="SE">SE</option>
                                                        <option value="SP">SP</option>
                                                        <option value="TO">TO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
            
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email" class="form-label">E-mail *</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="fornecedor@empresa.com" required>
                                            </div>
                                        </div>
            
                                        <!-- Botões -->
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="reset" class="btn btn-outline-secondary btn-sm me-md-2">
                                                <i class="bi bi-x-circle"></i> Limpar
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-sm" id="botaocadastro">
                                                <i class="bi bi-check-circle"></i> Cadastrar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-muted text-center py-2">
                                    <small>Campos marcados com * são obrigatórios</small>
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

        // Formatação do campo de CPF/CNPJ
        document.getElementById('cpf_cnpj').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            // Verifica se é CPF (até 11 dígitos) ou CNPJ (mais de 11 dígitos)
            if (value.length <= 11) {
                // Formatação para CPF
                if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1.$2.$3');
                } else if (value.length > 3) {
                    value = value.replace(/(\d{3})(\d+)/, '$1.$2');
                }
            } else {
                // Formatação para CNPJ (limita a 14 dígitos)
                if (value.length > 14) value = value.slice(0, 14);
                
                if (value.length > 12) {
                    value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
                } else if (value.length > 8) {
                    value = value.replace(/(\d{2})(\d{3})(\d{3})(\d+)/, '$1.$2.$3/$4');
                } else if (value.length > 5) {
                    value = value.replace(/(\d{2})(\d{3})(\d+)/, '$1.$2.$3');
                }
            }
            e.target.value = value;
        });

        // Formatação do campo de telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 10) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length > 6) {
                value = value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/(\d{2})(\d+)/, '($1) $2');
            }
            e.target.value = value;
        });

        // Buscar CEP via API
        document.getElementById('buscarCep').addEventListener('click', function() {
            const cep = document.getElementById('cep').value.replace(/\D/g, '');
            
            if (cep.length !== 8) {
                alert('CEP inválido! Digite um CEP com 8 dígitos.');
                return;
            }
        
            // Mostrar loading
            this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Buscando...';
            this.disabled = true;
            
            // Fazer requisição para a API ViaCEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        alert('CEP não encontrado!');
                        return;
                    }
                    
                    // Preencher os campos com os dados retornados
                    document.getElementById('endereco').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                })
                .catch(error => {
                    console.error('Erro ao buscar CEP:', error);
                    alert('Erro ao buscar CEP. Tente novamente.');
                })
                .finally(() => {
                    // Restaurar botão
                    this.innerHTML = '<i class="bi bi-search"></i> Buscar';
                    this.disabled = false;
                });
        });

        // Formatação do campo de CEP
        document.getElementById('cep').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) value = value.slice(0, 8);
            
            if (value.length > 5) {
                value = value.replace(/(\d{5})(\d{3})/, '$1-$2');
            }
            e.target.value = value;
        });
</script>
</body>
</html>
<?php
session_start();
require_once 'conexao.php';
require_once 'php/permissoes.php';

// VERIFICA SE O USUARIO ESTÁ LOGADO
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso Negado! Faça login primeiro.'); window.location.href='index.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Recebe e sanitiza os dados do formulário
    $id_funcionario = $_SESSION['id_usuario']; 
    $nome_client_ordem = $_POST['cliente'];
    $tecnico = $_POST['tecnico'];
    $marca_aparelho = $_POST['marca_aparelho'];
    $tempo_uso = $_POST['tempo_uso'];
    $problema = $_POST['problema'];
    $prioridade = $_POST['prioridade'];
    $observacao = $_POST['observacao'];
    $dt_recebimento = $_POST['dt_recebimento'];
    $valor_total = $_POST['valor_total'];
    $metodo_pag = $_POST['metodo_pag'];

    try {
        $sql = "INSERT INTO nova_ordem(id_funcionario,nome_client_ordem,tecnico,marca_aparelho,tempo_uso,problema,prioridade,observacao,dt_recebimento,valor_total,metodo_pag) 
                VALUES (:id_funcionario,:nome_client_ordem,:tecnico,:marca_aparelho,:tempo_uso,:problema,:prioridade,:observacao,:dt_recebimento,:valor_total,:metodo_pag)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_funcionario', $id_funcionario, PDO::PARAM_INT);
        $stmt->bindParam(':nome_client_ordem', $nome_client_ordem, PDO::PARAM_STR);
        $stmt->bindParam(':tecnico', $tecnico, PDO::PARAM_STR);
        $stmt->bindParam(':marca_aparelho', $marca_aparelho, PDO::PARAM_STR);
        $stmt->bindParam(':tempo_uso', $tempo_uso, PDO::PARAM_STR);
        $stmt->bindParam(':problema', $problema, PDO::PARAM_STR);
        $stmt->bindParam(':prioridade', $prioridade);
        $stmt->bindParam(':observacao', $observacao, PDO::PARAM_STR);
        $stmt->bindParam(':dt_recebimento', $dt_recebimento);
        $stmt->bindParam(':valor_total', $valor_total);
        $stmt->bindParam(':metodo_pag', $metodo_pag);

        if ($stmt->execute()) {
            // REGISTRAR LOG - APÓS INSERT BEM-SUCEDIDO
            $id_nova_ordem = $pdo->lastInsertId();
            
            // Incluir informações na ação
            $acao = "Abertura de Ordem de serviço: " . $nome_client_ordem . " (" . $tecnico . ")";
            
            // Registrar o log
            if (function_exists('registrarLog')) {
                registrarLog($_SESSION['id_usuario'], $acao, "ordem", $id_nova_ordem);
            } else {
                error_log("Função registrarLog não encontrada! Ação: " . $acao);
            }
            
            echo "<script>
                alert('Ordem cadastrada com sucesso!');
                window.location.href = 'cadastro_cliente.php';
            </script>";
        } else {
            echo "<script>alert('Erro ao cadastrar ordem!');</script>";
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Erro: CPF/CNPJ já cadastrado no sistema!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar ordem: " . addslashes($e->getMessage()) . "');</script>";
            error_log("Erro PDO: " . $e->getMessage());
        }
    }
}

    // Buscar clientes para exibição (se necessário)
    $sql_ordem = "SELECT * FROM nova_ordem";
    $stmt_ordem = $pdo->query($sql_ordem);
    $clientes = $stmt_ordem->fetchAll(PDO::FETCH_ASSOC);

    // Buscar técnicos do banco
    $sql_tecnicos = "SELECT id_usuario, nome_usuario FROM usuario WHERE id_perfil = 4 AND status = 'ativo' ORDER BY nome_usuario";
    $stmt_tecnicos = $pdo->query($sql_tecnicos);
    $tecnicos = $stmt_tecnicos->fetchAll(PDO::FETCH_ASSOC);
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
            <div class="flex-grow-1 p-3" style="overflow-y: auto;">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white py-2">
                                    <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Nova Ordem de Serviço</h5>
                                </div>
                                <div class="card-body p-3">
                                    <form action="nova_ordem.php" method="POST">
                                        <!-- Técnico -->
                                        <div class="mb-2">
                                            <label for="tecnico" class="form-label">Técnico</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-person-gear"></i></span>
                                                <select class="form-select" id="tecnico" name="tecnico" required>
                                                    <option value="" selected disabled>Selecione o técnico</option>
                                                    <?php foreach ($tecnicos as $tecnico): ?>
                                                        <option value="<?= $tecnico['id_usuario'] ?>">
                                                            <?= htmlspecialchars($tecnico['nome_usuario']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
            
                                        <!-- Nome do Cliente -->
                                        <div class="mb-2">
                                            <label for="cliente" class="form-label">Nome do Cliente</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" class="form-control" name="cliente" id="nome_client_ordem" placeholder="Digite o nome do cliente" required>
                                            </div>
                                        </div>
            
                                        <!-- Marca do Aparelho -->
                                        <div class="mb-2">
                                            <label for="marca" class="form-label">Marca do Aparelho</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-device-ssd"></i></span>
                                                <input type="text" class="form-control" id="marca_aparelho" name="marca_aparelho" placeholder="Digite a marca do aparelho" required>
                                            </div>
                                        </div>
            
                                        <!-- Tempo de Uso -->
                                        <div class="mb-2">
                                            <label for="tempo_uso" class="form-label">Tempo de Uso</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-clock-history"></i></span>
                                                <input type="text" class="form-control" id="tempo_uso" name="tempo_uso" placeholder="Ex: 2 anos, 6 meses" required>
                                            </div>
                                        </div>
            
                                        <!-- Problema -->
                                        <div class="mb-2">
                                            <label for="problema" class="form-label">Problema</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-exclamation-triangle"></i></span>
                                                <textarea class="form-control" id="problema" name="problema" placeholder="Descreva o problema relatado" rows="2" required></textarea>
                                            </div>
                                        </div>
            
                                        <!-- Observação -->
                                        <div class="mb-2">
                                            <label for="observacao" class="form-label">Observação</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
                                                <textarea class="form-control" id="observacao" name="observacao" placeholder="Observações adicionais" rows="2"></textarea>
                                            </div>
                                        </div>
            
                                        <!-- Data de Recebimento -->
                                        <div class="mb-2">
                                            <label for="data_recebimento" class="form-label">Data de Recebimento</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                                                <input type="date" class="form-control" id="dt_recebimento" name="dt_recebimento" required>
                                            </div>
                                        </div>

            
                                        <!-- Prioridade do Conserto -->
                                        <div class="mb-3">
                                            <label for="prioridade" class="form-label">Prioridade do Conserto</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-arrow-up-right-circle"></i></span>
                                                <select class="form-select" id="prioridade" name="prioridade" required>
                                                    <option value="" selected disabled>Selecione a prioridade</option>
                                                    <option value="baixa">Baixa</option>
                                                    <option value="media">Média</option>
                                                    <option value="alta">Alta</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Valor da Ordem -->
                                        <div class="mb-2">
                                            <label for="valor_total" class="form-label">Valor Total</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                                <input type="text" class="form-control" id="valor_total" name="valor_total" placeholder="R$ 0,00" required>
                                            </div>
                                        </div>

                                        <div class="mb-2">
                                            <label for="metodo_pag" class="form-label">Método de pagamento</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                                <input type="text" class="form-control" id="metodo_pag" name="metodo_pag" placeholder="Pix / Cartão / Dinheiro" required>
                                            </div>
                                        </div>
            
                                        <!-- Botões -->
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="reset" class="btn btn-outline-secondary btn-sm me-md-2">
                                                <i class="bi bi-x-circle"></i> Limpar
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-check-circle"></i> Criar O.S.
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

        function selecionarTecnico() {
            document.getElementById('id_perfil')
        }

        setInterval(updateClock, 1000);
        updateClock(); // Inicializa imediatamente
    </script>

</body>
</html>
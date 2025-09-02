<?php
// permissoes.php
// Verificar se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit();
}

// Definição das permissões por perfil
$permissoes = [
    // nível 1: Administrador
    1 => [
        "Início" => ["principal.php"],
        "Perfil" => ["perfil.php"],
        "Cadastro" => [
            "cadastro_usuario.php", "cadastro_cliente.php", "cadastro_funcionario.php",
            "cadastro_fornecedor.php", "cadastro_pecas.php"
        ],
        "Gestão de Pessoas" => [
            "gestao_usuario.php", "gestao_cliente.php", "gestao_funcionario.php",
            "gestao_fornecedor.php"
        ],
        "Ordem de Serviços" => ["nova_ordem.php", "consultar_ordem.php", "pagamento.php"],
        "Relatório de Finanças" => ["relatorio_despesas.php", "relatorio_lucro.php"],
        "Relatório de Estoque" => [
            "relatorio_saida.php", "relatorio_pecas_estoque.php", "relatorio_uso.php"
        ],
        "Logs" => ["logs.php"],
    ],
    2 => [
        "Início" => ["principal.php"],
        "Perfil" => ["perfil.php"],
        "Cadastro" => [
            "cadastro_cliente.php", "cadastro_funcionario.php",
            "cadastro_fornecedor.php", "cadastro_pecas.php"
        ],
        "Gestão de Pessoas" => ["gestao_cliente.php"],
        "Ordem de Serviços" => ["nova_ordem.php", "consultar_ordem.php", "pagamento.php"],
        "Relatório de Estoque" => [
            "relatorio_saida.php", "relatorio_pecas_estoque.php", "relatorio_uso.php"
        ],
    ],
    3 => [
        "Início" => ["principal.php"],
        "Perfil" => ["perfil.php"],
        "Cadastro" => ["cadastro_cliente.php"],
        "Gestão de Pessoas" => ["gestao_cliente.php"],
        "Ordem de Serviços" => ["nova_ordem.php", "consultar_ordem.php", "pagamento.php"],
    ],
    4 => [
        "Início" => ["principal.php"],
        "Perfil" => ["perfil.php"],
        "Cadastro" => ["cadastro_pecas.php"],
        "Ordem de Serviços" => ["nova_ordem.php", "consultar_ordem.php", "pagamento.php"],
        "Relatório de Estoque" => [
            "relatorio_saida.php", "relatorio_pecas_estoque.php", "relatorio_uso.php"
        ],
    ],
];

// Obtendo as opções disponíveis para o perfil logado
$id_perfil = $_SESSION['perfil'];
$opcoes_menu = isset($permissoes[$id_perfil]) ? $permissoes[$id_perfil] : [];

// Definir ícones para cada categoria
$icones_menu = [
    "Início" => "bi-house-door",
    "Perfil" => "bi-person",
    "Cadastro" => "bi-person-plus",
    "Gestão de Pessoas" => "bi-people",
    "Ordem de Serviços" => "bi-tools",
    "Relatório de Finanças" => "bi-graph-up",
    "Relatório de Estoque" => "bi-boxes",
    "Logs" => "bi-clock-history"
];

// Função para formatar o nome de exibição removendo prefixos
function formatarNomeExibicao($nomeArquivo) {
    // Remove a extensão .php
    $nome = basename($nomeArquivo, ".php");
    
    // Remove prefixos comuns
    $prefixos = ['cadastro_', 'gestao_', 'relatorio_'];
    
    foreach ($prefixos as $prefixo) {
        if (strpos($nome, $prefixo) === 0) {
            $nome = substr($nome, strlen($prefixo));
            break;
        }
    }
    
    // Converte underlines para espaços e capitaliza
    $nome = str_replace("_", " ", $nome);
    $nome = ucwords($nome);
    
    return $nome;
}

// Mapeamento manual de IDs para cada item do menu
$ids = [
    "principal.php" => "menu-inicio",
    "perfil.php" => "menu-perfil",
    
    // Cadastro
    "cadastro_usuario.php" => "cadastro_usuario",
    "cadastro_cliente.php" => "cadastro_cliente",
    "cadastro_funcionario.php" => "cadastro_funcionario",
    "cadastro_fornecedor.php" => "cadastro_fornecedor",
    "cadastro_pecas.php" => "cadastro_pecas",
    
    // Gestão
    "gestao_usuario.php" => "menu-gestao-usuario",
    "gestao_cliente.php" => "menu-gestao-cliente",
    "gestao_funcionario.php" => "menu-gestao-funcionario",
    "gestao_fornecedor.php" => "menu-gestao-fornecedor",
    
    // Ordem de Serviços
    "nova_ordem.php" => "nova_ordem",
    "consultar_ordem.php" => "menu-consultar-ordem",
    "pagamento.php" => "menu-pagamento",
    
    // Relatório de Finanças
    "relatorio_despesas.php" => "menu-relatorio-despesas",
    "relatorio_lucro.php" => "menu-relatorio-lucro",
    
    // Relatório de Estoque
    "relatorio_saida.php" => "menu-relatorio-saida",
    "relatorio_pecas_estoque.php" => "menu-relatorio-pecas",
    "relatorio_uso.php" => "menu-relatorio-uso",
    
    // Logs
    "logs.php" => "menu-logs"
];

// Função para obter ID manual baseado no arquivo
function obterIdManual($arquivo) {
    global $ids;
    return isset($ids[$arquivo]) ? $ids[$arquivo] : 'menu-' . basename($arquivo, '.php');
}

// Função para gerar o menu
function gerarMenu($opcoes_menu, $icones_menu) {
    $html = '';
    
    foreach ($opcoes_menu as $categoria => $arquivos) {
        $icone = isset($icones_menu[$categoria]) ? $icones_menu[$categoria] : "bi-circle";
        
        if (count($arquivos) > 1) {
            // Menu dropdown
            $html .= '<li class="nav-item mb-2 dropdown">';
            $html .= '<a class="nav-link text-white dropdown-toggle" href="#" id="menu-' . strtolower(str_replace(' ', '-', $categoria)) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
            $html .= '<i class="bi ' . $icone . ' me-2"></i> ' . $categoria;
            $html .= '</a>';
            $html .= '<ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="menu-' . strtolower(str_replace(' ', '-', $categoria)) . '">';
            
            foreach ($arquivos as $arquivo) {
                $nomeExibicao = formatarNomeExibicao($arquivo);
                $html .= '<li><a class="dropdown-item" id="' . obterIdManual($arquivo) . '" href="' . $arquivo . '">' . $nomeExibicao . '</a></li>';
            }
            
            $html .= '</ul>';
            $html .= '</li>';
        } else {
            // Item simples (sem dropdown)
            $html .= '<li class="nav-item mb-2">';
            $html .= '<a id="' . obterIdManual($arquivos[0]) . '" href="' . $arquivos[0] . '" class="nav-link text-white">';
            $html .= '<i class="bi ' . $icone . ' me-2"></i> ' . $categoria;
            $html .= '</a>';
            $html .= '</li>';
        }
    }
    
    return $html;
}

// Gerar o HTML do menu
$menu_html = '
<!-- Sidebar -->
<nav id="sidebar" class="bg-dark text-white p-3" style="width: 250px;">
    <h4 class="mb-4">Menu</h4>
    <ul class="nav flex-column">
        ' . gerarMenu($opcoes_menu, $icones_menu) . '
        <li class="nav-item">
            <a id="menu-sair" href="php/logout.php" class="nav-link text-white"><i class="bi bi-box-arrow-right me-2"></i> Sair</a>
        </li>
    </ul>
</nav>

<!-- Script para alternar o menu -->
<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("d-none");
    });

    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString(\'pt-BR\');
        document.getElementById(\'liveClock\').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
';

// Função para exibir o menu
function exibirMenu() {
    global $menu_html;
    echo $menu_html;
}

// Função para obter o HTML do menu (se precisar manipular antes de exibir)
function obterMenu() {
    global $menu_html;
    return $menu_html;
}
?>
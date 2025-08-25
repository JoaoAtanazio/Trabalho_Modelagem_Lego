<?php
// Informações para o menú dropdown
$id_perfil = $_SESSION['perfil'];
// Definição das permissões por perfil

permissoes = [
    1 => "Cadastro" => ["cadastro_usuario.php","cadastro_cliente.php","cadastro_funcionario.php",
                        "cadastro_fornecedor.php","cadastro_pecas.php"],
         "Gestão de Pessoas" => ["gestao_usuario.php","gestao_cliente.php","gestao_funcionario.php",
                                 "gestao_fornecedor.php"],
         "Ordem de Serviços" => ["nova_ordem.php","consultar_ordem.php","pagamento.php"],
         "Relatório de Finanças" => ["relatorio_despesas.php","relatorio_lucro.php"],
         "Relatório de Estoque" => ["relatorio_saida.php","relatorio_pecas_estoque.php","relatorio_uso.php"],
         "Logs" => ["logs.php"],
]

?>
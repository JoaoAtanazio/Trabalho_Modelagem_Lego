-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/09/2025 às 20:18
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lego_mania`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `cpf_cnpj` varchar(20) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(15) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('Ativo','Inativo') DEFAULT 'Ativo',
  `data_inatividade` date DEFAULT NULL,
  `observacao_inatividade` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id_cliente`, `id_funcionario`, `nome_cliente`, `cpf_cnpj`, `endereco`, `bairro`, `cep`, `cidade`, `estado`, `telefone`, `email`, `status`, `data_inatividade`, `observacao_inatividade`) VALUES
(1, 12, 'DALTON MARCELINO', '55555555588', 'bom retiro', 'Bom retiro', '89223200', 'Joinville', 'SC', '57575757575', 'dalton@empresa.com', 'Inativo', '2025-08-29', ''),
(5, 12, 'MARIA SILVA', '12345678901', 'Rua das Flores, 123', 'Centro', '89223001', 'Joinville', 'SC', '4733334444', 'maria.silva@email.com', 'Ativo', NULL, NULL),
(6, 12, 'JOÃO SANTOS', '23456789012', 'Avenida Brasil, 456', 'Bucarein', '89223002', 'Joinville', 'SC', '4733344555', 'joao.santos@email.com', 'Ativo', NULL, NULL),
(7, 12, 'ANA COSTA', '34567890123', 'Rua XV de Novembro, 789', 'Anita Garibaldi', '89223003', 'Joinville', 'SC', '4733355666', 'ana.costa@email.com', 'Ativo', NULL, NULL),
(8, 12, 'PEDRO ALMEIDA', '45678901234', 'Rua Blumenau, 101', 'Atiradores', '89223004', 'Joinville', 'SC', '4733366777', 'pedro.almeida@email.com', 'Inativo', '2025-08-15', 'Cliente mudou de cidade'),
(9, 12, 'CARLA OLIVEIRA', '56789012345', 'Rua das Palmeiras, 202', 'Costa e Silva', '89223005', 'Joinville', 'SC', '4733377888', 'carla.oliveira@email.com', 'Ativo', NULL, NULL),
(10, 12, 'LUCAS PEREIRA', '67890123456', 'Avenida Santos Dumont, 303', 'Iririú', '89223006', 'Joinville', 'SC', '4733388999', 'lucas.pereira@email.com', 'Ativo', NULL, NULL),
(11, 12, 'JULIANA RODRIGUES', '78901234567', 'Rua Rio Branco, 404', 'Glória', '89223007', 'Joinville', 'SC', '4733399000', 'juliana.rodrigues@email.com', 'Inativo', '2025-07-20', 'Não atende mais'),
(12, 12, 'ROBERTO MARTINS', '89012345678', 'Rua das Acácias, 505', 'Jardim Paraíso', '89223008', 'Joinville', 'SC', '4733311223', 'roberto.martins@email.com', 'Ativo', NULL, NULL),
(13, 12, 'FERNANDA LIMA', '90123456789', 'Avenida Getúlio Vargas, 606', 'Saguaçu', '89223009', 'Joinville', 'SC', '4733322334', 'fernanda.lima@email.com', 'Ativo', NULL, NULL),
(14, 12, 'RAFAEL SOUZA', '01234567890', 'Rua Joinville, 707', 'Boa Vista', '89223010', 'Joinville', 'SC', '4733333445', 'rafael.souza@email.com', 'Ativo', NULL, NULL),
(15, 12, 'TECNOLOGIA LTDA', '12345678000190', 'Rua dos Empresários, 800', 'Zona Industrial', '89224001', 'Joinville', 'SC', '4733444555', 'contato@tecnologialtda.com.br', 'Ativo', NULL, NULL),
(16, 12, 'PATRICIA GOMES', '23456789013', 'Rua das Orquídeas, 909', 'Petrópolis', '89223011', 'Joinville', 'SC', '4733555666', 'patricia.gomes@email.com', 'Inativo', '2025-09-01', 'Solicitou cancelamento'),
(17, 12, 'MARCOS FERREIRA', '34567890124', 'Avenida Copacabana, 1010', 'América', '89223012', 'Joinville', 'SC', '4733666777', 'marcos.ferreira@email.com', 'Ativo', NULL, NULL),
(18, 12, 'VANESSA CASTRO', '45678901235', 'Rua das Margaridas, 1111', 'Cobrasol', '89223013', 'São José', 'SC', '4833777888', 'vanessa.castro@email.com', 'Ativo', NULL, NULL),
(19, 12, 'DIEGO RAMOS', '56789012346', 'Rua Central, 1212', 'Centro', '88010001', 'Florianópolis', 'SC', '4833888999', 'diego.ramos@email.com', 'Ativo', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `nome_fornecedor` varchar(100) NOT NULL,
  `cpf_cnpj` varchar(18) NOT NULL,
  `ramo_atividade` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(15) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('Ativo','Inativo','Pendente','Bloqueado','Suspenso') DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id_fornecedor`, `id_funcionario`, `nome_fornecedor`, `cpf_cnpj`, `ramo_atividade`, `telefone`, `endereco`, `bairro`, `cep`, `cidade`, `estado`, `email`, `status`) VALUES
(2, 12, 'dasda', '22222222222222', 'ttttttttttttttttttt', '22222222222', 'jgyjygj', 'ygjygjyjgyjygj', '89223200', 'Joinville', 'SC', 'gsg@gesg', 'Ativo'),
(3, 12, 'JOEs BARBER', '25235223255235', 'HARDWAR', '52323626616', 'GSEGSEGSEGSE', '5UTFJFTJ', '57454754', 'FTJFTJFTJFTJFTJT', 'PE', 'DRHRD@FWFS', 'Ativo'),
(4, 12, 'MobileTech Solutions', '98.765.432/0001-10', 'Peças para Celulares', '(47) 3222-5555', 'Avenida Beira Rio, 456', 'Atiradores', '89203-002', 'Joinville', 'SC', 'vendas@mobiletech.com', 'Ativo'),
(5, 12, 'EletroMundo Componentes', '55.444.333/0001-22', 'Eletrônicos em Geral', '(47) 3344-6677', 'Rua Blumenau, 789', 'Bom Retiro', '89223-200', 'Joinville', 'SC', 'compras@eletromundo.com', 'Ativo'),
(6, 12, 'Baterias Express', '11.222.333/0001-44', 'Baterias e Fontes', '(47) 3456-7890', 'Rua Joinville, 321', 'Jardim Sofia', '89223-450', 'Joinville', 'SC', 'sac@bateriasexpress.com', 'Ativo'),
(7, 12, 'Conecta Brasil', '66.777.888/0001-33', 'Cabos e Conectores', '(47) 3333-8888', 'Rua das Flores, 654', 'Costa e Silva', '89217-300', 'Joinville', 'SC', 'contato@conectabrasil.com', 'Ativo'),
(8, 12, 'TechInova Components', '22.333.444/0001-55', 'Inovações Tecnológicas', '(47) 3444-9999', 'Avenida Santos Dumont, 987', 'Bucarein', '89202-300', 'Joinville', 'SC', 'vendas@techinova.com', 'Pendente'),
(9, 12, 'DisplayMaster', '77.888.999/0001-66', 'Telas e Displays', '(47) 3555-0000', 'Rua Rio Branco, 147', 'Anita Garibaldi', '89203-100', 'Joinville', 'SC', 'suporte@displaymaster.com', 'Ativo'),
(10, 12, 'AudioTech Fornecedora', '33.444.555/0001-77', 'Componentes de Áudio', '(47) 3666-1111', 'Rua XV de Novembro, 258', 'Centro', '89201-200', 'Joinville', 'SC', 'contato@audiotech.com', 'Ativo'),
(11, 12, 'Hardware Brasil', '44.555.666/0001-88', 'Hardware em Geral', '(47) 3777-2222', 'Avenida Hermann August Lepper, 369', 'Saguaçu', '89221-100', 'Joinville', 'SC', 'vendas@hardwarebrasil.com', 'Bloqueado'),
(12, 12, 'Circuitos Eletrônicos', '99.000.111/0001-99', 'Circuitos e Placas', '(47) 3888-3333', 'Rua Dona Francisca, 741', 'Centro', '89201-300', 'Joinville', 'SC', 'comercial@circuitoseletronicos.com', 'Ativo'),
(13, 12, 'FontePower Ltda', '88.999.000/0001-11', 'Fontes e Carregadores', '(47) 3999-4444', 'Rua Amazonas, 852', 'Glória', '89216-200', 'Joinville', 'SC', 'sac@fonterpower.com', 'Ativo'),
(14, 12, 'MegaParts Distribuidora', '00.111.222/0001-00', 'Distribuição de Peças', '(47) 3000-5555', 'Rua das Nações, 963', 'Iririú', '89227-100', 'Joinville', 'SC', 'contato@megaparts.com', 'Suspenso'),
(15, 12, 'ConectorTech', '12.345.679/0001-91', 'Conectores e Adaptadores', '(47) 3111-6666', 'Avenida Colombo, 159', 'Costa e Silva', '89217-400', 'Joinville', 'SC', 'vendas@conectortech.com', 'Ativo'),
(16, 12, 'CellParts Brasil', '23.456.789/0001-12', 'Peças para Celulares', '(47) 3222-7777', 'Rua São Paulo, 357', 'Bom Retiro', '89223-201', 'Joinville', 'SC', 'suporte@cellparts.com', 'Ativo'),
(17, 12, 'TechSupply SC', '34.567.890/0001-23', 'Suprimentos Tecnológicos', '(47) 3333-8888', 'Rua Rio de Janeiro, 456', 'Atiradores', '89203-003', 'Joinville', 'SC', 'compras@techsupplysc.com', 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` int(11) NOT NULL,
  `nome_funcionario` varchar(100) NOT NULL,
  `cpf_funcionario` varchar(20) NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cep` varchar(15) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `dt_nascimento` date DEFAULT NULL,
  `status` enum('Ativo','Inativo') DEFAULT 'Ativo',
  `id_motivo_inatividade` int(11) DEFAULT NULL,
  `data_inatividade` date DEFAULT NULL,
  `observacao_inatividade` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`id_funcionario`, `nome_funcionario`, `cpf_funcionario`, `salario`, `endereco`, `bairro`, `cep`, `cidade`, `estado`, `email`, `dt_nascimento`, `status`, `id_motivo_inatividade`, `data_inatividade`, `observacao_inatividade`) VALUES
(12, 'dalton', '44444444444', 99999999.99, 'wadawdwwawa', 'gsdgdsgs', '22222-222', 'hsdhshsdhsd', 'PR', 'adm@tste123', '2000-02-25', 'Ativo', NULL, NULL, NULL),
(15, 'CARLOS EDUARDO', '11122233344', 3500.00, 'Rua das Acácias, 100', 'Bucarein', '89223020', 'Joinville', 'SC', 'carlos.eduardo@empresa.com', '1990-05-15', 'Ativo', NULL, NULL, NULL),
(16, 'AMANDA SANTOS', '22233344455', 2800.00, 'Avenida Brasil, 200', 'Anita Garibaldi', '89223021', 'Joinville', 'SC', 'amanda.santos@empresa.com', '1992-08-22', 'Ativo', NULL, NULL, NULL),
(17, 'RODRIGO MENDES', '33344455566', 4200.00, 'Rua Blumenau, 300', 'Atiradores', '89223022', 'Joinville', 'SC', 'rodrigo.mendes@empresa.com', '1988-12-10', 'Ativo', NULL, NULL, NULL),
(18, 'TATIANE OLIVEIRA', '44455566677', 3200.00, 'Rua XV de Novembro, 400', 'Centro', '89223023', 'Joinville', 'SC', 'tatiane.oliveira@empresa.com', '1991-03-30', 'Inativo', 8, '2025-07-15', 'Desligamento por acordo'),
(19, 'FABIO COSTA', '55566677788', 3800.00, 'Avenida Santos Dumont, 500', 'Iririú', '89223024', 'Joinville', 'SC', 'fabio.costa@empresa.com', '1989-07-18', 'Ativo', NULL, NULL, NULL),
(20, 'JÉSSICA PEREIRA', '66677788899', 3000.00, 'Rua das Palmeiras, 600', 'Costa e Silva', '89223025', 'Joinville', 'SC', 'jessica.pereira@empresa.com', '1993-11-05', 'Inativo', 2, '2025-08-10', 'Licença médica prolongada'),
(21, 'BRUNO ALVES', '77788899900', 4500.00, 'Rua Rio Branco, 700', 'Glória', '89223026', 'Joinville', 'SC', 'bruno.alves@empresa.com', '1987-02-14', 'Ativo', NULL, NULL, NULL),
(22, 'CAMILA RIBEIRO', '88899900011', 2900.00, 'Rua Joinville, 800', 'Boa Vista', '89223027', 'Joinville', 'SC', 'camila.ribeiro@empresa.com', '1994-06-25', 'Ativo', NULL, NULL, NULL),
(23, 'DIEGO MARTINS', '99900011122', 5100.00, 'Avenida Getúlio Vargas, 900', 'Saguaçu', '89223028', 'Joinville', 'SC', 'diego.martins@empresa.com', '1986-09-12', 'Ativo', NULL, NULL, NULL),
(24, 'LARISSA SILVEIRA', '00011122233', 3400.00, 'Rua das Flores, 1000', 'Jardim Paraíso', '89223029', 'Joinville', 'SC', 'larissa.silveira@empresa.com', '1990-12-08', 'Inativo', 3, '2025-06-01', 'Licença maternidade'),
(25, 'RAFAEL GONÇALVES', '11122233300', 4700.00, 'Rua Central, 1100', 'Petrópolis', '89223030', 'Joinville', 'SC', 'rafael.goncalves@empresa.com', '1985-04-17', 'Ativo', NULL, NULL, NULL),
(26, 'VANESSA LIMA', '22233344400', 3300.00, 'Avenida Copacabana, 1200', 'América', '89223031', 'Joinville', 'SC', 'vanessa.lima@empresa.com', '1992-10-03', 'Ativo', NULL, NULL, NULL),
(27, 'MARCOS SOUZA', '33344455500', 3900.00, 'Rua das Orquídeas, 1300', 'Cobrasol', '89223032', 'São José', 'SC', 'marcos.souza@empresa.com', '1988-01-20', 'Inativo', 1, '2025-08-01', 'Férias programadas'),
(28, 'PATRICIA FERREIRA', '44455566600', 3600.00, 'Rua dos Empresários, 1400', 'Zona Industrial', '89224002', 'Joinville', 'SC', 'patricia.ferreira@empresa.com', '1991-07-07', 'Ativo', NULL, NULL, NULL),
(29, 'GUSTAVO RAMOS', '55566677700', 4300.00, 'Rua das Margaridas, 1500', 'Bom Retiro', '89223201', 'Joinville', 'SC', 'gustavo.ramos@empresa.com', '1987-12-28', 'Ativo', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_acao`
--

CREATE TABLE `log_acao` (
  `id_log` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `acao` varchar(255) NOT NULL,
  `tabela_afetada` varchar(100) NOT NULL,
  `id_registro` int(11) DEFAULT NULL,
  `data_hora` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `log_acao`
--

INSERT INTO `log_acao` (`id_log`, `id_usuario`, `id_perfil`, `acao`, `tabela_afetada`, `id_registro`, `data_hora`) VALUES
(1, 12, 1, 'Cadastro de [ENTIDADE]:  ()', '[NOME_TABELA]', 3, '2025-09-05 17:09:07'),
(2, 12, 1, 'Cadastro de cliente: AWFWAFWAFWA (fesfse@gegsege)', 'cliente', 8, '2025-09-05 17:11:16'),
(3, 12, 1, 'Cadastro de fornecedor: JOEs BARBER (fawffwa@fafafsf)', 'fornecedor', 4, '2025-09-05 17:15:57'),
(4, 12, 1, 'Cadastro de funcionário: JOÃO (52352352352)', 'funcionario', 15, '2025-09-05 17:17:10'),
(5, 12, 1, 'Cadastro de peça: boing (Quantidade: 9, Preço: R$ 5,25)', 'peca_estoque', 7, '2025-09-05 17:18:00'),
(6, 12, 1, 'Cadastro de usuário: Gustavort (Gustavort@Gustavort) como Administrador', 'usuario', 38, '2025-09-05 17:22:40'),
(7, 12, 1, 'Cadastro de usuário: Leonardo (Leonardo123@Leonardo123) como Tecnico', 'usuario', 39, '2025-09-05 17:29:42'),
(8, 12, 1, 'Cadastro de usuário: Danton (Danton123@Danton123) como Tecnico', 'usuario', 40, '2025-09-05 17:29:57'),
(9, 12, 1, 'Cadastro de usuário: Dalton Silvio (DaltonSilvio@DaltonSilvio) como Tecnico', 'usuario', 41, '2025-09-05 17:30:27'),
(10, 12, 1, 'Cadastro de usuário: trombolho (trombolho@trombolho) como Tecnico', 'usuario', 42, '2025-09-05 18:10:40'),
(11, 12, 1, 'Cadastro de usuário: Malricio Espedições Ultraáreas (Malricio@Malricio) como Secretaria', 'usuario', 43, '2025-09-05 18:11:59'),
(12, 12, 1, 'Cadastro de usuário: Amanda Expedições Ultra Submarina (AmandaSub@AmandaSub) como Tecnico', 'usuario', 44, '2025-09-05 18:13:23'),
(13, 12, 1, 'Cadastro de usuário: José Vieira Santos Silva Pereira (josevieira@josevieira) como Tecnico', 'usuario', 45, '2025-09-05 18:18:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `motivo_inatividade`
--

CREATE TABLE `motivo_inatividade` (
  `id_motivo` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `motivo_inatividade`
--

INSERT INTO `motivo_inatividade` (`id_motivo`, `descricao`) VALUES
(1, 'Férias'),
(2, 'Licença médica'),
(3, 'Licença maternidade/paternidade'),
(4, 'Licença não remunerada'),
(5, 'Suspensão'),
(6, 'Treinamento externo'),
(7, 'Aposentadoria'),
(8, 'Rescisão (demitido/desligado)'),
(9, 'Outro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `nova_ordem`
--

CREATE TABLE `nova_ordem` (
  `id_ordem` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `nome_client_ordem` varchar(100) NOT NULL,
  `tecnico` varchar(100) DEFAULT NULL,
  `marca_aparelho` varchar(100) DEFAULT NULL,
  `tempo_uso` varchar(50) DEFAULT NULL,
  `problema` text DEFAULT NULL,
  `prioridade` varchar(20) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  `dt_recebimento` date DEFAULT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `metodo_pag` varchar(50) DEFAULT NULL,
  `id_peca_est` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `status_ordem` enum('Aberta','Em Andamento','Aguardando Peças','Concluído','Cancelada') DEFAULT 'Aberta',
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `nova_ordem`
--

INSERT INTO `nova_ordem` (`id_ordem`, `id_funcionario`, `nome_client_ordem`, `tecnico`, `marca_aparelho`, `tempo_uso`, `problema`, `prioridade`, `observacao`, `dt_recebimento`, `valor_total`, `metodo_pag`, `id_peca_est`, `id_cliente`, `status_ordem`, `id_usuario`) VALUES
(1, 12, 'MARIA SILVA', '33', 'Samsung Galaxy S21', '1 ano', 'Tela trincada após queda', 'Alta', 'Cliente precisa do aparelho urgente para trabalho', '2025-09-01', 420.00, 'Cartão Crédito', 8, 5, 'Concluído', 39),
(2, 12, 'JOÃO SANTOS', '41', 'iPhone 12', '8 meses', 'Bateria não segura carga', 'Média', 'Aparelho desliga sozinho com 30% de bateria', '2025-09-02', 550.00, 'Dinheiro', 13, 6, 'Em Andamento', 40),
(3, 12, 'ANA COSTA', 'Dalton Silvio', 'Dell Inspiron', '2 anos', 'Teclado com teclas falhando', 'Baixa', 'Tecla espaço e enter não funcionam corretamente', '2025-09-03', 249.00, 'PIX', 12, 7, 'Aguardando Peças', 41),
(4, 12, 'CARLA OLIVEIRA', 'Leonardo', 'PC Gamer', '6 meses', 'Placa de vídeo com artefatos na tela', 'Alta', 'Jogos ficam com linhas coloridas na tela', '2025-09-04', 1299.00, 'Cartão Débito', 9, 9, 'Aberta', 39),
(5, 12, 'LUCAS PEREIRA', '45', 'Notebook Dell', '3 anos', 'Bateria não carrega', 'Média', 'Só funciona na tomada', '2025-09-05', 189.00, 'Cartão Crédito', 10, 10, 'Concluído', 40),
(6, 12, 'ROBERTO MARTINS', 'Dalton Silvio', 'PC Desktop', '1 ano', 'Memória RAM com defeito', 'Alta', 'Computador não liga, dá bip contínuo', '2025-09-06', 199.00, 'Dinheiro', 16, 12, 'Em Andamento', 41),
(7, 12, 'FERNANDA LIMA', '39', 'Webcam', '3 meses', 'Imagem estática', 'Baixa', 'Não transmite vídeo, apenas imagem congelada', '2025-09-07', 159.00, 'PIX', 18, 13, 'Aguardando Peças', 39),
(8, 12, 'RAFAEL SOUZA', 'Danton', 'SSD', '1 mês', 'Lentidão excessiva', 'Média', 'SSD novo com performance abaixo do esperado', '2025-09-08', 289.00, 'Cartão Débito', 19, 14, 'Aberta', 40),
(9, 12, 'TECNOLOGIA LTDA', '44', 'Headphone Gamer', '2 semanas', 'Áudio apenas de um lado', 'Alta', 'Fone direito sem áudio', '2025-09-09', 199.00, 'Cartão Crédito', 21, 15, 'Concluído', 41),
(10, 12, 'MARCOS FERREIRA', '39', 'Carregador USB-C', '1 mês', 'Não carrega', 'Baixa', 'LED do carregador não acende', '2025-09-10', 99.00, 'Dinheiro', 20, 17, 'Em Andamento', 39),
(11, 12, 'VANESSA CASTRO', '44', 'Mouse Gamer', '4 meses', 'Scroll não funciona', 'Média', 'Roda do mouse não responde', '2025-09-11', 120.00, 'PIX', 15, 18, 'Aguardando Peças', 40),
(12, 12, 'DIEGO RAMOS', '42', 'Fonte ATX', '1 ano', 'Computador não liga', 'Alta', 'Fonte não dá sinal de vida', '2025-09-12', 329.00, 'Cartão Débito', 17, 19, 'Aberta', 41),
(13, 12, 'PATRICIA GOMES', '39', 'Cooler Processador', '6 meses', 'Barulho excessivo', 'Baixa', 'Cooler faz barulho de britadeira', '2025-09-13', 89.00, 'Cartão Crédito', 14, 16, 'Concluído', 39),
(14, 12, 'DALTON MARCELINO', '42', 'Cabo HDMI', '2 meses', 'Imagem intermitente', 'Média', 'Imagem pisca constantemente', '2025-09-14', 35.00, 'Dinheiro', 11, 1, 'Concluído', 40),
(15, 12, 'MARIA SILVA', '41', 'iPhone 12', '1 ano', 'Carregador não reconhece', 'Alta', 'Não carrega com carregador original', '2025-09-15', 99.00, 'PIX', 20, 5, 'Aguardando Peças', 41),
(16, 12, 'PEDRO ALMEIDA', '39', 'Samsung Galaxy A54', '1 ano', 'Tela quebrada', 'Alta', 'Cliente desistiu do reparo', '2025-08-20', 300.00, NULL, NULL, 8, 'Cancelada', 39);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_servico_pecas`
--

CREATE TABLE `ordem_servico_pecas` (
  `id_os_peca` int(11) NOT NULL,
  `id_ordem` int(11) NOT NULL,
  `id_peca_est` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordem_servico_pecas`
--

INSERT INTO `ordem_servico_pecas` (`id_os_peca`, `id_ordem`, `id_peca_est`, `quantidade`) VALUES
(13, 12, 21, 1),
(14, 11, 1, 1),
(15, 1, 19, 1),
(16, 10, 16, 1),
(17, 9, 21, 1),
(18, 7, 16, 1),
(19, 5, 21, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `peca_estoque`
--

CREATE TABLE `peca_estoque` (
  `id_peca_est` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `nome_peca` varchar(100) NOT NULL,
  `descricao_peca` text DEFAULT NULL,
  `qtde` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `dt_cadastro` date DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `qtde_minima` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `peca_estoque`
--

INSERT INTO `peca_estoque` (`id_peca_est`, `id_funcionario`, `id_fornecedor`, `nome_peca`, `descricao_peca`, `qtde`, `tipo`, `dt_cadastro`, `preco`, `qtde_minima`) VALUES
(1, 12, 2, 'Placa Mãe ', 'Memória interna: 128 GB.\r\nConta com 4 GB de memória RAM.', 14, 'Hardware', '2025-09-01', 175.00, 3),
(2, 12, 2, 'Bateria Lg Bl-41a1h 3,8v 2020mah', 'Uma bateria potente de 2020mah que é compatível apenas com smartphones Samsung, bateria possui coloração cinza', 3, 'perifericos', '2025-09-01', 15.00, 3),
(5, 12, 2, 'Bateria Iphone', 'Bateria', 5, 'eletronico', '2025-09-02', 80.00, 2),
(6, 12, 2, 'Peça Gamer', '1123', 0, 'cabos', '2025-09-04', 47.00, 5),
(7, 12, 3, 'boing', 'Fadada', 9, 'hardware', '2025-09-05', 5.25, 1),
(8, 12, 4, 'Tela Samsung Galaxy S21', 'Tela OLED 6.2 polegadas para Samsung Galaxy S21, resolução 2400x1080', 12, 'Display', '2025-09-04', 420.00, 5),
(9, 12, 5, 'Placa de Vídeo GTX 1660', 'Placa de vídeo NVIDIA GeForce GTX 1660 Super 6GB GDDR6', 5, 'Hardware', '2025-09-04', 1299.00, 2),
(10, 12, 6, 'Bateria Notebook Dell 5000mAh', 'Bateria replacement para notebooks Dell, capacidade 5000mAh', 15, 'Bateria', '2025-09-04', 189.00, 4),
(11, 12, 7, 'Cabo HDMI 2.0 2 metros', 'Cabo HDMI alta velocidade 2.0, compatível com 4K@60Hz', 25, 'Cabo', '2025-09-04', 35.00, 10),
(12, 12, 8, 'Teclado Mecânico RGB', 'Teclado mecânico com switches blue, iluminação RGB ABNT2', 7, 'Periférico', '2025-09-04', 249.00, 3),
(13, 12, 9, 'Display iPhone 12', 'Tela de replacement para iPhone 12, 6.1 polegadas, OLED', 10, 'Display', '2025-09-04', 550.00, 4),
(14, 12, 10, 'Cooler para Processador', 'Cooler para processadores Intel/AMD, LED azul, 120mm', 18, 'Hardware', '2025-09-04', 89.00, 6),
(15, 12, 11, 'Mouse Gamer 6400DPI', 'Mouse gamer com 7 botões, RGB, sensor óptico 6400DPI', 14, 'Periférico', '2025-09-04', 120.00, 5),
(16, 12, 12, 'Memória RAM 8GB DDR4', 'Memória RAM 8GB DDR4 2666MHz, Kingston', 18, 'Hardware', '2025-09-04', 199.00, 8),
(17, 12, 13, 'Fonte ATX 600W 80 Plus', 'Fonte de alimentação 600W, certificação 80 Plus Bronze', 9, 'Hardware', '2025-09-04', 329.00, 3),
(18, 12, 14, 'Webcam Full HD 1080p', 'Webcam com microfone integrado, resolução Full HD 1080p', 11, 'Periférico', '2025-09-04', 159.00, 4),
(19, 12, 15, 'SSD 500GB SATA III', 'SSD 500GB, leitura 550MB/s, gravação 500MB/s, SATA III', 15, 'Armazenamento', '2025-09-04', 289.00, 6),
(20, 12, 16, 'Carregador USB-C 65W', 'Carregador rápido USB-C 65W com cabo incluído', 22, 'Acessório', '2025-09-04', 99.00, 8),
(21, 12, 17, 'Headphone Gamer 7.1', 'Headphone gamer com surround virtual 7.1, microfone retrátil', 10, 'Áudio', '2025-09-04', 199.00, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nome_perfil` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nome_perfil`) VALUES
(1, 'Administrador'),
(2, 'Funcionario'),
(3, 'Secretaria'),
(4, 'Tecnico');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha_temporaria` tinyint(1) DEFAULT 0,
  `id_perfil` int(11) NOT NULL,
  `status` enum('Ativo','Inativo') DEFAULT 'Ativo',
  `id_motivo_inatividade` int(11) DEFAULT NULL,
  `data_inatividade` date DEFAULT NULL,
  `observacao_inatividade` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `senha`, `email`, `senha_temporaria`, `id_perfil`, `status`, `id_motivo_inatividade`, `data_inatividade`, `observacao_inatividade`) VALUES
(12, 'Admin', '$2y$10$RjRfXwZANRJomQAL3Aao6e74U4CHBopq0OcPJBJ8mi1H4UdAJorkG', 'admin@admin', 0, 1, 'Ativo', NULL, NULL, NULL),
(16, 'adm', '$2y$10$zj8t1ATAceJaMDwlk.6D4.3AfuRo7edaZL5YORJYYqKBPY.wNjAkq', 'adm@adm', 0, 1, 'Ativo', NULL, NULL, NULL),
(19, 'Dalton Marcelino', '$2y$10$sGEf6OMfgrUAoi7o4r3/1eUCGxIUf9PqD4Hc5QQjyHEGH8jtv1VMu', 'Dalton@Dalton', 0, 1, 'Inativo', 1, '2025-08-26', '2 meses'),
(22, 'Dalton', '$2y$10$R3QcQUV8AoBk23W2pJ3Xiuo2I9ee.Uzkcxn7CP6XDDbTgDDYOkLYC', 'Dalton12@Dalton', 0, 2, 'Ativo', NULL, NULL, NULL),
(23, 'joaozinho', '$2y$10$SCi19TOitx2U1ZFiAa.Bju.tzQG1JhgX8wMheK5ivt.BFyXlrp5U6', 'joaozinho@joaozinho', 0, 1, 'Ativo', NULL, NULL, NULL),
(28, 'logs', '$2y$10$mhhzHehNFHKgp6TuIPeuCueRYzT4QnWs0INQvHODSZsHMc3.L4yKW', 'logs@logs', 0, 1, 'Ativo', NULL, NULL, NULL),
(29, 'COBRA', '$2y$10$6R5zhbs09a1i4LQMD3UIXeU.qRa7S/VmV5OQBOMAkKJYJGUUwEyC2', 'cobra@cobra', 0, 1, 'Ativo', NULL, NULL, NULL),
(31, 'Gustavo', '$2y$10$kLdUxZtMScvUoEARMPdb9e3QJ3nNyDgnvxdHJd1Q5nc8nLeEL4J2i', 'admin@teste123', 0, 1, 'Ativo', NULL, NULL, NULL),
(33, 'LEAO', '$2y$10$vNM5byDVNIPskKPXIF2b3eRW.H.eWsyc.XQe7FE0QjmRvvMtjVipK', 'LEAO@TECNICO', 0, 4, 'Ativo', NULL, NULL, NULL),
(35, 'Gustavo', '$2y$10$drYk9gOsC3Wjxc7Mx6Hf3e5h/0GYMs0me0ihnpcBeWTSp.ctRSjM6', 'Gustavo@Gustavo', 0, 2, 'Ativo', NULL, NULL, NULL),
(38, 'Gustavort', '$2y$10$/jtIjlCCnzI8d1i83Rk93.mXrsXWD.CChEclXYEknd52LksHPM7Gy', 'Gustavort@Gustavort', 0, 1, 'Ativo', NULL, NULL, NULL),
(39, 'Leonardo', '$2y$10$/B2W4Bh776MxOfasEMbUVuteTo8NdjAL5VxHSktUNwHfV9FasEuHm', 'Leonardo123@Leonardo123', 0, 4, 'Ativo', NULL, NULL, NULL),
(40, 'Danton', '$2y$10$ZaXTytTgQ5mJzPMPQ6BoZuRnEnsEgoBMyjoZ5YvTEuknIjziW52Vy', 'Danton123@Danton123', 0, 4, 'Ativo', NULL, NULL, NULL),
(41, 'Dalton Silvio', '$2y$10$Y0e/AB9FYfAos1aZqNKHXuu4aL4IhJi3rUTGls2.8wpPu1Iol8JI.', 'DaltonSilvio@DaltonSilvio', 0, 4, 'Ativo', NULL, NULL, NULL),
(42, 'trombolho', '$2y$10$Lz2rBiJxY1sGIFLYFfHxLOn9aFd2fIyItVZkm0rknEnsBAiWdrgmm', 'trombolho@trombolho', 0, 4, 'Ativo', NULL, NULL, NULL),
(43, 'Malricio Espedições Ultraáreas', '$2y$10$sTwoKv6ZIepapfXSbZL7ru4mne6mghNLLoWh6HQ.TaO8G8YlwTdo6', 'Malricio@Malricio', 0, 3, 'Ativo', NULL, NULL, NULL),
(44, 'Amanda Expedições Ultra Submarina', '$2y$10$i5hdoqlanXh6BqwNN38gsORBp3lMxnuPI0Ycq1uYJZqhq9nAq2inu', 'AmandaSub@AmandaSub', 0, 4, 'Ativo', NULL, NULL, NULL),
(45, 'José Vieira Santos Silva Pereira', '$2y$10$dPDe3jwrJ7OnmF5pw..saetcaKsI6FpdFi7iZyxckcQFEQ4DjxDei', 'josevieira@josevieira', 0, 4, 'Ativo', NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id_fornecedor`),
  ADD UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD UNIQUE KEY `cpf_funcionario` (`cpf_funcionario`),
  ADD KEY `fk_funcionario_motivo` (`id_motivo_inatividade`);

--
-- Índices de tabela `log_acao`
--
ALTER TABLE `log_acao`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- Índices de tabela `motivo_inatividade`
--
ALTER TABLE `motivo_inatividade`
  ADD PRIMARY KEY (`id_motivo`);

--
-- Índices de tabela `nova_ordem`
--
ALTER TABLE `nova_ordem`
  ADD PRIMARY KEY (`id_ordem`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `fk_id_peca_est` (`id_peca_est`),
  ADD KEY `fk_id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `ordem_servico_pecas`
--
ALTER TABLE `ordem_servico_pecas`
  ADD PRIMARY KEY (`id_os_peca`),
  ADD KEY `id_ordem` (`id_ordem`),
  ADD KEY `id_peca_est` (`id_peca_est`);

--
-- Índices de tabela `peca_estoque`
--
ALTER TABLE `peca_estoque`
  ADD PRIMARY KEY (`id_peca_est`),
  ADD KEY `id_funcionario` (`id_funcionario`),
  ADD KEY `id_fornecedor` (`id_fornecedor`);

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_perfil` (`id_perfil`),
  ADD KEY `fk_usuario_motivo` (`id_motivo_inatividade`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `log_acao`
--
ALTER TABLE `log_acao`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `motivo_inatividade`
--
ALTER TABLE `motivo_inatividade`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `nova_ordem`
--
ALTER TABLE `nova_ordem`
  MODIFY `id_ordem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `ordem_servico_pecas`
--
ALTER TABLE `ordem_servico_pecas`
  MODIFY `id_os_peca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `peca_estoque`
--
ALTER TABLE `peca_estoque`
  MODIFY `id_peca_est` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Restrições para tabelas `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD CONSTRAINT `fornecedor_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Restrições para tabelas `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_funcionario_motivo` FOREIGN KEY (`id_motivo_inatividade`) REFERENCES `motivo_inatividade` (`id_motivo`);

--
-- Restrições para tabelas `log_acao`
--
ALTER TABLE `log_acao`
  ADD CONSTRAINT `log_acao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `log_acao_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);

--
-- Restrições para tabelas `nova_ordem`
--
ALTER TABLE `nova_ordem`
  ADD CONSTRAINT `fk_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `fk_id_peca_est` FOREIGN KEY (`id_peca_est`) REFERENCES `peca_estoque` (`id_peca_est`),
  ADD CONSTRAINT `nova_ordem_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`),
  ADD CONSTRAINT `nova_ordem_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `ordem_servico_pecas`
--
ALTER TABLE `ordem_servico_pecas`
  ADD CONSTRAINT `ordem_servico_pecas_ibfk_1` FOREIGN KEY (`id_ordem`) REFERENCES `nova_ordem` (`id_ordem`),
  ADD CONSTRAINT `ordem_servico_pecas_ibfk_2` FOREIGN KEY (`id_peca_est`) REFERENCES `peca_estoque` (`id_peca_est`);

--
-- Restrições para tabelas `peca_estoque`
--
ALTER TABLE `peca_estoque`
  ADD CONSTRAINT `peca_estoque_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`),
  ADD CONSTRAINT `peca_estoque_ibfk_2` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`);

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_motivo` FOREIGN KEY (`id_motivo_inatividade`) REFERENCES `motivo_inatividade` (`id_motivo`),
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

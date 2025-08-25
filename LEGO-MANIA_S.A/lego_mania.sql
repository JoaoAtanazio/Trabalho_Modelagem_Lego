-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/08/2025 às 02:35
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
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `dt_nascimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 19, 1, 'Limpeza completa dos logs do sistema', 'log_acao', NULL, '2025-08-25 00:09:24'),
(2, 19, 1, 'Cadastro de usuário: joe (joe@gmail.com) como Administrador', 'usuario', 30, '2025-08-25 00:20:15');

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
  `valor_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `id_pagamento` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `metodo_pag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `peca_estoque`
--

CREATE TABLE `peca_estoque` (
  `id_peca_est` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `id_fornecedor` int(11) NOT NULL,
  `peca` varchar(100) NOT NULL,
  `qtde` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `dt_cadastro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_perfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `senha`, `email`, `senha_temporaria`, `id_perfil`) VALUES
(12, 'Admin', '$2y$10$RjRfXwZANRJomQAL3Aao6e74U4CHBopq0OcPJBJ8mi1H4UdAJorkG', 'admin@admin', 0, 1),
(16, 'adm', '$2y$10$zj8t1ATAceJaMDwlk.6D4.3AfuRo7edaZL5YORJYYqKBPY.wNjAkq', 'adm@adm', 0, 1),
(17, 'gustavo123', '$2y$10$3yn5HgWBcV0Av5JEVp1tHeTH1MeyecNNGRQd3nwFPAJVgjtUIvfYC', 'gustavo123@gustavo123', 0, 1),
(18, 'luiz', '$2y$10$Rl94SdWw39RPoaojvRLOI.MIf.msx/YI8JgMGqT5ft6xjlidZRjhS', 'luiz@luiz', 0, 1),
(19, 'Dalton', '$2y$10$N9oYq22p2WqnP22L49zBBO90KdNxLkDLDixnln3H7hCluDg1p3.Wa', 'Dalton@Dalton', 0, 1),
(22, 'Dalton', '$2y$10$R3QcQUV8AoBk23W2pJ3Xiuo2I9ee.Uzkcxn7CP6XDDbTgDDYOkLYC', 'Dalton12@Dalton', 0, 2),
(23, 'joaozinho', '$2y$10$SCi19TOitx2U1ZFiAa.Bju.tzQG1JhgX8wMheK5ivt.BFyXlrp5U6', 'joaozinho@joaozinho', 0, 1),
(27, 'carlo', '$2y$10$0BHvm6YvBm/V.zuTsgp61e478pUDjz7GMGW0paK6TipSVj9.hkZ9C', 'carl@empresa.com', 0, 1),
(28, 'logs', '$2y$10$mhhzHehNFHKgp6TuIPeuCueRYzT4QnWs0INQvHODSZsHMc3.L4yKW', 'logs@logs', 0, 1),
(29, 'COBRA', '$2y$10$6R5zhbs09a1i4LQMD3UIXeU.qRa7S/VmV5OQBOMAkKJYJGUUwEyC2', 'cobra@cobra', 0, 1),
(30, 'joe', '$2y$10$dJwtlyCPzRyEkyBua01DbOEbQbEYc.zoYzUL5KFBWMLuILgzhSV4.', 'joe@gmail.com', 0, 1);

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
  ADD UNIQUE KEY `cpf_funcionario` (`cpf_funcionario`);

--
-- Índices de tabela `log_acao`
--
ALTER TABLE `log_acao`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- Índices de tabela `nova_ordem`
--
ALTER TABLE `nova_ordem`
  ADD PRIMARY KEY (`id_ordem`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_cliente` (`id_cliente`);

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
  ADD KEY `id_perfil` (`id_perfil`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `log_acao`
--
ALTER TABLE `log_acao`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `nova_ordem`
--
ALTER TABLE `nova_ordem`
  MODIFY `id_ordem` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `peca_estoque`
--
ALTER TABLE `peca_estoque`
  MODIFY `id_peca_est` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- Restrições para tabelas `log_acao`
--
ALTER TABLE `log_acao`
  ADD CONSTRAINT `log_acao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `log_acao_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);

--
-- Restrições para tabelas `nova_ordem`
--
ALTER TABLE `nova_ordem`
  ADD CONSTRAINT `nova_ordem_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionario` (`id_funcionario`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

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
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

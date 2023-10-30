-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/10/2023 às 04:02
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mmsx`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinhosfinalizados`
--

CREATE TABLE `carrinhosfinalizados` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `IdDono` bigint(20) NOT NULL,
  `Data` tinytext NOT NULL,
  `Conteudo` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Conteudo`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `carrinhosfinalizados`
--

INSERT INTO `carrinhosfinalizados` (`Id`, `IdDono`, `Data`, `Conteudo`) VALUES
(1, 36, '15.10.23  5:37', '[{\"produto\":\"1\",\"quantidade\":50}]'),
(2, 36, '27.10.23  2:49', '[{\"produto\":\"1\",\"quantidade\":50}]'),
(3, 36, '27.10.23  2:54', '[{\"produto\":\"1\",\"quantidade\":50}]'),
(4, 36, '29.10.23  12:23', '[{\"produto\":\"1\",\"quantidade\":50}]'),
(5, 36, '29.10.23  12:27', '[{\"produto\":\"1\",\"quantidade\":50}]');

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `IdDono` int(11) NOT NULL,
  `nomeEndereco` char(25) NOT NULL,
  `Cep` char(20) NOT NULL,
  `Cidade` char(30) NOT NULL,
  `Rua` char(40) NOT NULL,
  `Bairro` char(30) NOT NULL,
  `Numero` char(8) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT 1,
  `DataCriacao` char(15) NOT NULL,
  `InstrucoesEntrega` tinytext NOT NULL,
  `dataModificacao` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`Id`, `IdDono`, `nomeEndereco`, `Cep`, `Cidade`, `Rua`, `Bairro`, `Numero`, `Status`, `DataCriacao`, `InstrucoesEntrega`, `dataModificacao`) VALUES
(28, 36, 'casa', '11740-000', 'Itanhaém', 'av lydia', 'Loty', '1160', 1, '29.10.23  11:46', 'deixar no vizinho e na rua de baixo', '29.10.23  11:46'),
(29, 36, 'casa', '11740-000', 'Itanhaém', 'av lydia', 'Loty', '1160', 1, '30.10.23  12:01', 'deixar no vizinho e na rua de baixo', '30.10.23  12:01'),
(30, 36, 'casa', '11740-000', 'Itanhaém', 'av lydia', 'Loty', '1160', 1, '30.10.23  12:01', 'ru!ARuim$', '30.10.23  12:01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `parentId` int(11) NOT NULL,
  `conteudo` text NOT NULL,
  `DataEnvio` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtoprimario`
--

CREATE TABLE `produtoprimario` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Classificacoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Classificacoes`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtoprimario`
--

INSERT INTO `produtoprimario` (`Id`, `Nome`, `Classificacoes`) VALUES
(1, 'amortecedor xv3', '[\"dahora\",\"bonito\",\"cheiroso\"]'),
(2, 'amortecedor xv5', '[\"dahora\",\"bonito\",\"cheirosaso\"]'),
(3, 'amortecedor xv10', '[\"dahora\",\"bonito\",\"cheirosinho\"]');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtosecundario`
--

CREATE TABLE `produtosecundario` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `ParentId` tinyint(4) NOT NULL,
  `preco/peca` tinytext NOT NULL,
  `qtd` smallint(6) NOT NULL,
  `Disponibilidade` tinyint(4) NOT NULL,
  `especificacoes` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtosecundario`
--

INSERT INTO `produtosecundario` (`Id`, `ParentId`, `preco/peca`, `qtd`, `Disponibilidade`, `especificacoes`) VALUES
(1, 1, '150.00', 50, 1, 'o mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mlehoo mleho');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `Nome` tinytext NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Senha` varchar(155) NOT NULL,
  `Telefone` varchar(25) DEFAULT NULL,
  `Carrinho` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `TipoConta` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`Id`, `Nome`, `Email`, `Senha`, `Telefone`, `Carrinho`, `TipoConta`) VALUES
(36, 'felipe luiz mariano de souza', 'felipeluizmsouza@gmail.com', 'relinha123', '+5513997673802', '[]', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinhosfinalizados`
--
ALTER TABLE `carrinhosfinalizados`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- Índices de tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- Índices de tabela `produtoprimario`
--
ALTER TABLE `produtoprimario`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- Índices de tabela `produtosecundario`
--
ALTER TABLE `produtosecundario`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD UNIQUE KEY `Id` (`Id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinhosfinalizados`
--
ALTER TABLE `carrinhosfinalizados`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produtoprimario`
--
ALTER TABLE `produtoprimario`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtosecundario`
--
ALTER TABLE `produtosecundario`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

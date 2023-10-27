-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/10/2023 às 20:29
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

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
-- Estrutura para tabela `produtoprimario`
--

CREATE TABLE `produtoprimario` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `classificacoes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtoprimario`
--

INSERT INTO `produtoprimario` (`id`, `Nome`, `classificacoes`) VALUES
(1, 'sucrilharia', '[\"dahora\",\"boas\"]');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtosecundario`
--

CREATE TABLE `produtosecundario` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `parentId` tinyint(4) NOT NULL,
  `especificacoes` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `preco/peca` char(10) NOT NULL,
  `qtd` int(11) NOT NULL,
  `disponibilidade` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtosecundario`
--

INSERT INTO `produtosecundario` (`Id`, `parentId`, `especificacoes`, `preco/peca`, `qtd`, `disponibilidade`) VALUES
(1, 1, 'sucrilhos', '150', 250, 1),
(2, 1, 'sucrilhos', '151', 2500, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `Id` bigint(20) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Senha` varchar(100) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `carrinho` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]',
  `tipoConta` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`Id`, `nome`, `Email`, `Senha`, `telefone`, `carrinho`, `tipoConta`) VALUES
(6, '61616', 'felipeluizmsouza@gmail.com', 'relinha123', '61616161', '[]', 0),
(15, 'Felipe Luiz', 'jurema@gmail.com', 're', '', '', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtoprimario`
--
ALTER TABLE `produtoprimario`
  ADD UNIQUE KEY `id` (`id`);

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
-- AUTO_INCREMENT de tabela `produtoprimario`
--
ALTER TABLE `produtoprimario`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtosecundario`
--
ALTER TABLE `produtosecundario`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

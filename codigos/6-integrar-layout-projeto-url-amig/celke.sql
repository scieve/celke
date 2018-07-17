-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/02/2018 às 13:32
-- Versão do servidor: 5.7.14
-- Versão do PHP: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `celke`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `sts_paginas`
--

CREATE TABLE `sts_paginas` (
  `id` int(11) NOT NULL,
  `endereco` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `nome_pagina` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `obs` text COLLATE utf8_unicode_ci,
  `keywords` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `robots` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `imagem` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `tp_pagina` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sts_situacaos_pg_id` int(11) NOT NULL DEFAULT '2',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Fazendo dump de dados para tabela `sts_paginas`
--

INSERT INTO `sts_paginas` (`id`, `endereco`, `nome_pagina`, `obs`, `keywords`, `description`, `author`, `robots`, `imagem`, `tp_pagina`, `sts_situacaos_pg_id`, `created`, `modified`) VALUES
(1, 'home', 'Celke - Home', 'Home', 'site celke home, PHP, HTML, CSS, Bootstrap, JavaScript', 'home do site desenvolvido no Curso de PHP, MySQLi e Bootstrap', 'Celke', 'index, follow', 'home.jpg', 'sts', 1, '2018-02-23 00:00:00', NULL),
(2, 'sobre_empresa', 'Celke - Sobre empresa', NULL, 'site celke sobre empresa, PHP, HTML, CSS, Bootstrap', 'sobre empresa do site desenvolvido no Curso de PHP, MySQLi e Bootstrap', 'Celke', 'index, follow', 'sobre_empresa.jpg', 'sts', 1, '2018-02-23 00:00:00', NULL),
(3, 'contato', 'Celke - Contato', NULL, 'site celke contato, PHP, HTML, CSS, Bootstrap, JavaScript', 'contato do site desenvolvido no Curso de PHP, MySQLi e Bootstrap', 'Celke', 'index, follow', 'contato.jpg', 'sts', 1, '2018-02-23 00:00:00', NULL),
(4, 'blog', 'Celke - Blog', NULL, 'site celke blog, PHP, HTML, CSS, Bootstrap, JavaScript', 'blog do site desenvolvido no Curso de PHP, MySQLi e Bootstrap', 'Celke', 'index, follow', 'blog.jpg', 'sts', 1, '2018-02-23 00:00:00', NULL),
(5, 'artigo', 'Celke - Artigo', NULL, 'site celke artigo, PHP, HTML, CSS, Bootstrap, JavaScript', 'artigo do site desenvolvido no Curso de PHP, MySQLi e Bootstrap', 'Celke', 'index, follow', 'artigo.jpg', 'sts', 1, '2018-02-23 00:00:00', NULL);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `sts_paginas`
--
ALTER TABLE `sts_paginas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `sts_paginas`
--
ALTER TABLE `sts_paginas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

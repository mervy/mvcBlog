-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 28/03/2015 às 11:08
-- Versão do servidor: 5.5.41-0ubuntu0.14.10.1
-- Versão do PHP: 5.6.7-1+deb.sury.org~utopic+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `mvcblog`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `albuns`
--

CREATE TABLE IF NOT EXISTS `albuns` (
`id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `slug_titulo` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `imagens` text NOT NULL,
  `data` date NOT NULL,
  `aprovar` char(4) NOT NULL DEFAULT 'Não',
  `autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `artigos`
--

CREATE TABLE IF NOT EXISTS `artigos` (
`id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `artigo` text NOT NULL,
  `imagem` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `aprovar` char(4) NOT NULL DEFAULT 'Não',
  `categorias_id` int(11) NOT NULL,
  `autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `autores`
--

CREATE TABLE IF NOT EXISTS `autores` (
`id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `apelido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `nivel` int(1) NOT NULL COMMENT 'Basico: 1; Intermediário: 2; Avançado: 3.',
  `data` date NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'ativo' COMMENT 'valores: ativo ou inativo'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `autores`
--

INSERT INTO `autores` (`id`, `login`, `nome`, `apelido`, `email`, `senha`, `nivel`, `data`, `status`) VALUES
(1, 'admin', 'Administrador', 'admin', 'admin@yahoo.com.br', '$2y$13$a29525098721c30fb2a87utgJDtw8A0NmIYCp9ozYbl8Hbr4HBLJ6', 3, '0000-00-00', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_artigos`
--

CREATE TABLE IF NOT EXISTS `categorias_artigos` (
`id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `slug_categoria` varchar(100) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_noticias`
--

CREATE TABLE IF NOT EXISTS `categorias_noticias` (
`id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `slug_categoria` varchar(100) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_videos`
--

CREATE TABLE IF NOT EXISTS `categorias_videos` (
`id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `slug_categoria` varchar(100) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
`id` int(11) NOT NULL,
  `fonte` varchar(200) NOT NULL,
  `feed` varchar(200) NOT NULL,
  `categorias_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `autor` int(11) NOT NULL,
  `aprovar` char(4) NOT NULL DEFAULT 'Não'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
`id` int(11) NOT NULL,
  `categorias_id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `thumbnail` varchar(11) NOT NULL,
  `codigo` text NOT NULL,
  `descricao` text NOT NULL,
  `data` varchar(10) NOT NULL,
  `autor` int(11) NOT NULL,
  `aprovar` char(4) DEFAULT 'Não'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `albuns`
--
ALTER TABLE `albuns`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_albuns_autores` (`autor`);

--
-- Índices de tabela `artigos`
--
ALTER TABLE `artigos`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_artigos_categorias_artigos` (`categorias_id`), ADD KEY `fk_artigos_autores` (`autor`);

--
-- Índices de tabela `autores`
--
ALTER TABLE `autores`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`), ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `categorias_artigos`
--
ALTER TABLE `categorias_artigos`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `categoria` (`categoria`);

--
-- Índices de tabela `categorias_noticias`
--
ALTER TABLE `categorias_noticias`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `categoria` (`categoria`);

--
-- Índices de tabela `categorias_videos`
--
ALTER TABLE `categorias_videos`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `categoria` (`categoria`);

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_noticias_autores_idx` (`autor`), ADD KEY `fk_noticias_categorias_noticias_idx` (`categorias_id`);

--
-- Índices de tabela `videos`
--
ALTER TABLE `videos`
 ADD PRIMARY KEY (`id`), ADD KEY `fk_videos_categorias_videos` (`categorias_id`), ADD KEY `fk_videos_autores` (`autor`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `albuns`
--
ALTER TABLE `albuns`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `artigos`
--
ALTER TABLE `artigos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `autores`
--
ALTER TABLE `autores`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de tabela `categorias_artigos`
--
ALTER TABLE `categorias_artigos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `categorias_noticias`
--
ALTER TABLE `categorias_noticias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `categorias_videos`
--
ALTER TABLE `categorias_videos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de tabela `videos`
--
ALTER TABLE `videos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `albuns`
--
ALTER TABLE `albuns`
ADD CONSTRAINT `fk_albuns_autores` FOREIGN KEY (`autor`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `artigos`
--
ALTER TABLE `artigos`
ADD CONSTRAINT `fk_artigos_autores` FOREIGN KEY (`autor`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_categorias_artigos` FOREIGN KEY (`categorias_id`) REFERENCES `categorias_artigos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
ADD CONSTRAINT `fk_noticias_autores` FOREIGN KEY (`autor`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_noticias_categorias_noticias` FOREIGN KEY (`categorias_id`) REFERENCES `categorias_noticias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `videos`
--
ALTER TABLE `videos`
ADD CONSTRAINT `fk_autor` FOREIGN KEY (`autor`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_categorias_id` FOREIGN KEY (`categorias_id`) REFERENCES `categorias_videos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

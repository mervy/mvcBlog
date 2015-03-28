CREATE TABLE IF NOT EXISTS `albuns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `slug_titulo` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `imagens` text NOT NULL,
  `data` date NOT NULL,
  `aprovar` char(4) NOT NULL DEFAULT 'Não',
  `autor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_albuns_autores` (`autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `artigos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `artigo` text NOT NULL,
  `imagem` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `aprovar` char(4) NOT NULL DEFAULT 'Não',
  `categorias_id` int(11) NOT NULL,
  `autor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_artigos_categorias_artigos` (`categorias_id`),
  KEY `fk_artigos_autores` (`autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `autores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `apelido` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `nivel` int(1) NOT NULL COMMENT 'Basico: 1; Intermediário: 2; Avançado: 3.',
  `data` date NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'ativo' COMMENT 'valores: ativo ou inativo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `autores` (`id`, `login`, `nome`, `apelido`, `email`, `senha`, `nivel`, `data`, `status`) VALUES
(1, 'admin', 'Administrador', 'admin', 'admin@yahoo.com.br', '$2y$13$a29525098721c30fb2a87utgJDtw8A0NmIYCp9ozYbl8Hbr4HBLJ6', 3, '0000-00-00', 'ativo');

CREATE TABLE IF NOT EXISTS `categorias_artigos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `slug_categoria` varchar(100) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoria` (`categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `categorias_noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `slug_categoria` varchar(100) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoria` (`categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `categorias_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  `slug_categoria` varchar(100) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoria` (`categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fonte` varchar(200) NOT NULL,
  `feed` varchar(200) NOT NULL,
  `categorias_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `autor` int(11) NOT NULL,
  `aprovar` char(4) NOT NULL DEFAULT 'Não',
  PRIMARY KEY (`id`),
  KEY `fk_noticias_autores_idx` (`autor`),
  KEY `fk_noticias_categorias_noticias_idx` (`categorias_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorias_id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `thumbnail` varchar(11) NOT NULL,
  `codigo` text NOT NULL,
  `descricao` text NOT NULL,
  `data` varchar(10) NOT NULL,
  `autor` int(11) NOT NULL,
  `aprovar` char(4) DEFAULT 'Não',
  PRIMARY KEY (`id`),
  KEY `fk_videos_categorias_videos` (`categorias_id`),
  KEY `fk_videos_autores` (`autor`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `albuns`
  ADD CONSTRAINT `fk_albuns_autores` FOREIGN KEY (`autor`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `artigos`
  ADD CONSTRAINT `fk_artigos_autores` FOREIGN KEY (`autor`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_categorias_artigos` FOREIGN KEY (`categorias_id`) REFERENCES `categorias_artigos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `noticias`
  ADD CONSTRAINT `fk_noticias_autores` FOREIGN KEY (`autor`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_noticias_categorias_noticias` FOREIGN KEY (`categorias_id`) REFERENCES `categorias_noticias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `videos`
  ADD CONSTRAINT `fk_autor` FOREIGN KEY (`autor`) REFERENCES `autores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_categorias_id` FOREIGN KEY (`categorias_id`) REFERENCES `categorias_videos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
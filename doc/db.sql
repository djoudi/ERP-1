-- phpMyAdmin SQL Dump
-- version 3.5.0-rc1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 06/02/2013 às 01:05:22
-- Versão do Servidor: 5.5.20
-- Versão do PHP: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `topclaro_erp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `cliente_id` int(11) NOT NULL AUTO_INCREMENT,
  `responsavel` int(11) NOT NULL,
  `cnpj` varchar(15) NOT NULL,
  `razaoSocial` varchar(140) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `senhaAtendimento` varchar(4) DEFAULT NULL,
  `numeroCliente` varchar(45) DEFAULT NULL,
  `usuarioGestor` varchar(45) DEFAULT NULL,
  `senhaGestor` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cliente_id`),
  UNIQUE KEY `cnpj_UNIQUE` (`cnpj`),
  KEY `fk_empresas_pessoas1_idx` (`responsavel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`cliente_id`, `responsavel`, `cnpj`, `razaoSocial`, `endereco`, `senhaAtendimento`, `numeroCliente`, `usuarioGestor`, `senhaGestor`) VALUES
(1, 2, '20482776000100', 'Top Claro LTDA', 'Rua C, QD F2, LT 16, nº 164, Leste Vila Nova, Goiânia, Goiás', '1234', '1231231231', 'tc123', 'senha');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas`
--

CREATE TABLE IF NOT EXISTS `pessoas` (
  `pessoa_id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(230) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pessoa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `pessoas`
--

INSERT INTO `pessoas` (`pessoa_id`, `nome`, `email`, `endereco`) VALUES
(1, 'Edygar de Lima Oliveira', 'edygardelima@gmail.com', 'Rua C, QD F2, LT 16, nº 164, Leste Vila Nova, Goiânia, Goiás'),
(2, 'Ricardo Rodrigues Barbosa', 'ricardo@topclaro.com.br', 'Av. Independencia, Cond. Janaina, Apt. 102B, Leste Vila Nova, Goiânia, Goiás');

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

CREATE TABLE IF NOT EXISTS `registros` (
  `registro_id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa` int(11) NOT NULL,
  `autor` int(11) NOT NULL,
  `titulo` varchar(140) DEFAULT NULL,
  `descricao` text,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`registro_id`),
  KEY `fk_registros_empresas1_idx` (`empresa`),
  KEY `fk_registros_usuarios1_idx` (`autor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessoes`
--

CREATE TABLE IF NOT EXISTS `sessoes` (
  `hash` varchar(255) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `data_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip` text NOT NULL,
  PRIMARY KEY (`hash`),
  UNIQUE KEY `hash_UNIQUE` (`hash`),
  KEY `fk_sessao_usuario1_idx` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sessoes`
--

INSERT INTO `sessoes` (`hash`, `usuario_id`, `data_login`, `ip`) VALUES
('M2g4bDE3OWJ1bWc5ZGhiZGs3YzB0cThiaTE3OGVmYzc4YTliN2RlMDNiZjE2YjNlNmU1ZTUxYzZmMQ==', 1, '2013-02-03 11:39:54', '127.0.0.1'),
('M2g4bDE3OWJ1bWc5ZGhiZGs3YzB0cThiaTE3OTlkNTI3ZDJmMWNmYTZlOWE4ZDZjYmMxNzhiZjRjNQ==', 1, '2013-02-03 11:40:22', '127.0.0.1'),
('M2g4bDE3OWJ1bWc5ZGhiZGs3YzB0cThiaTFjMGNmYTQwOTE0NTA3NTZlMDU2OTY2ZGYxMWIyNWZiZQ==', 1, '2013-02-03 11:39:56', '127.0.0.1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `pessoa_id` int(11) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `permissao` int(45) NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `pessoa_id_UNIQUE` (`pessoa_id`),
  KEY `fk_usuario_pessoa_idx` (`pessoa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `pessoa_id`, `senha`, `permissao`) VALUES
(1, 1, 'd677465a55b64dcab9cd3d6a3aae5db5', 1);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_empresas_pessoas1` FOREIGN KEY (`responsavel`) REFERENCES `pessoas` (`pessoa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `fk_registros_empresas1` FOREIGN KEY (`empresa`) REFERENCES `clientes` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_registros_usuarios1` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `sessoes`
--
ALTER TABLE `sessoes`
  ADD CONSTRAINT `fk_sessao_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuario_pessoa` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoas` (`pessoa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

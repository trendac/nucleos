-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.14 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para nucleos
CREATE DATABASE IF NOT EXISTS `nucleos` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `nucleos`;


-- Copiando estrutura para tabela nucleos.funcionalidades
CREATE TABLE IF NOT EXISTS `funcionalidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `modulo_id` int(11) DEFAULT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `FK_funcionalidades_modulos` (`modulo_id`),
  CONSTRAINT `FK_funcionalidades_modulos` FOREIGN KEY (`modulo_id`) REFERENCES `modulos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela nucleos.funcionalidades: ~9 rows (aproximadamente)
DELETE FROM `funcionalidades`;
/*!40000 ALTER TABLE `funcionalidades` DISABLE KEYS */;
INSERT INTO `funcionalidades` (`id`, `name`, `modulo_id`, `active`, `created`, `modified`) VALUES
	(1, 'Usuários', 1, 1, '2014-03-31 21:41:16', '2014-04-04 18:39:27'),
	(2, 'Grupos', 1, 1, '2014-03-31 21:41:38', '2014-04-04 18:39:27'),
	(3, 'Funcionalidades', 1, 1, '2014-03-31 21:42:04', '2014-04-04 18:39:27'),
	(4, 'Permissões', 1, 1, '2014-03-31 21:42:12', '2014-04-04 18:39:27'),
	(9, 'Home', 2, 1, '2014-04-01 10:59:32', '2014-04-01 18:29:33'),
	(10, 'Módulos', 1, 1, '2014-04-01 15:12:20', '2014-04-04 18:39:27'),
	(11, 'Menu', 1, 1, '2014-04-01 15:19:58', '2014-04-21 10:30:19'),
	(12, 'Dashboard', 1, 1, '2014-04-01 22:15:34', '2014-04-04 19:41:15'),
	(13, 'Minha Conta', 2, 1, '2014-04-15 15:21:36', '2014-04-15 15:21:36');
/*!40000 ALTER TABLE `funcionalidades` ENABLE KEYS */;


-- Copiando estrutura para tabela nucleos.funcionalidades_groups
CREATE TABLE IF NOT EXISTS `funcionalidades_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcionalidade_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `funcionalidade_id_group_id` (`funcionalidade_id`,`group_id`),
  KEY `FK_funcionalidades_groups_groups` (`group_id`),
  CONSTRAINT `FK_funcionalidades_groups_funcionalidades` FOREIGN KEY (`funcionalidade_id`) REFERENCES `funcionalidades` (`id`),
  CONSTRAINT `FK_funcionalidades_groups_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela nucleos.funcionalidades_groups: ~8 rows (aproximadamente)
DELETE FROM `funcionalidades_groups`;
/*!40000 ALTER TABLE `funcionalidades_groups` DISABLE KEYS */;
INSERT INTO `funcionalidades_groups` (`id`, `funcionalidade_id`, `group_id`) VALUES
	(45, 1, 1),
	(42, 2, 1),
	(41, 3, 1),
	(44, 4, 1),
	(46, 9, 1),
	(43, 10, 1),
	(40, 12, 1),
	(47, 13, 1);
/*!40000 ALTER TABLE `funcionalidades_groups` ENABLE KEYS */;


-- Copiando estrutura para tabela nucleos.funcionalidades_permissions
CREATE TABLE IF NOT EXISTS `funcionalidades_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcionalidade_id` int(11) NOT NULL DEFAULT '0',
  `permission_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 4` (`funcionalidade_id`,`permission_id`),
  KEY `FK__permissions` (`permission_id`),
  CONSTRAINT `FK__funcionalidades` FOREIGN KEY (`funcionalidade_id`) REFERENCES `funcionalidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK__permissions` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela nucleos.funcionalidades_permissions: ~24 rows (aproximadamente)
DELETE FROM `funcionalidades_permissions`;
/*!40000 ALTER TABLE `funcionalidades_permissions` DISABLE KEYS */;
INSERT INTO `funcionalidades_permissions` (`id`, `funcionalidade_id`, `permission_id`) VALUES
	(23, 1, 12),
	(20, 1, 14),
	(22, 1, 15),
	(21, 1, 16),
	(14, 2, 25),
	(11, 2, 26),
	(13, 2, 27),
	(12, 2, 28),
	(61, 3, 21),
	(58, 3, 22),
	(60, 3, 23),
	(59, 3, 24),
	(28, 4, 2),
	(24, 4, 3),
	(27, 4, 4),
	(25, 4, 5),
	(26, 4, 6),
	(37, 9, 1),
	(41, 10, 30),
	(38, 10, 31),
	(40, 10, 32),
	(39, 10, 33),
	(65, 12, 34),
	(66, 13, 35);
/*!40000 ALTER TABLE `funcionalidades_permissions` ENABLE KEYS */;


-- Copiando estrutura para tabela nucleos.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1',
  `tipo` char(6) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela nucleos.groups: ~3 rows (aproximadamente)
DELETE FROM `groups`;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`, `active`, `tipo`, `created`, `modified`) VALUES
	(1, 'Desenvolvedor', 1, 'I', '2014-03-29 22:01:05', '2014-04-15 15:22:06'),
	(2, 'Cliente', 1, 'E', '0000-00-00 00:00:00', '2014-04-04 19:43:40'),
	(6, 'Administrador', 1, 'I', '2014-03-31 02:50:23', '2014-04-04 18:34:42');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


-- Copiando estrutura para tabela nucleos.groups_permissions
CREATE TABLE IF NOT EXISTS `groups_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id_permission_id` (`group_id`,`permission_id`),
  KEY `FK_groups_permissions_permissions` (`permission_id`),
  CONSTRAINT `FK_groups_permissions_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  CONSTRAINT `FK_groups_permissions_permissions` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela nucleos.groups_permissions: ~0 rows (aproximadamente)
DELETE FROM `groups_permissions`;
/*!40000 ALTER TABLE `groups_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups_permissions` ENABLE KEYS */;


-- Copiando estrutura para tabela nucleos.modulos
CREATE TABLE IF NOT EXISTS `modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela nucleos.modulos: ~2 rows (aproximadamente)
DELETE FROM `modulos`;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` (`id`, `name`, `active`, `created`, `modified`) VALUES
	(1, 'Configurações', 1, '2014-04-01 15:05:59', '2014-04-04 18:39:27'),
	(2, 'Geral', 1, '2014-04-01 15:10:26', '2014-04-01 18:29:33');
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;


-- Copiando estrutura para tabela nucleos.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela nucleos.permissions: ~33 rows (aproximadamente)
DELETE FROM `permissions`;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `description`, `created`, `modified`) VALUES
	(1, 'pages.display', 'Home', '2014-03-25 18:14:42', '2014-03-29 15:14:56'),
	(2, 'permissions.index', NULL, '2014-03-25 18:14:42', '2014-03-25 18:14:42'),
	(3, 'permissions.add', '', '2014-03-25 18:14:42', '2014-03-25 19:46:32'),
	(4, 'permissions.edit', NULL, '2014-03-25 18:14:42', '2014-03-25 18:14:42'),
	(5, 'permissions.checar', 'Verifica permissões que não foram cadastras nos controllers', '2014-03-25 18:14:42', '2014-03-31 20:56:28'),
	(6, 'permissions.delete', NULL, '2014-03-25 18:14:42', '2014-03-25 18:14:42'),
	(12, 'users.index', NULL, '2014-03-25 18:14:42', '2014-03-25 18:14:42'),
	(14, 'users.add', NULL, '2014-03-25 18:14:42', '2014-03-25 18:14:42'),
	(15, 'users.edit', NULL, '2014-03-25 18:14:42', '2014-03-25 18:14:42'),
	(16, 'users.delete', NULL, '2014-03-25 18:14:42', '2014-03-25 18:14:42'),
	(17, 'users.recuperar', 'Inicia processo de recuperação de senha de acesso enviando um e-mail o usuário', '2014-03-25 18:14:42', '2014-03-25 18:54:44'),
	(18, 'users.login', 'Verifica se as credenciais de acesso são validas e salva os dados na sessão ', '2014-03-25 18:14:42', '2014-03-25 18:55:58'),
	(19, 'users.logout', 'Mata os dados da sessão do usuário logado', '2014-03-25 18:14:42', '2014-03-25 18:53:39'),
	(20, 'users.assign', 'Permite que usuários cadastrem suas senhas de acesso ao sistema', '2014-03-30 17:27:11', '2014-03-30 17:27:41'),
	(21, 'funcionalidades.index', NULL, '2014-03-31 04:26:50', '2014-03-31 04:26:50'),
	(22, 'funcionalidades.add', '', '2014-03-31 04:26:50', '2014-04-01 21:02:31'),
	(23, 'funcionalidades.edit', NULL, '2014-03-31 04:26:50', '2014-03-31 04:26:50'),
	(24, 'funcionalidades.delete', NULL, '2014-03-31 04:26:50', '2014-03-31 04:26:50'),
	(25, 'groups.index', NULL, '2014-03-31 04:26:50', '2014-03-31 04:26:50'),
	(26, 'groups.add', NULL, '2014-03-31 04:26:50', '2014-03-31 04:26:50'),
	(27, 'groups.edit', NULL, '2014-03-31 04:26:50', '2014-03-31 04:26:50'),
	(28, 'groups.delete', NULL, '2014-03-31 04:26:50', '2014-03-31 04:26:50'),
	(30, 'modulos.index', NULL, '2014-04-01 15:11:22', '2014-04-01 15:11:22'),
	(31, 'modulos.add', NULL, '2014-04-01 15:11:22', '2014-04-01 15:11:22'),
	(32, 'modulos.edit', NULL, '2014-04-01 15:11:22', '2014-04-01 15:11:22'),
	(33, 'modulos.delete', NULL, '2014-04-01 15:11:22', '2014-04-01 15:11:22'),
	(34, 'configurations.index', 'Dashboard do módulo: Configurações', '2014-04-01 22:14:24', '2014-04-04 18:35:40'),
	(35, 'users.profile', NULL, '2014-04-15 15:19:17', '2014-04-15 15:19:17');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;


-- Copiando estrutura para tabela nucleos.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '1',
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `active` smallint(5) unsigned NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `FK_users_groups` (`group_id`),
  CONSTRAINT `FK_users_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela nucleos.users: ~1 rows (aproximadamente)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `group_id`, `username`, `password`, `name`, `active`, `created`, `modified`) VALUES
	(4, 1, 'demo@nucleos.com', '5b59c08f645574a09fc963c381f872fe63d69601', 'Desenvolvedor', 1, '2014-04-19 17:40:09', '2014-04-21 09:51:38');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

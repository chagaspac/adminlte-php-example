-- MySQL dump 10.13  Distrib 5.7.13, for Linux (x86_64)
--
-- Host: localhost    Database: ordem
-- ------------------------------------------------------
-- Server version	5.7.13-0ubuntu0.16.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `ordem`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `ordem` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ordem`;

--
-- Table structure for table `departamento`
--

DROP TABLE IF EXISTS `departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamento` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `setor` varchar(100) NOT NULL,
  `ramal` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamento`
--

LOCK TABLES `departamento` WRITE;
/*!40000 ALTER TABLE `departamento` DISABLE KEYS */;
INSERT INTO `departamento` VALUES (2,'Financeiro','Economia','2','4080');
/*!40000 ALTER TABLE `departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipamento`
--

DROP TABLE IF EXISTS `equipamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamento` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(2000) NOT NULL,
  `patrimonio` varchar(30) NOT NULL,
  `tipo_equipamento_id` int(11) NOT NULL,
  `departamento_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_equipamento_tipo_equipamento1_idx` (`tipo_equipamento_id`),
  KEY `fk_equipamento_departamento1_idx` (`departamento_id`),
  CONSTRAINT `fk_equipamento_departamento1` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipamento_tipo_equipamento1` FOREIGN KEY (`tipo_equipamento_id`) REFERENCES `tipo_equipamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamento`
--

LOCK TABLES `equipamento` WRITE;
/*!40000 ALTER TABLE `equipamento` DISABLE KEYS */;
INSERT INTO `equipamento` VALUES (2,'Caneta BIC','Bom estado, com tinta','33132',4,2);
/*!40000 ALTER TABLE `equipamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `function`
--

DROP TABLE IF EXISTS `function`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `function` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `function`
--

LOCK TABLES `function` WRITE;
/*!40000 ALTER TABLE `function` DISABLE KEYS */;
/*!40000 ALTER TABLE `function` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` VALUES (1,'Administrador'),(2,'Operador'),(3,'Usuário');
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_functions`
--

DROP TABLE IF EXISTS `grupo_functions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_functions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `grupo_id` bigint(20) NOT NULL,
  `functions_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_has_functions_functions1_idx` (`functions_id`),
  KEY `fk_grupo_has_functions_grupo1_idx` (`grupo_id`),
  CONSTRAINT `fk_grupo_has_functions_functions1` FOREIGN KEY (`functions_id`) REFERENCES `function` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_has_functions_grupo1` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_functions`
--

LOCK TABLES `grupo_functions` WRITE;
/*!40000 ALTER TABLE `grupo_functions` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_functions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_menu`
--

DROP TABLE IF EXISTS `grupo_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_menu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `grupo_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_has_menu_menu1_idx` (`menu_id`),
  KEY `fk_grupo_has_menu_grupo1_idx` (`grupo_id`),
  CONSTRAINT `fk_grupo_has_menu_grupo1` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_has_menu_menu1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_menu`
--

LOCK TABLES `grupo_menu` WRITE;
/*!40000 ALTER TABLE `grupo_menu` DISABLE KEYS */;
INSERT INTO `grupo_menu` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6),(7,1,7),(8,1,8),(9,1,9),(10,2,6),(11,2,7),(12,3,6),(13,3,8),(14,3,9),(15,1,10);
/*!40000 ALTER TABLE `grupo_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensagem`
--

DROP TABLE IF EXISTS `mensagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensagem` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(2000) NOT NULL,
  `dt_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensagem`
--

LOCK TABLES `mensagem` WRITE;
/*!40000 ALTER TABLE `mensagem` DISABLE KEYS */;
INSERT INTO `mensagem` VALUES (1,'AVCBADFA','2016-09-22 05:33:01',1),(2,'asdad','2016-09-22 05:34:00',1),(3,'asdasdasd','2016-09-22 05:34:16',1),(4,'asdasdASD','2016-09-22 05:34:39',1),(5,'TESTEEEEEEEEEEEEE','2016-09-22 06:57:35',1),(6,'TESTEEEEEEEEEEEEE','2016-09-22 06:57:42',1),(7,'TESTEEEEEEEEEEEEE','2016-09-22 06:57:43',1),(8,'t','2016-09-22 07:02:07',1),(9,'asdasdasd','2016-09-22 07:03:26',1),(10,'TESTEE','2016-09-22 07:05:28',1),(11,'TESTEE2','2016-09-22 07:05:30',1),(12,'TESTEE24','2016-09-22 07:05:33',1);
/*!40000 ALTER TABLE `mensagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `url` varchar(50) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `ordem` int(11) NOT NULL,
  `url_pai` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Administrativo','#','fa-list-alt',1,''),(2,'Usuário','usuario.php','fa-user',1,'1'),(3,'Departamento','departamento.php','fa-user',2,'1'),(4,'Equipamento','equipamento.php','fa-user',3,'1'),(5,'Menu','cadastrar_menu.php','fa-user',4,'1'),(6,'Home','home.php','fa-home',0,''),(7,'Solicitações Pendentes','solicitacoes_pendentes.php','fa-home',2,''),(8,'Nova Solicitação','nova_solicitacao.php','fa-home',3,''),(9,'Minhas Solicitações','minhas_solicitacoes.php','fa-home',4,''),(10,'Tipo de Equipamento','tipo_equipamento.php','fa-home',5,'1');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitacao`
--

DROP TABLE IF EXISTS `solicitacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitacao` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `dt_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int(11) NOT NULL,
  `usuario_solicitante_id` bigint(20) NOT NULL,
  `usuario_atendente_id` bigint(20) DEFAULT NULL,
  `dt_resolucao` datetime DEFAULT NULL,
  `equipamento_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ordem_status1_idx` (`status_id`),
  KEY `fk_solicitacao_usuario1_idx` (`usuario_solicitante_id`),
  KEY `fk_solicitacao_usuario2_idx` (`usuario_atendente_id`),
  KEY `fk_solicitacao_equipamento1_idx` (`equipamento_id`),
  CONSTRAINT `fk_ordem_status1` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitacao_equipamento1` FOREIGN KEY (`equipamento_id`) REFERENCES `equipamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitacao_usuario1` FOREIGN KEY (`usuario_solicitante_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitacao_usuario2` FOREIGN KEY (`usuario_atendente_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitacao`
--

LOCK TABLES `solicitacao` WRITE;
/*!40000 ALTER TABLE `solicitacao` DISABLE KEYS */;
INSERT INTO `solicitacao` VALUES (1,'2016-09-22 05:33:01',1,1,NULL,NULL,2),(2,'2016-09-22 05:34:00',3,1,NULL,'2016-09-22 07:15:38',2),(3,'2016-09-22 05:34:16',1,1,NULL,NULL,2),(4,'2016-09-22 05:34:39',1,1,NULL,NULL,2);
/*!40000 ALTER TABLE `solicitacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitacao_mensagem`
--

DROP TABLE IF EXISTS `solicitacao_mensagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitacao_mensagem` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `solicitacao_id` bigint(20) NOT NULL,
  `mensagem_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitacao_has_mensagem_mensagem1_idx` (`mensagem_id`),
  KEY `fk_solicitacao_has_mensagem_solicitacao1_idx` (`solicitacao_id`),
  CONSTRAINT `fk_solicitacao_has_mensagem_mensagem1` FOREIGN KEY (`mensagem_id`) REFERENCES `mensagem` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitacao_has_mensagem_solicitacao1` FOREIGN KEY (`solicitacao_id`) REFERENCES `solicitacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitacao_mensagem`
--

LOCK TABLES `solicitacao_mensagem` WRITE;
/*!40000 ALTER TABLE `solicitacao_mensagem` DISABLE KEYS */;
INSERT INTO `solicitacao_mensagem` VALUES (1,4,4),(2,4,5),(3,4,6),(4,4,7),(5,4,8),(6,4,9),(7,2,10),(8,2,11),(9,2,12);
/*!40000 ALTER TABLE `solicitacao_mensagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status`
--

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` VALUES (3,'Concluída'),(1,'Pendente'),(2,'Processando');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_equipamento`
--

DROP TABLE IF EXISTS `tipo_equipamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_equipamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_equipamento`
--

LOCK TABLES `tipo_equipamento` WRITE;
/*!40000 ALTER TABLE `tipo_equipamento` DISABLE KEYS */;
INSERT INTO `tipo_equipamento` VALUES (2,'Retroprojetores'),(3,'Apagadores'),(4,'Caneta'),(5,'Lápis'),(6,'Gís'),(7,'Notebook');
/*!40000 ALTER TABLE `tipo_equipamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `senha_md5` char(32) NOT NULL,
  `login` varchar(100) NOT NULL,
  `grupo_id` bigint(20) NOT NULL,
  `dt_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_grupo_idx` (`grupo_id`),
  CONSTRAINT `fk_usuario_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Pedro Chagas','e10adc3949ba59abbe56e057f20f883e','chagasaki',1,'2016-09-22 03:48:02'),(2,'Maiara Oliveira','e10adc3949ba59abbe56e057f20f883e','maihe',2,'2016-09-22 04:06:02'),(3,'Thales Brandão','e10adc3949ba59abbe56e057f20f883e','thalesgbrandao',3,'2016-09-22 04:06:02');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-22 15:17:32

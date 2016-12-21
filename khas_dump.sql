# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: cpmy0125.servidorwebfacil.com (MySQL 5.1.66-community-log)
# Database: nepali_khas
# Generation Time: 2016-12-21 15:56:36 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `id_typecategory` int(11) NOT NULL,
  PRIMARY KEY (`id_category`),
  KEY `fk_category_typecategory1_idx` (`id_typecategory`),
  CONSTRAINT `fk_category_typecategory1` FOREIGN KEY (`id_typecategory`) REFERENCES `typecategory` (`id_typecategory`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;

INSERT INTO `category` (`id_category`, `name`, `id_typecategory`)
VALUES
	(3,'Categoria Blog',1),
	(4,'teste2',2),
	(5,'teste',2),
	(6,'Página',3);

/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table comment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(200) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `fk_comment_user1_idx` (`id_user`),
  KEY `fk_comment_post1_idx` (`id_post`),
  CONSTRAINT `fk_comment_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_post1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table datalog
# ------------------------------------------------------------

DROP TABLE IF EXISTS `datalog`;

CREATE TABLE `datalog` (
  `id_datalog` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) DEFAULT NULL,
  `id_post` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `source` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_datalog`),
  KEY `fk_datalog_user1_idx` (`id_user`),
  KEY `fk_datalog_post1_idx` (`id_post`),
  KEY `fk_datalog_product1_idx` (`id_product`),
  CONSTRAINT `fk_datalog_post1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_datalog_product1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_datalog_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `datalog` WRITE;
/*!40000 ALTER TABLE `datalog` DISABLE KEYS */;

INSERT INTO `datalog` (`id_datalog`, `date`, `id_user`, `id_post`, `id_product`, `ip`, `source`)
VALUES
	(1,'2016-12-15 17:09:01',1,3,NULL,'::1',NULL),
	(2,'2016-12-16 08:27:48',1,6,NULL,'::1',''),
	(3,'2016-12-16 09:25:12',1,5,NULL,'::1',''),
	(4,'2016-12-20 08:46:26',1,6,NULL,'::1',''),
	(5,'2016-12-21 13:47:52',1,6,NULL,'200.98.224.27',''),
	(6,'2016-12-21 13:48:26',1,4,NULL,'200.98.224.27','');

/*!40000 ALTER TABLE `datalog` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table event
# ------------------------------------------------------------

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `title` varchar(145) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `hour` varchar(45) DEFAULT NULL,
  `content` text,
  `path` varchar(45) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_event`),
  KEY `fk_event_user1_idx` (`id_user`),
  CONSTRAINT `fk_event_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;

INSERT INTO `event` (`id_event`, `title`, `date`, `hour`, `content`, `path`, `id_user`)
VALUES
	(1,'teste4','2016-09-20','3:00','teste','teste',1),
	(2,'teste2','2016-09-29','14:00','teste','teste',1);

/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table galery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `galery`;

CREATE TABLE `galery` (
  `id_galery` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `slug` varchar(45) DEFAULT NULL,
  `path` varchar(45) DEFAULT NULL,
  `mainpicture` varchar(45) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_galery`),
  KEY `fk_galery_user1_idx` (`id_user`),
  CONSTRAINT `fk_galery_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `galery` WRITE;
/*!40000 ALTER TABLE `galery` DISABLE KEYS */;

INSERT INTO `galery` (`id_galery`, `name`, `slug`, `path`, `mainpicture`, `date`, `id_user`)
VALUES
	(1,'Festa2','festa2','galery_20161221_121709','img-3.jpg','2016-12-21',2),
	(2,'Portfolio','portfolio','galery_20161221_043705','','2016-12-21',2);

/*!40000 ALTER TABLE `galery` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table like
# ------------------------------------------------------------

DROP TABLE IF EXISTS `like`;

CREATE TABLE `like` (
  `id_like` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `placing` int(11) DEFAULT NULL COMMENT 'Nota de 1 a 5 para o projeto.',
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id_like`),
  KEY `fk_like_user1_idx` (`id_user`),
  KEY `fk_like_post1_idx` (`id_post`),
  CONSTRAINT `fk_like_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_like_post1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table manufacturer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `manufacturer`;

CREATE TABLE `manufacturer` (
  `id_manufacturer` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_manufacturer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `manufacturer` WRITE;
/*!40000 ALTER TABLE `manufacturer` DISABLE KEYS */;

INSERT INTO `manufacturer` (`id_manufacturer`, `name`)
VALUES
	(1,'Fabricante');

/*!40000 ALTER TABLE `manufacturer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table newsletter
# ------------------------------------------------------------

DROP TABLE IF EXISTS `newsletter`;

CREATE TABLE `newsletter` (
  `id_newsletter` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(120) DEFAULT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_newsletter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permission`;

CREATE TABLE `permission` (
  `id_permission` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `summary` varchar(250) DEFAULT NULL,
  `content` text,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) DEFAULT '0',
  `status` enum('DRAFT','PUBLISHED') DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `path` varchar(85) DEFAULT NULL,
  `mainpicture` varchar(300) DEFAULT NULL COMMENT 'Guarda a imagem principal do post',
  `type` enum('post','page') DEFAULT NULL,
  `slug` varchar(145) DEFAULT NULL,
  `author` varchar(150) DEFAULT NULL,
  `source` varchar(250) DEFAULT NULL,
  `tags` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id_post`),
  KEY `fk_post_user2_idx` (`id_user`),
  CONSTRAINT `fk_post_user2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;

INSERT INTO `post` (`id_post`, `title`, `summary`, `content`, `date`, `views`, `status`, `id_user`, `path`, `mainpicture`, `type`, `slug`, `author`, `source`, `tags`)
VALUES
	(1,'tesrte2',NULL,'<p>teste</p>','2016-09-13 15:42:37',0,'PUBLISHED',2,'img_post_20160913_083059','teste2',NULL,'tesrte2',NULL,NULL,NULL),
	(3,'teste3',NULL,'<p>teste</p>','2016-09-13 16:22:25',0,'DRAFT',2,'img_post_20160913_085824','teste',NULL,'teste3',NULL,NULL,NULL),
	(4,'teste5',NULL,'<p>testea</p>','2016-09-14 08:47:04',0,'DRAFT',1,'img_post_20160914_014654','teste4',NULL,'teste5',NULL,NULL,NULL),
	(5,'Titulo de testeá',NULL,'<p>Loren ipsun2</p>','2016-09-26 14:27:07',0,'PUBLISHED',1,'img_post_20160926_013230','img-0.jpg',NULL,'titulo-de-testea',NULL,NULL,'teste1, teste2'),
	(6,'Teste Acentuação',NULL,'<p>teste</p>\r\n<p>&nbsp;</p>','2016-12-15 16:41:09',0,'PUBLISHED',1,'img_post_20161215_073208','img-2.jpg',NULL,'teste-acentuacao',NULL,NULL,'social, anúncios, vendas');

/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table post_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `post_category`;

CREATE TABLE `post_category` (
  `id_post` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id_post`,`id_category`),
  KEY `fk_post_has_category_category1_idx` (`id_category`),
  KEY `fk_post_has_category_post1_idx` (`id_post`),
  CONSTRAINT `fk_post_has_category_post1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id_post`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_has_category_category1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `post_category` WRITE;
/*!40000 ALTER TABLE `post_category` DISABLE KEYS */;

INSERT INTO `post_category` (`id_post`, `id_category`)
VALUES
	(1,3),
	(5,3),
	(6,3),
	(4,4),
	(3,5);

/*!40000 ALTER TABLE `post_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(45) DEFAULT NULL,
  `name` varchar(145) DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  `note` text,
  `color` varchar(45) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `data` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `path` varchar(145) DEFAULT NULL,
  `mainpicture` varchar(145) DEFAULT NULL,
  `slug` varchar(145) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `id_provider` int(11) NOT NULL,
  `id_manufacturer` int(11) NOT NULL,
  PRIMARY KEY (`id_product`),
  KEY `fk_product_user1_idx` (`id_user`),
  KEY `fk_product_provider1_idx` (`id_provider`),
  KEY `fk_product_manufacturer1_idx` (`id_manufacturer`),
  CONSTRAINT `fk_product_manufacturer1` FOREIGN KEY (`id_manufacturer`) REFERENCES `manufacturer` (`id_manufacturer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_provider1` FOREIGN KEY (`id_provider`) REFERENCES `provider` (`id_provider`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;

INSERT INTO `product` (`id_product`, `code`, `name`, `price`, `note`, `color`, `size`, `data`, `status`, `path`, `mainpicture`, `slug`, `amount`, `id_user`, `id_provider`, `id_manufacturer`)
VALUES
	(1,'001','Teste','1000.00','Teste','Teste','Teste','2016-12-16 11:50:14','ACTIVE','product_20161216_022129','img-1.jpg','teste',NULL,1,1,1);

/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_category`;

CREATE TABLE `product_category` (
  `id_product` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  PRIMARY KEY (`id_product`,`id_category`),
  KEY `fk_product_has_category_category1_idx` (`id_category`),
  KEY `fk_product_has_category_product1_idx` (`id_product`),
  CONSTRAINT `fk_product_has_category_product1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_product_has_category_category1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;

INSERT INTO `product_category` (`id_product`, `id_category`)
VALUES
	(1,4),
	(1,5);

/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table provider
# ------------------------------------------------------------

DROP TABLE IF EXISTS `provider`;

CREATE TABLE `provider` (
  `id_provider` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `adress` varchar(45) DEFAULT NULL,
  `phone1` varchar(45) DEFAULT NULL,
  `phone2` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `provider` WRITE;
/*!40000 ALTER TABLE `provider` DISABLE KEYS */;

INSERT INTO `provider` (`id_provider`, `name`, `email`, `adress`, `phone1`, `phone2`)
VALUES
	(1,'Fornecedor','email@email.com','Endereço','(11) 0000-0000','(11) 0000-0000');

/*!40000 ALTER TABLE `provider` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stock
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) DEFAULT NULL,
  `min` int(11) DEFAULT NULL,
  `max` int(11) DEFAULT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_product` int(11) NOT NULL,
  PRIMARY KEY (`id_stock`),
  KEY `fk_stock_product1_idx` (`id_product`),
  CONSTRAINT `fk_stock_product1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table typecategory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `typecategory`;

CREATE TABLE `typecategory` (
  `id_typecategory` int(11) NOT NULL AUTO_INCREMENT COMMENT '	',
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_typecategory`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `typecategory` WRITE;
/*!40000 ALTER TABLE `typecategory` DISABLE KEYS */;

INSERT INTO `typecategory` (`id_typecategory`, `name`)
VALUES
	(1,'Blog'),
	(2,'Produto'),
	(3,'Página');

/*!40000 ALTER TABLE `typecategory` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table typeuser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `typeuser`;

CREATE TABLE `typeuser` (
  `id_typeuser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_typeuser`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `typeuser` WRITE;
/*!40000 ALTER TABLE `typeuser` DISABLE KEYS */;

INSERT INTO `typeuser` (`id_typeuser`, `name`)
VALUES
	(1,'Admin');

/*!40000 ALTER TABLE `typeuser` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table typeuser_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `typeuser_permission`;

CREATE TABLE `typeuser_permission` (
  `id_typeuser` int(11) NOT NULL,
  `id_permission` int(11) NOT NULL,
  PRIMARY KEY (`id_typeuser`,`id_permission`),
  KEY `fk_typeuser_has_permission_permission1_idx` (`id_permission`),
  KEY `fk_typeuser_has_permission_typeuser1_idx` (`id_typeuser`),
  CONSTRAINT `fk_typeuser_has_permission_typeuser1` FOREIGN KEY (`id_typeuser`) REFERENCES `typeuser` (`id_typeuser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_typeuser_has_permission_permission1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id_permission`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `numlogin` int(11) DEFAULT '0',
  `date` timestamp NULL DEFAULT NULL,
  `id_typeuser` int(11) NOT NULL DEFAULT '1',
  `lastlogin` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('ACTIVE','INACTIVE') DEFAULT NULL,
  `path` varchar(145) DEFAULT NULL,
  `slug` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `fk_user_typeuser1_idx` (`id_typeuser`),
  CONSTRAINT `fk_user_typeuser1` FOREIGN KEY (`id_typeuser`) REFERENCES `typeuser` (`id_typeuser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id_user`, `name`, `login`, `password`, `email`, `numlogin`, `date`, `id_typeuser`, `lastlogin`, `status`, `path`, `slug`)
VALUES
	(1,'Filipe Rodrigues','filiperdo','123','filipe.rodrigues@nepali.com.br',18,'2016-06-01 00:00:00',1,'2016-12-21 13:49:13','ACTIVE',NULL,NULL),
	(2,'Jonas Rodrigues','jonas','jonas@123','jonasrod@gmail.com',NULL,'2016-06-01 00:00:00',1,'2016-12-21 13:48:58','ACTIVE',NULL,NULL);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

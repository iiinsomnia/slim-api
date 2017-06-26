# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.18)
# Database: slim
# Generation Time: 2017-06-26 08:34:24 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table slim_book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `slim_book`;

CREATE TABLE `slim_book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '书名',
  `subtitle` varchar(50) NOT NULL DEFAULT '' COMMENT '副标题',
  `author` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(20) NOT NULL DEFAULT '' COMMENT '版本',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `publisher` varchar(50) NOT NULL DEFAULT '' COMMENT '出版社',
  `publish_date` varchar(50) NOT NULL DEFAULT '' COMMENT '出版日期',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `slim_book` WRITE;
/*!40000 ALTER TABLE `slim_book` DISABLE KEYS */;

INSERT INTO `slim_book` (`id`, `title`, `subtitle`, `author`, `version`, `price`, `publisher`, `publish_date`, `created_at`, `updated_at`)
VALUES
	(1,'PHP从入门到精通','','明日科技','第三版',69.80,'清华大学出版社','2012年9月','2017-06-19 17:23:13','2017-06-19 17:36:21'),
	(2,'Go语言编程','','许世伟 吕桂华','第一版',49.00,'人民邮电出版社','2012年8月','2017-06-19 17:23:51','2017-06-19 17:36:45'),
	(3,'C程序设计','新世纪计算机基础教育丛书','谭浩强','第三版',26.00,'清华大学出版社','2005年7月','2017-06-19 17:24:28','2017-06-19 17:35:22'),
	(4,'Docker技术入门与实战','','杨保华 戴王剑 曹亚仑','第一版',59.00,'机械工业出版社','2015年1月','2017-06-19 17:27:23','2017-06-19 17:34:10'),
	(5,'Go Web编程','','谢孟军','第一版',65.00,'电子工业出版社','2013年6月','2017-06-19 17:29:54','2017-06-19 17:33:57'),
	(6,'鸟哥的Linux私房菜','基础学习篇','鸟哥','第三版',88.00,'人民邮电出版社','2010年8月','2017-06-19 17:32:29','2017-06-19 17:38:08');

/*!40000 ALTER TABLE `slim_book` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table slim_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `slim_user`;

CREATE TABLE `slim_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `phone` varchar(20) NOT NULL COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` varchar(20) NOT NULL DEFAULT '' COMMENT '加密盐',
  `role` int(11) NOT NULL COMMENT '角色',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最近登录IP',
  `last_login_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最近登录时间',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_username` (`username`),
  UNIQUE KEY `index_email` (`email`),
  UNIQUE KEY `index_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

LOCK TABLES `slim_user` WRITE;
/*!40000 ALTER TABLE `slim_user` DISABLE KEYS */;

INSERT INTO `slim_user` (`id`, `username`, `phone`, `email`, `password`, `salt`, `role`, `last_login_ip`, `last_login_time`, `created_at`, `updated_at`)
VALUES
	(1,'admin','13912999999','admin@qq.com','7734ab9d47e56189d2bbb384be7483b1','dQP!6Bn#^y79Aw3t',1,'127.0.0.1','2017-06-25 12:19:48','2017-06-04 21:03:19','2017-06-25 12:19:48'),
	(2,'slim','13913999999','slim@qq.com','62192e6af1d05ab3945b16161194ba63','I2NEi!tyi7#0!FVa',2,'127.0.0.1','2017-06-17 11:33:29','2017-06-09 09:22:45','2017-06-17 11:33:29'),
	(3,'demo','13914999999','demo@qq.com','027a94619ce748fac471a905af271894','QAfY0TJDhHHmm%8R',3,'127.0.0.1','2017-06-17 10:40:10','2017-06-13 15:14:49','2017-06-17 10:40:10');

/*!40000 ALTER TABLE `slim_user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

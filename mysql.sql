/*
SQLyog Enterprise v12.09 (64 bit)
MySQL - 5.7.14 : Database - pintuan_shop
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pintuan_shop` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `pintuan_shop`;

/*Table structure for table `sp_admin` */

DROP TABLE IF EXISTS `sp_admin`;

CREATE TABLE `sp_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `power` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `sp_admin` */

insert  into `sp_admin`(`id`,`username`,`password`,`question`,`answer`,`phone`,`power`) values (14,'hello','5d41402abc4b2a76b9719d911017c592',NULL,NULL,NULL,1),(13,'xiaochai','113a337f82eeb1829a27c7b4ea124dbd',NULL,NULL,NULL,1),(11,'admin','0192023a7bbd73250516f069df18b500','wenti','daan','13800138000',1),(12,'halou','42500c3668b0daf33a5533c7cf0416c5',NULL,NULL,NULL,2);

/*Table structure for table `sp_cart` */

DROP TABLE IF EXISTS `sp_cart`;

CREATE TABLE `sp_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(9) NOT NULL DEFAULT '0',
  `session_id` char(128) DEFAULT NULL,
  `goods_id` mediumint(9) DEFAULT NULL,
  `goods_name` varchar(120) DEFAULT NULL,
  `goods_price` decimal(10,0) DEFAULT NULL,
  `goods_num` smallint(5) DEFAULT NULL,
  `goods_thumb` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `store` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

/*Data for the table `sp_cart` */

/*Table structure for table `sp_category` */

DROP TABLE IF EXISTS `sp_category`;

CREATE TABLE `sp_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `goods_thumb` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `sort_order` int(4) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

/*Data for the table `sp_category` */

insert  into `sp_category`(`id`,`parent_id`,`name`,`goods_thumb`,`status`,`sort_order`,`create_time`,`update_time`) values (1,0,'服装','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,NULL,NULL),(2,0,'手机','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,NULL,NULL),(82,2,'小米','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,NULL,NULL),(96,1,'奶不起','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,'2018-01-29 04:48:00','2018-01-29 04:48:00'),(95,1,'耐克啊','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,'2018-01-29 04:47:00','2018-01-29 04:47:00'),(94,1,'耐力','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,'2018-01-29 04:46:00','2018-01-29 04:46:00'),(93,2,'可可','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,NULL,NULL),(90,1,'加了','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,'2018-01-28 09:58:00','2018-01-28 09:58:00'),(89,1,'加了','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,'2018-01-28 09:58:00','2018-01-28 09:58:00'),(87,1,'耐克','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,'2018-01-28 09:35:00','2018-01-28 09:35:00'),(86,2,'米其林)','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,NULL,NULL),(85,1,'改来来来了','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,NULL,'2018-01-28 09:59:00'),(84,2,'大大米','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,NULL,NULL),(83,2,'小米5','/public/uploads/images/5a6f2b8e0ba45.jpg',1,NULL,NULL,NULL);

/*Table structure for table `sp_goods` */

DROP TABLE IF EXISTS `sp_goods`;

CREATE TABLE `sp_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_price` varchar(50) DEFAULT NULL,
  `goods_num` int(50) DEFAULT NULL,
  `goods_description` text,
  `goods_thumb` varchar(255) DEFAULT NULL,
  `goods_thumbs` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `comment_num` int(11) NOT NULL DEFAULT '0',
  `sales_volume` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

/*Data for the table `sp_goods` */

insert  into `sp_goods`(`id`,`goods_name`,`goods_price`,`goods_num`,`goods_description`,`goods_thumb`,`goods_thumbs`,`category_id`,`category_name`,`comment_num`,`sales_volume`,`create_time`,`update_time`) values (1,'大神','999',NULL,'<p>aaassssssdvad&nbsp;</p>','/public/uploads/images/5a6f2006614fd.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',89,'服装',0,0,NULL,'2018-01-29 09:22:00'),(17,'肖奈柯','25',NULL,'<p>aaassssssdvad&nbsp;</p>','/public/uploads/images/1516173010.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',87,NULL,0,0,'2018-01-29 08:15:00','2018-01-29 09:32:00'),(5,'小米2555','666',111,'<p>aaassssssdvad&nbsp;</p>','/public/uploads/images/5a6f216908324.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',90,'手机',0,0,NULL,'2018-01-29 09:28:00'),(11,'小可','5556',111,'<p>aaassssssdvad&nbsp;</p>','/public/uploads/images/5a6f2bcbbceb7.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',1,'服装',0,0,NULL,'2018-01-29 10:12:00'),(15,'华为','2999.6',NULL,'<p>66</p>','/public/uploads/images/5a6f2b8e0ba45.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',1,'手机',0,0,NULL,'2018-01-29 10:11:00'),(16,'耐克','699',NULL,'<p>66</p>','/public/uploads/images/5a6f2b8e0ba45.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',1,'服装',0,0,NULL,NULL),(18,'的萨芬','222',NULL,'<p>66</p>','/public/uploads/images/5a6f2b8e0ba45.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',84,NULL,0,0,'2018-01-29 10:23:00','2018-01-29 10:26:00'),(21,'的v','22',NULL,'<p>aaassssssdvad&nbsp;</p>','/public/uploads/images/5a7003e2e46c8.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,'2018-01-29 10:28:00','2018-01-30 01:35:00'),(20,'是','6666',123,'<p>66</p>','/public/uploads/images/5a71644b06a2b.jpg','[\"\\/public\\/uploads\\/images\\/5a71644b06a2b.jpg\",\"\\/public\\/uploads\\/images\\/5a71644b0d8ad.jpg\",\"\\/public\\/uploads\\/images\\/5a71644b10172.jpg\"]',84,NULL,0,0,'2018-01-29 10:26:00','2018-01-29 10:26:00'),(22,'谁','6',22,'<p>ssssaw</p>','/public/uploads/images/5a6fff2cdf396.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',85,NULL,0,0,'2018-01-29 10:29:00','2018-01-30 01:33:00'),(23,'打算','88',131,'<p>99993003ssasa</p>','/public/uploads/images/5a6fff75125b0.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',89,NULL,0,0,'2018-01-29 10:30:00','2018-01-30 01:34:00'),(24,'个百分点','99',121,'<p>990</p>','/public/uploads/images/5a7012df2cf4e.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',84,NULL,0,0,'2018-01-29 10:34:00','2018-01-30 02:38:00'),(25,'的撒','66',25,'<p>555555ss0sd&nbsp;</p>','/public/uploads/images/5a7011af131c2.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,'2018-01-29 10:35:00','2018-01-30 02:35:00'),(26,'ff','66.3',55,'<p>66</p>','/public/uploads/images/5a6f31441de66.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,NULL,NULL),(27,'d','783',NULL,NULL,'/public/uploads/images/5a6f31441de66.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,NULL,NULL),(28,'v','387',NULL,NULL,'/public/uploads/images/5a6f31441de66.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,NULL,NULL),(29,'施峰','87',NULL,NULL,'/public/uploads/images/5a6f31441de66.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,NULL,NULL),(30,'ds','78',NULL,NULL,'/public/uploads/images/5a6f31441de66.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,NULL,NULL),(31,'打发','88',NULL,NULL,'/public/uploads/images/5a6f31441de66.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,NULL,NULL),(32,'速度v','327',NULL,NULL,'/public/uploads/images/5a7164bd50a84.jpg','[\"\\/public\\/uploads\\/images\\/5a7164bd50a84.jpg\",\"\\/public\\/uploads\\/images\\/5a7164bd51a59.jpg\"]',82,NULL,0,0,NULL,'2018-01-31 02:39:00'),(33,'对不起','965',NULL,'<p>aaassssssdvad 发</p>','/public/uploads/images/5a71644b06a2b.jpg','[\"\\/public\\/uploads\\/images\\/5a71644b06a2b.jpg\",\"\\/public\\/uploads\\/images\\/5a71644b0d8ad.jpg\",\"\\/public\\/uploads\\/images\\/5a71644b10172.jpg\"]',82,NULL,0,0,NULL,'2018-01-31 02:38:00'),(34,'十大','55',NULL,NULL,'/public/uploads/images/5a716645b6624.jpg','[\"\\/public\\/uploads\\/images\\/5a716645b6624.jpg\",\"\\/public\\/uploads\\/images\\/5a716645b8d1d.jpg\"]',85,NULL,0,0,'2018-01-31 02:46:00','2018-01-31 02:46:00'),(35,'哈哈','44',NULL,NULL,'/public/uploads/images/5a716bcc08ee7.jpg','[\"\\/public\\/uploads\\/images\\/5a716bcc08ee7.jpg\",\"\\/public\\/uploads\\/images\\/5a716bcc0a49d.jpg\"]',85,NULL,0,0,'2018-01-31 03:10:00','2018-01-31 03:10:00'),(39,'有人','55',NULL,'<p>66</p>','/public/uploads/images/5a716d82db462.jpg','[\"\\/public\\/uploads\\/images\\/5a716d82db462.jpg\"]',89,NULL,0,0,'2018-01-31 03:17:00','2018-01-31 03:17:00'),(40,'vdf','8844',NULL,'<p>的撒fft</p>','/public/uploads/images/5a717e9355324.jpg','[\"\\/public\\/uploads\\/images\\/5a717e9355324.jpg\",\"\\/public\\/uploads\\/images\\/5a717e935658d.jpg\"]',95,NULL,0,0,'2018-01-31 03:18:00','2018-01-31 04:30:00'),(37,'合法的','5',NULL,'<p>的撒</p>','/public/uploads/images/5a716da5733bd.jpg','[\"\\/public\\/uploads\\/images\\/5a716da5733bd.jpg\",\"\\/public\\/uploads\\/images\\/5a716da5744f9.jpg\"]',85,NULL,0,0,'2018-01-31 03:15:00','2018-01-31 03:17:00'),(41,'gsda','999',9999,'<p>sdf</p>','/public/uploads/images/5a717eac60051.jpg','[\"\\/public\\/uploads\\/images\\/5a717eac60051.jpg\",\"\\/public\\/uploads\\/images\\/5a717eac61687.jpg\",\"\\/public\\/uploads\\/images\\/5a717eac62807.jpg\",\"\\/public\\/uploads\\/images\\/5a717eac69339.jpg\"]',89,NULL,0,0,'2018-01-31 04:30:00','2018-01-31 04:30:00');

/*Table structure for table `sp_goods_comment` */

DROP TABLE IF EXISTS `sp_goods_comment`;

CREATE TABLE `sp_goods_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `comment_text` varchar(255) DEFAULT NULL,
  `quality_pf` int(11) DEFAULT NULL,
  `speed_pf` int(11) DEFAULT NULL,
  `attitude_pf` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `sp_goods_comment` */

insert  into `sp_goods_comment`(`id`,`user_id`,`goods_id`,`order_id`,`comment_text`,`quality_pf`,`speed_pf`,`attitude_pf`,`create_time`,`update_time`) values (1,2,25,34,'发电公司的',2,NULL,NULL,'2018-01-29 09:22:00','2018-01-29 09:22:00'),(2,2,25,26,'55',4,2,2,NULL,NULL),(3,2,25,26,'55',4,2,2,NULL,NULL),(4,2,25,26,'55',4,2,2,NULL,NULL);

/*Table structure for table `sp_order` */

DROP TABLE IF EXISTS `sp_order`;

CREATE TABLE `sp_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_sn` varchar(50) DEFAULT NULL COMMENT '序列号',
  `total_amount` decimal(10,0) DEFAULT NULL COMMENT '商品总价',
  `order_amount` decimal(10,0) DEFAULT NULL COMMENT '订单总价',
  `order_status` int(11) NOT NULL DEFAULT '0',
  `active_type` int(11) NOT NULL DEFAULT '0' COMMENT '0正常下单，1拼团',
  `pay_status` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(25) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `confirm_time` datetime DEFAULT NULL,
  `shipping_status` int(11) NOT NULL DEFAULT '0',
  `shipping_name` varchar(30) DEFAULT NULL,
  `shipping_code` varchar(50) DEFAULT NULL,
  `shipping_time` datetime DEFAULT NULL,
  `comment_time` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

/*Data for the table `sp_order` */

insert  into `sp_order`(`id`,`user_id`,`order_sn`,`total_amount`,`order_amount`,`order_status`,`active_type`,`pay_status`,`phone`,`address`,`confirm_time`,`shipping_status`,`shipping_name`,`shipping_code`,`shipping_time`,`comment_time`,`create_time`,`update_time`) values (34,2,'201802020946514676','44','44',7,1,0,'13800138000','广州','2018-02-02 09:21:00',1,'孙峰','555','2018-03-02 12:00:00',NULL,NULL,'2018-03-02 12:02:00'),(33,2,'201802020946353327','55','55',1,1,0,'13800138000','广州',NULL,0,NULL,NULL,NULL,NULL,NULL,'2018-02-03 10:37:00'),(42,2,'201803011412558299','25','25',0,0,0,'1122','来来来',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(31,2,'201802020938576219','17688','17688',1,1,0,'13800138000','广州',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(24,2,'201802012144151062','55','55',0,1,0,'11111111111','改改',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(30,2,'201802020937501294','3000','3000',0,0,0,'13800138000','广州',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(26,2,'201802012146348255','78','78',8,0,1,'111d','发的撒范德萨发生的',NULL,0,NULL,NULL,NULL,'2018-03-01 02:50:00',NULL,'2018-03-01 02:50:00'),(38,2,'201802031755114868','965','965',0,0,0,'222','是大户出身v客户v必胜客点胶设备',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(39,2,'201802031954347213','33','33',4,0,0,'222','是大户出身v客户v必胜客点胶设备',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(40,2,'201803010114472465','6666','6666',0,0,0,'555','的大撒比s\'d',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(41,2,'201803010118371258','6666','6666',0,0,0,'555','的大撒比s\'d',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),(43,2,'201803020018394042','66','66',0,0,0,'1122','来来来',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `sp_order_goods` */

DROP TABLE IF EXISTS `sp_order_goods`;

CREATE TABLE `sp_order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) DEFAULT NULL,
  `goods_price` decimal(10,0) DEFAULT NULL,
  `goods_thumb` varchar(255) DEFAULT NULL,
  `goods_num` mediumint(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

/*Data for the table `sp_order_goods` */

insert  into `sp_order_goods`(`id`,`order_id`,`goods_id`,`goods_name`,`goods_price`,`goods_thumb`,`goods_num`) values (13,13,41,'gsda','999','',1),(12,12,24,'个百分点','99','',2),(11,11,32,'速度v','327','',2),(10,10,23,'打算','88',NULL,NULL),(8,9,40,'vdf','8844',NULL,NULL),(9,9,41,'gsda','999',NULL,NULL),(14,14,40,'vdf','8844',NULL,NULL),(15,15,32,'速度v','327',NULL,NULL),(16,16,39,'有人','55',NULL,NULL),(17,17,34,'十大','55',NULL,NULL),(18,18,34,'十大','55',NULL,NULL),(19,19,34,'十大','55',NULL,NULL),(20,20,34,'十大','55',NULL,NULL),(21,21,34,'十大','55',NULL,NULL),(22,22,34,'十大','55',NULL,NULL),(23,23,34,'十大','55',NULL,NULL),(24,24,34,'十大','55',NULL,NULL),(25,25,30,'ds','78',NULL,NULL),(26,26,30,'ds','78',NULL,NULL),(27,27,24,'个百分点','99',NULL,NULL),(28,27,41,'gsda','999',NULL,NULL),(29,28,24,'个百分点','99',NULL,NULL),(30,28,41,'gsda','999',NULL,NULL),(31,29,40,'vdf','8844',NULL,NULL),(32,30,15,'华为','3000',NULL,NULL),(33,31,40,'vdf','8844',NULL,NULL),(35,33,34,'十大','55','',1),(36,34,35,'哈哈','44','',1),(44,41,20,'是','6666',NULL,NULL),(45,42,17,'肖奈柯','25',NULL,NULL),(43,40,20,'是','6666',NULL,NULL),(42,39,33,'的萨芬','33',NULL,NULL),(41,38,33,'对不起','965',NULL,NULL),(46,43,26,'大水法大水法是i就hi就发生大火复古的萨芬十大','66',NULL,NULL);

/*Table structure for table `sp_team_active` */

DROP TABLE IF EXISTS `sp_team_active`;

CREATE TABLE `sp_team_active` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `team_price` decimal(10,0) DEFAULT NULL,
  `people_num` int(11) DEFAULT NULL,
  `sales_sum` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `goods_id` int(11) DEFAULT NULL,
  `goods_name` varchar(250) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `sp_team_active` */

insert  into `sp_team_active`(`id`,`name`,`team_price`,`people_num`,`sales_sum`,`status`,`goods_id`,`goods_name`,`create_time`,`update_time`) values (1,'十大s0','5',6,1,1,25,'是',NULL,'2018-02-03 03:42:00'),(3,'大水法大水法是i就hi就发生大火复古的萨芬十大','66',5,9,1,26,'gsda','2018-02-03 01:09:00','2018-02-03 01:09:00'),(2,'的萨芬','33',3,1,1,33,'打发',NULL,NULL);

/*Table structure for table `sp_team_follow` */

DROP TABLE IF EXISTS `sp_team_follow`;

CREATE TABLE `sp_team_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `found_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_sn` varchar(50) DEFAULT NULL,
  `follow_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `sp_team_follow` */

insert  into `sp_team_follow`(`id`,`team_id`,`user_id`,`username`,`status`,`found_id`,`order_id`,`order_sn`,`follow_user_id`) values (1,1,2,NULL,2,2,2,NULL,33),(2,1,2,NULL,0,1,2,NULL,NULL);

/*Table structure for table `sp_team_found` */

DROP TABLE IF EXISTS `sp_team_found`;

CREATE TABLE `sp_team_found` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `need_num` int(11) DEFAULT NULL,
  `join_num` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `sp_team_found` */

insert  into `sp_team_found`(`id`,`user_id`,`team_id`,`order_id`,`need_num`,`join_num`,`price`,`status`,`create_time`,`update_time`) values (1,2,1,34,6,2,'55',2,'2018-01-29 09:32:00','2018-01-29 09:32:00'),(2,4,1,33,5,1,'22',2,'2018-01-29 09:32:00',NULL);

/*Table structure for table `sp_user` */

DROP TABLE IF EXISTS `sp_user`;

CREATE TABLE `sp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `question` varchar(200) DEFAULT NULL,
  `answer` varchar(200) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `sex` int(1) DEFAULT '0' COMMENT '0:保密，1:男，2:女',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `sp_user` */

insert  into `sp_user`(`id`,`username`,`password`,`question`,`answer`,`phone`,`sex`) values (1,'xiaochai','aaa123','问题','答案','13800138000',1),(2,'admin','admin123','问题','答案','13800138001',2),(3,'1',NULL,NULL,NULL,NULL,0),(4,'yonghu','aaa123','wen','da','15885888888',0),(20,'dsfasd','47b6a1dc2630d007476be624ea76577c',NULL,NULL,NULL,0),(24,'admin','admin123','dd','dd','13800138000',0);

/*Table structure for table `sp_user_address` */

DROP TABLE IF EXISTS `sp_user_address`;

CREATE TABLE `sp_user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL COMMENT '收货人',
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_default` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `sp_user_address` */

insert  into `sp_user_address`(`id`,`user_id`,`username`,`phone`,`address`,`is_default`) values (1,2,'小可','11111111118','改改56',0),(12,2,'小区','13800138000','广州',0),(23,2,'大苏打','222','是大户出身v客户v必胜客点胶设备',0),(21,2,'是得瑟得瑟','555','的大撒比s\'d',0),(17,2,'宿舍','11152222222','发的撒范德萨发生的',0),(26,2,'谢谢谢','1122','来来来',1),(25,2,'admin','11111112582','vvv',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 5.5.53 : Database - video
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`video` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `video`;

/*Table structure for table `comic` */

DROP TABLE IF EXISTS `comic`;

CREATE TABLE `comic` (
  `Id` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT '主键Id',
  `gmt_create` varchar(60) NOT NULL COMMENT '创建时间时间戳',
  `gmt_modified` varchar(60) NOT NULL COMMENT '上一次修改时间时间戳',
  `is_deleted` tinyint(4) NOT NULL COMMENT '1为删除，0为不删除',
  `ComicUrl` text NOT NULL COMMENT '动漫Url Json格式',
  `ComicNumber` tinyint(4) NOT NULL COMMENT '动漫的Url个数',
  `ComicName` varchar(30) NOT NULL COMMENT '动漫名称',
  `ComicType` varchar(30) NOT NULL COMMENT '动漫类型',
  `ImgUrl` varchar(60) NOT NULL COMMENT '封面的Url',
  `ComicDetailed` text NOT NULL COMMENT '详情描述',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `comic` */

/*Table structure for table `comictype` */

DROP TABLE IF EXISTS `comictype`;

CREATE TABLE `comictype` (
  `TypeId` int(11) NOT NULL AUTO_INCREMENT COMMENT '动画类型的Id，主键',
  `gmt_create` varchar(60) NOT NULL COMMENT '创建时的时间戳',
  `gmt_modified` varchar(60) NOT NULL COMMENT '上一次修改时的时间戳',
  `is_deleted` tinyint(4) NOT NULL COMMENT '删除为1，不删除为0',
  `TypeName` varchar(20) NOT NULL COMMENT '动画类型名称',
  PRIMARY KEY (`TypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='动画类型表';

/*Data for the table `comictype` */

insert  into `comictype`(`TypeId`,`gmt_create`,`gmt_modified`,`is_deleted`,`TypeName`) values 
(1,'1521878042','1522463058',0,'MAD—AMV'),
(2,'1521878053','1522463059',0,'MMD(窑子)'),
(3,'1521878082','1521878082',0,'连载番剧'),
(4,'1521878087','1521878848',0,'完结番剧');

/*Table structure for table `rootuser` */

DROP TABLE IF EXISTS `rootuser`;

CREATE TABLE `rootuser` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `gmt_create` varchar(60) NOT NULL COMMENT '创建时间的时间戳',
  `gmt_modified` varchar(60) NOT NULL COMMENT '上一次修改时间的时间戳',
  `is_delete` tinyint(4) NOT NULL COMMENT '1为删除,0为存在',
  `UserName` varchar(60) NOT NULL COMMENT '管理员账号,唯一性由PHP逻辑来保证',
  `PassWord` varbinary(60) NOT NULL COMMENT '管理员密码的md5值',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `rootuser` */

insert  into `rootuser`(`Id`,`gmt_create`,`gmt_modified`,`is_delete`,`UserName`,`PassWord`) values 
(1,'1521266796','1521266796',0,'admin','21232f297a57a5a743894a0e4a801fc3');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

/*
SQLyog Trial v13.1.8 (64 bit)
MySQL - 10.4.24-MariaDB : Database - api
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`api` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `api`;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(20) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

/*Data for the table `users` */

insert  into `users`(`Id`,`Name`,`Email`,`Password`) values 
(1,'123','123','098f6bcd4621d373cade'),
(2,'12332','12332','098f6bcd4621d373cade'),
(3,'123325','123325','098f6bcd4621d373cade'),
(4,'1233256','1233256','098f6bcd4621d373cade'),
(5,'reynan@g','reynan@g','098f6bcd4621d373cade'),
(6,'reynan@g1','reynan@g1','098f6bcd4621d373cade'),
(7,'reynan@g15','reynan@g15','098f6bcd4621d373cade'),
(8,'reynan@g156','reynan@g156','098f6bcd4621d373cade'),
(9,'reynanestolora@gmail.com','reynanestolora@gmail.com','cb590aaf28085b20f859'),
(10,'reynanestolora1@gmail.com','reynanestolora1@gmail.com','cb590aaf28085b20f859'),
(11,'reynanestolora12@gmail.com','reynanestolora12@gmail.com','cb590aaf28085b20f859'),
(12,'reynanestolora123@gmail.com','reynanestolora123@gmail.com','cb590aaf28085b20f859'),
(13,'reynanestolora14@gmail.com','reynanestolora14@gmail.com','18c134cd4a7960b8e33a'),
(14,'reynanestolora1234@gmail.com','reynanestolora1234@gmail.com','cb590aaf28085b20f859'),
(15,'reynanestolora321@gmail.com','reynanestolora321@gmail.com','cb590aaf28085b20f859'),
(16,'reynanestolora14111@gmail.com','reynanestolora14111@gmail.com','cb590aaf28085b20f859'),
(17,'test','test','098f6bcd4621d373cade'),
(18,'juandc@gmail.com','juandc@gmail.com','e87c6aa7ade8e7062732');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: houserent
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Mr. Admin','admin@gmail.com','1234','e9b8c0aea4f91cec8f3076911b61e1b4d239faebcc5825d743467ecf413da133.jpg');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact`
--

LOCK TABLES `contact` WRITE;
/*!40000 ALTER TABLE `contact` DISABLE KEYS */;
INSERT INTO `contact` VALUES (1,'Test','Test@gmail.com','Test','Test','2022-04-06'),(2,'Customer2','customer@gmail.com','Test','Test message.','2022-04-14');
/*!40000 ALTER TABLE `contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `photo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'cm1','cm1@gmail.com','1234','01700000000','','fd08da34ac0ee63b05b64aed9dcdb070d9bd6c461322121ab9e5e3972e334749.jpg'),(2,'cm2','cm2@gmail.com','1234','','','profile.jpg');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `house`
--

DROP TABLE IF EXISTS `house`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `total_room` int(11) NOT NULL,
  `total_washroom` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_phone` varchar(255) NOT NULL,
  `location` varchar(50) NOT NULL,
  `house_type` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `reference_id` varchar(255) NOT NULL,
  `rent_from` date NOT NULL,
  `photo` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `house`
--

LOCK TABLES `house` WRITE;
/*!40000 ALTER TABLE `house` DISABLE KEYS */;
INSERT INTO `house` VALUES (5,'Shopno Chura',20,10,420,25000,'Three bedrooms are in the flat and two of these have attached balconies. These balconies are on one side of the flat. One space is available for the dining and the drawing. You will be able to clearly make a separation between the two if you decorate carefully. There is also an attendant\'s bathroom within the abode. ','HW1','01700112233','Uttara','Residential','For Rent','826348762','2022-04-04','3bac7abc016c8fee3cc793510915419b2d93160b6e5b1bba73dca72d8cd65b02.jpg, db1c8c7c902bbad463a1dfa0c03b0b8f1618aecc6dd251a5cd268c6947360584.jpg, 0a413b65b95877e3c65e4ea17eda0150a67abef08e42ee92950113186b9b6056.jpg, bc82439bd11f5a04c5107c1fa974d0092e559c6e445c745d4cf3a19432c960a8.jpg',1),(6,'Nikunja',30,15,450,30000,'While you wonder where the best place to settle in could be, Uttara is making progress like never before. The area has seen drastic developments in the past few years and continues to go further with becoming modern every day. ','HW1','01700817239','Uttara','Commercial','For Rent','168231283','2022-04-05','472cc4335c031e748c82bc00588a995210dc53ea919f5f605875d9500eb65c3c.jpg, 06a74d2355294e254caa4ad7ab5beaeded7a33d88465b7f7eb725f8f29bb7679.jpg, 39a6dc027541c78909b5142d599ee84a81af5a56733fdeb522862320d8cb87ed.jpg, 9a0eb9a16ac4670bfecdf31c3f33178cebf900da7d6cc900bbe59abc1938f958.jpg, 0a5dd4a4a8cc300f045912b0a6284218b3f013ad58c76e7682980e747f389753.jpg',1),(7,'Nikunja 2',20,10,510,30000,'The apartment here has three bedrooms and three washrooms. When you enter the flat, you will see that there are two separate spaces to be used as the dining and drawing areas. Two of the bedrooms have balconies attached to them and washrooms are also attached to these bedrooms. You will find an attendant\'s bedroom and bathroom here as well that are placed very close to the kitchen within the abode. ','HW1','01708917171','Dhanmondi','Residential','For Rent','89728391','2022-04-05','6379dfa47c5c931ebba3806406740415fab6085ca144566a54dd17c2c006433d.jpg, eda26390b4c2bdcf00f2153730376e473bd0da5c61246162dd241ca34634cbb8.jpg, 5c21c16dea9049be551e8a941964e9ee22395af27378c8b009809a7058a24ca2.jpg, f2979a3ab785bba64c8375f51fbae44cc3cc821858664b4e4848fd4d9f60e3e1.jpg',1),(8,'Nikunja 3',40,20,1200,24000,'Three bedrooms are in the flat and two of these have attached balconies. These balconies are on one side of the flat. One space is available for the dining and the drawing. You will be able to clearly make a separation between the two if you decorate carefully. There is also an attendant\'s bathroom within the abode. ','HW1','01578234876','Mirpur','Residential','For Rent','24352452','2022-04-05','768630af09a67fda0b402bdd62b4e75ebbfca69e33379eaa5dec9a393ae3a5eb.jpg, 9ce7e4f7b571e5fd830ba45f7baeac4fc67c4e5130b9ef80abe50f98e1b72d30.jpg, 7df6f19c0172adb905e8eace9815f40a3e5e1a3435577983d151156f42e14e60.jpg, ee3edea907cfe7e259ac269b4b4ddf6deca8a399a651ea366d2d8cfbecf5cef9.jpg',2);
/*!40000 ALTER TABLE `house` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `house_booked_list`
--

DROP TABLE IF EXISTS `house_booked_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `house_booked_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `amount` int(11) NOT NULL,
  `payment` varchar(20) NOT NULL,
  `house_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `txn_id` varchar(20) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `owner_name` varchar(255) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `house_booked_list`
--

LOCK TABLES `house_booked_list` WRITE;
/*!40000 ALTER TABLE `house_booked_list` DISABLE KEYS */;
INSERT INTO `house_booked_list` VALUES (31,'Client1','01700000000','Dhaka',20000,'Bkash',5,1,'JKSAHJUA','2022-04-14','HW1',1),(32,'Customer1','01700012345','Dhaka',25000,'Bkash',8,1,'JKSAH1234','2022-04-14','HW1',0);
/*!40000 ALTER TABLE `house_booked_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `house_owner`
--

DROP TABLE IF EXISTS `house_owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `house_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `house_owner`
--

LOCK TABLES `house_owner` WRITE;
/*!40000 ALTER TABLE `house_owner` DISABLE KEYS */;
INSERT INTO `house_owner` VALUES (1,'HW1','01700000000','hw1@gmail.com','1234','profile.jpg'),(3,'hw2','','hw2@gmail.com','1234','cb7543604567e690b6b2157aafb4e3631568518da520e27d1167e90d0d6e976b.jpg');
/*!40000 ALTER TABLE `house_owner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,'Uttara'),(2,'Dhanmondi'),(3,'Mirpur');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-16  9:45:08

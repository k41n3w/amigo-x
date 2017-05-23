-- MySQL dump 10.13  Distrib 5.7.12, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: amigo_x
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `Desejo`
--

DROP TABLE IF EXISTS `Desejo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Desejo` (
  `idDesejo` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idproducts` int(11) NOT NULL,
  PRIMARY KEY (`idDesejo`),
  KEY `fk_Desejo_1_idx` (`iduser`),
  KEY `fk_Desejo_2_idx` (`idproducts`),
  CONSTRAINT `fk_Desejo_1` FOREIGN KEY (`iduser`) REFERENCES `User` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Desejo_2` FOREIGN KEY (`idproducts`) REFERENCES `Products` (`idproducts`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Desejo`
--

LOCK TABLES `Desejo` WRITE;
/*!40000 ALTER TABLE `Desejo` DISABLE KEYS */;
INSERT INTO `Desejo` VALUES (1,2,1),(2,2,2),(3,3,1),(4,6,1);
/*!40000 ALTER TABLE `Desejo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Groups_in`
--

DROP TABLE IF EXISTS `Groups_in`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Groups_in` (
  `idgroups_in` int(11) NOT NULL AUTO_INCREMENT,
  `idgroup` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `finalized` int(1) NOT NULL,
  PRIMARY KEY (`idgroups_in`),
  KEY `fk_Groups_in_1_idx` (`idgroup`),
  KEY `fk_Groups_in_2_idx` (`iduser`),
  CONSTRAINT `fk_Groups_in_1` FOREIGN KEY (`idgroup`) REFERENCES `Grupo` (`idgroup`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Groups_in_2` FOREIGN KEY (`iduser`) REFERENCES `User` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Groups_in`
--

LOCK TABLES `Groups_in` WRITE;
/*!40000 ALTER TABLE `Groups_in` DISABLE KEYS */;
INSERT INTO `Groups_in` VALUES (1,1,2,0),(2,1,3,0),(3,1,4,0),(4,1,5,0),(5,6,6,0),(6,7,2,0);
/*!40000 ALTER TABLE `Groups_in` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Grupo`
--

DROP TABLE IF EXISTS `Grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Grupo` (
  `idgroup` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `owner` int(11) NOT NULL,
  PRIMARY KEY (`idgroup`),
  KEY `fk_Grupo_1_idx` (`owner`),
  CONSTRAINT `fk_Grupo_1` FOREIGN KEY (`owner`) REFERENCES `User` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Grupo`
--

LOCK TABLES `Grupo` WRITE;
/*!40000 ALTER TABLE `Grupo` DISABLE KEYS */;
INSERT INTO `Grupo` VALUES (1,'Grupo 2',2),(2,'Grupo 3',3),(3,'Grupo 4',4),(5,'Grupo 5',5),(6,'Grupo Jeff',6),(7,'',2);
/*!40000 ALTER TABLE `Grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Lottery_relation`
--

DROP TABLE IF EXISTS `Lottery_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Lottery_relation` (
  `idlottery_relation` int(11) NOT NULL AUTO_INCREMENT,
  `idgroup` int(11) NOT NULL,
  `iduserorigin` int(11) NOT NULL,
  `iduserdestination` int(11) NOT NULL,
  PRIMARY KEY (`idlottery_relation`),
  KEY `fk_Lottery_relation_1_idx` (`idgroup`),
  KEY `fk_Lottery_relation_2_idx` (`iduserorigin`),
  KEY `fk_Lottery_relation_3_idx` (`iduserdestination`),
  CONSTRAINT `fk_Lottery_relation_1` FOREIGN KEY (`idgroup`) REFERENCES `Grupo` (`idgroup`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Lottery_relation_2` FOREIGN KEY (`iduserorigin`) REFERENCES `User` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Lottery_relation_3` FOREIGN KEY (`iduserdestination`) REFERENCES `User` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Lottery_relation`
--

LOCK TABLES `Lottery_relation` WRITE;
/*!40000 ALTER TABLE `Lottery_relation` DISABLE KEYS */;
INSERT INTO `Lottery_relation` VALUES (1,1,2,3),(2,1,3,2);
/*!40000 ALTER TABLE `Lottery_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Mensages`
--

DROP TABLE IF EXISTS `Mensages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Mensages` (
  `idmensages` int(11) NOT NULL AUTO_INCREMENT,
  `mensage` varchar(255) NOT NULL,
  `userorigin` int(11) NOT NULL,
  `userreciver` int(11) NOT NULL,
  `datetime` varchar(45) NOT NULL,
  PRIMARY KEY (`idmensages`),
  KEY `fk_Mensages_1_idx` (`userorigin`),
  KEY `fk_Mensages_2_idx` (`userreciver`),
  CONSTRAINT `fk_Mensages_1` FOREIGN KEY (`userorigin`) REFERENCES `User` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Mensages_2` FOREIGN KEY (`userreciver`) REFERENCES `User` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Mensages`
--

LOCK TABLES `Mensages` WRITE;
/*!40000 ALTER TABLE `Mensages` DISABLE KEYS */;
INSERT INTO `Mensages` VALUES (1,'mensagem de teste',2,2,'2017-05-19 16:05');
/*!40000 ALTER TABLE `Mensages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Products`
--

DROP TABLE IF EXISTS `Products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Products` (
  `idproducts` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`idproducts`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Products`
--

LOCK TABLES `Products` WRITE;
/*!40000 ALTER TABLE `Products` DISABLE KEYS */;
INSERT INTO `Products` VALUES (1,'Teste 3',30),(2,'a',1);
/*!40000 ALTER TABLE `Products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sells`
--

DROP TABLE IF EXISTS `Sells`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sells` (
  `idsells` int(11) NOT NULL AUTO_INCREMENT,
  `idproducts` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  PRIMARY KEY (`idsells`),
  KEY `fk_Sells_1_idx` (`idproducts`),
  KEY `fk_Sells_2_idx` (`iduser`),
  CONSTRAINT `fk_Sells_1` FOREIGN KEY (`idproducts`) REFERENCES `Products` (`idproducts`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sells_2` FOREIGN KEY (`iduser`) REFERENCES `User` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sells`
--

LOCK TABLES `Sells` WRITE;
/*!40000 ALTER TABLE `Sells` DISABLE KEYS */;
INSERT INTO `Sells` VALUES (1,1,2),(2,2,3),(3,1,6);
/*!40000 ALTER TABLE `Sells` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (2,'caio','kaineo2','$2y$10$7Zd.TmqTqamNCRy.m7uUu.hn/yM9jYZafPcOFjnlBaCtIa2w55OgC'),(3,'Caio','kaineo','$2y$10$4qagsx/k23DGi.S9y0A8jefIErtpW9c4aezwGN3Xl8w3hcHqXBlR.'),(4,'Caio','caio','$2y$10$k.MECSgN.tz4YzJsgiEY7O6q/.A5iD5qLY038xkcU0ViBOVXWkKo6'),(5,'Caio2','caio2','$2y$10$LJMD3IaARs9URC9BTMUhD.VT1sGyFj3UjPawDtK5ECaBG29hXMit2'),(6,'Jeff','jeff','$2y$10$f1hMjKuOc/cCpr/ssFxaXu75XPqxXUNMG.TA.C9ZeHI96pJ9MXpwO');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-23 16:50:19

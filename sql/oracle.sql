-- MySQL dump 10.19  Distrib 10.3.28-MariaDB, for Linux (aarch64)
--
-- Host: localhost    Database: oracle
-- ------------------------------------------------------
-- Server version	10.3.28-MariaDB

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
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `houses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `meaning` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `houses`
--

LOCK TABLES `houses` WRITE;
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
INSERT INTO `houses` VALUES (1,'1st House of Self','ego, identity, consciousness, focus, appearance, how we are perceived'),(2,'2nd House of Value','finances, possessions, values, self-worth, lending and borrowing, material desires'),(3,'3rd House of Intellect','language, communication, technology, transport, early education, data, perception'),(4,'4th House of Origins','family, home, ancestry, nurturing, youth'),(5,'5th House of Play','fun and games, pleasure, play, hobbies, entertainment, creativity'),(6,'6th House of Service','work (not career), service, health, vitality, healing, pets, daily routines, hygiene, duty'),(7,'7th House of Partners','long term relationships, marriages, business partners, enemies, legal contracts'),(8,'8th House of Transformation','death, sexuality, transformation, the occult, what must be left behind'),(9,'9th House of Journeys','ideology, world-view, higher learning, travel, spirituality'),(10,'10th House of Ambition','career (not work), contributions to society, reputation, social standing, influence, power'),(11,'11th House of Society','community, friendships, wishes, charity, groups, earned wealth'),(12,'12th House of Secrets','secrets, fears, hidden desires, dreams, fantasies, all that lies hidden');
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phases`
--

DROP TABLE IF EXISTS `phases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `meaning` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phases`
--

LOCK TABLES `phases` WRITE;
/*!40000 ALTER TABLE `phases` DISABLE KEYS */;
INSERT INTO `phases` VALUES (1,'&#127761; New Moon','planning ahead, establishing goals, aligning with self, clean slate, a new beginning'),(2,'&#127762; Waxing Crescent','set intention, align with goals, plant seeds'),(3,'&#127763; First Quarter','taking action, overcoming obstacles, first steps, executing plans'),(4,'&#127764; Waxing Gibbous','analyze mistakes, make improvements, finalize details'),(5,'&#127765; Full Moon','harvest intentions, celebrate achievements, receive gifts'),(6,'&#127766; Waning Gibbous','reflect, look inwards, explore biases, self-analyze'),(7,'&#127767; Last Quarter','cleanse, release negativity, forgive mistakes'),(8,'&#127768; Waning Crescent','rest, recuperation, relief'),(9,'&#9728;&#127758;&#127761; Lunar Eclipse','sudden change, transformation, harvesting past cycles'),(10,'&#9728;&#127767;&#127758; Solar Eclipse','release from past cycles, rebirth');
/*!40000 ALTER TABLE `phases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planets`
--

DROP TABLE IF EXISTS `planets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `meaning` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planets`
--

LOCK TABLES `planets` WRITE;
/*!40000 ALTER TABLE `planets` DISABLE KEYS */;
INSERT INTO `planets` VALUES (1,'Sun','ego, basic personality, consciousness, vitality, stamina'),(2,'Moon','unconsciousness, emotions, instincts, habits, moods'),(3,'Mercury','mind, communication, intellect, reason, language, intelligence'),(4,'Venus','attraction, love, relationships, art, beauty, harmony'),(5,'Mars','aggression, sex, action, desire, competition, courage, passion'),(6,'Jupiter','luck, growth, expansion, optimism, abundance, understanding'),(7,'Saturn','structure, law, restriction, discipline, responsibility, obligation, ambition'),(8,'Uranus','eccentricity, unpredictable changes, rebellion, reformation'),(9,'Neptune','dreams, intuition, mysticism, imagination, delusions'),(10,'Pluto','transformation, power, death, rebirth, evolution');
/*!40000 ALTER TABLE `planets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `signs`
--

DROP TABLE IF EXISTS `signs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `signs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `meaning` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `signs`
--

LOCK TABLES `signs` WRITE;
/*!40000 ALTER TABLE `signs` DISABLE KEYS */;
INSERT INTO `signs` VALUES (1,'Aries','brave, powerful, direct, independent, assertive, fearless'),(2,'Taurus','steady, driven, patient, solid, determined, trustworthy'),(3,'Gemini','adaptable, agile, communicative, informative, connected'),(4,'Cancer','nurturing, supportive, healing, compassionate, loving'),(5,'Leo','playful, leader, warm, protective, generous, charismatic'),(6,'Virgo','modest, humble, orderly, altruistic, logical, responsible'),(7,'Libra','charming, harmonious, diplomatic, easy-going, polished'),(8,'Scorpio','passionate, perceptive, emotional, sacrificing, determined'),(9,'Sagittarius','ambitious, lucky, moral, optimistic, enthusiastic, open'),(10,'Capricorn','patient, strategic, determined, disciplined, responsible'),(11,'Aquarius','inventive, humanistic, friendly, altruistic, reformative'),(12,'Pisces','mystical, intuitive, imaginative, compassionate, sensitive');
/*!40000 ALTER TABLE `signs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-15 19:13:42

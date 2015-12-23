# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.42)
# Database: SSL
# Generation Time: 2015-12-23 01:25:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `contactPhone` varchar(50) DEFAULT NULL,
  `contactEmail` varchar(255) DEFAULT NULL,
  `altEmail` varchar(255) DEFAULT NULL,
  `contactWebsite` varchar(255) DEFAULT NULL,
  `contactImage` varchar(255) DEFAULT NULL,
  `contactNotes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;

INSERT INTO `contacts` (`id`, `firstname`, `lastname`, `contactPhone`, `contactEmail`, `altEmail`, `contactWebsite`, `contactImage`, `contactNotes`)
VALUES
	(31,'Luke','Skywalker','800-GET-JEDI','LSkywalker@gmail.com','realJedi@rebels.com','http://www.ReturnoftheJedi.com','images/Luke-rotjpromo.jpg','I will save my father and Lea is my sister'),
	(48,'Mr. John','Smith','1-800-Blue-Pill','GottaGetNeo@thematrix.com','MrAndersonGotAway@neo.com','http://www.thematrix.com','images/agent-smith-standing-in-rain-matrix-revolutions1.jpg','He will not escape me!'),
	(52,'Corey','Gumbs','347-5952347','coreygumbs@gmail.com','cgumbs@fullsail.edu','http://www.twitter.com/GumbsWebDesign','images/me.jpg','My Contact Info'),
	(53,'Barack','Obama','202-123-4567','Folkswannapopoff@whitehouse.us.gov','8yearsanddone@gmail.com','http://www.barackobama.com','images/polls_obama_pointing_small_4758_36797_answer_3_xlarge.jpg','Kiss it.'),
	(62,'Tony','Starks','212-650-2345','IamIronman@starkenterprises.com','Heartofshrapnel@gmail.com','http://www.starkenterprises.com','images/gone_forever__tony_stark_x_male_reader__by_xxdarknymphxx-d8drpzx.png','Billionaire. Playboy. Philanthropist.... Iron Man.'),
	(63,'Annakin','Skywalker','1-800-The-Sith','Iamabigcrybaby@theempire.com','Thedarkside@thedeathstar.com','http://www.starwars.com','images/haydenchristensen1.jpg','Darth Vader'),
	(64,'Test','Test','1234','test@test.com','','','images/Guy_Fawkes_V_for_Vendetta.jpg','');

/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

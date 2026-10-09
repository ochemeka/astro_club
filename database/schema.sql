-- ============================================================
-- Lekki Astro Sports Club - Medical Record System
-- Database schema (structure only, no member data)
-- Compatible with MySQL 5.7+/MariaDB 10.x (XAMPP)
--
-- Usage:
--   mysql -u root -e "CREATE DATABASE IF NOT EXISTS astro_sport_club"
--   mysql -u root astro_sport_club < database/schema.sql
--
-- Default admin account seeded below: admin / admin
-- Change the password immediately after first login.
-- ============================================================

CREATE DATABASE IF NOT EXISTS `astro_sport_club`
  DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `astro_sport_club`;

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admintbl` (
  `adm_id` int(30) NOT NULL AUTO_INCREMENT,
  `adm_username` varchar(300) NOT NULL,
  `adm_password` varchar(300) NOT NULL,
  `adm_status` varchar(300) NOT NULL DEFAULT '1',
  PRIMARY KEY (`adm_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newmember_tbl` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `fname` varchar(300) NOT NULL,
  `lname` varchar(300) NOT NULL,
  `username` text NOT NULL,
  `mem_id` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `img_alt` varchar(300) DEFAULT NULL,
  `phone` varchar(300) NOT NULL,
  `gender` varchar(300) NOT NULL,
  `pulse_rate` varchar(300) DEFAULT NULL,
  `blood_pressure` varchar(300) DEFAULT NULL,
  `weight` varchar(300) DEFAULT NULL,
  `bmi` varchar(300) DEFAULT NULL,
  `height` varchar(300) DEFAULT NULL,
  `password` varchar(300) NOT NULL,
  `temp_pass` varchar(300) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `status` varchar(300) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vitals_tbl` (
  `vitals_id` int(30) NOT NULL AUTO_INCREMENT,
  `id` int(30) NOT NULL,
  `pulse_rate` varchar(300) DEFAULT NULL,
  `blood_pressure` varchar(300) DEFAULT NULL,
  `weight` varchar(300) DEFAULT NULL,
  `height` varchar(300) DEFAULT NULL,
  `bmi` varchar(300) DEFAULT NULL,
  `vacination` varchar(300) DEFAULT NULL,
  `vacination_img` varchar(300) DEFAULT NULL,
  `current_med` text DEFAULT NULL,
  `med_advice_updated_at` datetime DEFAULT NULL,
  `medical_advice` text DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` int(30) DEFAULT 1,
  PRIMARY KEY (`vitals_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(300) NOT NULL,
  `attempted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ip_time` (`ip_address`,`attempted_at`),
  KEY `idx_user_time` (`username`,`attempted_at`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_lockouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identity` varchar(190) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `lock_level` tinyint(4) NOT NULL DEFAULT 1,
  `locked_until` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_identity_ip` (`identity`,`ip_address`),
  KEY `idx_identity` (`identity`),
  KEY `idx_ip` (`ip_address`),
  KEY `idx_until` (`locked_until`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Seed default administrator (password: admin - bcrypt)
INSERT INTO `admintbl` (`adm_username`, `adm_password`, `adm_status`)
SELECT 'admin', '$2y$10$mQAZ1h56n62Mg0S78RBHteAJswRPeLCjUPaUKj6ckuBSKhVCMW3em', '1'
WHERE NOT EXISTS (SELECT 1 FROM `admintbl` WHERE `adm_username` = 'admin');

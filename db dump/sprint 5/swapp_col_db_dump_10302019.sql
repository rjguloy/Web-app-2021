-- --------------------------------------------------------
-- Host:                         10.0.14.23
-- Server version:               5.5.5-10.3.13-MariaDB-1:10.3.13+maria~bionic - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for swapp_col
CREATE DATABASE IF NOT EXISTS `swapp_col` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `swapp_col`;


-- Dumping structure for table swapp_col.checklistactivitydate
CREATE TABLE IF NOT EXISTS `checklistactivitydate` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`),
  KEY `FK_checklistactivitydate_school` (`school_id`),
  CONSTRAINT `FK_checklistactivitydate_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.checklistactivitydate: ~21 rows (approximately)
/*!40000 ALTER TABLE `checklistactivitydate` DISABLE KEYS */;
/*!40000 ALTER TABLE `checklistactivitydate` ENABLE KEYS */;


-- Dumping structure for table swapp_col.division
CREATE TABLE IF NOT EXISTS `division` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`),
  KEY `FK_division_region` (`region_id`),
  CONSTRAINT `FK_division_region` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table swapp_col.division: ~75 rows (approximately)
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
INSERT INTO `division` (`seqid`, `id`, `region_id`, `name`, `createstatus`, `createdby`, `createdate`) VALUES
	(1, 1, 1, 'Alaminos City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(2, 2, 1, 'Batac City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(3, 3, 1, 'Candon City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(4, 4, 1, 'Dagupan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(5, 5, 1, 'Ilocos Norte', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(6, 6, 1, 'Ilocos Sur', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(7, 7, 1, 'La Union', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(8, 8, 1, 'Laoag City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(9, 9, 1, 'Pangasinan I, Lingayen', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(10, 10, 1, 'Pangasinan II, Binalonan', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(11, 11, 1, 'San Carlos City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(12, 12, 1, 'San Fernando City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(13, 13, 1, 'Urdaneta City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(14, 14, 1, 'Vigan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:35:46'),
	(15, 15, 2, 'Batanes', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(16, 16, 2, 'Cagayan', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(17, 17, 2, 'Cauayan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(18, 18, 2, 'City of Ilagan', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(19, 19, 2, 'Isabela', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(20, 20, 2, 'Nueva Vizcaya', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(21, 21, 2, 'Quirino', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(22, 22, 2, 'Santiago City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(23, 23, 2, 'Tuguegarao City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:41:21'),
	(24, 24, 3, 'Angeles City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(25, 25, 3, 'Aurora', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(26, 26, 3, 'Balanga City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(27, 27, 3, 'Bataan', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(28, 28, 3, 'Bulacan', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(29, 29, 3, 'Cabanatuan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(30, 30, 3, 'Gapan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(31, 31, 3, 'Mabalacat City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(32, 32, 3, 'Malolos City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(33, 33, 3, 'Meycauayan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(34, 34, 3, 'Munoz Science City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(35, 35, 3, 'Nueva Ecija', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(36, 36, 3, 'Olongapo City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(37, 37, 3, 'Pampanga', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(38, 38, 3, 'San Fernando City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(39, 39, 3, 'San Jose City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(40, 40, 3, 'San Jose del Monte City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(41, 41, 3, 'Tarlac', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(42, 42, 3, 'Tarlac City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(43, 43, 3, 'Zambales', 'ACTIVE', 'SYSTEM', '2019-10-11 11:48:12'),
	(44, 44, 4, 'Antipolo City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:54:58'),
	(45, 45, 4, 'Bacoor City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:54:58'),
	(46, 46, 4, 'Antipolo City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(47, 47, 4, 'Bacoor City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(48, 48, 4, 'Batangas', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(49, 49, 4, 'Batangas City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(50, 50, 4, 'Binan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(51, 51, 4, 'Calamba City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(52, 52, 4, 'Cavite', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(53, 53, 4, 'Cavite City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(54, 54, 4, 'Dasmarinas City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(55, 55, 4, 'Imus City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(56, 56, 4, 'Laguna', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(57, 57, 4, 'Lipa City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(58, 58, 4, 'Lucena City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(59, 59, 4, 'Quezon', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(60, 60, 4, 'Rizal', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(61, 61, 4, 'San Pablo City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(62, 62, 4, 'Sta. Rosa City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(63, 63, 4, 'Tanauan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(64, 64, 4, 'Tayabas City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:55:07'),
	(65, 65, 5, 'Calapan City', 'ACTIVE', 'SYSTEM', '2019-10-11 11:58:29'),
	(66, 66, 5, 'Marinduque', 'ACTIVE', 'SYSTEM', '2019-10-11 11:58:29'),
	(67, 67, 5, 'Occidental Mindoro', 'ACTIVE', 'SYSTEM', '2019-10-11 11:58:29'),
	(68, 68, 5, 'Oriental Mindoro', 'ACTIVE', 'SYSTEM', '2019-10-11 11:58:29'),
	(69, 69, 5, 'Palawan', 'ACTIVE', 'SYSTEM', '2019-10-11 11:58:29'),
	(70, 70, 5, 'Puerto Princesa', 'ACTIVE', 'SYSTEM', '2019-10-11 11:58:29'),
	(71, 71, 5, 'Romblon', 'ACTIVE', 'SYSTEM', '2019-10-11 11:58:29'),
	(72, 72, 2, 'Isabela', 'ACTIVE', 'SYSTEM', '2019-10-18 01:01:43'),
	(73, 73, 5, 'Marinduque', 'ACTIVE', 'SYSTEM', '2019-10-18 01:05:25'),
	(74, 74, 6, 'Albay', 'ACTIVE', 'SYSTEM', '2019-10-18 01:11:00');
/*!40000 ALTER TABLE `division` ENABLE KEYS */;


-- Dumping structure for table swapp_col.hazard
CREATE TABLE IF NOT EXISTS `hazard` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text DEFAULT NULL,
  `type` enum('HAZARD','CAPACITY','ADDITIONAL') NOT NULL DEFAULT 'ADDITIONAL',
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`),
  KEY `FK_hazard_school` (`school_id`),
  KEY `idx_id_status` (`createstatus`,`id`) USING BTREE,
  CONSTRAINT `FK_hazard_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.hazard: ~48 rows (approximately)
/*!40000 ALTER TABLE `hazard` DISABLE KEYS */;
INSERT INTO `hazard` (`seqid`, `id`, `school_id`, `name`, `description`, `type`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 0, 'Blocked corridor', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(2, 2, 0, 'Blocked/no emergency exits', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(3, 3, 0, 'Broken door knobs', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(4, 4, 0, 'Broken toilet bowl and/or sinks', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(5, 5, 0, 'Broken window', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(6, 6, 0, 'Broken/dilapidated ceiling', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(7, 7, 0, 'Busted electrical facilities', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(8, 8, 0, 'Busted light bulb', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(9, 9, 0, 'Busted plugs', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(10, 10, 0, 'Condemnable building (i.e. very old structure, collapsing building and/or prominent cracks on classroom walls)', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(11, 11, 0, 'Detached/peeled off GI sheet', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(12, 12, 0, 'Dripping ceiling', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(13, 13, 0, 'Exposed chemicals and liquids', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(14, 14, 0, 'Exposed electrical wires', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(15, 15, 0, 'Flooded area', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(16, 16, 0, 'Flooding', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(17, 17, 0, 'Heavy objets mounted on top of cabinets/shelves', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(18, 18, 0, 'Lack/absence of storage for equipment', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(19, 19, 0, 'No posted emergency hotline numbers', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(20, 20, 0, 'No ramps for elevated school buildings or other facilities', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(21, 21, 0, 'No system of release to parents during emergencies', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(22, 22, 0, 'Open pit', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(23, 23, 0, 'Open/clogged canals', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(24, 24, 0, 'Open/incomplete perimeter fence', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(25, 25, 0, 'Plants mounted on the building railings', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(26, 26, 0, 'Presence of electrical post/transformer near or within the school perimeter', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(27, 27, 0, 'Presence of stray animals inside the school campus', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(28, 28, 0, 'Protruding nails in chairs and tables', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(29, 29, 0, 'Slippery pathway', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(30, 30, 0, 'Stagnant water', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(31, 31, 0, 'Swingin doors', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(32, 32, 0, 'Unlabeled chemicals and liquids', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(33, 33, 0, 'Unmounted cabinets/shelves', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(34, 34, 0, 'Unpruned bushes', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(35, 35, 0, 'Unpruned shrubs', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(36, 36, 0, 'Unpruned trees', NULL, 'HAZARD', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(37, 37, 0, 'Fire extinguishers', NULL, 'CAPACITY', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(38, 38, 0, 'Medical kit', NULL, 'CAPACITY', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(39, 39, 0, 'Presence in DRRM bulletin and DRRM IEC materials', NULL, 'CAPACITY', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(40, 40, 0, 'Safe Zone or evacuation area for earthquake, tsunami, etc.', NULL, 'CAPACITY', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(41, 41, 0, 'School clinic', NULL, 'CAPACITY', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59'),
	(42, 42, 0, 'Warning sign: Slippery pathways/corridors', NULL, 'CAPACITY', 'SYSTEM', 'ACTIVE', '2019-08-06 16:08:59');
/*!40000 ALTER TABLE `hazard` ENABLE KEYS */;


-- Dumping structure for table swapp_col.hazardcategory
CREATE TABLE IF NOT EXISTS `hazardcategory` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.hazardcategory: ~5 rows (approximately)
/*!40000 ALTER TABLE `hazardcategory` DISABLE KEYS */;
INSERT INTO `hazardcategory` (`seqid`, `id`, `name`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 'Room', 'SYSTEM', 'ACTIVE', '2019-07-30 12:24:45'),
	(2, 2, 'Floor', 'SYSTEM', 'ACTIVE', '2019-07-30 12:24:57'),
	(3, 3, 'Building', 'SYSTEM', 'ACTIVE', '2019-07-30 12:25:05'),
	(4, 4, 'School Ground', 'SYSTEM', 'ACTIVE', '2019-07-30 12:25:10'),
	(5, 5, 'Others', 'SYSTEM', 'ACTIVE', '2019-07-30 12:25:18');
/*!40000 ALTER TABLE `hazardcategory` ENABLE KEYS */;


-- Dumping structure for table swapp_col.hazarditem
CREATE TABLE IF NOT EXISTS `hazarditem` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `hazardcategory_id` int(11) NOT NULL,
  `hazard_id` int(11) NOT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`),
  KEY `FK_hazard_school` (`school_id`),
  KEY `FK_hazarditems_hazardcategory` (`hazardcategory_id`),
  KEY `FK_hazarditems_hazard` (`hazard_id`),
  CONSTRAINT `FK_hazarditems_hazard` FOREIGN KEY (`hazard_id`) REFERENCES `hazard` (`id`),
  CONSTRAINT `FK_hazarditems_hazardcategory` FOREIGN KEY (`hazardcategory_id`) REFERENCES `hazardcategory` (`id`),
  CONSTRAINT `hazarditem_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.hazarditem: ~49 rows (approximately)
/*!40000 ALTER TABLE `hazarditem` DISABLE KEYS */;
INSERT INTO `hazarditem` (`seqid`, `id`, `school_id`, `hazardcategory_id`, `hazard_id`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 0, 1, 3, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(2, 2, 0, 1, 4, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(3, 3, 0, 1, 5, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(4, 4, 0, 1, 6, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(5, 5, 0, 1, 7, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(6, 6, 0, 1, 8, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(7, 7, 0, 1, 9, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(8, 8, 0, 1, 12, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(9, 9, 0, 1, 13, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(10, 10, 0, 1, 14, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(11, 11, 0, 1, 17, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(12, 12, 0, 1, 28, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(13, 13, 0, 1, 31, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(14, 14, 0, 1, 32, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(15, 15, 0, 1, 33, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(16, 16, 0, 2, 1, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(17, 17, 0, 2, 2, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(18, 18, 0, 2, 8, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(19, 19, 0, 2, 15, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(20, 20, 0, 2, 19, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(21, 21, 0, 2, 25, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(22, 22, 0, 2, 29, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(23, 23, 0, 2, 30, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(24, 24, 0, 2, 37, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(25, 25, 0, 2, 42, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(26, 26, 0, 3, 10, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(27, 27, 0, 3, 11, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(28, 28, 0, 3, 16, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(29, 29, 0, 3, 18, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(30, 30, 0, 3, 20, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(31, 31, 0, 3, 23, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(32, 32, 0, 3, 38, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(33, 33, 0, 4, 8, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(34, 34, 0, 4, 15, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(35, 35, 0, 4, 16, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(36, 36, 0, 4, 22, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(37, 37, 0, 4, 23, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(38, 38, 0, 4, 24, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(39, 39, 0, 4, 26, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(40, 40, 0, 4, 27, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(41, 41, 0, 4, 29, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(42, 42, 0, 4, 30, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(43, 43, 0, 4, 34, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(44, 44, 0, 4, 35, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(45, 45, 0, 4, 36, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(46, 46, 0, 4, 39, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(47, 47, 0, 4, 40, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(48, 48, 0, 4, 41, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36'),
	(49, 49, 0, 5, 21, 'SYSTEM', 'ACTIVE', '2019-08-06 16:33:36');
/*!40000 ALTER TABLE `hazarditem` ENABLE KEYS */;


-- Dumping structure for table swapp_col.hazardstatus
CREATE TABLE IF NOT EXISTS `hazardstatus` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.hazardstatus: ~8 rows (approximately)
/*!40000 ALTER TABLE `hazardstatus` DISABLE KEYS */;
INSERT INTO `hazardstatus` (`seqid`, `id`, `name`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 'Not Yet Started', 'SYSTEM', 'ACTIVE', '2019-07-30 12:20:52'),
	(2, 2, 'On-going', 'SYSTEM', 'ACTIVE', '2019-07-30 12:21:08'),
	(3, 3, 'Not Priority', 'SYSTEM', 'ACTIVE', '2019-07-30 12:21:23'),
	(4, 4, 'Completed', 'SYSTEM', 'ACTIVE', '2019-07-30 12:21:38'),
	(5, 5, 'Unchanged', 'SYSTEM', 'ACTIVE', '2019-07-30 12:21:53'),
	(6, 6, 'Upgraded', 'SYSTEM', 'ACTIVE', '2019-07-30 12:22:09'),
	(7, 7, 'Obselete', 'SYSTEM', 'ACTIVE', '2019-07-30 12:22:41'),
	(8, 8, 'Replaced', 'SYSTEM', 'ACTIVE', '2019-07-30 12:23:51');
/*!40000 ALTER TABLE `hazardstatus` ENABLE KEYS */;


-- Dumping structure for table swapp_col.hazardtype
CREATE TABLE IF NOT EXISTS `hazardtype` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.hazardtype: ~5 rows (approximately)
/*!40000 ALTER TABLE `hazardtype` DISABLE KEYS */;
INSERT INTO `hazardtype` (`seqid`, `id`, `name`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 'Minor Hazard', 'SYSTEM', 'ACTIVE', '2019-07-30 12:19:02'),
	(2, 2, 'Major Hazard', 'SYSTEM', 'ACTIVE', '2019-07-30 12:19:23'),
	(3, 3, 'Sufficient', 'SYSTEM', 'ACTIVE', '2019-07-30 12:19:54'),
	(4, 4, 'Insufficient', 'SYSTEM', 'ACTIVE', '2019-07-30 12:20:12'),
	(5, 5, 'Not Available', 'SYSTEM', 'ACTIVE', '2019-07-30 12:20:27');
/*!40000 ALTER TABLE `hazardtype` ENABLE KEYS */;


-- Dumping structure for table swapp_col.location
CREATE TABLE IF NOT EXISTS `location` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`),
  KEY `FK_location_school` (`school_id`),
  CONSTRAINT `FK_location_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- Dumping data for table swapp_col.location: ~14 rows (approximately)
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
/*!40000 ALTER TABLE `location` ENABLE KEYS */;


-- Dumping structure for table swapp_col.narrative
CREATE TABLE IF NOT EXISTS `narrative` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `cad_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `FK_narrative_checklistactivitydate` (`cad_id`),
  KEY `id` (`id`),
  KEY `FK_narrative_school` (`school_id`),
  CONSTRAINT `FK_narrative_checklistactivitydate` FOREIGN KEY (`cad_id`) REFERENCES `checklistactivitydate` (`id`),
  CONSTRAINT `FK_narrative_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.narrative: ~0 rows (approximately)
/*!40000 ALTER TABLE `narrative` DISABLE KEYS */;
/*!40000 ALTER TABLE `narrative` ENABLE KEYS */;


-- Dumping structure for table swapp_col.record
CREATE TABLE IF NOT EXISTS `record` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `cad_id` int(11) NOT NULL,
  `sublocation_id` int(11) NOT NULL,
  `hazard_id` int(11) NOT NULL,
  `validationdate` datetime DEFAULT NULL,
  `validatedby` varchar(50) DEFAULT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `cad_id` (`cad_id`),
  KEY `sublocation_id` (`sublocation_id`),
  KEY `hazard_id` (`hazard_id`),
  KEY `id` (`id`),
  KEY `FK_record_school` (`school_id`),
  CONSTRAINT `FK__Hazard` FOREIGN KEY (`hazard_id`) REFERENCES `hazard` (`id`),
  CONSTRAINT `FK__Sublocation` FOREIGN KEY (`sublocation_id`) REFERENCES `sublocation` (`id`),
  CONSTRAINT `FK__checklistactivitydate` FOREIGN KEY (`cad_id`) REFERENCES `checklistactivitydate` (`id`),
  CONSTRAINT `FK_record_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=271 DEFAULT CHARSET=utf8;

-- Dumping data for table swapp_col.record: ~138 rows (approximately)
/*!40000 ALTER TABLE `record` DISABLE KEYS */;
/*!40000 ALTER TABLE `record` ENABLE KEYS */;


-- Dumping structure for table swapp_col.recordaction
CREATE TABLE IF NOT EXISTS `recordaction` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `action` text DEFAULT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `FK_narrative_checklistactivitydate` (`record_id`),
  KEY `id` (`id`),
  KEY `FK_recordaction_school` (`school_id`),
  CONSTRAINT `FK_recordaction_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`),
  CONSTRAINT `recordaction_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.recordaction: ~63 rows (approximately)
/*!40000 ALTER TABLE `recordaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordaction` ENABLE KEYS */;


-- Dumping structure for table swapp_col.recordphoto
CREATE TABLE IF NOT EXISTS `recordphoto` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `image` longblob DEFAULT NULL,
  `createdby` varchar(50) CHARACTER SET utf8 NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') CHARACTER SET utf8 NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `FK_narrative_checklistactivitydate` (`record_id`),
  KEY `id` (`id`),
  KEY `FK_recordphoto_school` (`school_id`),
  CONSTRAINT `FK_recordphoto_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`),
  CONSTRAINT `recordphoto_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=317 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.recordphoto: ~149 rows (approximately)
/*!40000 ALTER TABLE `recordphoto` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordphoto` ENABLE KEYS */;


-- Dumping structure for table swapp_col.region
CREATE TABLE IF NOT EXISTS `region` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Dumping data for table swapp_col.region: ~17 rows (approximately)
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` (`seqid`, `id`, `name`, `createstatus`, `createdby`, `createdate`) VALUES
	(1, 1, 'Region I', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(2, 2, 'Region II', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(3, 3, 'Region III', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(4, 4, 'Region IV-A', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(5, 5, 'Region IV-B', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(6, 6, 'Region V', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(7, 7, 'Region VI', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(8, 8, 'Region VII', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(9, 9, 'Region VIII', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(10, 10, 'Region IX', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(11, 11, 'Region X', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(12, 12, 'Region XI', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(13, 13, 'Region XII', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(14, 14, 'NCR', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(15, 15, 'CAR', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(16, 16, 'CARAGA', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39'),
	(17, 17, 'ARMM', 'ACTIVE', 'SYSTEM', '2019-10-11 11:27:39');
/*!40000 ALTER TABLE `region` ENABLE KEYS */;


-- Dumping structure for table swapp_col.school
CREATE TABLE IF NOT EXISTS `school` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`),
  KEY `FK_school_division` (`division_id`),
  CONSTRAINT `FK_school_division` FOREIGN KEY (`division_id`) REFERENCES `division` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.school: ~12 rows (approximately)
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` (`seqid`, `id`, `division_id`, `name`, `address`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 100001, 5, 'Apaleng-Libtong ES', NULL, 'SYSTEM', 'ACTIVE', '2019-10-11 12:04:31'),
	(2, 100002, 5, 'Bacarra CES', NULL, 'SYSTEM', 'ACTIVE', '2019-10-11 12:04:31'),
	(3, 100003, 5, 'Buyon ES', NULL, 'SYSTEM', 'ACTIVE', '2019-10-11 12:04:31'),
	(4, 100004, 5, 'Ganagan Elementary School', NULL, 'SYSTEM', 'ACTIVE', '2019-10-11 12:04:31'),
	(5, 100005, 5, 'Macupit ES', NULL, 'SYSTEM', 'ACTIVE', '2019-10-11 12:04:31'),
	(6, 100006, 5, 'Nambaran ES', NULL, 'SYSTEM', 'ACTIVE', '2019-10-11 12:04:31'),
	(7, 100007, 5, 'Pasiocan ES', NULL, 'SYSTEM', 'ACTIVE', '2019-10-11 12:04:31'),
	(10, 1, 25, 'Test Elem School', NULL, 'SYSTEM', 'ACTIVE', '2019-10-17 13:54:12'),
	(11, 103439, 72, 'A.C. Ruiz Elementary School', NULL, 'SYSTEM', 'ACTIVE', '2019-10-18 01:01:43'),
	(12, 109865, 73, 'Agot ES', NULL, 'SYSTEM', 'ACTIVE', '2019-10-18 01:05:25'),
	(13, 109866, 73, 'Agumaymayan ES', NULL, 'SYSTEM', 'ACTIVE', '2019-10-18 01:07:10'),
	(14, 111584, 74, 'Bacacay East Central School', NULL, 'SYSTEM', 'ACTIVE', '2019-10-18 01:11:00');
/*!40000 ALTER TABLE `school` ENABLE KEYS */;


-- Dumping structure for procedure swapp_col.sp_colreports_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_colreports_get`(
	IN `i_cad` INT
,
	IN `i_region` INT,
	IN `i_division` INT,
	IN `i_school` INT




)
BEGIN
	SELECT 
	b.name, a.hazard_id, b.type,
	COUNT(a.hazard_id) AS region_count,
	(
		SELECT COUNT(h.hazard_id) 
		FROM record AS h
		LEFT JOIN hazard AS i
		ON i.id = h.hazard_id
		LEFT JOIN school AS j
		ON j.id = h.school_id
		WHERE j.division_id = i_division
		AND h.cad_id = i_cad
		AND h.createstatus = 'ACTIVE'
		AND h.hazard_id = a.hazard_id
		GROUP BY h.hazard_id
		ORDER BY i.type ASC, h.hazard_id ASC
	)AS `division_count`,
	(
		SELECT COUNT(k.hazard_id) 
		FROM record AS k
		LEFT JOIN hazard AS l
		ON l.id = k.hazard_id
		WHERE k.school_id = i_school
		AND k.cad_id = i_cad
		AND k.createstatus = 'ACTIVE'
		AND k.hazard_id = a.hazard_id
		GROUP BY k.hazard_id
		ORDER BY l.type ASC, k.hazard_id ASC
	)AS `school_count`,
	CONCAT(c.`from`, ' - ', c.`to`) AS timeline,
	d.`name` AS hazardtype_name,
	e.`name` AS hazardstatus_name 
	FROM record AS a 
	LEFT JOIN hazard AS b
	ON b.id = a.hazard_id
	
	LEFT JOIN summary AS c
	ON c.cad_id = a.cad_id
	AND c.hazard_id = a.hazard_id
	AND c.createstatus = 'ACTIVE'
	
	LEFT JOIN hazardtype AS d
	ON d.id = c.hazardtype_id
	
	LEFT JOIN hazardstatus AS e
	ON e.id = c.hazardstatus_id
	
	LEFT JOIN school AS f
	ON f.id = a.school_id
	
	LEFT JOIN division AS g
	ON g.id = f.division_id
	
	LEFT JOIN region AS h
	ON h.id = g.region_id
	
	WHERE a.cad_id = 6
	AND a.createstatus = 'ACTIVE'
	AND g.region_id = i_region
	GROUP BY a.hazard_id
	ORDER BY b.type ASC, a.hazard_id ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_hazard_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_dashboard_hazard_get`()
BEGIN
	SELECT * FROM 
		(
			SELECT 
			b.name, a.hazard_id, 
			COUNT(a.hazard_id) AS hazard_count
			
			FROM record AS a 
			LEFT JOIN hazard AS b
			ON b.id = a.hazard_id
			
			WHERE YEAR(a.createdate) = YEAR(NOW())
			AND b.type = 'HAZARD'
			AND a.createstatus = 'ACTIVE'
			GROUP BY a.hazard_id
			ORDER BY hazard_count DESC
			LIMIT 10
		) AS z
	ORDER BY RAND();
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_submission_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_dashboard_submission_get`()
BEGIN
	SELECT x.`name` AS region_name, z.school_count, z.region_id
	FROM region AS x 
	LEFT JOIN (
	SELECT COUNT(y.school_id) AS school_count, y.region_id FROM 
		(
			SELECT 
			a.school_id, b.division_id, c.region_id  
			FROM record AS a
			LEFT JOIN school AS b
			ON b.id =  a.school_id
			LEFT JOIN division AS c
			ON c.id = b.division_id
			WHERE YEAR(a.createdate) = YEAR(NOW())
			AND a.createstatus = 'ACTIVE'
			GROUP BY a.school_id
		) AS y
		GROUP BY y.region_id
	) AS z
	ON z.region_id = x.id
	ORDER BY x.id;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_dates_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reports_dates_get`(
	IN `i_school` INT
)
BEGIN
	SELECT `id`, `date` as `name` 
	FROM checklistactivitydate
	WHERE	
	school_id = i_school
	AND createstatus = 'ACTIVE'
	GROUP BY `id`
	ORDER BY `id` DESC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_divisions_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reports_divisions_get`(
	IN `i_region` INT

)
BEGIN
	SELECT c.`id`, c.`name` 
	FROM checklistactivitydate AS a
	LEFT JOIN school AS b
	ON b.id = a.school_id
	LEFT JOIN division AS c
	ON c.id = b.division_id
	WHERE	
	c.region_id = i_region
	AND a.createstatus = 'ACTIVE'
	GROUP BY c.`id`
	ORDER BY c.`id` ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reports_get`(
	IN `i_item` INT,
	IN `i_region` INT,
	IN `i_division` INT,
	IN `i_school` INT,
	IN `i_cad` INT



)
BEGIN
	DECLARE v_where, v_tail VARCHAR(255) DEFAULT '';
	DECLARE v_sql VARCHAR(21844) DEFAULT '';
	
	IF i_item <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.hazard_id = ', i_item); 
	END IF;
	
	IF i_region <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND g.region_id = ', i_region); 
	END IF;
	
	IF i_division <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND f.division_id = ', i_division); 
	END IF;
	
	IF i_school <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.school_id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT 
	b.`name` AS item, a.hazard_id, b.`type`,
	h.`name` AS region_name, g.`name` AS division_name,
	f.`name` AS school_name, z.date,
	COALESCE(
	(
		SELECT COUNT(k.hazard_id) 
		FROM record AS k
		LEFT JOIN hazard AS l
		ON l.id = k.hazard_id
		WHERE k.school_id = a.school_id
		AND k.createstatus = \'ACTIVE\'
		AND k.hazard_id = a.hazard_id
		AND k.cad_id = a.cad_id
		GROUP BY k.hazard_id
	), 0) AS `item_count`,
	CASE WHEN c.`from` IS NOT NULL AND c.`to` IS NOT NULL
	 	THEN CONCAT(c.`from`, \' to \', c.`to`)
	 	ELSE \'\'
	END AS timeline,
	COALESCE(d.`name`, \'\') AS hazardtype_name,
	COALESCE(e.`name`, \'\') AS hazardstatus_name 
	FROM record AS a 
	LEFT JOIN hazard AS b
	ON b.id = a.hazard_id
	
	LEFT JOIN summary AS c
	ON c.cad_id = a.cad_id
	AND c.hazard_id = a.hazard_id
	AND c.createstatus = \'ACTIVE\'
	
	LEFT JOIN hazardtype AS d
	ON d.id = c.hazardtype_id
	
	LEFT JOIN hazardstatus AS e
	ON e.id = c.hazardstatus_id
	
	LEFT JOIN school AS f
	ON f.id = a.school_id
	
	LEFT JOIN division AS g
	ON g.id = f.division_id
	
	LEFT JOIN region AS h
	ON h.id = g.region_id
	
	LEFT JOIN checklistactivitydate AS z
	ON z.id = a.cad_id
	
	WHERE 
	a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' GROUP BY 
	f.division_id, a.school_id, a.cad_id, a.hazard_id
	ORDER BY b.type ASC, a.hazard_id ASC, 
	division_name ASC, school_name ASC';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_itemlist_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reports_itemlist_get`()
BEGIN
	SELECT `id`, `name` 
	FROM hazard 
	WHERE	
	`type` = 'HAZARD'
	AND createstatus = 'ACTIVE'
	ORDER BY `id` ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_regions_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reports_regions_get`()
BEGIN
	SELECT d.`id`, d.`name` 
	FROM checklistactivitydate AS a
	LEFT JOIN school AS b
	ON b.id = a.school_id
	LEFT JOIN division AS c
	ON c.id = b.division_id
	LEFT JOIN region AS d
	ON d.id = c.region_id
	WHERE	
	a.createstatus = 'ACTIVE'
	GROUP BY d.`id`
	ORDER BY d.`id` ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_schools_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reports_schools_get`(
	IN `i_division` INT

)
BEGIN
	SELECT b.`id`, b.`name` 
	FROM checklistactivitydate AS a
	LEFT JOIN school AS b
	ON b.id = a.school_id
	WHERE	
	b.division_id = i_division
	AND a.createstatus = 'ACTIVE'
	GROUP BY b.`id`
	ORDER BY b.`id` ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_school_getbyid
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_school_getbyid`(IN `i_schoolId` INT)
BEGIN

	SELECT * 
	  FROM school
	 WHERE id = i_schoolId
	   AND createstatus = 'ACTIVE';

END//
DELIMITER ;


-- Dumping structure for table swapp_col.sublocation
CREATE TABLE IF NOT EXISTS `sublocation` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `location_id` (`location_id`),
  KEY `id` (`id`),
  KEY `FK_sublocation_school` (`school_id`),
  KEY `idx_common` (`id`,`location_id`,`createstatus`) USING BTREE,
  CONSTRAINT `FK_sublocation_location` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  CONSTRAINT `FK_sublocation_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.sublocation: ~15 rows (approximately)
/*!40000 ALTER TABLE `sublocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `sublocation` ENABLE KEYS */;


-- Dumping structure for table swapp_col.summary
CREATE TABLE IF NOT EXISTS `summary` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `cad_id` int(11) NOT NULL,
  `hazard_id` int(11) NOT NULL,
  `hazardtype_id` int(11) DEFAULT NULL,
  `hazardstatus_id` int(11) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `cad_id` (`cad_id`),
  KEY `hazard_id` (`hazard_id`),
  KEY `FK_summary_hazardtype` (`hazardtype_id`),
  KEY `FK_summary_hazardstatus` (`hazardstatus_id`),
  KEY `id` (`id`),
  KEY `FK_summary_school` (`school_id`),
  CONSTRAINT `FK_summary_checklistactivitydate` FOREIGN KEY (`cad_id`) REFERENCES `checklistactivitydate` (`id`),
  CONSTRAINT `FK_summary_hazardstatus` FOREIGN KEY (`hazardstatus_id`) REFERENCES `hazardstatus` (`id`),
  CONSTRAINT `FK_summary_hazardtype` FOREIGN KEY (`hazardtype_id`) REFERENCES `hazardtype` (`id`),
  CONSTRAINT `FK_summary_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`),
  CONSTRAINT `summary_ibfk_1` FOREIGN KEY (`hazard_id`) REFERENCES `hazard` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.summary: ~8 rows (approximately)
/*!40000 ALTER TABLE `summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `summary` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

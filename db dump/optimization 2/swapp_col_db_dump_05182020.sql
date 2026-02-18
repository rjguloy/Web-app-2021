-- --------------------------------------------------------
-- Host:                         10.0.14.23
-- Server version:               5.5.5-10.4.12-MariaDB-1:10.4.12+maria~bionic - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for swapp_col
DROP DATABASE IF EXISTS `swapp_col`;
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
  KEY `school_id` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.checklistactivitydate: ~2 rows (approximately)
DELETE FROM `checklistactivitydate`;
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

-- Dumping data for table swapp_col.division: ~0 rows (approximately)
DELETE FROM `division`;
/*!40000 ALTER TABLE `division` DISABLE KEYS */;
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
  KEY `idx_id_status` (`createstatus`,`id`) USING BTREE,
  KEY `id` (`id`,`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.hazard: ~42 rows (approximately)
DELETE FROM `hazard`;
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
DELETE FROM `hazardcategory`;
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
  KEY `FK_hazarditems_hazardcategory` (`hazardcategory_id`),
  KEY `FK_hazarditems_hazard` (`hazard_id`),
  KEY `school_id` (`school_id`),
  CONSTRAINT `FK_hazarditems_hazard` FOREIGN KEY (`hazard_id`) REFERENCES `hazard` (`id`),
  CONSTRAINT `FK_hazarditems_hazardcategory` FOREIGN KEY (`hazardcategory_id`) REFERENCES `hazardcategory` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.hazarditem: ~49 rows (approximately)
DELETE FROM `hazarditem`;
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
DELETE FROM `hazardstatus`;
/*!40000 ALTER TABLE `hazardstatus` DISABLE KEYS */;
INSERT INTO `hazardstatus` (`seqid`, `id`, `name`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 'Not Yet Started', 'SYSTEM', 'ACTIVE', '2019-07-30 12:20:52'),
	(2, 2, 'On-going', 'SYSTEM', 'ACTIVE', '2019-07-30 12:21:08'),
	(3, 3, 'Not Priority', 'SYSTEM', 'ACTIVE', '2019-07-30 12:21:23'),
	(4, 4, 'Completed', 'SYSTEM', 'ACTIVE', '2019-07-30 12:21:38'),
	(5, 5, 'Unchanged', 'SYSTEM', 'ACTIVE', '2019-07-30 12:21:53'),
	(6, 6, 'Upgraded', 'SYSTEM', 'ACTIVE', '2019-07-30 12:22:09'),
	(7, 7, 'Obsolete', 'SYSTEM', 'ACTIVE', '2019-07-30 12:22:41'),
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
DELETE FROM `hazardtype`;
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
  KEY `school_id` (`school_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- Dumping data for table swapp_col.location: ~10 rows (approximately)
DELETE FROM `location`;
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
  KEY `school_id` (`school_id`),
  CONSTRAINT `FK_narrative_checklistactivitydate` FOREIGN KEY (`cad_id`) REFERENCES `checklistactivitydate` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.narrative: ~2 rows (approximately)
DELETE FROM `narrative`;
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
  KEY `school_id` (`school_id`),
  CONSTRAINT `FK__Hazard` FOREIGN KEY (`hazard_id`) REFERENCES `hazard` (`id`),
  CONSTRAINT `FK__Sublocation` FOREIGN KEY (`sublocation_id`) REFERENCES `sublocation` (`id`),
  CONSTRAINT `FK__checklistactivitydate` FOREIGN KEY (`cad_id`) REFERENCES `checklistactivitydate` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;

-- Dumping data for table swapp_col.record: ~5 rows (approximately)
DELETE FROM `record`;
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
  KEY `school_id` (`school_id`),
  CONSTRAINT `recordaction_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.recordaction: ~1 rows (approximately)
DELETE FROM `recordaction`;
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
  KEY `school_id` (`school_id`),
  CONSTRAINT `recordphoto_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`) ON DELETE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.recordphoto: ~3 rows (approximately)
DELETE FROM `recordphoto`;
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

-- Dumping data for table swapp_col.region: ~0 rows (approximately)
DELETE FROM `region`;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.school: ~0 rows (approximately)
DELETE FROM `school`;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
/*!40000 ALTER TABLE `school` ENABLE KEYS */;


-- Dumping structure for procedure swapp_col.sp_dashboard_school_submission_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_school_submission_get`(
	IN `i_year` INT,
	IN `i_school` INT,
	IN `i_cad` INT



)
BEGIN
	DECLARE v_where, v_tail VARCHAR(2000) DEFAULT '';
	DECLARE v_sql VARCHAR(21844) DEFAULT '';
	
	IF i_year <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND YEAR(a.date) = ', i_year); 
	END IF;
	
	IF i_school <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.school_id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.id = ', i_cad); 
	END IF;
	
	
	
	SET v_sql = 'SELECT 
	a.id AS loc_id, a.`date` AS loc_name
	FROM checklistactivitydate AS a
	WHERE 
	a.createstatus = \'ACTIVE\'';
		
	 
	
	SET v_tail = CONCAT(' ORDER BY loc_id');
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_submission_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_submission_get`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_school` INT,
	IN `i_cad` INT






)
BEGIN
	DECLARE v_where, v_tail VARCHAR(2000) DEFAULT '';
	DECLARE v_sql VARCHAR(21844) DEFAULT '';
	
	IF i_year <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND YEAR(d.date) = ', i_year); 
	END IF;
	
	IF i_item <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.hazard_id = ', i_item); 
	END IF;
	
	IF i_school <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.school_id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT 
	a.school_id
	FROM record AS a
	LEFT JOIN checklistactivitydate AS d
	ON d.id = a.cad_id
	WHERE a.createstatus = \'ACTIVE\'';
	
	set v_tail = ' GROUP BY a.school_id';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_hazardstatus_getlist
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hazardstatus_getlist`()
BEGIN

	SELECT * FROM hazardstatus;

END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_hazardtype_getlist
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hazardtype_getlist`()
    DETERMINISTIC
BEGIN

	SELECT * FROM hazardtype;

END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_dates_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_dates_get`(
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


-- Dumping structure for procedure swapp_col.sp_reports_dropdown_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_dropdown_get`()
BEGIN
	SELECT a.school_id 
	FROM checklistactivitydate AS a
	WHERE	
	a.createstatus = 'ACTIVE'
	GROUP BY a.school_id
	ORDER BY a.school_id ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_get`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_school` INT,
	IN `i_cad` INT


)
BEGIN
	DECLARE v_where, v_tail VARCHAR(255) DEFAULT '';
	DECLARE v_sql VARCHAR(21844) DEFAULT '';
	
	IF i_year <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND YEAR(z.date) = ', i_year); 
	END IF;
	
	IF i_item <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.hazard_id = ', i_item); 
	END IF;
	
	IF i_school <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.school_id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT 
	b.`name` AS item, a.hazard_id, a.school_id, b.`type`,
	z.date,
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
	
	LEFT JOIN checklistactivitydate AS z
	ON z.id = a.cad_id AND z.school_id = a.school_id
	
	WHERE 
	a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' GROUP BY 
	a.school_id, a.cad_id, a.hazard_id
	ORDER BY b.type ASC, a.hazard_id ASC';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_itemlist_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_itemlist_get`()
BEGIN
	SELECT `id`, `name` 
	FROM hazard 
	WHERE	
	`type` = 'HAZARD'
	AND createstatus = 'ACTIVE'
	ORDER BY `id` ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_yearlist_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_yearlist_get`()
BEGIN
	SELECT YEAR(`date`) AS `year` FROM checklistactivitydate GROUP BY YEAR(`date`);
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
  KEY `idx_common` (`id`,`location_id`,`createstatus`) USING BTREE,
  KEY `school_id` (`school_id`),
  CONSTRAINT `FK_sublocation_location` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.sublocation: ~37 rows (approximately)
DELETE FROM `sublocation`;
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
  KEY `school_id` (`school_id`),
  CONSTRAINT `FK_summary_checklistactivitydate` FOREIGN KEY (`cad_id`) REFERENCES `checklistactivitydate` (`id`),
  CONSTRAINT `FK_summary_hazardstatus` FOREIGN KEY (`hazardstatus_id`) REFERENCES `hazardstatus` (`id`),
  CONSTRAINT `FK_summary_hazardtype` FOREIGN KEY (`hazardtype_id`) REFERENCES `hazardtype` (`id`),
  CONSTRAINT `summary_ibfk_1` FOREIGN KEY (`hazard_id`) REFERENCES `hazard` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp_col.summary: ~6 rows (approximately)
DELETE FROM `summary`;
/*!40000 ALTER TABLE `summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `summary` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

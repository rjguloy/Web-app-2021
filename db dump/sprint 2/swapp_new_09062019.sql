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

-- Dumping database structure for swapp
DROP DATABASE IF EXISTS `swapp`;
CREATE DATABASE IF NOT EXISTS `swapp` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `swapp`;


-- Dumping structure for table swapp.account
DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `username` (`username`),
  CONSTRAINT `FK_account_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.account: ~93 rows (approximately)
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` (`seqid`, `username`, `password`, `createstatus`, `createdate`) VALUES
	(1, 'superadmin', '724b340e5eb3783820060de70bbdf806544504e48a91b5854c2f756f79ae71ee35e945f6c43fa4253eb5ab25b2567b59c5be50afecfe614c879a9839c53ab16cCLEbOgNoGmyFlyicc6IIswlbqXkbO2PhErjKcjGjiWk=', 'ACTIVE', '2019-08-22 07:52:50');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;


-- Dumping structure for table swapp.checklistactivitydate
DROP TABLE IF EXISTS `checklistactivitydate`;
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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.checklistactivitydate: ~31 rows (approximately)
/*!40000 ALTER TABLE `checklistactivitydate` DISABLE KEYS */;
/*!40000 ALTER TABLE `checklistactivitydate` ENABLE KEYS */;


-- Dumping structure for table swapp.hazard
DROP TABLE IF EXISTS `hazard`;
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.hazard: ~42 rows (approximately)
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


-- Dumping structure for table swapp.hazardcategory
DROP TABLE IF EXISTS `hazardcategory`;
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

-- Dumping data for table swapp.hazardcategory: ~5 rows (approximately)
/*!40000 ALTER TABLE `hazardcategory` DISABLE KEYS */;
INSERT INTO `hazardcategory` (`seqid`, `id`, `name`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 'Room', 'SYSTEM', 'ACTIVE', '2019-07-30 12:24:45'),
	(2, 2, 'Floor', 'SYSTEM', 'ACTIVE', '2019-07-30 12:24:57'),
	(3, 3, 'Building', 'SYSTEM', 'ACTIVE', '2019-07-30 12:25:05'),
	(4, 4, 'School Ground', 'SYSTEM', 'ACTIVE', '2019-07-30 12:25:10'),
	(5, 5, 'Others', 'SYSTEM', 'ACTIVE', '2019-07-30 12:25:18');
/*!40000 ALTER TABLE `hazardcategory` ENABLE KEYS */;


-- Dumping structure for table swapp.hazarditem
DROP TABLE IF EXISTS `hazarditem`;
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

-- Dumping data for table swapp.hazarditem: ~49 rows (approximately)
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


-- Dumping structure for table swapp.hazardstatus
DROP TABLE IF EXISTS `hazardstatus`;
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

-- Dumping data for table swapp.hazardstatus: ~8 rows (approximately)
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


-- Dumping structure for table swapp.hazardtype
DROP TABLE IF EXISTS `hazardtype`;
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

-- Dumping data for table swapp.hazardtype: ~5 rows (approximately)
/*!40000 ALTER TABLE `hazardtype` DISABLE KEYS */;
INSERT INTO `hazardtype` (`seqid`, `id`, `name`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 'Minor Hazard', 'SYSTEM', 'ACTIVE', '2019-07-30 12:19:02'),
	(2, 2, 'Major Hazard', 'SYSTEM', 'ACTIVE', '2019-07-30 12:19:23'),
	(3, 3, 'Sufficient', 'SYSTEM', 'ACTIVE', '2019-07-30 12:19:54'),
	(4, 4, 'Insufficient', 'SYSTEM', 'ACTIVE', '2019-07-30 12:20:12'),
	(5, 5, 'Not Available', 'SYSTEM', 'ACTIVE', '2019-07-30 12:20:27');
/*!40000 ALTER TABLE `hazardtype` ENABLE KEYS */;


-- Dumping structure for table swapp.location
DROP TABLE IF EXISTS `location`;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Dumping data for table swapp.location: ~18 rows (approximately)
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
/*!40000 ALTER TABLE `location` ENABLE KEYS */;


-- Dumping structure for table swapp.loginaccess
DROP TABLE IF EXISTS `loginaccess`;
CREATE TABLE IF NOT EXISTS `loginaccess` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `username` (`username`),
  CONSTRAINT `FK_loginaccess_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.loginaccess: ~3 rows (approximately)
/*!40000 ALTER TABLE `loginaccess` DISABLE KEYS */;
/*!40000 ALTER TABLE `loginaccess` ENABLE KEYS */;


-- Dumping structure for table swapp.narrative
DROP TABLE IF EXISTS `narrative`;
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.narrative: ~27 rows (approximately)
/*!40000 ALTER TABLE `narrative` DISABLE KEYS */;
/*!40000 ALTER TABLE `narrative` ENABLE KEYS */;


-- Dumping structure for table swapp.record
DROP TABLE IF EXISTS `record`;
CREATE TABLE IF NOT EXISTS `record` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `cad_id` int(11) NOT NULL,
  `sublocation_id` int(11) NOT NULL,
  `hazard_id` int(11) NOT NULL,
  `validationdate` datetime DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Dumping data for table swapp.record: ~8 rows (approximately)
/*!40000 ALTER TABLE `record` DISABLE KEYS */;
/*!40000 ALTER TABLE `record` ENABLE KEYS */;


-- Dumping structure for table swapp.recordaction
DROP TABLE IF EXISTS `recordaction`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.recordaction: ~0 rows (approximately)
/*!40000 ALTER TABLE `recordaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordaction` ENABLE KEYS */;


-- Dumping structure for table swapp.recordphoto
DROP TABLE IF EXISTS `recordphoto`;
CREATE TABLE IF NOT EXISTS `recordphoto` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `FK_narrative_checklistactivitydate` (`record_id`),
  KEY `id` (`id`),
  KEY `FK_recordphoto_school` (`school_id`),
  CONSTRAINT `FK_recordphoto_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`),
  CONSTRAINT `recordphoto_ibfk_1` FOREIGN KEY (`record_id`) REFERENCES `record` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.recordphoto: ~17 rows (approximately)
/*!40000 ALTER TABLE `recordphoto` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordphoto` ENABLE KEYS */;


-- Dumping structure for table swapp.school
DROP TABLE IF EXISTS `school`;
CREATE TABLE IF NOT EXISTS `school` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `depedserver` varchar(50) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `approver` varchar(50) DEFAULT NULL COMMENT 'standby column for PDF Approver',
  `reviewer` varchar(50) DEFAULT NULL COMMENT 'standby column for PDF Reviewer',
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.school: ~6 rows (approximately)
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` (`seqid`, `id`, `depedserver`, `name`, `address`, `approver`, `reviewer`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, '1234', 'MCCNHS', 'Cebu City', 'Mr. Polano', 'Mr. Polana', 'SYSTEM', 'ACTIVE', '2019-08-23 13:53:55');
/*!40000 ALTER TABLE `school` ENABLE KEYS */;


-- Dumping structure for table swapp.securityquestion
DROP TABLE IF EXISTS `securityquestion`;
CREATE TABLE IF NOT EXISTS `securityquestion` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.securityquestion: ~10 rows (approximately)
/*!40000 ALTER TABLE `securityquestion` DISABLE KEYS */;
INSERT INTO `securityquestion` (`seqid`, `id`, `description`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 1, 'Where is your favorite place for vacation?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(2, 2, 'What is your favorite number?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(3, 3, 'What is your favorite food?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(4, 4, 'Where did you go to high school?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(5, 5, 'Where did you have your first date?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(6, 6, 'Who is you worst nightmare?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(7, 7, 'What was the name of your first pet?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(8, 8, 'What is your favorite book?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(9, 9, 'What is your favorite color?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55'),
	(10, 10, 'What is the first letter of the name of your first crush?', 'SYSTEM', 'ACTIVE', '2019-08-02 18:16:55');
/*!40000 ALTER TABLE `securityquestion` ENABLE KEYS */;


-- Dumping structure for procedure swapp.sp_account_add
DROP PROCEDURE IF EXISTS `sp_account_add`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_account_add`(IN `i_username` VARCHAR(50), IN `i_password` VARCHAR(255))
BEGIN

	INSERT INTO account (username, `password`)
	VALUES (i_username, i_password);
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_account_update
DROP PROCEDURE IF EXISTS `sp_account_update`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_account_update`(IN `i_username` VARCHAR(50), IN `i_password` VARCHAR(255))
BEGIN

	UPDATE account
	   SET createstatus = 'UPDATED'
	 WHERE username = i_username;

	CALL sp_account_add(i_username, i_password);
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklistactivitydate_add
DROP PROCEDURE IF EXISTS `sp_checklistactivitydate_add`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_add`(
	IN `i_date` DATE
,
	IN `i_schoolid` INT
,
	IN `i_createdBy` INT

)
BEGIN

	DECLARE v_id INT;
	
	SELECT COUNT(id) INTO v_id FROM checklistactivitydate;

	INSERT INTO checklistactivitydate (id,school_id,date,createdby)
	VALUES (v_id+1,i_schoolid,i_date,i_createdBy);
	#where not exists 
	#(select 1 from checklistactivitydate where date=i_date);
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklistactivitydate_delete
DROP PROCEDURE IF EXISTS `sp_checklistactivitydate_delete`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_delete`(
	IN `i_id` INT
)
BEGIN
	DELETE FROM checklistactivitydate
	WHERE id = i_id;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklistactivitydate_getByDate
DROP PROCEDURE IF EXISTS `sp_checklistactivitydate_getByDate`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_getByDate`(
	IN `i_date` DATE

)
BEGIN

	SELECT * 
	FROM checklistactivitydate
	WHERE date = i_date;
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklistactivitydate_getByID
DROP PROCEDURE IF EXISTS `sp_checklistactivitydate_getByID`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_getByID`(
	IN `i_id` INT
)
BEGIN
	SELECT * 
	FROM checklistactivitydate
	WHERE id = i_id;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklistactivitydate_getList
DROP PROCEDURE IF EXISTS `sp_checklistactivitydate_getList`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_getList`()
BEGIN

	SELECT * 
	FROM checklistactivitydate
	ORDER BY date ASC;
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklist_ByType
DROP PROCEDURE IF EXISTS `sp_checklist_ByType`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklist_ByType`(
	IN `i_type` VARCHAR(50)






)
BEGIN
	SELECT 
		hazard.id,
		hazard.name,
		CASE
			when (SELECT COUNT(*) FROM hazarditem WHERE hazarditem.hazardcategory_id = 1 AND hazarditem.hazard_id = hazard.id) > 0
			then 'on' ELSE 'off' END AS room,
		CASE
			when (SELECT COUNT(*) FROM hazarditem WHERE hazarditem.hazardcategory_id = 2 AND hazarditem.hazard_id = hazard.id) > 0
			then 'on' ELSE 'off' END AS floor,
		CASE
			when (SELECT COUNT(*) FROM hazarditem WHERE hazarditem.hazardcategory_id = 3 AND hazarditem.hazard_id = hazard.id) > 0
			then 'on' ELSE 'off' END AS building,
		CASE
			when (SELECT COUNT(*) FROM hazarditem WHERE hazarditem.hazardcategory_id = 4 AND hazarditem.hazard_id = hazard.id) > 0
			then 'on' ELSE 'off' END AS schoolGround,
		CASE
			when (SELECT COUNT(*) FROM hazarditem WHERE hazarditem.hazardcategory_id = 5 AND hazarditem.hazard_id = hazard.id) > 0
			then 'on' ELSE 'off' END AS others	
	FROM hazard
	WHERE hazard.type = i_type;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_hazardcat_get
DROP PROCEDURE IF EXISTS `sp_hazardcat_get`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hazardcat_get`()
BEGIN
	SELECT * FROM 
		hazardcategory 
	WHERE 
		createstatus = 'ACTIVE' 
	ORDER BY 
		id ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_locations_add
DROP PROCEDURE IF EXISTS `sp_locations_add`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_locations_add`(
	IN `i_id` INT,
	IN `i_school` INT,
	IN `i_name` VARCHAR(100),
	IN `i_user` VARCHAR(50)
)
BEGIN
	
	DECLARE v_id INT DEFAULT 0;
	
	IF i_id = 0 THEN
		SELECT id  INTO v_id FROM location ORDER BY id DESC LIMIT 1;
		SET i_id = v_id + 1;
	END IF;

	INSERT INTO location (id, school_id, name, createdby) 
	VALUES (i_id, i_school, i_name, i_user);
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_locations_delete
DROP PROCEDURE IF EXISTS `sp_locations_delete`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_locations_delete`(IN `i_id` INT


)
BEGIN
	UPDATE location SET createstatus = 'DELETED' WHERE id = i_id;
	UPDATE sublocation SET createstatus = 'DELETED' WHERE location_id = i_id;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_locations_get
DROP PROCEDURE IF EXISTS `sp_locations_get`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_locations_get`()
BEGIN
	SELECT 
		a.seqid 					AS bldg_seqid,
		a.id 						AS id,
		a.school_id,
		a.name 					AS bldg,
		b.seqid 					AS room_seqid,
		b.id 						AS room_id, 
		b.name					AS room
	FROM location	 			AS a
	LEFT JOIN sublocation 	AS b
	ON b.location_id = a.id 
	AND b.createstatus = 'ACTIVE'
	WHERE a.createstatus = 'ACTIVE'
	ORDER BY a.name ASC, b.name ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_locations_update
DROP PROCEDURE IF EXISTS `sp_locations_update`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_locations_update`(
	IN `i_id` INT,
	IN `i_school` INT,
	IN `i_name` VARCHAR(100)

,
	IN `i_user` VARCHAR(50)
)
BEGIN
	UPDATE location SET createstatus = 'UPDATED' WHERE id = i_id;
	CALL sp_locations_add(i_id, i_school, i_name, i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_location_check
DROP PROCEDURE IF EXISTS `sp_location_check`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_location_check`(
	IN `i_id` INT,
	IN `i_school` INT,
	IN `i_name` VARCHAR(100)


)
BEGIN
	SELECT * FROM location 
	WHERE id <> i_id 
	AND school_id = i_school 
	AND name = i_name 
	AND createstatus = 'ACTIVE';
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_loginaccess_add
DROP PROCEDURE IF EXISTS `sp_loginaccess_add`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_loginaccess_add`(IN `i_username` VARCHAR(50), OUT `o_count` INT)
BEGIN

	INSERT INTO loginaccess (username) VALUES (i_username);
	
	SELECT COUNT(*)
	  INTO o_count
	  FROM loginaccess
	 WHERE username = i_username;

	SELECT o_count;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_loginaccess_delete
DROP PROCEDURE IF EXISTS `sp_loginaccess_delete`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_loginaccess_delete`(IN `i_username` VARCHAR(50))
BEGIN

	DELETE FROM loginaccess WHERE username = i_username;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_narrative_getbychecklistdateid
DROP PROCEDURE IF EXISTS `sp_narrative_getbychecklistdateid`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_narrative_getbychecklistdateid`(IN `i_checklistDateId` INT)
BEGIN

	SELECT * 
	  FROM narrative
	 INNER JOIN checklistactivitydate
	    ON checklistactivitydate.id = narrative.cad_id
	 WHERE checklistactivitydate.id = i_checklistDateId
	   AND narrative.createstatus = 'ACTIVE'
		AND checklistactivitydate.createstatus = 'ACTIVE';

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_narrative_update
DROP PROCEDURE IF EXISTS `sp_narrative_update`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_narrative_update`(IN `i_checklistDateId` INT, IN `i_narrative` TEXT, IN `i_createdBy` VARCHAR(50), IN `i_schoolId` INT)
BEGIN
	
	DECLARE v_id INTEGER;
	DECLARE v_count INTEGER;
	
	SELECT id, COUNT(*)
	  INTO v_id, v_count
	  FROM narrative
	 WHERE cad_id = i_checklistDateId
	   AND createstatus = 'ACTIVE'; 
	   
	IF v_count > 0 THEN	   	  
		UPDATE narrative
	 		SET createstatus = 'UPDATED'
		 WHERE cad_id = i_checklistDateId
	 	   AND createstatus = 'ACTIVE'; 	   
	ELSE
		SELECT MAX(id) +1
	     INTO v_id
	     FROM narrative;
	END IF;
	    
	INSERT INTO narrative (id, school_id, cad_id, description, createdby)
	VALUES (v_id, i_schoolId, i_checklistDateId, i_narrative, i_createdBy);

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_schoolinfo_get
DROP PROCEDURE IF EXISTS `sp_schoolinfo_get`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_schoolinfo_get`()
BEGIN
	SELECT * FROM school WHERE createstatus = 'ACTIVE' LIMIT 1;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_schoolinfo_save
DROP PROCEDURE IF EXISTS `sp_schoolinfo_save`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_schoolinfo_save`(
	IN `i_schoolid` INT,
	IN `i_server` INT,
	IN `i_school` VARCHAR(100),
	IN `i_address` VARCHAR(255),
	IN `i_approver` VARCHAR(50),
	IN `i_reviewer` VARCHAR(50),
	IN `i_user` VARCHAR(50)
)
BEGIN
	
	UPDATE school SET createstatus = 'UPDATED' WHERE createstatus = 'ACTIVE';	
	
	INSERT INTO school (id, depedserver, name, address, approver, reviewer, createdby)
	VALUES (i_schoolid, i_server, i_school, i_address, i_approver, i_reviewer, i_user);

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_securityquestion_getlistbyusername
DROP PROCEDURE IF EXISTS `sp_securityquestion_getlistbyusername`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_securityquestion_getlistbyusername`(IN `i_username` VARCHAR(50))
BEGIN

	SELECT sq.seqid, sq.id, sq.description
	  FROM user_securityquestion usq
	 INNER JOIN securityquestion sq
	    ON sq.id = usq.securityquestion_id
	 WHERE usq.username = i_username
	 ORDER BY usq.seqid DESC LIMIT 3;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_securityquestion_getlistrandom
DROP PROCEDURE IF EXISTS `sp_securityquestion_getlistrandom`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_securityquestion_getlistrandom`()
BEGIN

	SELECT *
	  FROM securityquestion
	 ORDER BY RAND()
	 LIMIT 3;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_securityquestion_validateanswer
DROP PROCEDURE IF EXISTS `sp_securityquestion_validateanswer`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_securityquestion_validateanswer`(IN `i_username` VARCHAR(50), IN `i_securityQuestion` VARCHAR(50), IN `i_answer` VARCHAR(50))
BEGIN

    SELECT COUNT(*) AS isverified
	   FROM user_securityquestion
	  WHERE username = i_username
	    AND securityquestion_id = i_securityQuestion 
		 AND answer = i_answer;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_sublocation_add
DROP PROCEDURE IF EXISTS `sp_sublocation_add`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_sublocation_add`(
	IN `i_id` INT,
	IN `i_school` INT,
	IN `i_loc` INT,
	IN `i_name` VARCHAR(100),
	IN `i_user` VARCHAR(50)
)
BEGIN
	
	DECLARE v_id INT DEFAULT 0;
	
	IF i_id = 0 THEN
		SELECT id INTO v_id FROM sublocation ORDER BY id DESC LIMIT 1;
		SET i_id = v_id + 1;
	END IF;

	INSERT INTO sublocation (id, school_id, location_id, name, createdby) 
	VALUES (i_id, i_school, i_loc, i_name, i_user);
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_sublocation_check
DROP PROCEDURE IF EXISTS `sp_sublocation_check`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_sublocation_check`(
	IN `i_id` INT,
	IN `i_loc` INT,
	IN `i_school` INT,
	IN `i_name` VARCHAR(100)


)
BEGIN
	SELECT * FROM sublocation 
	WHERE id <> i_id 
	AND (location_id = i_loc 
	AND school_id = i_school
	AND name = i_name
	AND createstatus = 'ACTIVE');
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_sublocation_delete
DROP PROCEDURE IF EXISTS `sp_sublocation_delete`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_sublocation_delete`(
	IN `i_id` INT
)
BEGIN
	UPDATE sublocation SET createstatus = 'DELETED' WHERE id = i_id;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_sublocation_update
DROP PROCEDURE IF EXISTS `sp_sublocation_update`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_sublocation_update`(
	IN `i_id` INT,
	IN `i_school` INT,
	IN `i_loc` INT,
	IN `i_name` VARCHAR(100)
,
	IN `i_user` VARCHAR(50)
)
BEGIN
	UPDATE sublocation SET createstatus = 'UPDATED' WHERE id = i_id;
	CALL sp_sublocation_add(i_id, i_school, i_loc, i_name, i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_add_permissions_check
DROP PROCEDURE IF EXISTS `sp_swt_add_permissions_check`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_add_permissions_check`(
	IN `i_team` ENUM('A','B','C'),
	IN `i_loc` INT,
	IN `i_hazcat` INT

)
BEGIN
	SELECT * FROM swtpermission 
	WHERE team = i_team 
	AND sublocation_id = i_loc
	AND hazardcategory_id = i_hazcat
	AND createstatus = 'ACTIVE';
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_members_delete
DROP PROCEDURE IF EXISTS `sp_swt_members_delete`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_members_delete`(
	IN `i_id` VARCHAR(50),
	IN `i_team` ENUM('A','B', 'C'),
	IN `i_name` VARCHAR(50),
	IN `i_gender` ENUM('M','F'),
	IN `i_user` VARCHAR(50)
)
BEGIN
	UPDATE swt SET 
		createstatus = 'UPDATED' 
	WHERE 
		id = i_id;
		
	INSERT INTO 
		swt (id, team, name, gender, createstatus, createdby)
	VALUES
		(i_id, i_team, i_name, i_gender, 'DELETED', i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_members_get
DROP PROCEDURE IF EXISTS `sp_swt_members_get`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_members_get`()
BEGIN
	SELECT * FROM 
		swt 
	WHERE 
		createstatus = 'ACTIVE' 
	ORDER BY 
		team ASC, 
		name ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_member_add
DROP PROCEDURE IF EXISTS `sp_swt_member_add`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_member_add`(
	IN `i_team` VARCHAR(50),
	IN `i_name` VARCHAR(50),
	IN `i_gender` VARCHAR(50),
	IN `i_user` VARCHAR(50)







)
BEGIN
	DECLARE v_id VARCHAR(50);
	DECLARE v_num INT UNSIGNED DEFAULT 0;
	
	SELECT CAST(SUBSTRING(id, 2) AS UNSIGNED), CONCAT(i_team, CAST(SUBSTRING(id, 2) AS UNSIGNED)+1) INTO v_num, v_id 
	FROM 
		swt
	WHERE 
		team = i_team
	ORDER BY
		1 DESC
	LIMIT 1;
	
	INSERT INTO swt (id, team, name, gender, createdby)
	VALUES (v_id, i_team, i_name, i_gender, i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_member_check
DROP PROCEDURE IF EXISTS `sp_swt_member_check`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_member_check`(
	IN `i_id` VARCHAR(50),
	IN `i_name` VARCHAR(50)

)
BEGIN
	SELECT 
		id, team 
	FROM 
		swt
	WHERE
			NAME = i_name
		AND
			id <> i_id
		AND
			createstatus = 'ACTIVE';
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_non_member_check
DROP PROCEDURE IF EXISTS `sp_swt_non_member_check`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_non_member_check`(
	IN `i_team` VARCHAR(50),
	IN `i_id1` VARCHAR(50),
	IN `i_id2` VARCHAR(50),
	IN `i_id3` VARCHAR(50),
	IN `i_id4` VARCHAR(50),
	IN `i_id5` VARCHAR(50)

)
BEGIN
	SELECT id, name, gender, team FROM 
		swt 
	WHERE 
		createstatus = 'ACTIVE'
		AND
		team = i_team
		AND
		id NOT IN (i_id1, i_id2, i_id3, i_id4, i_id5) 
	ORDER BY 
		id ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_permissions_add
DROP PROCEDURE IF EXISTS `sp_swt_permissions_add`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_permissions_add`(
	IN `i_team` ENUM('A','B','C'),
	IN `i_loc` INT,
	IN `i_hazcat` INT,
	IN `i_user` VARCHAR(50)

)
BEGIN
	DECLARE v_id INT DEFAULT 0;
	
	SELECT id INTO v_id 
	FROM 
		swtpermission
	WHERE 
		team = i_team
	ORDER BY
		id DESC
	LIMIT 1;
	
	
	INSERT INTO 
		swtpermission (id, team, sublocation_id, hazardcategory_id, createdby)
	VALUES
		(v_id+1, i_team, i_loc, i_hazcat, i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_permissions_delete
DROP PROCEDURE IF EXISTS `sp_swt_permissions_delete`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_permissions_delete`(
	IN `i_id` INT,
	IN `i_team` ENUM('A','B', 'C'),
	IN `i_loc` INT,
	IN `i_hazcat` INT,
	IN `i_user` VARCHAR(50)


)
BEGIN
	UPDATE swtpermission SET 
		createstatus = 'UPDATED' 
	WHERE 
		id = i_id AND createstatus = 'ACTIVE' AND team = i_team;
		
	INSERT INTO 
		swtpermission (id, team, sublocation_id, hazardcategory_id, createstatus, createdby)
	VALUES
		(i_id, i_team, i_loc, i_hazcat, 'DELETED', i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_permissions_get
DROP PROCEDURE IF EXISTS `sp_swt_permissions_get`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_permissions_get`()
BEGIN
	SELECT * FROM 
		swtpermission 
	WHERE 
		createstatus = 'ACTIVE' 
	ORDER BY 
		team ASC, 
		sublocation_id ASC, 
		hazardcategory_id ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_permissions_hazcat_check
DROP PROCEDURE IF EXISTS `sp_swt_permissions_hazcat_check`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_permissions_hazcat_check`(
	IN `i_team` ENUM('A','B', 'C'),
	IN `i_loc` INT,
	IN `i_ids` VARCHAR(50)

)
BEGIN
	set @sql = concat("SELECT * FROM swtpermission WHERE team = '", i_team, "' 
	AND sublocation_id = ", i_loc, " AND hazardcategory_id NOT IN (", i_ids, ") AND createstatus = 'ACTIVE'");
   PREPARE stmt FROM @sql;
   EXECUTE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_permissions_subloc_check
DROP PROCEDURE IF EXISTS `sp_swt_permissions_subloc_check`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_permissions_subloc_check`(
	IN `i_team` ENUM('A','B', 'C'),
	IN `i_ids` VARCHAR(50)



)
BEGIN
	set @sql = concat("SELECT * FROM swtpermission WHERE team = '", i_team, "' AND sublocation_id NOT IN (", i_ids, ") AND createstatus = 'ACTIVE'");
   PREPARE stmt FROM @sql;
   EXECUTE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_permission_check
DROP PROCEDURE IF EXISTS `sp_swt_permission_check`;
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_swt_permission_check`(
	IN `i_subloc` INT,
	IN `i_hazcat` INT,
	IN `i_team` ENUM('A','B', 'C')
)
BEGIN
	SELECT 
	id, team 
	FROM 
		swtpermission
	WHERE
		sublocation_id = i_subloc
		AND
		hazardcategory_id = i_hazcat
		AND
		createstatus = 'ACTIVE'
		AND
		team NOT IN (i_team);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_user_add
DROP PROCEDURE IF EXISTS `sp_user_add`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_add`(IN `i_username` VARCHAR(50), IN `i_name` VARCHAR(100), IN `i_password` VARCHAR(255), IN `i_securityQuestions` TEXT, IN `i_answers` TEXT)
BEGIN

	INSERT INTO `user` (username, name)
	VALUES (i_username, i_name);
	
	CALL sp_account_add(i_username, i_password);
	
    INSERT INTO user_securityquestion (username, securityquestion_id, answer)
	 VALUES (i_username, (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(i_securityQuestions, ',', 1), ',', -1)), (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(i_answers, ',', 1), ',', -1))),
	 		  (i_username, (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(i_securityQuestions, ',', 2), ',', -1)), (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(i_answers, ',', 2), ',', -1))),
	 		  (i_username, (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(i_securityQuestions, ',', 3), ',', -1)), (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(i_answers, ',', 3), ',', -1)));

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_user_approve
DROP PROCEDURE IF EXISTS `sp_user_approve`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_approve`(IN `i_seqid` VARCHAR(50), IN `i_createdby` VARCHAR(50))
BEGIN

	UPDATE `user`
	   SET validationdate = NOW(),
	   	 createdby = i_createdby
	 WHERE seqid = i_seqid
	   AND createstatus = 'ACTIVE';

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_user_delete
DROP PROCEDURE IF EXISTS `sp_user_delete`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_delete`(IN `i_seqid` INT, IN `i_createdby` VARCHAR(50))
BEGIN

	DECLARE v_username VARCHAR(50);
	DECLARE v_name VARCHAR(50);
	DECLARE v_validationdate DATE;

	UPDATE `user` 
	   SET createstatus = 'UPDATED'
	 WHERE seqid = i_seqid;
	 
	 SELECT username, name, validationdate
	   INTO @v_username, @v_name, @v_validationdate
	   FROM `user`
	  WHERE seqid = i_seqid;
	 
	 INSERT INTO `user` (username, name, validationdate, createdby, createstatus)
	 VALUES (@v_username, @v_name, @v_validationdate, i_createdby, 'DELETED');

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_user_getbyusername
DROP PROCEDURE IF EXISTS `sp_user_getbyusername`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_getbyusername`(IN `i_username` VARCHAR(50))
BEGIN

	SELECT `user`.username AS username, name, validationdate, `password`, account.createdate AS passworddate, DATEDIFF(NOW(), account.createdate) AS passwordduration,
	 		 COUNT(loginaccess.username) AS failedcount, COALESCE(TIME_TO_SEC(TIMEDIFF(NOW(), MAX(loginaccess.createdate))), 0) AS lastloginduration  
	  FROM `user` 
	 INNER JOIN account
	    ON account.username = `user`.username
	  LEFT JOIN loginaccess
	    ON loginaccess.username = `user`.username
	 WHERE `user`.username = i_username
	   AND `user`.createstatus = 'ACTIVE'
		AND account.createstatus = 'ACTIVE';     

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_user_getbywildcard
DROP PROCEDURE IF EXISTS `sp_user_getbywildcard`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_getbywildcard`(IN `i_searchkey` VARCHAR(50))
BEGIN

	SET @i_searchkey = '%' + ISNULL(@i_searchkey) + '%';

	SELECT *, 
			 CASE WHEN validationdate IS NULL THEN 'For Approval'
			 ELSE 'Active'
			 END AS `status`
	  FROM `user`
	 WHERE createstatus = 'ACTIVE'
	   AND (name LIKE @i_searchkey
		 OR username LIKE @i_searchkey);

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_user_getlist
DROP PROCEDURE IF EXISTS `sp_user_getlist`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_getlist`()
BEGIN

	SELECT *, 
			 CASE WHEN validationdate IS NULL THEN 'For Approval'
			 ELSE 'Active'
			 END AS `status`
	  FROM `user`
	 WHERE createstatus = 'ACTIVE'
	   AND username != 'superadmin';

END//
DELIMITER ;


-- Dumping structure for table swapp.sublocation
DROP TABLE IF EXISTS `sublocation`;
CREATE TABLE IF NOT EXISTS `sublocation` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `location_id` (`location_id`),
  KEY `id` (`id`),
  KEY `FK_sublocation_school` (`school_id`),
  KEY `idx_common` (`id`,`location_id`,`createstatus`) USING BTREE,
  CONSTRAINT `FK_sublocation_location` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  CONSTRAINT `FK_sublocation_school` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.sublocation: ~15 rows (approximately)
/*!40000 ALTER TABLE `sublocation` DISABLE KEYS */;
/*!40000 ALTER TABLE `sublocation` ENABLE KEYS */;


-- Dumping structure for table swapp.summary
DROP TABLE IF EXISTS `summary`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.summary: ~0 rows (approximately)
/*!40000 ALTER TABLE `summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `summary` ENABLE KEYS */;


-- Dumping structure for table swapp.swt
DROP TABLE IF EXISTS `swt`;
CREATE TABLE IF NOT EXISTS `swt` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `team` enum('A','B','C') NOT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `id` (`id`),
  KEY `idx_team_status` (`team`,`createstatus`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;

-- Dumping data for table swapp.swt: ~57 rows (approximately)
/*!40000 ALTER TABLE `swt` DISABLE KEYS */;
/*!40000 ALTER TABLE `swt` ENABLE KEYS */;


-- Dumping structure for table swapp.swtpermission
DROP TABLE IF EXISTS `swtpermission`;
CREATE TABLE IF NOT EXISTS `swtpermission` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `team` enum('A','B','C') NOT NULL,
  `sublocation_id` int(11) NOT NULL,
  `hazardcategory_id` int(11) NOT NULL,
  `createdby` varchar(50) NOT NULL,
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `FK_swtpermission_sublocation` (`sublocation_id`),
  KEY `FK_swtpermission_hazardcategory` (`hazardcategory_id`),
  KEY `id` (`id`),
  CONSTRAINT `FK_swtpermission_hazardcategory` FOREIGN KEY (`hazardcategory_id`) REFERENCES `hazardcategory` (`id`),
  CONSTRAINT `FK_swtpermission_sublocation` FOREIGN KEY (`sublocation_id`) REFERENCES `sublocation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.swtpermission: ~0 rows (approximately)
/*!40000 ALTER TABLE `swtpermission` DISABLE KEYS */;
/*!40000 ALTER TABLE `swtpermission` ENABLE KEYS */;


-- Dumping structure for table swapp.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `validationdate` date DEFAULT NULL,
  `createdby` varchar(50) NOT NULL DEFAULT 'SYSTEM',
  `createstatus` enum('ACTIVE','UPDATED','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.user: ~49 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`seqid`, `username`, `name`, `validationdate`, `createdby`, `createstatus`, `createdate`) VALUES
	(1, 'superadmin', 'Super Administrator', '2019-08-22', 'SYSTEM', 'ACTIVE', '2019-08-22 07:52:50');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for table swapp.user_securityquestion
DROP TABLE IF EXISTS `user_securityquestion`;
CREATE TABLE IF NOT EXISTS `user_securityquestion` (
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `securityquestion_id` int(11) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`seqid`),
  KEY `username` (`username`),
  KEY `FK_user_securityquestion_securityquestion` (`securityquestion_id`),
  CONSTRAINT `FK_user_securityquestion_securityquestion` FOREIGN KEY (`securityquestion_id`) REFERENCES `securityquestion` (`id`),
  CONSTRAINT `FK_user_securityquestion_user` FOREIGN KEY (`username`) REFERENCES `user` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table swapp.user_securityquestion: ~78 rows (approximately)
/*!40000 ALTER TABLE `user_securityquestion` DISABLE KEYS */;
INSERT INTO `user_securityquestion` (`seqid`, `username`, `securityquestion_id`, `answer`, `createdate`) VALUES
	(1, 'superadmin', 10, 'M', '2019-08-22 07:52:50'),
	(2, 'superadmin', 7, 'browny', '2019-08-22 07:52:50'),
	(3, 'superadmin', 6, 'him', '2019-08-22 07:52:50');
/*!40000 ALTER TABLE `user_securityquestion` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

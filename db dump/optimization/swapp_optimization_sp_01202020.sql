-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               10.4.6-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for swapp
USE `swapp`;

-- Dumping structure for procedure swapp.sp_checklistactivitydate_add
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_add`(
	IN `i_date` DATE
,
	IN `i_schoolid` INT
,
	IN `i_createdBy` INT







)
BEGIN

	DECLARE v_id INT DEFAULT 0;
	
	SELECT COUNT(id) INTO v_id FROM checklistactivitydate;

	INSERT INTO checklistactivitydate (id,school_id,date,createdby)
	VALUES ((v_id+1),i_schoolid,i_date,i_createdBy);

	
END//
DELIMITER ;

-- Dumping structure for procedure swapp.sp_summary_hazardstatus_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_summary_hazardstatus_get`()
BEGIN
	set @sql = concat("SELECT id, name FROM hazardstatus WHERE createstatus = 'ACTIVE'");
   PREPARE stmt FROM @sql;
   EXECUTE stmt;
END//
DELIMITER ;

-- Dumping structure for procedure swapp.sp_summary_hazardtype_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_summary_hazardtype_get`()
BEGIN
	set @sql = concat("SELECT id, name FROM hazardtype WHERE createstatus = 'ACTIVE'");
   PREPARE stmt FROM @sql;
   EXECUTE stmt;
 END//
DELIMITER ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

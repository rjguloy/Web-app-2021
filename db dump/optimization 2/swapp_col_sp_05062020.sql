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
CREATE DATABASE IF NOT EXISTS `swapp_col` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `swapp_col`;


-- Dumping structure for procedure swapp_col.sp_dashboard_school_submission_get
DROP PROCEDURE IF EXISTS `sp_dashboard_school_submission_get`;
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
		SET v_where = CONCAT(v_where, ' AND b.id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.id = ', i_cad); 
	END IF;
	
	
	
	SET v_sql = 'SELECT 
	a.id AS loc_id, a.`date` AS loc_name, 
	b.id AS scope_id, b.`name` AS scope_name 
	FROM checklistactivitydate AS a
	LEFT JOIN school AS b
	ON b.id = a.school_id
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
DROP PROCEDURE IF EXISTS `sp_dashboard_submission_get`;
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
	a.school_id, b.division_id
	FROM record AS a
	LEFT JOIN school AS b
	ON b.id = a.school_id
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
DROP PROCEDURE IF EXISTS `sp_hazardstatus_getlist`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hazardstatus_getlist`()
BEGIN

	SELECT * FROM hazardstatus;

END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_hazardtype_getlist
DROP PROCEDURE IF EXISTS `sp_hazardtype_getlist`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hazardtype_getlist`()
    DETERMINISTIC
BEGIN

	SELECT * FROM hazardtype;

END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_dates_get
DROP PROCEDURE IF EXISTS `sp_reports_dates_get`;
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
DROP PROCEDURE IF EXISTS `sp_reports_dropdown_get`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_dropdown_get`()
BEGIN
	SELECT b.`id` AS school_id 
	FROM checklistactivitydate AS a
	LEFT JOIN school AS b
	ON b.id = a.school_id
	WHERE	
	a.createstatus = 'ACTIVE'
	GROUP BY b.`id`
	ORDER BY b.`id` ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_get_new
DROP PROCEDURE IF EXISTS `sp_reports_get_new`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_get_new`(
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
	f.division_id, f.`name` AS school_name, z.date,
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
	
	LEFT JOIN checklistactivitydate AS z
	ON z.id = a.cad_id AND z.school_id = a.school_id
	
	WHERE 
	a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' GROUP BY 
	f.division_id, a.school_id, a.cad_id, a.hazard_id
	ORDER BY b.type ASC, a.hazard_id ASC, 
 	school_name ASC';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_itemlist_get
DROP PROCEDURE IF EXISTS `sp_reports_itemlist_get`;
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
DROP PROCEDURE IF EXISTS `sp_reports_yearlist_get`;
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_yearlist_get`()
BEGIN
	SELECT YEAR(`date`) AS `year` FROM checklistactivitydate GROUP BY YEAR(`date`);
END//
DELIMITER ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

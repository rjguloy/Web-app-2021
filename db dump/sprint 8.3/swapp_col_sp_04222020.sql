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


-- Dumping structure for procedure swapp_col.sp_dashboard_division_submission_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_division_submission_get`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_division` INT
,
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
	
	IF i_division <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.division_id = ', i_division); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.cad_id = ', i_cad); 
	END IF;
	
	
	
	SET v_sql = 'SELECT x.`name` AS loc_name, x.id AS loc_id, COALESCE(z.school_submitted, 0) AS school_submitted, 
	COALESCE((COALESCE(g.total_schools, 0) - COALESCE(z.school_submitted, 0)), 0) AS school_not_submitted, 
	COALESCE(g.total_schools, 0) AS total_schools, x.division_id AS scope_id, w.`name` AS scope_name
	FROM school AS x 
	LEFT JOIN (
		SELECT COUNT(y.school_id) AS school_submitted, y.school_id FROM 
			(
				SELECT 
				a.school_id, b.division_id
				FROM record AS a
				RIGHT JOIN school AS b
				ON b.id =  a.school_id
				RIGHT JOIN division AS c
				ON c.id = b.division_id
				LEFT JOIN checklistactivitydate AS d
				ON d.id = a.cad_id
				WHERE a.createstatus = \'ACTIVE\'';
		
	 
	
	SET v_tail = CONCAT(' GROUP BY a.school_id
			) AS y
			GROUP BY y.school_id
		) AS z
	ON z.school_id = x.id
	LEFT JOIN (
		SELECT COUNT(h.id) AS total_schools, h.id
		FROM (
			SELECT i.id, i.division_id FROM
			school AS i
			RIGHT JOIN division AS j
			ON j.id = i.division_id 
			RIGHT JOIN region AS k
			ON k.id = j.region_id
			WHERE i.createstatus = \'ACTIVE\'
		) AS h GROUP BY h.id
	) AS g ON g.id = x.id
	LEFT JOIN division AS w
	ON w.id = x.division_id
	WHERE x.division_id = ', i_division, '
	ORDER BY x.id');
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_hazardstatus_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_hazardstatus_get`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_region` INT,
	IN `i_division` INT,
	IN `i_school` INT,
	IN `i_cad` INT


)
BEGIN
	DECLARE v_where, v_tail VARCHAR(255) DEFAULT '';
	DECLARE v_sql VARCHAR(21844) DEFAULT '';
	
	IF i_year <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND YEAR(d.date) = ', i_year); 
	END IF;
	
	IF i_item <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.hazard_id = ', i_item); 
	END IF;
	
	IF i_region <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND f.region_id = ', i_region); 
	END IF;
	
	IF i_division <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND e.division_id = ', i_division); 
	END IF;
	
	IF i_school <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.school_id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT x.id, x.`name` AS hstatus, y.`type`, COALESCE(y.typecount, 0) AS type_count
	FROM hazardstatus AS x 
	LEFT JOIN (
	SELECT a.id, a.`name` AS hazard_status, c.`type`, COUNT(c.`type`) AS typecount
	FROM hazardstatus AS a
	LEFT JOIN summary AS b
	ON b.hazardstatus_id = a.id
	LEFT JOIN hazard AS c
	ON c.id = b.hazard_id
	LEFT JOIN checklistactivitydate AS d
	ON d.id = b.cad_id AND d.school_id = b.school_id
	LEFT JOIN school AS e
	ON e.id = d.school_id
	LEFT JOIN division AS f
	ON f.id = e.division_id
	WHERE  a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' GROUP BY c.type, a.id
			ORDER BY a.id
			) AS y
		ON x.id = y.id';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_hazardstatus_get_new
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_hazardstatus_get_new`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_school` INT,
	IN `i_cad` INT
)
BEGIN
	DECLARE v_where, v_tail VARCHAR(255) DEFAULT '';
	DECLARE v_sql VARCHAR(21844) DEFAULT '';
	
	IF i_year <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND YEAR(d.date) = ', i_year); 
	END IF;
	
	IF i_item <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.hazard_id = ', i_item); 
	END IF;
	
	IF i_school <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.school_id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT x.id, x.`name` AS hstatus, y.`type`, y.school_id
	FROM hazardstatus AS x 
	LEFT JOIN (
	SELECT a.id, a.`name` AS hazard_status, c.`type`, e.id AS school_id
	FROM hazardstatus AS a
	LEFT JOIN summary AS b
	ON b.hazardstatus_id = a.id
	LEFT JOIN hazard AS c
	ON c.id = b.hazard_id
	LEFT JOIN checklistactivitydate AS d
	ON d.id = b.cad_id AND d.school_id = b.school_id
	LEFT JOIN school AS e
	ON e.id = d.school_id
	WHERE  a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' ORDER BY a.id
		) AS y
	ON x.id = y.id';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_hazardtype_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_hazardtype_get`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_region` INT,
	IN `i_division` INT,
	IN `i_school` INT,
	IN `i_cad` INT
)
BEGIN
	DECLARE v_where, v_tail VARCHAR(255) DEFAULT '';
	DECLARE v_sql VARCHAR(21844) DEFAULT '';
	
	IF i_year <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND YEAR(d.date) = ', i_year); 
	END IF;
	
	IF i_item <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.hazard_id = ', i_item); 
	END IF;
	
	IF i_region <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND f.region_id = ', i_region); 
	END IF;
	
	IF i_division <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND e.division_id = ', i_division); 
	END IF;
	
	IF i_school <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.school_id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT x.id, x.`name` AS htype, COALESCE(y.hazardtype_count) AS type_count, y.`type`
	FROM hazardtype AS x
	LEFT JOIN 
		(
			SELECT a.id, a.`name` AS hazard_type, COALESCE(COUNT(c.`type`),0) AS hazardtype_count, c.`type`
			FROM hazardtype AS a 
			LEFT JOIN summary AS b
			ON b.hazardtype_id = a.id
			LEFT JOIN hazard AS c
			ON c.id = b.hazard_id
			LEFT JOIN checklistactivitydate AS d
			ON d.id = b.cad_id AND d.school_id = b.school_id
			LEFT JOIN school AS e
			ON e.id = d.school_id
			LEFT JOIN division AS f
			ON f.id = e.division_id
			WHERE a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' GROUP BY a.id, c.`type`
		) AS y
	ON x.id = y.id 
	ORDER BY x.id';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_hazardtype_get_new
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_hazardtype_get_new`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_school` INT,
	IN `i_cad` INT
)
BEGIN
	DECLARE v_where, v_tail VARCHAR(255) DEFAULT '';
	DECLARE v_sql VARCHAR(21844) DEFAULT '';
	
	IF i_year <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND YEAR(d.date) = ', i_year); 
	END IF;
	
	IF i_item <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.hazard_id = ', i_item); 
	END IF;
	
	IF i_school <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.school_id = ', i_school); 
	END IF;
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND b.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT x.id, x.`name` AS htype, y.`type`, y.school_id
	FROM hazardtype AS x
	LEFT JOIN 
		(
			SELECT a.id, a.`name` AS hazard_type, c.`type`, e.id AS school_id
			FROM hazardtype AS a 
			LEFT JOIN summary AS b
			ON b.hazardtype_id = a.id
			LEFT JOIN hazard AS c
			ON c.id = b.hazard_id
			LEFT JOIN checklistactivitydate AS d
			ON d.id = b.cad_id AND d.school_id = b.school_id
			LEFT JOIN school AS e
			ON e.id = d.school_id
			
			WHERE a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' ) AS y
	ON x.id = y.id 
	ORDER BY x.id';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_hazard_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_hazard_get`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_region` INT,
	IN `i_division` INT,
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
	
	SET v_sql = 'SELECT * FROM 
		(
			SELECT 
			b.name, a.hazard_id, 
			COUNT(a.hazard_id) AS hazard_count
			
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
			ON z.id = a.cad_id AND z.school_id = a.school_id
			
			WHERE YEAR(a.createdate) = YEAR(NOW())
			AND b.type = \'HAZARD\'
			AND a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' GROUP BY a.hazard_id
			ORDER BY hazard_count DESC
			LIMIT 10
		) AS z
	ORDER BY RAND()';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_hazard_get_new
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_hazard_get_new`(
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
	
	SET v_sql = 'SELECT * FROM 
		(
			SELECT 
			b.name, a.hazard_id, z.school_id,
			COUNT(a.hazard_id) AS hazard_count
			
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
			
			WHERE b.type = \'HAZARD\'
			AND a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' GROUP BY f.id, a.hazard_id
			ORDER BY hazard_count DESC
			LIMIT 10
		) AS z
	ORDER BY RAND()';
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_dashboard_region_submission_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_region_submission_get`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_cad` INT,
	IN `i_region` INT

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
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT x.`name` AS loc_name, x.id AS loc_id, COALESCE(z.school_submitted, 0) AS school_submitted, 
	COALESCE((COALESCE(g.total_schools, 0) - COALESCE(z.school_submitted, 0)), 0) AS school_not_submitted, 
	COALESCE(g.total_schools, 0) AS total_schools, x.region_id AS scope_id, w.`name` AS scope_name
	FROM division AS x 
	LEFT JOIN (
		SELECT COUNT(y.school_id) AS school_submitted, y.division_id, y.region_id FROM 
			(
				SELECT 
				a.school_id, b.division_id, c.region_id  
				FROM record AS a
				RIGHT JOIN school AS b
				ON b.id =  a.school_id
				RIGHT JOIN division AS c
				ON c.id = b.division_id
				LEFT JOIN checklistactivitydate AS d
				ON d.id = a.cad_id
				WHERE a.createstatus = \'ACTIVE\'';
		
	 
	
	SET v_tail = CONCAT(' GROUP BY a.school_id
			) AS y
			GROUP BY y.division_id
		) AS z
	ON z.division_id = x.id
	LEFT JOIN (
		SELECT COUNT(h.id) AS total_schools, h.division_id, h.region_id
		FROM (
			SELECT i.id, i.division_id, k.id AS region_id FROM
			school AS i
			RIGHT JOIN division AS j
			ON j.id = i.division_id 
			RIGHT JOIN region AS k
			ON k.id = j.region_id
			WHERE i.createstatus = \'ACTIVE\'
		) AS h GROUP BY h.division_id
	) AS g ON g.division_id = x.id
	LEFT JOIN region AS w
	ON w.id = x.region_id
	WHERE x.region_id = ', i_region, '
	ORDER BY x.id');
	
	SET v_sql = CONCAT(v_sql, v_where, v_tail);
	
	PREPARE stmt FROM v_sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	
END//
DELIMITER ;


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


-- Dumping structure for procedure swapp_col.sp_dashboard_super_submission_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_super_submission_get`(
	IN `i_year` INT,
	IN `i_item` INT,
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
	
	IF i_cad <> 0 THEN
		SET v_where = CONCAT(v_where, ' AND a.cad_id = ', i_cad); 
	END IF;
	
	SET v_sql = 'SELECT x.`name` AS loc_name, x.id AS loc_id, COALESCE(z.school_submitted, 0) AS school_submitted, 
	COALESCE((COALESCE(g.total_schools, 0) - COALESCE(z.school_submitted, 0)), 0) AS school_not_submitted, COALESCE(g.total_schools, 0) AS total_schools
	FROM region AS x 
	LEFT JOIN (
	SELECT COUNT(y.school_id) AS school_submitted, y.region_id FROM 
		(
			SELECT 
			a.school_id, b.division_id, c.region_id  
			FROM record AS a
			RIGHT JOIN school AS b
			ON b.id =  a.school_id
			RIGHT JOIN division AS c
			ON c.id = b.division_id
			LEFT JOIN checklistactivitydate AS d
			ON d.id = a.cad_id
			WHERE a.createstatus = \'ACTIVE\'';
	
	SET v_tail = ' GROUP BY a.school_id
		) AS y
		GROUP BY y.region_id
	) AS z
	ON z.region_id = x.id
	LEFT JOIN (
		SELECT COUNT(h.id) AS total_schools, h.region_id
		FROM (
			SELECT i.id, k.id AS region_id FROM
			school AS i
			RIGHT JOIN division AS j
			ON j.id = i.division_id
			RIGHT JOIN region AS k
			ON k.id = j.region_id
			WHERE i.createstatus = \'ACTIVE\'
		) AS h GROUP BY h.region_id
	) AS g ON g.region_id = x.id
	
	ORDER BY x.id';
	
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


-- Dumping structure for procedure swapp_col.sp_reports_divisions_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_divisions_get`(
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


-- Dumping structure for procedure swapp_col.sp_reports_division_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_division_get`(
	IN `i_region` INT,
	IN `i_division` INT
)
BEGIN
	SELECT `id`, `name` 
	FROM division 
	WHERE	
	region_id = i_region
	AND id = i_division
	LIMIT 1;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_dropdown_get
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


-- Dumping structure for procedure swapp_col.sp_reports_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_get`(
	IN `i_year` INT,
	IN `i_item` INT,
	IN `i_region` INT,
	IN `i_division` INT,
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
	ON z.id = a.cad_id AND z.school_id = a.school_id
	
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


-- Dumping structure for procedure swapp_col.sp_reports_get_new
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


-- Dumping structure for procedure swapp_col.sp_reports_regions_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_regions_get`()
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_schools_get`(
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


-- Dumping structure for procedure swapp_col.sp_reports_school_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_school_get`(
	IN `i_division` INT,
	IN `i_school` INT
)
BEGIN
	SELECT `id`, `name` 
	FROM school
	WHERE	
	division_id = i_division
	AND id = i_school
	LIMIT 1;
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_reports_yearlist_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_reports_yearlist_get`()
BEGIN
	SELECT YEAR(`date`) AS `year` FROM checklistactivitydate GROUP BY YEAR(`date`);
END//
DELIMITER ;


-- Dumping structure for procedure swapp_col.sp_school_getbyid
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_school_getbyid`(IN `i_schoolId` INT)
BEGIN

	SELECT * 
	  FROM school
	 WHERE id = i_schoolId
	   AND createstatus = 'ACTIVE';

END//
DELIMITER ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

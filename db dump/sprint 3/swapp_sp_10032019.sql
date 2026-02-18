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
CREATE DATABASE IF NOT EXISTS `swapp` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `swapp`;


-- Dumping structure for procedure swapp.sp_account_add
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_account_add`(IN `i_username` VARCHAR(50), IN `i_password` VARCHAR(255))
BEGIN

	INSERT INTO account (username, `password`)
	VALUES (i_username, i_password);
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_account_update
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
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_delete`(
	IN `i_id` INT

,
	IN `i_user` VARCHAR(50)


)
BEGIN
	DECLARE v_school INTEGER;
	DECLARE v_date DATE;
	
	SELECT school_id, `date` INTO v_school, v_date FROM checklistactivitydate WHERE id = i_id AND createstatus = 'ACTIVE';
	
	UPDATE checklistactivitydate SET createstatus = 'UPDATED' WHERE id = i_id AND createstatus = 'ACTIVE';
	
	INSERT INTO checklistactivitydate (id, school_id, `date`, createdby, createstatus) VALUES
	(i_id, v_school, v_date, i_user, 'DELETED'); 
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklistactivitydate_getByDate
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
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_getByID`(
	IN `i_id` INT

)
BEGIN
	SELECT * 
	FROM checklistactivitydate
	WHERE id = i_id AND createstatus='ACTIVE';
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklistactivitydate_getList
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_checklistactivitydate_getList`()
BEGIN

	SELECT * 
	FROM checklistactivitydate 
	WHERE createstatus = 'ACTIVE'
	ORDER BY date ASC;
	
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_checklist_ByType
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


-- Dumping structure for procedure swapp.sp_get_checklistactivitydate_getlast3
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_get_checklistactivitydate_getlast3`()
BEGIN

	SELECT * 
	  FROM (
				SELECT id, date 
				  FROM checklistactivitydate
				 WHERE createstatus = 'ACTIVE'
				 ORDER BY date DESC
				 LIMIT 3
			 ) AS temp
	 ORDER BY date ASC;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_hazardcat_get
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
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_locations_delete`(IN `i_id` INT


)
BEGIN
	UPDATE location SET createstatus = 'DELETED' WHERE id = i_id;
	UPDATE sublocation SET createstatus = 'DELETED' WHERE location_id = i_id;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_locations_get
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


-- Dumping structure for procedure swapp.sp_location_getlist
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_location_getlist`()
BEGIN

	SELECT * 
	  FROM location
	 WHERE createstatus = 'ACTIVE'
	 ORDER BY name ASC;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_loginaccess_add
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
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_loginaccess_delete`(IN `i_username` VARCHAR(50))
BEGIN

	DELETE FROM loginaccess WHERE username = i_username;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_narrative_getbychecklistdateid
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
		SELECT COALESCE(MAX(id), 0) +1
	     INTO v_id
	     FROM narrative;
	END IF;
	    
	INSERT INTO narrative (id, school_id, cad_id, description, createdby)
	VALUES (v_id, i_schoolId, i_checklistDateId, i_narrative, i_createdBy);

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_record_getchecklistactivity
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_record_getchecklistactivity`(IN `i_cadId` INT, IN `i_sublocationId` INT)
BEGIN

	SELECT cad_id, sublocation_id, hazard_id,  hazard.name, hazard.type, COALESCE(COUNT(record.id), 0) AS recordcount, 
			 COALESCE(COUNT(validationdate), 0) AS validationdatecount, 
			 IF(COALESCE(COUNT(validationdate), 0) != COALESCE(COUNT(record.id), 0), NULL, MAX(record.validationdate)) AS validationdate
	  FROM record
	 INNER JOIN hazard
	    ON hazard.id = record.hazard_id
	 WHERE record.cad_id = i_cadId
	   AND record.sublocation_id = i_sublocationId
	   AND record.createstatus = 'ACTIVE'
	   AND hazard.createstatus = 'ACTIVE'
	 GROUP BY record.hazard_id, record.sublocation_id, record.cad_id;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_record_getcomparativedata
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_record_getcomparativedata`()
BEGIN

	SELECT id, name, type, 
			 MAX((CASE WHEN cad_id = (SELECT id FROM checklistactivitydate WHERE createstatus = 'ACTIVE' ORDER BY date DESC LIMIT 2,1) THEN recordcount ELSE 0 END)) AS firstdate,
			 Max((CASE WHEN cad_id = (SELECT id FROM checklistactivitydate WHERE createstatus = 'ACTIVE' ORDER BY date DESC LIMIT 1,1) THEN recordcount ELSE 0 END)) AS seconddate,
			 Max((CASE WHEN cad_id = (SELECT id FROM checklistactivitydate WHERE createstatus = 'ACTIVE' ORDER BY date DESC LIMIT 0,1) THEN recordcount ELSE 0 END)) AS thirddate
	  FROM (SELECT record.cad_id, hazard.id, hazard.name, hazard.type, COALESCE(COUNT(record.id), 0) AS recordcount
			  FROM hazard
			  LEFT JOIN record
			    ON record.hazard_id = hazard.id
			   AND record.createstatus = 'ACTIVE'
			 WHERE hazard.createstatus = 'ACTIVE'
			 GROUP BY hazard.id, record.cad_id
			 ORDER BY type, name) AS temp
	 GROUP BY id;

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_record_validate
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_record_validate`(IN `i_cadId` INT, IN `i_sublocationId` INT, IN `i_hazardId` INT, IN `i_validator` VARCHAR(50))
BEGIN

	UPDATE record
	   SET validationdate = NOW(),
	   	 validatedby = i_validator
	 WHERE cad_id = i_cadId
	   AND sublocation_id = i_sublocationId
	   AND hazard_id = i_hazardId
		AND validationdate IS NULL
		AND createstatus = 'ACTIVE';
	   
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_reportphoto_action_add
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reportphoto_action_add`(
	IN `i_id` INT,
	IN `i_school` INT,
	IN `i_rec` INT,
	IN `i_desc` VARCHAR(250),
	IN `i_action` VARCHAR(250),
	IN `i_user` VARCHAR(50)


)
BEGIN

	DECLARE v_id INT DEFAULT 0;
	
	IF i_id = 0 THEN
		SELECT id INTO v_id FROM recordaction ORDER BY id DESC LIMIT 1;
		SET i_id = v_id + 1;
	END IF;

	INSERT INTO recordaction
	(id, school_id, record_id, description, `action`, createdby, createstatus)
	VALUES
	(i_id, i_school, i_rec, i_desc, i_action, i_user, 'ACTIVE');
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_reportphoto_action_check
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reportphoto_action_check`(
	IN `i_id` INT
)
BEGIN
	SELECT *
	FROM recordphoto
	WHERE	record_id = i_id
	AND createstatus = 'ACTIVE';
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_reportphoto_action_update
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reportphoto_action_update`(
	IN `i_id` INT,
	IN `i_school` INT,
	IN `i_rec` INT,
	IN `i_desc` VARCHAR(250),
	IN `i_action` VARCHAR(250),
	IN `i_user` VARCHAR(50)
)
BEGIN
	UPDATE recordaction SET createstatus = 'UPDATED' WHERE id = i_id;
	CALL sp_reportphoto_action_add(i_id, i_school, i_rec, i_desc, i_action, i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_reportphoto_bydate
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reportphoto_bydate`(
	IN `i_id` INT





)
BEGIN
	SELECT 
	a.id AS record_id, a.hazard_id, 
	b.`name` AS hazard_name, c.id AS photo_id,
	c.image, d.id AS action_id, 
	d.description AS `desc`, d.`action`
	FROM record AS a
	LEFT JOIN hazard AS b 
	ON b.id = a.hazard_id
	LEFT JOIN recordphoto AS c
	ON c.record_id = a.id
	LEFT JOIN recordaction AS d
	ON d.record_id = a.id
	WHERE a.cad_id = i_id 
	AND a.createstatus = 'ACTIVE'
	AND b.createstatus = 'ACTIVE'
	AND (c.createstatus = 'ACTIVE' OR c.createstatus = 'DELETED')
	AND (d.createstatus IS NULL OR d.createstatus = 'ACTIVE')
	ORDER BY 
	a.id ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_reportphoto_byrecord
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reportphoto_byrecord`(
	IN `i_id` INT
)
BEGIN
	SELECT id 
	FROM recordphoto
	WHERE record_id = i_id
	AND createstatus = 'ACTIVE';
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_reportphoto_images_delete
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_reportphoto_images_delete`(
	IN `i_id` INT,
	IN `i_school` INT,
	IN `i_rec` INT,
	IN `i_user` VARCHAR(50)
)
BEGIN
	UPDATE recordphoto 
	SET 
		image = NULL,
		createstatus = 'UPDATED' 
	WHERE 
		id = i_id AND createstatus = 'ACTIVE';
		
	INSERT INTO 
		recordphoto (id, school_id, record_id, createstatus, createdby)
	VALUES
		(i_id, i_school, i_rec, 'DELETED', i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_schoolinfo_get
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_schoolinfo_get`()
BEGIN
	SELECT * FROM school WHERE createstatus = 'ACTIVE' LIMIT 1;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_schoolinfo_save
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
	AND `name` = i_name
	AND createstatus = 'ACTIVE');
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_sublocation_delete
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_sublocation_delete`(
	IN `i_id` INT

)
BEGIN
	UPDATE sublocation SET createstatus = 'DELETED' WHERE id = i_id;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_sublocation_getlistbylocation
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_sublocation_getlistbylocation`(IN `i_locationId` INT)
BEGIN

	SELECT *
	  FROM sublocation
	 WHERE location_id = i_locationId
	   AND createstatus = 'ACTIVE';

END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_sublocation_update
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


-- Dumping structure for procedure swapp.sp_summary_add
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_summary_add`(
	IN `i_school` INT,
	IN `i_cad` INT,
	IN `i_hazard_id` INT,
	IN `i_hazardtype_id` INT,
	IN `i_hazardstatus_id` INT,
	IN `i_from` DATE,
	IN `i_to` DATE,
	IN `i_user` VARCHAR(50)

)
BEGIN
	DECLARE v_id INTEGER DEFAULT 0;
	DECLARE v_count INTEGER DEFAULT 0;
	
	SELECT COUNT(id) INTO v_count FROM summary 
	WHERE cad_id = i_cad
	AND hazard_id = i_hazard_id
	AND createstatus = 'ACTIVE';
	
	IF v_count > 0 THEN
		SELECT id INTO v_id FROM summary 
		WHERE cad_id = i_cad
		AND hazard_id = i_hazard_id
		AND createstatus = 'ACTIVE';
		
		UPDATE summary SET createstatus = 'UPDATED'
		WHERE id = v_id AND createstatus = 'ACTIVE';
	ELSE
		SELECT id INTO v_id FROM summary ORDER BY id DESC LIMIT 1;
		SET v_id = v_id + 1;
	END IF;
	
	INSERT INTO summary (id, school_id, cad_id, hazard_id, hazardtype_id, hazardstatus_id, `from`, `to`, createdby)
	VALUES (v_id, i_school, i_cad, i_hazard_id, i_hazardtype_id, i_hazardstatus_id, i_from, i_to, i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_summary_hazardstatus_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_summary_hazardstatus_get`(
	IN `i_ids` VARCHAR(50)

)
BEGIN
	set @sql = concat("SELECT id, name FROM hazardstatus WHERE id IN (", i_ids, ")
	AND createstatus = 'ACTIVE'");
   PREPARE stmt FROM @sql;
   EXECUTE stmt;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_summary_hazardtype_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_summary_hazardtype_get`(
	IN `i_ids` VARCHAR(50)

)
BEGIN
	set @sql = concat("SELECT id, name FROM hazardtype WHERE id IN (", i_ids, ")
	AND createstatus = 'ACTIVE'");
   PREPARE stmt FROM @sql;
   EXECUTE stmt;
 END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_summary_records_bydate_get
DELIMITER //
CREATE DEFINER=`root`@`%` PROCEDURE `sp_summary_records_bydate_get`(
	IN `i_cad` INT



)
BEGIN
	SELECT 
	b.name, a.hazard_id, b.type,
	COUNT(a.hazard_id) AS hazard_count,
	c.hazardtype_id, c.hazardstatus_id,
	c.`from`, c.`to` 
	FROM record AS a 
	LEFT JOIN hazard AS b
	ON b.id = a.hazard_id
	
	LEFT JOIN summary AS c
	ON c.cad_id = a.cad_id
	AND c.hazard_id = a.hazard_id
	AND c.createstatus = 'ACTIVE'
	
	WHERE a.cad_id = i_cad
	AND a.createstatus = 'ACTIVE'
	GROUP BY a.hazard_id
	ORDER BY b.type ASC, a.hazard_id ASC;
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_add_permissions_check
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
	
	SELECT COUNT(id) INTO v_num FROM swt WHERE team = i_team AND createstatus = 'ACTIVE';
	
	IF v_num < 1 THEN
		SELECT CONCAT(i_team, (v_num+1)) INTO v_id;
	ELSE
		SELECT CAST(SUBSTRING(id, 2) AS UNSIGNED), CONCAT(i_team, CAST(SUBSTRING(id, 2) AS UNSIGNED)+1) INTO v_num, v_id 
		FROM 
			swt
		WHERE 
			team = i_team
		ORDER BY
			1 DESC
		LIMIT 1;
	END IF;
	
	INSERT INTO swt (id, team, name, gender, createdby)
	VALUES (v_id, i_team, i_name, i_gender, i_user);
END//
DELIMITER ;


-- Dumping structure for procedure swapp.sp_swt_member_check
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
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

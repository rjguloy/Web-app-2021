SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `sublocation`
	ADD COLUMN `hazardcategory_id` INT(11) NOT NULL DEFAULT 1 AFTER `location_id`,
	ADD CONSTRAINT `FK_sublocation_hazardcategory` FOREIGN KEY (`hazardcategory_id`) REFERENCES `hazardcategory` (`id`);
	
ALTER TABLE `swtpermission`
	DROP COLUMN `hazardcategory_id`,
	DROP FOREIGN KEY `FK_swtpermission_hazardcategory`;
	
SET FOREIGN_KEY_CHECKS = 1;
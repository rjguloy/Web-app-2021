ALTER TABLE `record`
	ADD COLUMN `validatedby` VARCHAR(50) NULL DEFAULT NULL AFTER `validationdate`;
	
ALTER TABLE `recordphoto`
	CHANGE COLUMN `image` `image` LONGBLOB NULL AFTER `record_id`;
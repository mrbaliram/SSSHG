ALTER TABLE `users` ADD `phone` VARCHAR(255) NULL DEFAULT NULL AFTER `email`, ADD `type` VARCHAR(255) NULL DEFAULT NULL AFTER `phone`, ADD `remark` VARCHAR(255) NULL DEFAULT NULL AFTER `type`, ADD `other1` VARCHAR(255) NULL DEFAULT NULL AFTER `remark`, ADD `other2` VARCHAR(255) NULL DEFAULT NULL AFTER `other1`;


ALTER TABLE `users` ADD `society_id` INT NULL DEFAULT '0' AFTER `type`;

ALTER TABLE `users` ADD `status` TINYINT NOT NULL DEFAULT '1' AFTER `remark`, ADD `is_delete` TINYINT NOT NULL DEFAULT '0' AFTER `status`;


ALTER TABLE `society_members` ADD `account_nummber` VARCHAR(255) NULL DEFAULT NULL


-- ALTER TABLE `users` ADD `phone` VARCHAR(255) NULL DEFAULT NULL AFTER `email`, ADD `type` VARCHAR(255) NULL DEFAULT NULL AFTER `phone`, ADD `remark` VARCHAR(255) NULL DEFAULT NULL AFTER `type`, ADD `other1` VARCHAR(255) NULL DEFAULT NULL AFTER `remark`, ADD `other2` VARCHAR(255) NULL DEFAULT NULL AFTER `other1`;


-- $sql = "ALTER TABLE `users` ADD `phone` VARCHAR(255) NULL DEFAULT NULL AFTER `email`, ADD `type` VARCHAR(255) NULL DEFAULT NULL AFTER `phone`, ADD `remark` VARCHAR(255) NULL DEFAULT NULL AFTER `type`, ADD `other1` VARCHAR(255) NULL DEFAULT NULL AFTER `remark`, ADD `other2` VARCHAR(255) NULL DEFAULT NULL AFTER `other1`;";

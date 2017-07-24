ALTER TABLE `test_records` ADD `status` TINYINT(1) NOT NULL DEFAULT '0' AFTER `completed`;

ALTER TABLE `test_records` ADD `approved_by` VARCHAR(200) NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `test_records` CHANGE `status` `is_approved` TINYINT(1) NOT NULL DEFAULT '0';

ALTER TABLE `test_records` ADD `retest_remark` VARCHAR(500) NULL AFTER `approved_by`;

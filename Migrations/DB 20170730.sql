ALTER TABLE `users` CHANGE `user_type` `user_type` ENUM('Admin','Chamber','Dashboard','Approver','Testing','PUser') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `users` ADD `product_id` VARCHAR(50) NULL DEFAULT NULL AFTER `chamber_id`;

ALTER TABLE `users` CHANGE `user_type` `user_type` ENUM('Admin','Chamber','Dashboard','Approver','Testing','Product') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `test_records` ADD `skip_test` ENUM('1','0','','') NOT NULL DEFAULT '0' AFTER `completed`;

ALTER TABLE `test_records` CHANGE `skip_test` `skip_test` ENUM('1','0') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0';

ALTER TABLE `test_records` CHANGE `skip_test` `skip_test` TINYINT(1) NOT NULL DEFAULT '0';


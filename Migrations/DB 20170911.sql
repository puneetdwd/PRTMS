ALTER TABLE `users` CHANGE `user_type` `user_type` ENUM('Admin','Chamber','Dashboard','Approver','Testing','Product','SQA') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

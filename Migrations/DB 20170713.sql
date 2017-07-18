ALTER TABLE `product_parts` ADD `img_file` VARCHAR(200) NULL AFTER `part_no`;

ALTER TABLE `test_observations` ADD `test_img` VARCHAR(200) NULL AFTER `salt_water_level`;
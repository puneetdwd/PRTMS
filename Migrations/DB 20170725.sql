ALTER TABLE `tests` ADD `display_temp_set` VARCHAR(200) NULL AFTER `test_set`, ADD `humidity_set` VARCHAR(200) NULL AFTER `display_temp_set`, ADD `pressure_set` VARCHAR(200) NULL AFTER `humidity_set`, ADD `set_volt` VARCHAR(200) NULL AFTER `pressure_set`;

	
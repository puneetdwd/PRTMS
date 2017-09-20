UPDATE `test_records` INNER JOIN test_observations on test_records.id = test_observations.test_id set test_records.test_img = test_observations.test_img WHERE test_observations.test_img is not null

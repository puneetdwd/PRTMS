--
-- Table structure for table `monthly_plan`
--

CREATE TABLE IF NOT EXISTS `monthly_plan` (
  `id` int(11) NOT NULL,
  `month_year` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `planned_part_no` varchar(50) NOT NULL,
  `test_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `monthly_plan`
--
ALTER TABLE `monthly_plan`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `monthly_plan`
--
ALTER TABLE `monthly_plan`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
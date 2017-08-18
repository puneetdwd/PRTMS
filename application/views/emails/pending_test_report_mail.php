<html>
<body>
<p style="font-size: 16px;"><b>
<h3>Pending Test Report</h3></br>
Date: <?php echo $yesterday; ?>
</b></p>
<p style="font-size: 20px;"><b>
</b></p>


                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Tests are Pending till yesterday.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" border="1" style='border-collapse:collapse'>
                            <thead style='background-color:#D3D3D3'>
                                <tr>
                                    <th>Product</th>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Supplier</th>
                                    <th>Test Item</th>
                                    <th>Schedule Date</th>
                                    <!--th class="text-center">Status</th-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								// echo '<pre>';print_r($reports);exit;
								foreach($reports as $report) { ?>
                                    <tr>
                                         <td><?php echo $report['product']; ?></td>
                                        <td><?php echo $report['part']; ?></td>
                                        <td><?php echo $report['planned_part_no']; ?></td>
                                        <td><?php echo $report['supplier']; ?></td>
                                        <td><?php echo $report['test']; ?></td>
                                        <td><?php echo $report['schedule_date'] ? date('jS M Y', strtotime($report['schedule_date'])) : '--'; ?></td>
                                        <!--td>
											<?php echo $report['status']; ?>
										</td-->										
									</tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
              
	
<p>
	Regards,<br>
	PRTMS Administrator
	<br>
	<br>
	<i><b>Note:</b>&nbsp;This is a system generated mail. Please do not reply.</i>
</p>
</body>
</html>
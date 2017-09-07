<html>
<body>
<p style="font-size: 16px;"><b>
<h3>Incompleted Test Report</h3></br>
Date: <?php echo $yesterday; ?>
</b></p>
<p style="font-size: 20px;"><b>
</b></p>


                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Test has been done yesterday.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" border="1" style='border-collapse:collapse'>
                            <thead style='background-color:#D3D3D3'>
                                <tr>
                                    <th style='border: 1px solid black;' >Event</th>
                                    <th style='border: 1px solid black;' >Product Name</th>
                                    <th style='border: 1px solid black;'>Part Name</th>
                                    <th style='border: 1px solid black;'>Part Number</th>
                                    <th style='border: 1px solid black;'>Test Name</th>
                                    <th style='border: 1px solid black;'>Start Date</th>
                                    <!--th style='border: 1px solid black;'>End Date</th-->
                                    <th style='border: 1px solid black;'>Chamber Category</th>
                                    <th style='border: 1px solid black;'>Chamber Name</th>
                                    <!--th style='border: 1px solid black;'>Is Approved</th-->
                                    <th style='border: 1px solid black;'>Supplier</th>
                                    <th style='border: 1px solid black;'>Assistant</th>
                                    <th style='border: 1px solid black;'>ASN No.</th>
                                    <!--th style='border: 1px solid black;'>Result</th-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								// echo '<pre>';print_r($reports);exit;
								foreach($reports as $report) { ?>
                                    <tr>
                                        <td  style='border: 1px solid black;'><?php echo $report['stage_name']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['product_name']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['part_name']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['part_no']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['test_name']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo date('jS M, Y', strtotime($report['start_date'])); ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['chamber_category']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['chamber_name']; ?></td>
                                        
										<td style='border: 1px solid black;'><?php echo $report['supplier_name']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['assistant_name']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['lot_no']; ?></td>
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
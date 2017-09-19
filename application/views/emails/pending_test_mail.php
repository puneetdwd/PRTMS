<?php 
$CI =& get_instance();
$CI->load->model('plan_model');
?>


<html>
<body>
<p style="font-size: 16px;"><b>
<h3>Pending Test Report</h3></br>
Date: <?php echo $yesterday; ?>
</b></p>
<p style="font-size: 20px;"><b>
</b></p>


                    <?php if(empty($pending_tests)) { ?>
                        <p class="text-center">No Pending Test.</p>
                    <?php } else { ?>
                        <table class="table table-hover" border="1" style='border-collapse:collapse'>
                            <thead style='background-color:#D3D3D3;line-height:30px'>
                                <tr >
                                    <th>Product</th>
                                    <th>Part Name</th>
                                    <th>Part Number</th>                                  
                                    <th>Test Item</th>
                                    <th>Schedule Date</th>
                                    <th class="text-center" style='padding:0px 10px 0px 10px;'>Status</th>
                                </tr>
                            </thead>
                            </tbody>
                                <?php 
								// echo '<pre>';print_r($reports);exit;
								foreach($pending_tests as $pending_test) { 
									$ress = $CI->plan_model->get_part_plan($pending_test['planned_part_no'],$pending_test['schedule_date']);
									if($ress['no_inspection'] == 'NO')
									{ 
										continue;
									}
									
								?>
                                    
									<tr style='line-height:30px'>
                                        <td  style='border: 1px solid black;'><?php echo $pending_test['product']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $pending_test['part']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $pending_test['planned_part_no']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $pending_test['test']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $pending_test['schedule_date'] ? date('jS M', strtotime($pending_test['schedule_date'])) : '--'; ?></td>                                 
                                        <td style='border: 1px solid black;'><?php echo $pending_test['status']; ?></td>
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
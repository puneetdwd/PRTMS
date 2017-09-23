<html>
<body>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h3>
            Part Test Summary Report
        </h3>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-9" id='chamber_report_table'>
            <div class="portlet light bordered">
                <div class="portlet-title">
					<!--div class="caption">
                        <i class="fa fa-reorder"></i><b>Part Test Summary Report</b>
                    </div-->
                </div>
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" style='border: 1px solid black;border-collapse: collapse;'>
                            <thead style='background-color:"#D3D3D3"'>
                                <tr>
                                    <th style='border: 1px solid black;'>Product</th>
                                    <th style='border: 1px solid black;'>Part Name</th>
                                    <th style='border: 1px solid black;'>Part No.</th>
                                    <th style='border: 1px solid black;'>Event</th>
                                    <!--th style='border: 1px solid black;'>Planned Test Count</th-->
                                    <th style='border: 1px solid black;'>Approved Test Count</th>
                                    <th style='border: 1px solid black;'>No Lot Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								$CI =& get_instance();
								$CI->load->model('Plan_model');
								//$f = $_SESSION['pts_filters'];
								// print_r($f);exit;
								foreach($reports as $report) { ?>
                                    <tr>
                                        <td style='border: 1px solid black;'><?php echo $report['product']; ?></td>
                                        <td style='border: 1px solid black;'><?php 
										echo $report['part_name']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['part_no']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['st_name']; ?></td>
										<!--td style='border: 1px solid black;'>
											<?php 
											//echo $report['part_no'];
												$res = $CI->Plan_model->get_total_test_by_part($report['part_no'],$f['start_date'],$f['end_date']);
												
												 if(!empty($res))
												 {
													 echo $res['tot_planned_test'];
													 //print_r($res);
												 }
												else
													echo '0'; 
											?>
										</td-->
										
                                        <td style='border: 1px solid black;'><?php echo $report['test_cnt']; ?></td>
                                        <td style='border: 1px solid black;'><?php //echo $report['no_inspection'];											
											//$CI->load->model('Plan_model');
											$res = $CI->Plan_model->get_no_inspection_by_part($report['part_no'],$f['start_date'],$f['end_date']);
											if(!empty($res))
												echo $res['insp_cnt'];
											else
												echo '0';
										?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>                    
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
</body>
</html>
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
					<div class="caption">
                        <i class="fa fa-reorder"></i><b>Part Test Summary Report</b>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" style='border: 1px solid black;border-collapse: collapse;'>
                            <thead style='background-color:"#D3D3D3"'>
                                <tr>
                                    <th style='border: 1px solid black;'>Start Date</th>
                                    <th style='border: 1px solid black;'>Part No.</th>
                                    <th style='border: 1px solid black;'>Test Count</th>
                                    <th style='border: 1px solid black;'>No Lot Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								$CI =& get_instance();
								$CI->load->model('Plan_model');
								//print_r($_SESSION['pts_filters']);exit;
								foreach($reports as $report) { ?>
                                    <tr>
                                        <td style='border: 1px solid black;'><?php 
										echo date('jS M, Y h:i A', strtotime($report['start_date'])); ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['part_no']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $report['test_cnt']; ?></td>
                                        <td style='border: 1px solid black;'><?php //echo $report['no_inspection'];
											
											
											$res = $CI->Plan_model->get_no_inspection_by_part($report['part_no'],$_SESSION['pts_filters']['start_date'],$_SESSION['pts_filters']['end_date']);							
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
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Chamber Wise Test Count Report
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url().'reports/chamber_wise_test_count_report'; ?>">Chamber Wise Test Count Report</a>
            </li>
            <li class="active">Check Tests</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger">
               <i class="fa fa-times"></i>
               <?php echo $this->session->flashdata('error');?>
            </div>
        <?php } else if($this->session->flashdata('success')) { ?>
            <div class="alert alert-success">
                <i class="fa fa-check"></i>
               <?php echo $this->session->flashdata('success');?>
            </div>
        <?php } ?>
		
        <div class="col-md-12" id='chamber_report_check_table'>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Chamber Wise Test Count Report
                    </div>
                    <?php if(!empty($reports)) { ?>
						<div class="actions" style='margin: 5px;'>
							<a class="button normals btn-circle" href="<?php echo base_url()."reports/export_excel_check_tests/".$chamber_id; ?>">
								<i class="fa fa-download"></i> Export Report
							</a>
						</div>
						<!--div class="actions" style='float: left;margin: 5px;'>
							<a class="button normals btn-circle" onclick="printPage('chamber_report_check_table');" href="javascript:void(0);">
								<i class="fa fa-print"></i> Print
							</a>
						</div-->
					<?php } ?>
                </div>
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Test Name</th>
                                    <th>Test Start Date</th>
                                    <th>Test End Date</th>
                                    <th>Test Judgement</th>
                                    <th class="no_sort" style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reports as $report) { ?>
                                    <tr>
                                        <td><?php echo $report['test_name']; ?></td>
                                        <td><?php //echo $report['start_date']; 
											echo date('jS M, Y h:i A', strtotime($report['start_date']));
										?></td>
                                        <td><?php //echo $report['end_date']; 
											echo date('jS M, Y h:i A', strtotime($report['end_date']));
										?></td>
                                        <td><?php echo $report['judgement']; ?></td>
                                        <td nowrap>
                                            <button type="button" class="button small view-test-modal-btn" data-index="<?php echo $report['code']; ?>">
                                                View Test
                                            </button>
                                            <!--<a class="btn btn-success btn-xs"
                                                href="<?php echo base_url()."reports/view_test/".$report['test_id'];?>">
                                                <i class="fa fa-eye" aria-hidden="true"></i> View
                                            </a>-->
                                        </td>
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


<div class="modal fade bs-modal-lg" id="view-test-modal" tabindex="-1" role="dialog" aria-hidden="true">
    
</div>
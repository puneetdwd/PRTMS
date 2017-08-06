<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Completed Test Report
        </h1>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
    
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" border="1">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Product Name</th>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Test Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Chamber Category</th>
                                    <th>Chamber Name</th>
                                    <th>Is Approved</th>
                                    <th>Supplier</th>
                                    <th>Inspector</th>
                                    <th>ASN No.</th>
                                    <th>Result</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								// echo '<pre>';print_r($reports);exit;
								foreach($reports as $report) { ?>
                                    <tr>
                                        <td><?php echo $report['stage_name']; ?></td>
                                        <td><?php echo $report['product_name']; ?></td>
                                        <td><?php echo $report['part_name']; ?></td>
                                        <td><?php echo $report['part_no']; ?></td>
                                        <td><?php echo $report['test_name']; ?></td>
                                        <td><?php echo date('jS M, Y', strtotime($report['start_date'])); ?></td>
                                        <td><?php echo date('jS M, Y', strtotime($report['end_date'])); ?></td>
                                        <td><?php echo $report['chamber_category']; ?></td>
                                        <td><?php echo $report['chamber_name']; ?></td>
                                        <td><?php 
										if($report['is_approved'] == 1)
										{ ?>
												<p title='Approved by <?php $report['approved_by']; ?>'>
												Approved
												</p>
											<?php
										} else
											echo 'Not Approved'
										?></td>
										
										<td><?php echo $report['supplier_name']; ?></td>
                                        <td><?php echo $report['assistant_name']; ?></td>
                                        <td><?php echo $report['lot_no']; ?></td>
                                        <td><?php echo $report['observation_result']; ?></td>
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
<style>
    .table.table-light > thead > tr > th {
        font-size: 14px;
        font-weight: 700;
    }
</style>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="col-md-9">
            <div class="portlet light bordered">
                <div class="portlet light bordered">
                <div class="portlet-body">                    
                        <table class="table table-hover table-light" border="1" style='border-collapse:collapse;width: 90%;'>
                            <tr>
                                <td colspan="5" style="vertical-align:middle;"><h3>Monthly Plan Report</h3></td>
                                <td colspan="1" align="right" style="vertical-align:middle;"><h3> 
                                    Month :<?php echo date('M, Y', strtotime($plan_date)); ?></h3>
                                </td>
                            </tr>
                        </table>                   
                </div>
				</br>
            </div>
                <div class="portlet-body">
                    <?php if(empty($plan)) { ?>
                        <p class="text-center">No Plan.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light"  border="1" style='border-collapse:collapse'>
                            <thead>
                                <tr>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Supplier</th>
                                    <th>Test Item</th>
                                    <th>Schedule Date</th>
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								//print_r($plan);exit;
								foreach($plan as $pl) { ?>
                                    <tr>
                                        <td><?php echo $pl['part']; ?></td>
                                        <td><?php echo $pl['planned_part_no']; ?></td>
                                        <td><?php echo $pl['supplier']; ?></td>
                                        <td><?php echo $pl['test']; ?></td>
                                        <td><?php echo date('jS M', strtotime($pl['schedule_date'])); ?></td>
                                        <td><?php 
												if($pl['no_inspection'] == 'NO')
												{ echo 'No Lot'; }
												else {	echo $pl['status']; }
											?>
										</td>
                                        
                                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
 
    <!-- END PAGE CONTENT-->
</div>

<html>

<body>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        
        <div class="col-md-9">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>No lots Report
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($plan)) { ?>
                        <p class="text-center">No data for NO Lot.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Supplier</th>
                                    <th>Test Item</th>
                                    <th>Schedule Date</th>
                                    <th>Status</th>
                                    <th class="no_sort" style="width:100px;"></th>
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
											?></td>
                                        
                                        <td nowrap>
                                            
											<!--
                                            <a class="button small gray" href="<?php echo base_url()."plans/change_date/".$pl['id'];?>" data-target="#change-date-modal" data-toggle="modal">
                                                Change Date
                                            </a>
                                            -->
											
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
</div>

</body>
</html>

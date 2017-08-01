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
                        <table class="table table-hover table-light" style='border: 1px solid black;border-collapse: collapse;'>
                            <thead>
                                <tr style='background-color:"#D3D3D3"'>
                                    <th style='border: 1px solid black;'>Part Name</th>
                                    <th style='border: 1px solid black;'>Part Number</th>
                                    <th style='border: 1px solid black;'>Supplier</th>
                                    <th style='border: 1px solid black;'>Test Item</th>
                                    <th style='border: 1px solid black;'>Schedule Date</th>
                                    <th style='border: 1px solid black;'>Status</th>
                                    <!--th class="no_sort" style="width:100px;border: 1px solid black;"></th-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								//print_r($plan);exit;
								foreach($plan as $pl) { ?>
                                    <tr>
                                        <td style='border: 1px solid black;'><?php echo $pl['part']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $pl['planned_part_no']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $pl['supplier']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo $pl['test']; ?></td>
                                        <td style='border: 1px solid black;'><?php echo date('jS M', strtotime($pl['schedule_date'])); ?></td>
                                        <td style='border: 1px solid black;'><?php 
												if($pl['no_inspection'] == 'NO')
													{ echo 'No Lot'; }
												else {	echo $pl['status']; }
											?></td>
                                        
                                       <!-- <td nowrap>
                                            
											
                                            <a class="button small gray" href="<?php echo base_url()."plans/change_date/".$pl['id'];?>" data-target="#change-date-modal" data-toggle="modal">
                                                Change Date
                                            </a>
                                           
											
                                        </td> -->
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

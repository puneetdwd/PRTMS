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
                                    <th>Product</th>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Test Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Chamber Category</th>
                                    <th>Chamber Name</th>
                                    <th>Test Image</th>
                                    <th>Is Approved</th>
                                    <th>Supplier</th>
                                    <th>Inspector</th>
                                    <th>Sample/ASN No.</th>
                                    <th>Result</th>
									<th>Approver Remark</th>
                                    <th>Retest Remark</th>
                                    <th>Skiped Remark</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								// echo '<pre>';print_r($reports);exit;
								foreach($reports as $report) { ?>
                                    <tr>
                                        <td><?php echo $report['stage_name']; ?></td>
                                        <td><?php echo $report['product_code']; ?></td>
                                        <td><?php echo $report['part_name']; ?></td>
                                        <td><?php echo $report['part_no']; ?></td>
                                        <td><?php echo $report['test_name']; ?></td>
                                        <td><?php echo date('d M Y H:i:s', strtotime($report['start_date'])); ?></td>
                                        <td><?php echo date('d M Y H:i:s', strtotime($report['end_date'])); ?></td>
                                        <td><?php echo $report['chamber_category']; ?></td>
                                        <td><?php echo $report['chamber_name']; ?></td>
										<!--td height="70">
											<?php 
											 if(!empty($report["test_img"])){ ?>
												<img height="70" width="100" src='<?php echo base_url()."assets/test_images/".$report["test_img"]; ?>' />											
											
											<?php } ?>
										</td-->
										<td height='70' width='100'>									
										
											<?php 
											if(!empty($report['test_img'])){		
												//echo $report['test_img'] = "download.jpg";
												$file_path = FCPATH."assets \ test_images \ ".$report['test_img']; 
												$file_path = str_replace(' ','',$file_path);
												//echo FCPATH;
												if(file_exists($file_path))
												{
													?>
														<img height="70" width="100" src='<?php echo base_url()."assets/test_images/".$report['test_img']; ?>' class="img-responsive" ></img>
													<?php 
												}
												else
													echo 'No Img';
											} 										
											else{
												echo 'No Img';
											}  ?>
										</td>
                                    
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
										<td><?php echo $report['appr_test_remark']; ?></td>
                                        <td><?php echo $report['retest_remark']; ?></td>
                                        <td><?php echo $report['skip_remark']; ?></td>                                      
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
<style>
    .table.table-light > thead > tr > th {
        font-size: 14px;
        font-weight: 700;
    }
</style>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <!--<div class="breadcrumbs">
        <h3 style="text-align:center;">
            Mass Production Part Assurance Report
        </h3>
        
    </div>-->
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">    
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <?php if(empty($reports_common)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" border="1">
                            <tr>
                                <td colspan="6" style="vertical-align:middle;">
									<h3>
										<?php 
										if($reports_event['name'] == 'MP Assurance')
											echo 'Mass Production Part Assurance Report';
										if($reports_event['name'] == 'FPA')
											echo 'First Part Approval Reliablity Test Report';
										if($reports_event['name'] == 'Daily Lots')
											echo 'Daily Lots Reliablity Test Report';
										if($reports_event['name'] == 'Line/Field issues')
											echo 'Line/Field issues Test Report';
										?>
									</h3>
								</td>
                                <td colspan="6" align="right" style="vertical-align:middle;"><b>Product Name : </b>
                                    <?php echo $reports_common['product_name']; ?>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="table table-hover table-light" border="1">
                            <tr>
                                <td colspan="4"><b>Part Name &nbsp;&nbsp;&nbsp;&nbsp;: </b>
                                    <?php echo $reports_common['part_name']; ?>
                                </td>
                                <td colspan="4"><b>Part Number &nbsp;&nbsp;&nbsp;&nbsp;: </b>
                                    <?php echo $reports_common['part_no']; ?>
                                </td>
                                <td colspan="4"><b>Month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>
                                    <?php $date = strtotime($year."-".$month."-15");
                                          echo date("M'Y", $date);
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4"><b>Lot/ASN No. : </b>
                                    <?php echo $reports_common['lot_no']; ?>
                                </td>
                                <td colspan="8"><b>Supplier Name : </b>
                                    <?php echo $reports_common['supplier_name']; ?>
                                </td>
                                <!--td colspan="3"><b>Sample Qty : </b>
                                    <?php echo $samples; ?>
                                </td-->
                            </tr>
                        </table>
                        <table class="table table-hover table-light" border="1">
                            <tr>
                                <td colspan="12"><b>Judgement &nbsp;&nbsp;: </b>
                                    <?php echo $judgement; ?>
                                </td>
								<!--td colspan="5"><b>Event &nbsp;&nbsp;: </b>
                                    <?php echo $reports_event['name'];  ?>
                                </td-->
                            </tr>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>
            <br>
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>  
                        
                        <table class="table table-hover table-light" border="1" style="width:400px;border-collapse:collapse">
                            <thead>
                                <tr><th colspan="10" align="center">Test Details</th></tr>
                                <tr>
                                    <th width="5%">Sr No</th>
                                    <th width="10%">Name</th>
                                    <th width="20%">Method</th>
                                    <th width="15%">Judgement</th>
                                    <th width="5%">Samples</th>
                                    <th width="10%">Start Date</th>
                                    <th width="10%">End Date</th>
                                    <th width="15%">Tests Image</th>
                                    <th width="10%">Result</th>
                                    <th width="10%">Skip Remark</th>
                                    <th width="10%">Retest Remark</th>
                                    <th width="10%">Approver Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn=0; foreach($reports as $report) { $sn++; ?>
                                    <tr>
                                        <td width="5%" align="center" style="vertical-align:middle;"><?php echo $sn; ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo $report['test_name']; ?></td>
                                        <td width="25%" style="vertical-align:middle;"><?php echo $report['method']; ?></td>
                                        <td width="15%" align="center" style="vertical-align:middle;"><?php echo $report['judgement']; ?></td>
                                        <td width="5%" align="center" style="vertical-align:middle;"><?php echo $report['samples']; ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo date('d M y', strtotime($report['start_date'])); ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo date('d M y', strtotime($report['end_date'])); ?></td>
                                        <!--td width="10%" height='100' align="center" style="vertical-align:middle;">
										<?php if(!empty($report['test_img'])){	?>	
											
											<img width='8%' height='100'  src='<?php echo base_url()."assets/test_images/".$report['test_img']; ?>'>					
											
										<?php }else{
											echo 'No Img';
										} ?></td-->
										<td width="10%" height='100' align="center" style="vertical-align:middle;">
										
										
											<?php 
											if(!empty($report['test_img'])){		
												//echo $report['test_img'] = "download.jpg";
												$file_path = FCPATH."assets \ test_images \ ".$report['test_img']; 
												$file_path = str_replace(' ','',$file_path);
												//echo FCPATH;
												if(file_exists($file_path))
												{
													?>
														<img height="100" width="10%" src='<?php echo base_url()."assets/test_images/".$report['test_img']; ?>' class="img-responsive" ></img>
													<?php 
												}
												else
													echo 'No Img';
											} 										
											else{
												echo 'No Img';
											}  ?>
										</td>
                                       
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo strtoupper($report['observation_result']); ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo $report['skip_remark']; ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo $report['retest_remark']; ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo $report['appr_test_remark']; ?></td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td rowspan="4" colspan="9" valign="top"><b>Comment</b></td>
                                    </tr>
                            </tbody>
                        </table>
                        
                        <table class="table table-hover table-light">
                            <tr>
                                <td colspan="3">&nbsp;</td>
                                <td colspan="2"><b>Checked By</b></td>
                                <td colspan="2"><b>Verified By</b></td>
                                <td colspan="2"><b>Approved By</b></td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                                <td colspan="2"><b><?php echo ucwords($checker); ?></b></td>
                                <td colspan="2"><b><?php echo ucwords($approver); ?></b></td>
                                <td colspan="2"><b><?php echo ucwords($approver); ?></b></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                        <table class="table table-hover table-light">
                            <tr>
                                <td colspan="8">LG (ILP) QAS 009 (02042015)-00</td>
                                <td><b>LGE PUNE</b></td>
                            </tr>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>

        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

<!--Popup Start-->
<div class="modal fade bs-modal-lg" id="view-test-modal" tabindex="-1" role="dialog" aria-hidden="true">
    
</div>
<!--Popup End-->
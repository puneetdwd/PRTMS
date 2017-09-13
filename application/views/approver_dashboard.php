<style>
    .easy-pie-chart .number canvas {
        height:60px !important;
        line-height:60px !important;
    }
    .progress-info .progress {
        display: block;
        height: 10px;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
        margin-top: 0;
    }
    .progress-info .status {
        color: #aab5bc;
        font-size: 18px;
        font-weight: 600;
        margin-top: 5px;
        text-transform: uppercase;
    }
	  .form-inline .select2-container--bootstrap{
        width: 300px !important;
    }
    label.cameraButton {
        display: inline-block;
        /*margin: 1em 0;*/

        /* Styles to make it look like a button */
        padding: 0.2em 0.3em;
        border: 2px solid #666;
        border-color: #EEE #CCC #CCC #EEE;
        background-color: #DDD;
    }

      /* Look like a clicked/depressed button */
    label.cameraButton:active {
        border-color: #CCC #EEE #EEE #CCC;
    }

    /* This is the part that actually hides the 'Choose file' text box for camera inputs */
    label.cameraButton input[accept*="image"] {
        display: none;
    }
</style>
<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            <?php echo $this->session->userdata('name'); ?>
            <small>Welcome to your dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li class="active">Dashboard</li>
        </ol>
        
    </div>
	
       
              
                               
    <?php 
	//$CI = &get_instance();
	
	if($this->session->flashdata('error')) {?>
        <div class="alert alert-danger">
           <i class="icon-remove"></i>
           <?php echo $this->session->flashdata('error');?>
        </div>
    <?php } else if($this->session->flashdata('success')) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i>
           <?php echo $this->session->flashdata('success');?>
        </div>
    <?php } ?>

    <?php
	if($_SESSION['product_switch']['name']){
	?><span style='font-size:large'>Selected Product : <?php echo $_SESSION['product_switch']['name']; ?></span>
	<?php }
	?>
	
    <div class="row portlet">
        <div class="col-md-12">
            <div class="mt-element-ribbon bg-grey-steel" id='modal_view'>
                <div class="ribbon ribbon-clip ribbon-color-danger uppercase" style="font-size: 20px;">
                    <div class="ribbon-sub ribbon-clip"></div> Completed tests need to Approve
                </div>
                
                <div class="ribbon-content" style="padding-top: 40px;">
                    <?php if(empty($completed_tests)) { ?>
                        <div style="font-size: 20px;text-align:center;">No Completed tests yet.</div>
                    <?php } else { ?>
                        <table class="table table-hover table-light dashboard-table">
                            <thead>
                                <tr>
                                    
                                    <th>Event</th>
                                    <th>Product Name</th>
                                    <th>Part Name</th>
                                    <th>Part No</th>
                                    <th>Supplier Name</th>
                                    <th>Test Name</th>
                                    <!--<th>Test Method</th>
                                    <th>Chamber Category</th>
                                    <th>Chamber Specification</th>-->
                                    <th>Chamber Name</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                    <th class="no_sort"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($completed_tests as $completed_test) { ?>
                                    
                                    <tr>
                                        <td><?php echo $completed_test['event_name']; ?></td>
                                        <td><?php echo $completed_test['product_name']; ?></td>
                                        <td><?php echo $completed_test['part_name']; ?></td>
                                        <td><?php echo $completed_test['part_no']; ?></td>
                                        <td><?php echo $completed_test['supplier_name']; ?></td>
                                        <td><?php echo $completed_test['test_name']; ?></td>
                                        <!--<td><?php echo $completed_test['test_method']; ?></td>
                                        <td><?php echo $completed_test['chamber_category']; ?></td>
                                        <td><?php echo $completed_test['chamber_spec']; ?></td>-->
                                        <td><?php echo $completed_test['chamber_name']; ?></td>
                                        <td><?php if($completed_test['is_approved'] == 1) {
											echo 'Approved';
										}else{ echo 'Completed'; } ?></td>
										
										<td class="text-center" style="vertical-align:middle">
											 <?php if(!empty($completed_test["test_img"])){ ?>
										
											<button type="button" class="button small gray" data-toggle="modal" data-target="#myModal_img">Test Image</button>

											<div id="myModal_img" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											
											  <div class="modal-dialog">
											   
												<div class="modal-content">
												
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h3>Test Image</h3>
												</div>
													<div class="modal-body">
														<img src='<?php echo base_url()."assets/test images/".$completed_test["test_img"]; ?>' class="img-responsive">
													</div>
												</div>
											  </div>
											</div>
											
											 <?php }else{ 
												echo "No Image";
												//echo $completed_test['code'];
											  } 
											  ?>
										</td>
										
                                        <!-- <td><?php echo $completed_test['chamber_name']; ?></td> 
                                        <td><?php echo $completed_test['test_name']; ?></td>-->
                                        
                                        <td><?php echo date('jS M, Y h:i A', strtotime($completed_test['start_date'])); ?></td>
                                        <td><?php echo date('jS M, Y h:i A', strtotime($completed_test['end_date'])); ?></td>
                                        
										<?php if($completed_test['completed'] == 1){	?>
										<td>
                                            
                                            <!--<a class="button small gray" 
                                                
												href="<?php echo base_url()."apps/view_completed_test/".$completed_test['code'];?>">
                                                View
                                            </a>-->
											<button type="button" class="button small view-test-modal-btn1" data-index="<?php echo $completed_test['code']; ?>">
                                                View
                                            </button>
											
											<!--a class="button small gray" 
                                                href="<?php echo base_url()."apps/mark_as_approved/".$completed_test['code'];?>">
                                                Approve
                                            </a-->
											
											<button type="button" class="button small gray"  data-toggle="modal" data-target="#myModal_appr_<?php echo $completed_test['code']; ?>">Approve</button>
											<div id="myModal_appr_<?php echo $completed_test['code']; ?>" class="modal fade" role="dialog" style='z-index:99999'>
											  <div class="modal-dialog">

												<div class="modal-content">
												  <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h1>Remark for Approve Test</h1>
												  </div>
												  <div class="modal-body">
													<form id='test_remark_form' action="<?php echo base_url().'apps/mark_as_approved/'.$completed_test['code'];?>" method='post'>
													Remark : <?php echo $completed_test['code']; ?>
													<textarea required class="required form-control" rows="5" name='appr_test_remark' id="appr_test_remark"></textarea>
													</br>
												  <div class="modal-footer">
													<input style='text-align:center' type='submit' class='button white' id='retest_submit' value='SUBMIT'/>
													</div>
													</form>
												  </div>
												</div>

											  </div>
											</div>


											
											<button type="button" class="button small"  data-toggle="modal" data-target="#myModal_<?php echo $completed_test['code']; ?>">Re-test</button>
											
											<div id="myModal_<?php echo $completed_test['code']; ?>" class="modal fade" role="dialog" style='z-index:99999'>
											  <div class="modal-dialog">

												<div class="modal-content">
												  <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h1>Remark for Re-test</h1>
												  </div>
												  <div class="modal-body">
													<form id='test_remark_form' action="<?php echo base_url().'apps/sent_to_retest/'.$completed_test['code'];?>" method='post'>
													Remark : <?php echo $completed_test['code']; ?>
													<textarea required class="required form-control" rows="5" name='retest_remark' id="retest_remark"></textarea>
													</br>
												  <div class="modal-footer">
													<input style='text-align:center' type='submit' class='button white' id='retest_submit' value='SUBMIT'/>
													</div>
													</form>
												  </div>
												</div>

											  </div>
											</div>
											
										</td>
										<?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

<!--Popup Start-->
<div class="modal fade bs-modal-lg" id="view-test-modal1" tabindex="-1" role="dialog" aria-hidden="true" style='width: 80%;   margin-top: 50px;margin-left: auto;margin-right: auto;'>
        
</div>
<!--Popup End-->


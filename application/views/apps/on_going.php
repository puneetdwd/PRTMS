<style>
    .control-label.col-md-5 {
        padding-top:6px;
    }
    hr {
        margin: 10px 0px;
    }
    table .form-group {
        margin-bottom:0px;
    }
    td.merged-col {
        vertical-align:middle !important;
    }
</style>

<?php 
	$category = $test['chamber_category']; 
?>
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Part Monitoring
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Part Monitoring</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if($this->session->flashdata('error')) {?>
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
        
            <div class="portlet light bordered" id="monitoring-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> On Going Test Screen
                    </div>
                    
                    <div style="float: right; padding-top: 10px; width: 60%;">
                        <div class="progress progress-striped active" style="margin-bottom: 15px;">
                            <div style="width: <?php echo $progress; ?>%; color:#000000;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $progress; ?>" role="progressbar" class="progress-bar progress-bar-danger">
                                <b><?php echo $progress; ?>% Complete</b>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="" method="post" enctype='multipart/form-data'>
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>

                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-times"></i>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Start Date:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo date('jS M, Y h:i A', strtotime($test['start_date'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>End Date:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo date('jS M, Y h:i A', strtotime($test['end_date'])); ?>
                                                <?php if(!empty($test['extended_hrs'])) { ?>
                                                    <small>(Extended by <?php echo $test['extended_hrs'].' hours';?>)</small>
                                                <?php } ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Observation Frequency:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['observation_frequency'].' hrs'; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>No of Samples:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['samples']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>LOT/ASN NO:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['lot_no']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr />
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Chamber Category:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['chamber_category']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Chamber Name:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['chamber_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Chamber Spec:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['chamber_spec']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <hr />
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Product Name:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['product_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Supplier Name:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['supplier_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Part Name:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['part_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Part No:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['part_no']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <hr />

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Test Name:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['test_name']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Test Duration:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['duration'].' hrs'; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Test Method:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['test_method']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-5"><b>Test Judgement:</b></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static">
                                                <?php echo $test['test_judgement']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-puzzle font-grey-gallery"></i>
                                        <span class="caption-subject bold font-grey-gallery uppercase"> Observations</span>
										 
										 <?php if(!empty($test["img_file"])){ ?>
											<button style='border: none;background-color: #fff;color: black;font-size: 16px;' type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">(View Reference Image)</button>

											<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
        
											  <div class="modal-dialog">
												<div class="modal-content">
												
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h3>Reference Image</h3>
												</div>
												
													<div class="modal-body">
														<img src='<?php echo base_url()."assets/part reference files/".$test["img_file"]; ?>' class="img-responsive">
													</div>
												</div>
											  </div>
											</div>
											
										 <?php } ?>
                                    </div>
                                    <div class="tools">
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-condensed">
                                            <tr>
                                                <td rowspan="4" class="merged-col" style="width:0px;">Plan</td>
                                                <td style="width:100px;">Day</td>
                                                
                                                <?php for($i=0; $i<$test['no_of_observations']; $i++) { ?>
                                                    <td colspan="<?php echo $test['samples']; ?>" class="text-center"><?php echo $i; 
													?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td>Samples</td>
                                                <?php foreach($observations['sample'] as $ob) { ?>
                                                    <td><?php echo $ob; ?></td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td>Date</td>
                                                <?php foreach($observations['observation_at'] as $ob) { ?>
                                                    <td><?php echo $ob; ?></td>
                                                <?php } ?>
                                            </tr>
                                            
                                            
                                            <?php if($category == 'Electrical') { ?>
                                                <tr>
                                                    <td class="merged-col">Check Items</td>
                                                    <td>Unit</td>
                                                    
                                                    <?php foreach($observations['check_items'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="merged-col">Appearance</td>
                                                    <td>Visual</td>
                                                    
                                                    <?php foreach($observations['appearance'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="merged-col">Current</td>
                                                    <td>Amp</td>
                                                    
                                                    <?php foreach($observations['current'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td rowspan="2" class="merged-col">Voltage</td>
                                                    <td>Set Volt</td>
                                                    
                                                    <?php foreach($observations['set_volt'] as $ob) { ?>
                                                        <td><?php //echo $ob;
																echo $test['set_volt'];?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td>Test Volt</td>
                                                    
                                                    <?php foreach($observations['act_volt'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="merged-col">Power/Wattage</td>
                                                    <td>Watt</td>
                                                    
                                                    <?php foreach($observations['power_watt'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                            
                                            <?php if($category == 'Environmental' || $category == 'Heat & Humid') { ?>
                                                <tr>
                                                    <td rowspan="2" class="merged-col">Display Temperature (&#8451;)</td>
                                                    <td>Set</td>
                                                    
                                                    <?php foreach($observations['display_temp_set'] as $ob) { ?>
                                                        <td><?php echo $test['display_temp_set']; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td>Actual</td>
                                                    
                                                    <?php foreach($observations['display_temp_act'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2" class="merged-col">Humidity (%RH)</td>
                                                    <td>Set</td>
                                                    
                                                    <?php foreach($observations['humidity_set'] as $ob) { ?>
                                                        <td><?php echo $test['humidity_set']; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td>Actual</td>
                                                    
                                                    <?php foreach($observations['humidity_act'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="merged-col">Visual</td>
                                                    <td>Test Volt</td>
                                                    
                                                    <?php foreach($observations['act_volt'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                            
                                            <?php if($category == 'Salt Spray') { ?>
                                                <tr>
                                                    <td class="merged-col">Check Points</td>
                                                    <td>Unit</td>
                                                    
                                                    <?php foreach($observations['check_items'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td rowspan="2" class="merged-col">Display Temperature (&#8451;)</td>
                                                    <td>Set</td>
                                                    
                                                    <?php foreach($observations['display_temp_set'] as $ob) { ?>
                                                        <td><?php echo $test['display_temp_set']; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td>Actual</td>
                                                    
                                                    <?php foreach($observations['display_temp_act'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td rowspan="2" class="merged-col">Pressure</td>
                                                    <td>Set</td>
                                                    
                                                    <?php foreach($observations['pressure_set'] as $ob) { ?>
                                                        <td><?php echo $test['pressure_set']; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td>Actual</td>
                                                    
                                                    <?php foreach($observations['pressure_act'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="merged-col">PH</td>
                                                    <td>Actual PH</td>
                                                    
                                                    <?php foreach($observations['ph_act'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="merged-col">Fog Collection</td>
                                                    <td>Actual Fog</td>
                                                    
                                                    <?php foreach($observations['fog'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="merged-col">Salt Water Level</td>
                                                    <td>Actual</td>
                                                    
                                                    <?php foreach($observations['salt_water_level'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                
                                                <tr>
                                                    <td rowspan="2" class="merged-col">Voltage</td>
                                                    <td>Set Volt</td>
                                                    
                                                    <?php foreach($observations['set_volt'] as $ob) { ?>
                                                        <td><?php //echo $ob; 
														echo $test['set_volt'];
														?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td>Test Volt</td>
                                                    
                                                    <?php foreach($observations['act_volt'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
                                            
                                            <?php if($category != 'Salt Spray') { ?>
                                                <?php if($category == 'Electrical') { ?>
                                                    <tr>
                                                        <td class="merged-col">Torque</td>
                                                        <td>RPM</td>
                                                        
                                                        <?php foreach($observations['torque_rpm'] as $ob) { ?>
                                                            <td><?php echo $ob; ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td class="merged-col">Rust</td>
                                                        <td>Visual</td>
                                                        
                                                        <?php foreach($observations['rust'] as $ob) { ?>
                                                            <td><?php echo $ob; ?></td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                                
                                                <tr>
                                                    <td class="merged-col">Colour</td>
                                                    <td>&#916;E</td>
                                                    
                                                    <?php foreach($observations['colour'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td class="merged-col">Crack/Damage</td>
                                                    <td>Visual</td>
                                                    
                                                    <?php foreach($observations['crack'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td class="merged-col">Adhesion Peel-Off</td>
                                                    <td>Visual</td>
                                                    
                                                    <?php foreach($observations['adhesion'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td class="merged-col">Visual</td>
                                                    <td>Test Volt</td>
                                                    
                                                    <?php foreach($observations['act_volt'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td class="merged-col">Rust</td>
                                                    <td>White/Red</td>
                                                    
                                                    <?php foreach($observations['rust'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td class="merged-col">Adhesion Peel-Off</td>
                                                    <td>Visual</td>
                                                    
                                                    <?php foreach($observations['adhesion'] as $ob) { ?>
                                                        <td><?php echo $ob; ?></td>
                                                    <?php } ?>
                                                </tr>
                                            <?php } ?>
											<tr>
                                                <td colspan="2" class="merged-col">Result</td>                                             
                                                <?php foreach($observations['observation_result'] as $ob) { ?>
                                                    <td><?php echo $ob; ?></td>
                                                <?php } ?>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="2" class="merged-col">Assistant Name</td>
                                                
                                                <?php foreach($observations['assistant_name'] as $ob) { ?>
                                                    <td><?php echo $ob; ?></td>
                                                <?php } ?>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="2" class="merged-col"></td>
                                                <?php foreach($observations['allowed'] as $ind => $ob) { ?>
                                                    <?php if($ob == 'Yes') { ?>
                                                        <td class="text-center">
                                                            <button type="button" class="button small observation-modal-btn" data-index="<?php echo $ind; ?>" id="<?php echo $ind; ?>">
                                                                Add Observation
                                                            </button>
                                                        </td>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
							
							
                            
                            <div class="form-actions text-center">
                                <a data-toggle="modal" href="#switch-chamber-modal" class="button gray">
                                    Switch to different Chamber
                                </a>
                                <a data-toggle="modal" href="#basic" class="button gray">
                                    Extend
                                </a>
                                
                                <a href="<?php echo base_url().'apps/mark_as_abort/'.$test['code'];?>" class="button"
                                data-confirm="Are you sure you want to stop this test?">
                                    Stop
                                </a>
                                
                                <a href="<?php echo base_url().'apps/mark_as_complete/'.$test['code'];?>" class="button"
                                data-confirm="Are you sure you want to complete this test?">
                                    Complete
                                </a>
                                <!--<a href="<?php echo base_url().'apps/mark_as_skiped/'.$test['code'];?>" class="button"
                                data-confirm="Are you sure you want to SKIP this test?">
                                    SKIP TEST
                                </a>-->
								<button type="button" class="button"  data-toggle="modal" data-target="#myModal1">SKIP TEST</button>
											
                               
								
                                <a href="<?php echo base_url();?>" class="button white">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>

<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form class="validate-form2" action="<?php echo base_url().'apps/extent_test/'.$test['code']; ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Extend Test</h4>
                </div>
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="extended_hrs">Extent Test (in hrs):
                                <span class="required">*</span></label>
                                <input type="text" class="required form-control" name="extended_hrs" placeholder="Enter No of hrs to extend">
                                <span class="help-block">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button white" data-dismiss="modal">Close</button>
                    <button type="submit" class="button">Save</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="switch-chamber-modal" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <form class="validate-form3" action="<?php echo base_url().'apps/switch_test_chamber/'.$test['code']; ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Switch Test to different Chamber</h4>
                </div>
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" id="monitoring-form-switch-chamber-error">
                                <label class="control-label" for="chamber_id">Chambers:
                                <span class="required">*</span></label>
                                
                                <select name="chamber_id" class="form-control required select2me"
                                data-placeholder="Select Chamber" data-error-container="#monitoring-form-switch-chamber-error">
                                    <option value=""></option>
                                    
                                    <?php foreach($switch_chambers as $switch_chamber) { ?>
                                        <option value="<?php echo $switch_chamber['id']; ?>">
                                            <?php echo $switch_chamber['name']; ?>
                                        </option>
                                    <?php } ?>
                                    
                                </select>
                                
                                <span class="help-block">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button white" data-dismiss="modal">Close</button>
                    <button type="submit" class="button">Save</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade bs-modal-lg" id="observation-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="validate-form" id="observation-form" action="<?php echo base_url().'apps/add_observation/'.$test['code']; ?>" method="post" enctype='multipart/form-data'>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add Observation</h4>
                </div>
                <div class="modal-body"> 
                    <div class="row" style="margin-bottom:10px;">
                        <div class="form-group">
                            <label for="observation_result" class="col-md-2 col-md-offset-6" style="margin-top: 7px;">Observation Result<span class='required'>*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control required" name="observation_result" id="observation-id" placeholder="OK / NG">
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="observation_index" id="observation_index" />
                    <table class="table table-condensed table-bordered">
                        <?php if($category == 'Electrical') { ?>
                            <tr>
                                <td class="merged-col">Check Items</td>
                                <td class="merged-col">Unit</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="check_items">
                                    </div>
                                </td>
                                <td class="merged-col">Appearance</td>
                                <td class="merged-col">Visual</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="appearance">
                                    </div>
                                </td>
                            </tr>
                        
                            <tr>
                                <td rowspan="2" class="merged-col">Voltage</td>
                                <td class="merged-col">Set Volt</td>
                                <td>
                                    <div class="form-group">
                                        <input readonly type="text" class="form-control" name="set_volt" value='<?php echo $test["set_volt"]; ?>'>
                                    </div>
                                </td>
                                
                                <td class="merged-col">Current</td>
                                <td class="merged-col">Amp</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="current">
                                    </div>
                                </td>
                            </tr>
                        
                            <tr>
                                <td class="merged-col">Test Volt</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="act_volt">
                                    </div>
                                </td>
                                
                                <td class="merged-col ">Power/Wattage</td>
                                <td class="merged-col">Watt</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="power_watt">
                                    </div>
                                </td>
                                
                            </tr>
                        <?php } ?>
                        
                        <?php if($category == 'Environmental' || $category == 'Heat & Humid') { ?>
                            <tr>
                                <td rowspan="2" class="merged-col">Display Temperature (&#8451;)</td>
                                <td class="merged-col">Set</td>
                                <td>
                                    <div class="form-group">
                                        <input readonly type="text" class="form-control" name="display_temp_set" value='<?php echo $test["display_temp_set"]; ?>'>
                                    </div>
                                </td>
                                
                                <td rowspan="2" class="merged-col">Humidity (%RH)</td>
                                <td class="merged-col">Set</td>
                                <td>
                                    <div class="form-group">
                                        <input readonly type="text" class="form-control" name="humidity_set" value='<?php echo $test["humidity_set"]; ?>'>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="merged-col">Actual</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="display_temp_act">
                                    </div>
                                </td>
                                
                                <td class="merged-col">Actual</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="humidity_act">
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="merged-col">Visual</td>
                                <td class="merged-col">Test Volt</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="act_volt">
                                    </div>
                                </td>
                                
                                <td colspan="3"></td>
                                
                            </tr>
                        <?php } ?>
                        
                        <?php if($category == 'Salt Spray') { ?>
                            <tr>
                                <td class="merged-col">Check Points</td>
                                <td class="merged-col">Unit</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="check_items">
                                    </div>
                                </td>
                                <td class="merged-col">PH</td>
                                <td class="merged-col">Actual PH</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="ph_act">
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td rowspan="2" class="merged-col">Display Temperature (&#8451;)</td>
                                <td class="merged-col">Set</td>
                                <td>
                                    <div class="form-group">
                                        <input readonly type="text" class="form-control" name="display_temp_set" value='<?php  echo $test["display_temp_set"]; ?>'>
                                    </div>
                                </td>
                                
                                <td rowspan="2" class="merged-col">Pressure</td>
                                <td class="merged-col">Set</td>
                                <td>
                                    <div class="form-group">
                                        <input readonly type="text" class="form-control" name="pressure_set" value='<?php  echo $test["pressure_set"]; ?>'>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="merged-col">Actual</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="display_temp_act">
                                    </div>
                                </td>
                                
                                <td class="merged-col">Actual</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="pressure_act">
                                    </div>
                                </td>
                            </tr>
                        
                            <tr>
                                <td rowspan="2" class="merged-col">Voltage</td>
                                <td class="merged-col">Set Volt</td>
                                <td>
                                    <div class="form-group">
                                        <input readonly type="text" class="form-control" name="set_volt" value='<?php  echo $test["set_volt"]; ?>'> 
                                    </div>
                                </td>
                                
                                <td class="merged-col">Fog Collection</td>
                                <td class="merged-col">Actual Fog</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="fog">
                                    </div>
                                </td>
                            </tr>
                        
                            <tr>
                                <td class="merged-col">Test Volt</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="act_volt">
                                    </div>
                                </td>
                                
                                <td class="merged-col ">Salt Water Level</td>
                                <td class="merged-col">Actual </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="salt_water_level">
                                    </div>
                                </td>
                                
                            </tr>
                        <?php } ?>
                        
                        <?php if($category != 'Salt Spray') { ?>
                            <tr>
                                <?php if($category == 'Electrical') { ?>
                                    <td class="merged-col">Torque</td>
                                    <td class="merged-col">RPM</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="torque_rpm">
                                        </div>
                                    </td>
                                <?php } else { ?>
                                    <td class="merged-col">Rust</td>
                                    <td class="merged-col">Visual</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="rust">
                                        </div>
                                    </td>
                                <?php } ?>
                                
                                <td class="merged-col">Colour</td>
                                <td class="merged-col">&#916;E</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="colour">
                                    </div>
                                </td>
                                
                            </tr>
                            
                            <tr>
                                <td class="merged-col">Crack/Damage</td>
                                <td class="merged-col">Visual</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="crack">
                                    </div>
                                </td>
                                <td class="merged-col">Adhesion Peel-Off</td>
                                <td class="merged-col">Visual</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="adhesion">
                                    </div>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td class="merged-col">Visual</td>
                                <td class="merged-col">Test Volt</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="act_volt">
                                    </div>
                                </td>
                                
                                <td colspan="3"></td>
                                
                            </tr>
                            
                            <tr>
                                <td class="merged-col">Rust</td>
                                <td class="merged-col">White/Red</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="rust">
                                    </div>
                                </td>
                                <td class="merged-col">Adhesion Peel-Off</td>
                                <td class="merged-col">Visual</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="adhesion">
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                
                    <div class="row" style="margin-top:10px;">
							
			
						<?php 
							$max_observation =  $test['no_of_observations'] * $test['samples']; 
						
						if($max_observation - 1 ){ ?>
						<input type="hidden" name="max_observation" id="max_observation" value='<?php echo $max_observation; ?>' />
                    
						<div class="form-group img_test">
                            <label for="test_img" class="col-md-2 col-md-offset-6" style="margin-top: 7px;">Test Image<span class='required'>*</span></label>
                            <div class="col-md-4">
                                <input type="file" class="form-control" name="test_img" placeholder="Choose Image">
								<span class="help-block">Only jpg|png files are allowed.
								</span>
                            </div>
                        </div>
						<?php } ?>
                   
                        <div class="form-group">
                            <label for="assistant_name" class="required col-md-2 col-md-offset-6" style="margin-top: 7px;">Assistant Name<span class='required'>*</span></label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="assistant_name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button white" data-dismiss="modal">Close</button>
                    <button type="submit" class="button">Save</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

 <!-- Modal -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1>Remark for Skip test</h1>
      </div>
      <div class="modal-body">
        <form id='test_remark_form' action="<?php echo base_url().'apps/mark_as_skiped/'.$test['code'];?>" method='post'>
		Remark : 
		<textarea required class="form-control" rows="5" name='skip_remark' id="skip_remark"></textarea>
		</br>
      <div class="modal-footer">
		<input style='text-align:center' type='submit' class='button white' id='retest_submit' value='SUBMIT'/>
        </div>
        </form>
      </div>
    </div>

  </div>
</div>


<script>
$(".observation-modal-btn").click(function() {
    var obs_button = this.id; // or alert($(this).attr('id'));
    var max_obs = document.getElementById("max_observation").value;
	var max = max_obs -1;
	if(obs_button == max){
		$('.img_test').show();
		$(".img_test>div>input").addClass("required");
	}else{
		//$('.img_test').remove("CLASS_NAME");
		$('.img_test').hide();
	}
});
</script>



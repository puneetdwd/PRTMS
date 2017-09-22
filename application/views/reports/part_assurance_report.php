<style>
    .table.table-light > thead > tr > th {
        font-size: 14px;
        font-weight: 700;
    }
</style>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Part Assurance Report
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Part Assurance Report</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
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
            
        <div class="col-md-12">
            <div class="portlet light bordered" id="ptc-mapping-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-search"></i>Search
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post">
                        <div class="form-body" style="padding:0px;">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                You have some form errors. Please check below.
                            </div>
                        
                        
                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger">
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>
                            
                            <div class="row">
                                <input name = 'part_assurance' id = 'part_assurance' value = 'part_assurance' type = 'hidden' />
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Month<span class="required">*</span></label>
                                        <select name="month" id="month" class="required form-control select2me" data-placeholder="Month">
                                            <option></option>
                                            
                                            <option value="1" <?php if($this->input->post('month') == 1) { ?> selected="selected" <?php } ?>>
                                                Jan
                                            </option>
                                            <option value="2" <?php if($this->input->post('month') == 2) { ?> selected="selected" <?php } ?>>
                                                Feb
                                            </option>
                                            <option value="3" <?php if($this->input->post('month') == 3) { ?> selected="selected" <?php } ?>>
                                                Mar
                                            </option>
                                            <option value="4" <?php if($this->input->post('month') == 4) { ?> selected="selected" <?php } ?>>
                                                Apr
                                            </option>
                                            <option value="5" <?php if($this->input->post('month') == 5) { ?> selected="selected" <?php } ?>>
                                                May
                                            </option>
                                            <option value="6" <?php if($this->input->post('month') == 6) { ?> selected="selected" <?php } ?>>
                                                Jun
                                            </option>
                                            <option value="7" <?php if($this->input->post('month') == 7) { ?> selected="selected" <?php } ?>>
                                                Jul
                                            </option>
                                            <option value="8" <?php if($this->input->post('month') == 8) { ?> selected="selected" <?php } ?>>
                                                Aug
                                            </option>
                                            <option value="9" <?php if($this->input->post('month') == 9) { ?> selected="selected" <?php } ?>>
                                                Sep
                                            </option>
                                            <option value="10" <?php if($this->input->post('month') == 10) { ?> selected="selected" <?php } ?>>
                                                Oct
                                            </option>
                                            <option value="11" <?php if($this->input->post('month') == 11) { ?> selected="selected" <?php } ?>>
                                                Nov
                                            </option>
                                            <option value="12" <?php if($this->input->post('month') == 12) { ?> selected="selected" <?php } ?>>
                                                Dec
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Year<span class="required">*</span></label>
                                        <select name="year" id="year" class="required form-control select2me" data-placeholder="Year">
                                            <option></option>
                                            <?php for($y = 2016; $y <= date('Y'); $y++) { ?>
                                                <option value="<?php echo $y; ?>" <?php if($this->input->post('year') == $y) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $y; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="required form-group" id="ptc-mappings-chamber-search-error">
                                        <label class="control-label">Select Event:<span class="required">*</span></label>                                                
                                        <select name="stage_id" id="stage_id" class="required form-control select2me"
                                            data-placeholder="Select Event" data-error-container="#ptc-mappings-chamber-search-error">
                                            <option></option>
                                            <?php foreach($stages as $stage) { ?>
                                                <option value="<?php echo $stage['id']; ?>" <?php if($stage['id'] == $this->input->post('stage_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $stage['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-product-search-error">
                                        <label class="control-label">Select Product:<span class="required">*</span></label>
                                        <select name="product_id" class="required form-control select2me" id="product-part-selector"
                                            data-placeholder="Select Product" data-error-container="#ptc-mappings-product-search-error">
                                            <option></option>
                                            <?php foreach($products as $product) { ?>
                                                <option value="<?php echo $product['id']; ?>" <?php if($product['id'] == $this->input->post('product_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $product['name']; ?>
                                                </option>
                                            <?php }  ?>        
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-part-search-error">
                                        <label class="requried control-label">Select Part Name:<span class="required">*</span></label>                                                
                                        <select name="part_id" class="required form-control select2me " id="part-selector"
                                            data-placeholder="Select Part Name" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['name']; ?>" <?php if($part['name'] == $this->input->post('part_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="required form-group" id="ptc-mappings-part-search-error">
                                        <label class="control-label">Select Part Number:<span class="required">*</span></label>                                                
                                        <select name="part_id1" class="required form-control select2me" id="part-selector_number"
                                            data-placeholder="Select Part Number" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts_num as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == $this->input->post('part_id1')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['part_no']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-part-search-error">
                                        <label class="required control-label">Select Supplier:<span class="required">*</span></label>                                                
                                        <select name="supplier_id" class="required form-control select2me" id="part-selector_supplier" 
                                            data-placeholder="Select Supplier" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($suppliers as $supplier) { ?>
                                                <option value="<?php echo $supplier['id']; ?>" <?php if($supplier['id'] == $this->input->post('supplier_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $supplier['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button class="button" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		
        <div class="col-md-12" id='part_assu_report_table'>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Part Assurance Report
                    </div>
                    
					<?php if(!empty($reports)) { ?>
						<div class="actions" style='margin: 5px;'>
							<a class="button normals btn-circle" href="<?php echo base_url()."reports/export_excel/part_assurance_report"; ?>">
								<i class="fa fa-download"></i> Export Report
							</a>
						</div>
						
					<?php } ?>
                </div>
                <div class="portlet-body">
                    <?php if(empty($reports_common)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        
                        <table class="table table-hover table-light" id='make-data-table1' border=1 style='border-collapse:collapse'>
                            <tr>
                                <td><b>Product Name : </b></td>
                                <td><?php echo $reports_common['product_name']; ?></td>
                                <td><b>Part Name : </b></td>
                                <td><?php echo $reports_common['part_name']; ?></td>
                                <td><b>Part Number : </b></td>
                                <td><?php echo $reports_common['part_no']; ?></td>
                            </tr>

                            <tr>
                                <td><b>Month : </b></td>
                                <td>
									<?php 
											$date = strtotime($this->input->post('year')."-".$this->input->post('month')."-15");
                                          echo date("M'Y", $date);
                                    ?>
                                </td>
                                <td><b>Supplier Name : </b></td>
                                <td><?php echo $reports_common['supplier_name']; ?></td>
                                <td><b>Lot/ASN No. : </b></td>
                                <td><?php echo $reports_common['lot_no']; ?></td>
                            </tr>

                            <tr>
                                <!--td><b>Sample Quantity : </b></td>
                                <td><?php echo $samples; ?></td!-->
                                <td><b>Judgement</b></td>
                                <td><?php echo $judgement; ?></td>
                                <td><b>Event : </b></td>
                                <td><?php echo $reports_event['name']; ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                
                            </tr>

                        </table>
                    <?php } ?>
                    
                </div>
            </div>
            
            <div class="portlet light bordered">
                
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        
                        
                        <table class="table table-hover table-light"  id='make-data-table' border=1 style='border-collapse:collapse'>
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Test Name</th>
                                    <th>Test Method</th>
                                    <th>Test Judgement</th>
                                    <th>Samples</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Result</th>
                                    <th style='width: 100px;'>Image</th>
                                    <th>Skip Remark</th>
                                    <th>Retest Remark</th>
                                    <th>Approve Remark</th>
                                    
                                    <!--<th class="no_sort" style="width:100px;">Action</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn=0; foreach($reports as $report) { $sn++; ?>
                                    <tr>
                                        <td><?php echo $sn; ?></td>
                                        <td><?php echo $report['test_name']; ?></td>
                                        <td><?php echo $report['method']; ?></td>
                                        <td><?php echo $report['judgement']; ?></td>
                                        <td><?php echo $report['samples']; ?></td>
                                        <td>
											<?php //echo $report['start_date']; 
											echo date('d M Y h:i A', strtotime($report['start_date']));
											
											?>
										</td>
                                        <td>
											<?php //echo $report['end_date']; 
											echo date('d M Y h:i A', strtotime($report['end_date']));
											
											?>
										</td>
										<td><?php echo strtoupper($report['observation_result']); ?></td>
                                        
                                        <td>
											<?php if(!empty($report['test_img'])){	?>	
												
												<img style='width:100px;height:100px' src='<?php echo base_url()."assets/test_images/".$report['test_img']; ?>' class="img-responsive" ></img>					
												
											<?php }
											else{
												echo 'No Img';
											} ?>
										</td>
                                       
                                       <td><?php echo $report['skip_remark']; ?></td>
                                       <td><?php echo $report['retest_remark']; ?></td>
                                       <td><?php echo $report['appr_test_remark']; ?></td>
                                        <!--<td nowrap>
                                            <button type="button" class="button small view-test-modal-btn" data-index="<?php echo $report['code']; ?>">
                                                View
                                            </button>
                                        </td>-->
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

<!--Popup Start
<div class="modal fade bs-modal-lg" id="view-test-modal" tabindex="-1" role="dialog" aria-hidden="true">
    
</div>
Popup End-->
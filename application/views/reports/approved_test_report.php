<?php


if($this->user_type == 'Product' ){
	/* print_r($_SESSION['product_ids']);
echo array_search(2,$_SESSION['product_ids']); */
	/* if(empty($_SESSION['product_switch']))
	{
		$session_product_id = $_SESSION['product_switch']['id'];
	}else{
		$session_product_id = '';//$_SESSION['product_switch']['id'];
	} */
}
//exit; 
?>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Approved Test Report
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Approved Test Report</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Start Date Range</label>
                                        <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="form-control" name="start_date" 
                                            value="<?php echo $this->input->post('start_date'); ?>">
                                            <span class="input-group-addon">
                                            to </span>
                                            <input type="text" class="form-control" name="end_date"
                                            value="<?php echo $this->input->post('end_date'); ?>">
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-product-search-error">
                                        <label class="control-label">Select Product:</label>
                                                
                                        <select name="product_id" class="form-control select2me" id="product-part-selector"
                                            data-placeholder="Select Product" data-error-container="#ptc-mappings-product-search-error">
                                            <option></option>
                                            <?php foreach($products as $product) { ?>
                                                <option 
												
												value="<?php echo $product['id']; ?>" <?php if($product['id'] == $this->input->post('product_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $product['name']; ?>
                                                </option>
                                            <?php }  ?>        
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-part-search-error">
                                        <label class="control-label">Select Part Name:</label>
                                                
                                        <select name="part_id" class="form-control select2me" id="part-selector"
                                            data-placeholder="Select Part" data-error-container="#ptc-mappings-part-search-error">
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
                                    <div class="form-group" id="ptc-mappings-part-search-error">
                                        <label class="control-label">Select Part Number:</label>
                                                
                                        <select name="part_id1" class="form-control select2me part-test-selector_plan" id="part-selector_number"
                                            data-placeholder="Select Part" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts_num as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == $this->input->post('part_id1')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['part_no']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-chamber-search-error">
                                        <label class="control-label">Select Event:</label>
                                                
                                        <select name="stage_id" class="form-control select2me"
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
                                    <div class="form-group" id="ptc-mappings-test-search-error">
                                        <label class="control-label">Select Test:</label>
                                                
                                        <select name="test_id" class="form-control select2me"  id='part-test_selector'
                                            data-placeholder="Select Test" data-error-container="#ptc-mappings-test-search-error">
                                            <option></option>
                                            <?php foreach($tests as $test) { ?>
                                                <option value="<?php echo $test['id']; ?>" <?php if($test['id'] == $this->input->post('test_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $test['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-chamber-category-search-error">
                                        <label class="control-label">Select Chamber Category:</label>
                                                
                                        <select name="chamber_category" class="form-control select2me"
                                            data-placeholder="Select Chamber Category" data-error-container="#ptc-mappings-chamber-category-search-error">
                                            <option></option>
                                            <?php foreach($categories as $category) { ?>
                                                <option value="<?php echo $category['category']; ?>" <?php if($category['category'] == $this->input->post('chamber_category')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $category['category']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-chamber-search-error">
                                        <label class="control-label">Select Chamber:</label>
                                                
                                        <select name="chamber_id" class="form-control select2me"
                                            data-placeholder="Select Chamber" data-error-container="#ptc-mappings-chamber-search-error">
                                            <option></option>
                                            <?php foreach($chambers as $chamber) { ?>
                                                <option value="<?php echo $chamber['id']; ?>" <?php if($chamber['id'] == $this->input->post('chamber_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $chamber['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group" id="ptc-mappings-part-search-error">
                                        <label class="control-label">Select Supplier:</label>
                                                
                                        <select name="supplier_id" class="form-control select2me" id="part-selector_supplier"
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
     
        <div class="col-md-12" id='appr_report_table'>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i><b>Approved Test Report</b>
                    </div>
                    
					<?php if(!empty($reports)) { ?>
						<div class="actions" style='margin: 5px;'>
							<a class="button normals btn-circle" href="<?php echo base_url()."reports/export_excel/approved_test_report"; ?>">
								<i class="fa fa-download"></i> Export Report
							</a>
						</div>					
					<?php } ?>
					
                </div>
                <div class="portlet-body" style='overflow-x: AUTO;'>
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id='make-data-table'>
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
                                    <th>Test Image</th>
                                    <th>Is Approved</th>
                                    <th>Supplier</th>
                                    <th>Inspector</th>
                                    <th>ASN No.</th>
                                    <th>Result</th>
									<th>Approver Remark</th>
                                    <th>Retest Remark</th>
                                    <th>Skiped Remark</th>
                                    
                                    <th class="no_sort" style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reports as $report) { ?>
                                    <tr>
                                        <td><?php echo $report['stage_name']; ?></td>
                                        <td><?php echo $report['product_name']; ?></td>
                                        <td><?php echo $report['part_name']; ?></td>
                                        <td><?php echo $report['part_no']; ?></td>
                                        <td><?php echo $report['test_name']; ?></td>
                                        <td><?php echo date('jS M, Y H:s:i', strtotime($report['start_date'])); ?></td>
                                        <td><?php echo date('jS M, Y H:s:i', strtotime($report['end_date'])); ?></td>
                                        <td><?php echo $report['chamber_category']; ?></td>
                                        <td><?php echo $report['chamber_name']; ?></td>
										<!--td>
											<a href="<?php echo base_url()."assets/test_images/".$report["test_img"]; ?>" target="_blank" >
												<img src='<?php echo base_url()."assets/test_images/".$report["test_img"]; ?>' class="img-responsive">
											</a>
										</td-->
										<td>
										
											<?php 
											if(!empty($report['test_img'])){		
												//echo $report['test_img'] = "download.jpg";
												$file_path = FCPATH."assets \ test_images \ ".$report['test_img']; 
												$file_path = str_replace(' ','',$file_path);
												//echo FCPATH;
												if(file_exists($file_path))
												{
													?>
														<img style='width:100px;height:100px' src='<?php echo base_url()."assets/test_images/".$report['test_img']; ?>' class="img-responsive" ></img>
													<?php 
												}
												else
													echo 'No Img';
											} 										
											else{
												echo 'No Img';
											}  ?>
										</td>
                                        <td>
										<?php 
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
										
										
                                        <td nowrap>
                                            <button type="button" class="button small view-test-modal-btn" data-index="<?php echo $report['code']; ?>">
                                                View
                                            </button>
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

<!--Popup Start-->
<div class="modal fade bs-modal-lg" id="view-test-modal" tabindex="-1" role="dialog" aria-hidden="true">
    
</div>
<!--Popup End-->
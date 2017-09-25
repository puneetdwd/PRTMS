<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h3>
            Part Test Summary Report
        </h3>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Part Test Summary Report</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <?php if($this->session->flashdata('error')) { ?>
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
            
        <div class="col-md-3">
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class=" control-label">Start Date Range:<span class="required">*</span></label>
                                        <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="required form-control" name="start_date" 
                                            value="<?php echo $this->input->post('start_date'); ?>">
                                            <span class="input-group-addon">
                                            to </span>
                                            <input type="text" class="required form-control" name="end_date"
                                            value="<?php echo $this->input->post('end_date'); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-12">
									<div class="required form-group" id="ptc-mappings-chamber-search-error">
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
							</div>
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="sp-mappings-product-search-error">
                                        <label class="control-label">Select Product:</label>
                                                
                                        <select name="product_id" class="form-control select2me" id="product-part-selector_map"
                                            data-placeholder="Select Product" data-error-container="#sp-mappings-product-search-error">
                                            <option></option>
                                            <?php foreach($products as $product) { ?>
                                                <option value="<?php echo $product['id']; ?>" <?php if($product['id'] == $this->input->post('product_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $product['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="sp-mappings-part-search-error">
                                        <label class="control-label">Select Part:</label>
                                                
                                        <select name="part_id" class="form-control select2me" id="part-selector_map"
                                            data-placeholder="Select Part" data-error-container="#sp-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['name']; ?>" <?php if($part['name'] == $this->input->post('part_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
							<div class="row">
                                <div class="col-md-12">
                                    <div class="required form-group" id="ptc-mappings-part-search-error">
                                        <label class="control-label">Select Part Number:</label>                                                
                                        <select name="part_id1" class="form-control select2me" id="part-selector_number_map"
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
                            </div>
							
							
								
                        <div class="form-actions">
                            <button class="button" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
				
        <div class="col-md-9" id='part_test_report_table'>
            <div class="portlet light bordered">
                <div class="portlet-title">
					<div class="caption">
                        <i class="fa fa-reorder"></i><b>Part Test Count Report (Approved)</b>
						
                    </div>
					
							<?php if(!empty($reports)) { ?>
								<div class="actions" style='margin: 5px;'>
									<a class="button normals btn-circle" href="<?php echo base_url()."reports/export_excel/part_test_summary_report/"; ?>">
										<i class="fa fa-download"></i> Export Report
									</a>
								</div>
							<?php } ?>
				
                </div>
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id='make-data-table'>
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Product</th>
                                    <th>Part Name</th>
                                    <th>Part No.</th>
                                    <!--th>Planed Test Count</th-->
                                    <th>Approved Test Count</th>
                                    <th>No Lot Count</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								$CI =& get_instance();
								$CI->load->model('Plan_model');
								$f = $_SESSION['pts_filters'];
																
								foreach($reports as $report) { ?>
                                    <tr>
                                        <td><?php echo $report['st_name']; ?></td>
                                        <td><?php echo $report['product']; ?></td>
                                        <td><?php echo $report['part_name']; ?></td>
                                        <td><?php echo $report['part_no']; ?></td>
                                        <!--td style='text-align:center'>
											<?php 
												$res = $CI->Plan_model->get_total_test_by_part($report['part_no'],$this->input->post('start_date'),$this->input->post('end_date'));
												
												if(!empty($res))
													echo $res['tot_planned_test'];
												else
													echo '0'; 
											?>
										</td-->
                                        <td  style='text-align:center'><?php echo $report['test_cnt']; ?></td>
                                        <td  style='text-align:center'>
										<?php 
											$res = $CI->Plan_model->get_no_inspection_by_part($report['part_no'],$this->input->post('start_date'),$this->input->post('end_date'));
											if(!empty($res))
												echo $res['insp_cnt'];
											else
												echo '0';
										?>
										</td>
										<td>&nbsp;</td>
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
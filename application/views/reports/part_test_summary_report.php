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
                                    <div class="form-group" id="sp-mappings-product-search-error">
                                        <label class="control-label">Select Product:<span class="required">*</span></label>
                                                
                                        <select name="product_id" class="required form-control select2me" id="product-part-selector_map"
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
                                        <label class="control-label">Select Part:<span class="required">*</span></label>
                                                
                                        <select name="part_id1" class=" required form-control select2me" id="part-selector_map"
                                            data-placeholder="Select Part" data-error-container="#sp-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['name']; ?>" <?php if($part['id'] == $this->input->post('part_id')) { ?> selected="selected" <?php } ?>>
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
                                        <label class="control-label">Select Part Number:<span class="required">*</span></label>                                                
                                        <select name="part_id" class="required form-control select2me" id="part-selector_number_map"
                                            data-placeholder="Select Part Number" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == $this->input->post('part_id')) { ?> selected="selected" <?php } ?>>
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
				<div class="portlet-title">
                   <?php if(!empty($reports)) { ?>
                    <div class="actions" style='float: left;margin: 5px;'>
                        <a class="button normals btn-circle" href="<?php echo base_url()."reports/export_excel/part_test_summary_report/"; ?>">
                            <i class="fa fa-download"></i> Export Report
                        </a>
                    </div>
					<div class="actions" style='float: left;margin: 5px;'>
						<a class="button normals btn-circle" onclick="printPage('part_test_report_table');" href="javascript:void(0);">
							<i class="fa fa-print"></i> Print
						</a>
					</div>
                    <?php } ?>
                </div>
        <div class="col-md-9" id='part_test_report_table'>
            <div class="portlet light bordered">
                <div class="portlet-title">
					<div class="caption">
                        <i class="fa fa-reorder"></i><b>Part Test Count Report</b>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Start Date</th>
                                    <th>Part No.</th>
                                    <th>Test Count</th>
                                    <th>No Lot Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								$CI =& get_instance();
								/* if(empty($this->input->post('start_date')))
									
									
								if($this->input->post('end_date'))
								 */	
								foreach($reports as $report) { ?>
                                    <tr>
                                        <td><?php 
										echo date('jS M, Y', strtotime($report['start_date']))
										//echo $report['start_date']; 
										?></td>
                                        <td><?php echo $report['part_no']; ?></td>
                                        <td><?php echo $report['test_cnt']; ?></td>
                                        <td><?php //echo $report['no_inspection'];
											
											$CI->load->model('Plan_model');
											$res = $CI->Plan_model->get_no_inspection_by_part($report['part_no'],$this->input->post('start_date'),$this->input->post('end_date'));
											if(!empty($res))
												echo $res['insp_cnt'];
											else
												echo '0';
											//echo $this->db->last_query();exit;
											//echo $report['part_no'].$this->input->post('start_date').$this->input->post('end_date');exit;
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
    </div>
    <!-- END PAGE CONTENT-->
</div>
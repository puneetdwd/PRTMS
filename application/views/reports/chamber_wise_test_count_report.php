<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h3>
            Chamber Wise Test Count Report
        </h3>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Chamber Wise Test Count Report</li>
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
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="ptc-mappings-product-search-error">
                                        <label class="control-label">Select Product:<span class='required'>*</span></label>
                                                
                                        <select name="product_id" class="required form-control select2me" id="product-part-selector1"
                                            data-placeholder="Select Product" data-error-container="#ptc-mappings-product-search-error">
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
                                    <div class="form-group" id="ptc-mappings-part-search-error">
                                        <label class="control-label">Select Part:</label>
                                                
                                        <select name="part_id" class="form-control select2me" id="part-selector1"
                                            data-placeholder="Select Part" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == $this->input->post('part_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
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
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
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
                            
                        </div>
                        
                        <div class="form-actions">
                            <button class="button" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
				<div class="portlet-title">
                   <?php if(!empty($reports)) { ?>
                    <div class="actions" style='float: left;margin: 5px;'>
                        <a class="button normals btn-circle" href="<?php echo base_url()."reports/export_excel/chamber_wise_test_count_report/"; ?>">
                            <i class="fa fa-download"></i> Export Report
                        </a>
                    </div>
					<div class="actions" style='float: left;margin: 5px;'>
						<a class="button normals btn-circle" onclick="printPage('chamber_report_table');" href="javascript:void(0);">
							<i class="fa fa-print"></i> Print
						</a>
					</div>
                    <?php } ?>
                </div>
        <div class="col-md-9" id='chamber_report_table'>
            <div class="portlet light bordered">
                <div class="portlet-title">
					<div class="caption">
                        <i class="fa fa-reorder"></i><b>Chamber wise Test Count Report</b>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Chamber Category</th>
                                    <th>Chamber Name</th>
                                    <th>Test Count</th>
                                    <th class="no_sort" style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reports as $report) { ?>
                                    <tr>
                                        <td><?php echo $report['chamber_category']; ?></td>
                                        <td><?php echo $report['chamber_name']; ?></td>
                                        <td><?php echo $report['test_record_count']; ?></td>
                                        <td nowrap>
                                            <a class="btn btn-success btn-xs"
                                                href="<?php echo base_url()."reports/check_tests/".$report['chamber_id'];?>">
                                                <i class="fa fa-eye" aria-hidden="true"></i> Check Tests
                                            </a>
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
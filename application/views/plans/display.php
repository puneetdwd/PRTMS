<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Monthly Plan
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Monthly Plan</li>
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
            
        <div class="col-md-3">
            <div class="portlet light bordered" id="ptc-mapping-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-search"></i>Search
                    </div>
                </div>
                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post" action="<?php echo base_url().'plans/display';?>">
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
                                        <label class="control-label">Select Month:</label>
                                        
                                        <div class="input-group date month-picker" data-date-format="yyyy-mm-dd">
                                            <input name="plan_month" type="text" class="required form-control" readonly
                                            value="<?php echo $plan_month; ?>">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="plan-month-product-search-error">
                                        <label class="control-label">Select Product:</label>
                                                
                                        <select name="product_id" class="required form-control select2me" id="product-part-selector"
                                            data-placeholder="Select Product" data-error-container="#plan-month-product-search-error">
                                            <option></option>
                                            <?php $selected = isset($filters['product_id']) ? $filters['product_id'] : ''; ?>
                                            <?php foreach($products as $product) { ?>
                                                <option value="<?php echo $product['id']; ?>" <?php if($product['id'] == $selected) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $product['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="plan-month-part-search-error1">
                                        <label class="control-label">Select Part:</label>
                                                
                                        <select name="part_id1" class="form-control select2me" id="part-selector"
                                            data-placeholder="Select Part" data-error-container="#plan-month-part-search-error">
                                            <option></option>
                                            <?php $selected = isset($filters['part_id1']) ? $filters['part_id1'] : ''; ?>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['name']; ?>" <?php if($part['id'] == $selected) { ?> selected="selected" <?php } ?>>
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
                                        <select name="part_id1" class="required form-control select2me part-test-selector_plan" id="part-selector_number"
                                            data-placeholder="Select Part Number" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['id']; ?>" <?php if($part['id'] == $this->input->post('part_id1')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['part_no']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
								
                            <div class="row">
                                  <div class="col-md-12">
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
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="plan-month-test-search-error">
                                        <label class="control-label">Select Test:</label>
                                                
                                        <select name="test_id" class="form-control select2me"
                                            data-placeholder="Select Test" data-error-container="#plan-month-test-search-error">
                                            <option></option>
                                            <?php $selected = isset($filters['test_id']) ? $filters['test_id'] : ''; ?>
                                            <?php foreach($tests as $test) { ?>
                                                <option value="<?php echo $test['id']; ?>" <?php if($test['id'] == $selected) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $test['name']; ?>
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
    
        <div class="col-md-9">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Plan for the Month
                    </div>
                    <div class="actions">
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($plan)) { ?>
                        <p class="text-center">No Plan.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Supplier</th>
                                    <th>Test Item</th>
                                    <th>Schedule Date</th>
                                    <th>Status</th>
                                    <th>No Inspection</th>
                                    <th class="no_sort" style="width:100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
								//print_r($plan);exit;
								foreach($plan as $pl) { ?>
                                    <tr>
                                        <td><?php echo $pl['part']; ?></td>
                                        <td><?php echo $pl['planned_part_no']; ?></td>
                                        <td><?php echo $pl['supplier']; ?></td>
                                        <td><?php echo $pl['test']; ?></td>
                                        <td><?php echo date('jS M', strtotime($pl['schedule_date'])); ?></td>
                                        <td><?php 
												if($pl['no_inspection'] == 'NO')
													{ echo 'No Lot'; }
												else {	echo $pl['status']; }
											?></td>
                                        <td style='text-align: center;'>											
											<!--<form>-->
											<?php if($pl['status'] == 'Pending'){ ?>
												<input <?php if($pl['no_inspection'] == 'NO'){ echo 'checked'; } ?> data-index="<?php echo $pl['id']; ?>" type="checkbox" name="no_inspec" id="no_inspec" onClick='no_inspection();' >
											<?php } ?>
												<!--<button type="button" class="button small view-test-modal-btn" data-index="<?php echo $pl['id']; ?>" onClick='no_inspection();'>
                                                Submit
												</button>
											</form>-->
										</td>
                                        <td nowrap>
                                            
											<!--
                                            <a class="button small gray" href="<?php echo base_url()."plans/change_date/".$pl['id'];?>" data-target="#change-date-modal" data-toggle="modal">
                                                Change Date
                                            </a>
                                            -->
											
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

<div class="modal fade" id="change-date-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo base_url(); ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($plan)) { ?>
    <script>
        $(window).load(function() {
            groupTable($('table tr:has(td)'),0,3);
            $('table .deleted').remove();
        });
		
		
    </script>
<?php } ?>


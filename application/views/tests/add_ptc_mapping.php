<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($ptc_mapping) ? 'Edit': 'Add'); ?> Part-Test-Chamber Mapping
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."tests/ptc_mappings"; ?>">
                        Manage Part-Test-Chamber Mapping
                    </a>
            </li>
            <li class="active"><?php echo (isset($ptc_mapping) ? 'Edit': 'Add'); ?> Part-Test-Chamber Mapping</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-offset-2 col-md-8">
        
            <div class="portlet light bordered" id="add-ptc-mapping-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Part-Test-Chamber Mapping Form
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post">
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

                            <?php if(isset($ptc_mapping['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $ptc_mapping['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="add-ptc-mapping-product-error">
                                        <label class="control-label" for="product_id">Product:
                                        <span class="required">*</span></label>
                                        
                                        <select name="product_id" class="form-control required select2me" id="product-part-selector_ptc"
                                        data-placeholder="Select Product" data-error-container="#add-ptc-mapping-product-error">
                                            <option value=""></option>
                                            
                                            <?php $sel_product = (!empty($ptc_mapping['product_id']) ? $ptc_mapping['product_id'] : ''); ?>
                                            <?php foreach($products as $product) { ?>
                                                <option value="<?php echo $product['id']; ?>" 
                                                <?php if($sel_product == $product['id']) { ?> selected="selected" <?php } ?>>
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
                                                <span class="required">*</span>
                                        <select name="part_id" class="required form-control select2me" id="part-selector_ptc"
                                            data-placeholder="Select Part" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php 
											//print_r($parts);
											foreach($parts as $part) { ?>
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
                                    <div class="form-group" id="add-ptc-mapping-part-category-error">
                                        <label class="control-label" for="part_category_id">Test Category:
                                        <span class="required">*</span></label>
                                        
                                        <select name="part_category_id" class="form-control required select2me"
                                        data-placeholder="Select Part Category" data-error-container="#add-ptc-mapping-part-category-error">
                                            <option value=""></option>
                                            
                                            <?php $sel_part_category = (!empty($ptc_mapping['part_category_id']) ? $ptc_mapping['part_category_id'] : ''); ?>
                                            <?php foreach($categories as $category) { ?>
                                                <option value="<?php echo $category['id']; ?>" 
                                                <?php if($sel_part_category == $category['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $category['name']; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="add-ptc-mapping-test-error">
                                        <label class="control-label" for="test_id">Test:
                                        <span class="required">*</span></label>
                                        
                                        <select name="test_id" class="form-control required select2me"
                                        data-placeholder="Select Test" data-error-container="#add-ptc-mapping-test-error">
                                            <option value=""></option>
                                            
                                            <?php $sel_test = (!empty($ptc_mapping['test_id']) ? $ptc_mapping['test_id'] : ''); ?>
                                            <?php foreach($tests as $test) { ?>
                                                <option value="<?php echo $test['id']; ?>" 
                                                <?php if($sel_test == $test['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $test['name']; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="add-ptc-mapping-chamber-error">
                                        <label class="control-label" for="chamber_id">Chambers:
                                        <span class="required">*</span></label>
                                        
                                        <select name="chamber_id[]" class="form-control required select2me"
                                        data-placeholder="Select Chambers" data-error-container="#add-ptc-mapping-chamber-error" multiple>
                                            <option value=""></option>
                                            
                                            <?php $sel_product = (!empty($ptc_mapping['product_id']) ? $ptc_mapping['product_id'] : ''); ?>
                                            <?php foreach($chambers as $chamber) { ?>
                                                <option value="<?php echo $chamber['id']; ?>" 
                                                <?php if($sel_product == $chamber['id']) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $chamber['name']; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'ptc_mappings'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
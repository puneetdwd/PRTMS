<style>
    .control-label.col-md-5 {
        padding-top:6px;
    }
    .control-label.col-md-4 {
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

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Start Monitoring Screen
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Start Monitoring</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered" id="monitoring-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Monitoring Form 
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
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="monitoring-form-stage-error">
                                        <label class="control-label" for="stage_id">Event:
                                        <span class="required">*</span></label>
                                        
                                        <select name="stage_id" class="form-control required select2me"
                                        data-placeholder="Select Monitoring Stage" data-error-container="#monitoring-form-stage-error">
                                            <option value=""></option>
                                            
                                            <?php foreach($stages as $stage) { ?>
                                                <option value="<?php echo $stage['id']; ?>">
                                                    <?php echo $stage['code']; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group" id="monitoring-form-chamber-error">
                                        <label class="control-label" for="chamber_id">Chamber:
                                        <span class="required">*</span></label>
                                        
                                        <select name="chamber_id" id="start-monitoring-chamber-sel" class="form-control required select2me"
                                        data-placeholder="Select Chamber" data-error-container="#monitoring-form-chamber-error">
                                            <option value=""></option>
                                            
                                            <?php $allowed_chambers = $this->session->userdata('chambers'); ?>
                                            <?php foreach($allowed_chambers as $allowed_chamber) { ?>
                                                <option value="<?php echo $allowed_chamber['id']; ?>">
                                                    <?php echo $allowed_chamber['name']; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <hr />

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="monitoring-form-product-error">
                                        <label class="control-label" for="product_id">Product:
                                        <span class="required">*</span></label>
                                        
                                        <select name="product_id" id="product-part-selector" class="form-control required select2me"
                                        data-placeholder="Select Product" data-error-container="#monitoring-form-product-error">
                                            <option value=""></option>
                                            
                                            <?php foreach($products as $product) { ?>
                                                <option value="<?php echo $product['id']; ?>">
                                                    <?php echo $product['name']; ?>
                                                </option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group" id="monitoring-form-part-error">
                                        <label class="control-label" for="part_id">Part:
                                        <span class="required">*</span></label>
                                        
                                        <select name="part_id" id="part-selector" class="form-control required select2me part-supplier-selector"
                                        data-placeholder="Select Part" data-error-container="#monitoring-form-part-error">
                                            <option value=""></option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="part_no">Part No.:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="part_no" placeholder="Enter Part No.">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group" id="monitoring-form-supplier-error">
                                        <label class="control-label" for="supplier_id">Supplier:
                                        <span class="required">*</span></label>
                                        
                                        <select name="supplier_id" id="part-based-supplier-selector" class="form-control required select2me"
                                        data-placeholder="Select Supplier" data-error-container="#monitoring-form-supplier-error">
                                            <option value=""></option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="monitoring-form-test-error">
                                        <label class="control-label" for="test_id">Test:
                                        <span class="required">*</span></label>
                                        
                                        <select name="test_id" id="part-based-test-selector" class="form-control required select2me"
                                        data-placeholder="Select Supplier" data-error-container="#monitoring-form-test-error">
                                            <option value=""></option>
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="duration">Test Duration (in hrs):
                                        <span class="required">*</span></label>
                                        <input type="text" id="start-test-duration" class="required form-control" name="duration"  placeholder="Enter Duration in hrs">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div id="start-test-details" style="display:none;">
                                <hr />
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><b>Test Code:</b></label>
                                            <div class="col-md-8">
                                                <p class="form-control-static" id="start-test-code-text">
                                                    
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-md-4"><b>Test Name:</b></label>
                                            <div class="col-md-8">
                                                <p class="form-control-static" id="start-test-name-text">
                                                    
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-md-5"><b>Test Duration:</b></label>
                                            <div class="col-md-7">
                                                <p class="form-control-static" id="start-test-duration-text">
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
                                                <p class="form-control-static" id="start-test-method-text">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-5"><b>Test Judgement:</b></label>
                                            <div class="col-md-7">
                                                <p class="form-control-static" id="start-test-judgement-text">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <hr />
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="samples">No. Of Samples:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="samples" placeholder="Enter No. of Samples">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="observation_frequency">Observation Frequency (in hrs):
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="observation_frequency" placeholder="Enter Observation Frequency">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="lot_no">LOT/ASN NO:</label>
                                        <input type="text" class="form-control" name="lot_no" placeholder="Enter LOT/ASN NO">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url(); ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
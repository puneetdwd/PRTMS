<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Upload Monthly Plan
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Upload Monthly Plan</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        
            <div class="portlet light bordered inspection-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Upload Monthly Plan Form
                    </div>
                    
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."plans/copy_plan"; ?>">
                             Copy Plan
                        </a>
                        <a class="button normals btn-circle" target="_blank" href="<?php echo base_url()."assets/monthly_plan.xlsx"; ?>">
                            <i class="fa fa-download"></i> Download Sample
                        </a>
                    </div>
                </div>

                <div class="portlet-body form">
                    <form role="form" class="validate-form" method="post" enctype="multipart/form-data">
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
                                    <div class="form-group" id="upload-ptc-master-product-error">
                                        <label class="control-label" for="product_id">Product:
                                        <span class="required">*</span></label>
                                        
                                        <select name="product_id" class="form-control required select2me"
                                        data-placeholder="Select Product" data-error-container="#upload-ptc-master-product-error">
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
                                    <div class="form-group">
                                        <label class="control-label" for="product_id">Plan Month:
                                        <span class="required">*</span></label>
                                        
                                        <div class="input-group date month-picker" data-date-format="yyyy-mm-dd">
                                            <input name="plan_month" type="text" class="required form-control" readonly
                                            value="">
                                            <span class="input-group-btn">
                                                <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="plan_excel" class="control-label">Upload Plan Excel:
                                            <span class="required">*</span>
                                        </label>
                                        <input type="file" name="plan_excel">
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
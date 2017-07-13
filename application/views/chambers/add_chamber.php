<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($chamber) ? 'Edit': 'Add'); ?> Chamber
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."chambers"; ?>">
                        Manage Chambers
                    </a>
            </li>
            <li class="active"><?php echo (isset($chamber) ? 'Edit': 'Add'); ?> Chamber</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Chamber Form
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

                            <?php if(isset($chamber['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $chamber['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                    
                                <div class="col-md-6">
                                    <div class="form-group" id="add-chamber-category-error">
                                        <label class="control-label">Category:</label>
                                        <select name="category" class="form-control required select2me"
                                        data-placeholder="Select Category" data-error-container="#add-chamber-category-error">
                                            <?php $sel_category = isset($chamber['category']) ? $chamber['category'] : '';?>
                                            <option value=""></option>
                                            <option value="Electrical" <?php if($sel_category == 'Electrical') { echo "selected='selected'"; } ?>>
                                                Electrical
                                            </option>
                                            <option value="Environmental" <?php if($sel_category == 'Environmental') { echo "selected='selected'"; } ?>>
                                                Environmental
                                            </option>
                                            <option value="Heat & Humid" <?php if($sel_category == 'Heat & Humid') { echo "selected='selected'"; } ?>>
                                                Heat & Humid
                                            </option>
                                            <option value="Salt Spray" <?php if($sel_category == 'Salt Spray') { echo "selected='selected'"; } ?>>
                                                Salt Spray
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="name"
                                        value="<?php echo isset($chamber['name']) ? $chamber['name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="code">Code:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="code"
                                        value="<?php echo isset($chamber['code']) ? $chamber['code'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="detail">Specs:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="detail"
                                        value="<?php echo isset($chamber['detail']) ? $chamber['detail'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'chambers'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
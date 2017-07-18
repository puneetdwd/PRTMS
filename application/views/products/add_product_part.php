<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($part) ? 'Edit': 'Add'); ?> Product Part
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."products"; ?>">
                    Manage Products 
                </a>
            </li>
            <li>
                <a href="<?php echo base_url()."products/parts/".$product['id']; ?>">
                    Manage Product Parts
                </a>
            </li>
            <li class="active"><?php echo (isset($part) ? 'Edit': 'Add'); ?> Product Part</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        
            <div class="portlet light bordered checkpoint-add-form-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Product Part Form - <?php echo $product['name']; ?>
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."products/upload_product_parts/".$product['id']; ?>">
                            <i class="fa fa-plus"></i> Upload Parts
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

                            <?php if(isset($part['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $part['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="category">Category:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="category"
                                        value="<?php echo isset($part['category']) ? $part['category'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="code">Code:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="code"
                                        value="<?php echo isset($part['code']) ? $part['code'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="name"
                                        value="<?php echo isset($part['name']) ? $part['name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="part_no">Part Number:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="part_no"
                                        value="<?php echo isset($part['part_no']) ? $part['part_no'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="img_file">
											Image/File:<span class="required">*</span>
										</label>
                                        <input type="file" class="required form-control" name="img_file" id="img_file"
                                        value='<?php if(!empty($part['img_file'])) { echo $part['img_file'];} ?>'>
                                        <span class="help-block">Only jpg|jpeg|png files are allowed</span>
										<?php
										if(!empty($part['img_file']))
										{	?>
											<a href="<?php echo base_url()."assets/part reference files/".$part['img_file']; ?>" target='_blank'>View Uploaded Image</a>
											<?php
										}
										?>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'products/parts/'.$product['id']; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
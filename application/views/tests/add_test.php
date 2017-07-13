<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            <?php echo (isset($test) ? 'Edit': 'Add'); ?> Test
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url()."tests"; ?>">
                        Manage Tests
                    </a>
            </li>
            <li class="active"><?php echo (isset($test) ? 'Edit': 'Add'); ?> Test</li>
        </ol>
        
    </div>

    <div class="row">
        <div class="col-md-12">
        
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i> Test Form
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

                            <?php if(isset($test['id'])) { ?>
                                <input type="hidden" name="id" value="<?php echo $test['id']; ?>" />
                            <?php } ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="code">Code:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="code"
                                        value="<?php echo isset($test['code']) ? $test['code'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Name:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="name"
                                        value="<?php echo isset($test['name']) ? $test['name'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="method">Method:
                                        <span class="required">*</span></label>
                                        <textarea class="required form-control" name="method"><?php echo isset($test['method']) ? $test['method'] : ''; ?></textarea>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="judgement">Judgement:
                                        <span class="required">*</span></label>
                                        <textarea class="required form-control" name="judgement"><?php echo isset($test['judgement']) ? $test['judgement'] : ''; ?></textarea>
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="duration">Duration:
                                        <span class="required">*</span></label>
                                        <input type="text" class="required form-control" name="duration"
                                        value="<?php echo isset($test['duration']) ? $test['duration'] : ''; ?>">
                                        <span class="help-block">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                            
                        <div class="form-actions">
                            <button class="button" type="submit">Submit</button>
                            <a href="<?php echo base_url().'tests'; ?>" class="button white">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->
</div>
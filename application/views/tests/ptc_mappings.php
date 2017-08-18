<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Part-Test-Chamber Mappings
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage Part-Test-Chamber Mappings</li>
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
                                    <div class="form-group" id="ptc-mappings-product-search-error">
                                        <label class="control-label">Select Product:</label>
                                                <span class="required">*</span>
                                        <select name="product_id" class="required form-control select2me" id="product-part-selector_map"
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
                                               <select name="part_id1" class="form-control select2me" id="part-selector_map"
                                            data-placeholder="Select Part" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts as $part) { ?>
                                                <option value="<?php echo $part['name']; ?>" <?php if($part['name'] == $this->input->post('part_id1')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part['name']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="ptc-mappings-part-search-error">
                                        <label class="control-label">Select Part Number:</label>
                                                <select name="part_id" class="form-control select2me" id="part-selector_number_map"
                                            data-placeholder="Select Part" data-error-container="#ptc-mappings-part-search-error">
                                            <option></option>
                                            <?php foreach($parts_num as $part_num) { ?>
                                                <option value="<?php echo $part_num['id']; ?>" <?php if($part_num['id'] == $this->input->post('part_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $part_num['part_no']; ?>
                                                </option>
                                            <?php } ?>        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" id="ptc-mappings-test-search-error">
                                        <label class="control-label">Select Test:</label>
                                              <select name="test_id" class="form-control select2me"
                                            data-placeholder="Select Test" data-error-container="#ptc-mappings-test-search-error">
                                            <option></option>
                                            <?php foreach($tests as $test) { ?>
                                                <option value="<?php echo $test['id']; ?>" <?php if($test['id'] == $this->input->post('test_id')) { ?> selected="selected" <?php } ?>>
                                                    <?php echo $test['name']; ?>
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
                                                <select name="chamber_category" class="form-control select2me" id="catagory-chamber_selector_map"
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
                                                <select name="chamber_id" class="form-control select2me" id="chamber_selector_map"
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
    
        <div class="col-md-9">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Part-Test-Chamber Mappings
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."tests/add_ptc_mapping"; ?>">
                            <i class="fa fa-plus"></i> Add New Part-Test-Chamber Mapping
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($ptc_mappings)) { ?>
                        <p class="text-center">No Suppliers.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light"  id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Part Name</th>
                                    <th>Part No.</th>
                                    <th>Test Name</th>
                                    <th>Chamber Category</th>
                                    <th>Chamber Name</th>
                                    <th class="no_sort" style="width:100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ptc_mappings as $ptc_mapping) { ?>
                                    <tr>
                                        <td><?php echo $ptc_mapping['product_name']; ?></td>
                                        <td><?php echo $ptc_mapping['part_name']; ?></td>
                                        <td><?php echo $ptc_mapping['part_no']; ?></td>
                                        <td><?php echo $ptc_mapping['test_name']; ?></td>
                                        <td><?php echo $ptc_mapping['pc_name']; ?></td>
                                        <td><?php echo $ptc_mapping['chamber_name']; ?></td>
                                        <td nowrap>
                                            <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to delete this mapping?"
                                                href="<?php echo base_url()."tests/delete_ptc_mapping/".$ptc_mapping['id'];?>">
                                                <i class="fa fa-trash-o"></i> Delete
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
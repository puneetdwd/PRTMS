<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Product Parts
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
            <li class="active">Manage Product Parts</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-offset-2 col-md-8">

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

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>
                        Parts for product - <?php echo $product['name'];?>
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."products/add_product_part/".$product['id']; ?>">
                            <i class="fa fa-plus"></i> Add New Part
                        </a>
                        <a class="button normals btn-circle" href="<?php echo base_url()."products/upload_product_parts/".$product['id']; ?>">
                            <i class="fa fa-plus"></i> Upload Parts
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($parts)) { ?>
                        <p class="text-center">No Product Part exists yet.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Part Code</th>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Image/File</th>
                                    <th class="no_sort" style="width:100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($parts as $part) { ?>
                                    <tr>
                                        <td><?php echo $part['category']; ?></td>
                                        <td><?php echo $part['code']; ?></td>
                                        <td><?php echo $part['name']; ?></td>
                                        <td><?php echo $part['part_no']; ?></td>
                                        <td>
										<?php if(!empty($part['img_file'])){ ?>
											<!--a href="<?php echo base_url()."assets/part reference files/".$part['img_file']; ?>" target='_blank'>View Image</a-->
											
											
											<button type="button" class="button small" style='text-transform:capitalize;color:#000 !important;border: none;border-shadow:none;background-color:#fff' data-toggle="modal" data-target="#myModal_img_<?php echo $part['part_no']; ?>">Reference Image</button>

											<div id="myModal_img_<?php echo $part['part_no']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											
											  <div class="modal-dialog">
											   
												<div class="modal-content">
												
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h3>Part Reference Image</h3>
												</div>
													<div class="modal-body">
														<img src='<?php echo base_url()."assets/part reference files/".$part['img_file']; ?>' class="img-responsive">
													</div>
												</div>
											  </div>
											</div>
											
											
										<?php } ?>	
										</td>
                                        <td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."products/add_product_part/".$product['id'].'/'.$part['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            
                                            <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to this part?"
                                                href="<?php echo base_url()."products/delete_product_part/".$product['id'].'/'.$part['id'];?>">
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
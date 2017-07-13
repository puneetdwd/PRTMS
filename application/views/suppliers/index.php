<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Manage Suppliers
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Manage Suppliers</li>
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
                        <i class="fa fa-reorder"></i>Suppliers
                    </div>
                    <div class="actions">
                        <a class="button normals btn-circle" href="<?php echo base_url()."suppliers/add_supplier"; ?>">
                            <i class="fa fa-plus"></i> Add New Suppliers
                        </a>
                        
                        <a class="button normals btn-circle" href="<?php echo base_url()."suppliers/upload_suppliers"; ?>">
                            <i class="fa fa-plus"></i> Upload Suppliers
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($suppliers)) { ?>
                        <p class="text-center">No Suppliers.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Supplier Code</th>
                                    <th>Supplier Name</th>
                                    <th class="no_sort" style="width:100px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($suppliers as $supplier) { ?>
                                    <tr>
                                        <td><?php echo $supplier['supplier_no']; ?></td>
                                        <td><?php echo $supplier['name']; ?></td>
                                        <td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."suppliers/add_supplier/".$supplier['id'];?>">
                                                <i class="fa fa-edit"></i> Edit
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
<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            View Masters Uploads
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">View Masters Uploads</li>
        </ol>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">

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
                        <i class="fa fa-reorder"></i>List of Masters Uploads
                    </div>
                    
                </div>
                <div class="portlet-body">
                    <?php if(empty($uploaded_files)) { ?>
                        <p class="text-center">No Masters Uploads exist yet.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" id="make-data-table">
                            <thead>
                                <tr>
                                    <th>Uploaded By</th>
                                    <th>User Type</th>
                                    <th>File Type</th>
                                    <th>View File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($uploaded_files as $uploaded_file) { ?>
                                    <tr>
                                        <td><?php echo $uploaded_file['username']; ?></td>
                                        <td><?php echo $uploaded_file['user_type']; ?></td>
                                        <td><?php echo $uploaded_file['master_type']; ?></td>
                                        <td><?php //echo $uploaded_file['filename']; ?>
											<a class="button small gray" 
                                                href="<?php echo base_url().$uploaded_file['filename'];?>">
                                                <i class="fa fa-edit"></i> View
                                            </a>
										
										</td>
                                        <!--td nowrap>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."users/add/".$user['username'];?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."users/view/".$user['username'];?>">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a class="btn btn-xs btn-outline sbold red-thunderbird" data-confirm="Are you sure you want to mark this user as <?php echo $user['is_active'] ? 'inactive' : 'active';?>?"
                                                href="<?php echo base_url()."users/status/".$user['username'].'/'.($user['is_active'] ? 'inactive' : 'active' );?>">
                                                <i class="fa fa-trash-o"></i> <?php echo $user['is_active'] ? 'Mark Inactive' : 'Mark Active';?>
                                            </a>
                                        </td-->
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
<!-- BEGIN HEADER -->
<?php $page = isset($page) ? $page : ''; ?>
<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid">
            <div class="clearfix navbar-fixed-top">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="toggle-icon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
                <!-- BEGIN LOGO -->
                <a class="ir" href="<?php echo base_url(); ?>" id="logo" role="banner" title="Home" style="margin-top:0px;height:54px;">LG India</a>
                
                <!-- END LOGO -->
                
                <div class="topbar-actions">
                    <div style="text-align: right; margin-right: 10px;">
                        <span id="user-info">Welcome, <?php echo $this->session->userdata('name'); ?>
                        <?php if($this->chamber_id) { ?>
                            <small> &nbsp; [ <?php echo $this->session->userdata('user_type'); ?> User ]</small>
                        <?php } else { ?>
                            <small> &nbsp; [ Admin ]</small>
                        <?php } ?>
                        </span>
                    
                    </div>
                    <div>
                        
                        <ul class="user-info-links">
                            <!--
                            <?php $allowed_chambers = $this->session->userdata('chambers'); ?>
                            <?php if(count($allowed_chambers) > 1) { ?>
                                <li>
                                    <div class="btn-group">
                                        <a class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" href="javascript:;"> 
                                            Switch Chamber
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php foreach($allowed_chambers as $ac) { ?>
                                                <li>
                                                    <a href="<?php echo base_url().'users/switch_chamber/'.$ac['id']; ?>"> 
                                                        <?php echo $ac['name']; ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>
                            -->
                            <li>
                                <a href="<?php echo base_url(); ?>users/change_password" class="btn btn-link btn-sm">
                                    Change Password
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout" class="btn btn-link btn-sm">
                                    Log Out 
                                </a>
                            </li>
                        </ul>
                        <div style="clear:both;"></div>
                    </div>
                </div>
                <!-- END TOPBAR ACTIONS -->
                
                <div class="page-logo-text page-logo-text-new text-left">PRTMS - Part Reliability Test Monitoring System</div>
                
                
            </div>
            <!-- BEGIN HEADER MENU -->
            <?php if(!isset($no_header_links)) { ?>
                <div class="nav-collapse collapse navbar-collapse navbar-responsive-collapse header-nav-links">
                    <ul class="nav navbar-nav">
                        <li class="<?php if($page == '') { ?>active selected<?php } ?>">
                            <a href="<?php echo base_url(); ?>" class="text-uppercase">
                                <i class="icon-home"></i> Dashboard 
                            </a>
                        </li>
                        
                        <?php if($this->session->userdata('user_type') == 'Admin') { ?>
                            <li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Upload Masters 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>products/sp_master">
                                            <i class="icon-briefcase"></i> Supplier-Part Mapping 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>products/ptc_master">
                                            <i class="icon-briefcase"></i> Part-Test-Chamber Master 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown more-dropdown <?php if($page == 'masters') { ?>active selected<?php } ?>">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Masters 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>users">
                                            <i class="icon-users"></i> Users 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>products">
                                            <i class="icon-briefcase"></i> Products 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>suppliers">
                                            <i class="icon-briefcase"></i> Suppliers 
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="<?php echo base_url(); ?>chambers">
                                            <i class="icon-briefcase"></i> Chambers 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>tests">
                                            <i class="icon-briefcase"></i> Tests 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>stages">
                                            <i class="icon-briefcase"></i> Monitoring Stages 
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown more-dropdown">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Mappings
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>suppliers/sp_mappings">
                                            <i class="icon-briefcase"></i> Supplier-Part Mapping 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>tests/ptc_mappings">
                                            <i class="icon-briefcase"></i> Part-Test-Chamber Mapping 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="dropdown more-dropdown <?php if($page == 'plans') { ?>active selected<?php } ?>">
                                <a href="javascript:;" class="text-uppercase">
                                    <i class="icon-layers"></i> Plan 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo base_url(); ?>plans/upload">
                                            <i class="icon-users"></i> Upload Monthly Plan 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>plans/display">
                                            <i class="icon-briefcase"></i> Monthly Plan 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>plans/screen">
                                            <i class="icon-briefcase"></i> Plan Screen 
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="<?php if($page == 'sadsdsa') { ?>active selected<?php } ?>">
                                <a href="<?php echo base_url().'dashboard/dashboard_screen'; ?>" class="text-uppercase">
                                    <i class="icon-home"></i> Dashboard Screen
                                </a>
                            </li>
                        <?php } ?>
                        
                        <?php if($this->session->userdata('user_type') == 'Chamber') { ?>
                            <li class="<?php if($page == 'monitoring') { ?>active selected<?php } ?>">
                                <a href="<?php echo base_url().'apps/start_test'; ?>" class="text-uppercase">
                                    <i class="icon-home"></i> Start Monitoring 
                                </a>
                            </li>
                        <?php } ?>
                            
                        <li class="dropdown more-dropdown">
                            <a href="javascript:;" class="text-uppercase">
                                <i class="icon-layers"></i> Reports
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/completed_test_report">
                                        <i class="icon-briefcase"></i> Completed Test Report 
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/chamber_wise_test_count_report">
                                        <i class="icon-briefcase"></i> Chamber Wise Test Count Report
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url(); ?>reports/part_assurance_report">
                                        <i class="icon-briefcase"></i> Part Assurance Report
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
                </div>
            <?php } ?>
            <!-- END HEADER MENU -->
        </div>
        <!--/container-->
    </nav>
</header>
<!-- END HEADER -->
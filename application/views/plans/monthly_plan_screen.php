<?php 
$CI =& get_instance();
$CI->load->model('plan_model');
?>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Monthly Plan
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="active">Monthly Plan</li>
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
            
        <?php $alarm = false; ?>
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-reorder"></i>Plan for the Month
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(empty($plan)) { ?>
                        <p class="text-center">No Plan.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Part Name</th>
                                    <th>Part Number</th>
                                    <th>Supplier</th>
                                    <th>Test Item</th>
                                    <th>Schedule Date</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($plan as $pl) { ?>
                                    
                                    <?php 
                                        $class = '';
										if($pl['no_inspection'] == 'NO')
											$class = '';
                                        else if($pl['status'] == 'Pending' && $pl['schedule_date'] && strtotime('now') > strtotime('-1 day', strtotime($pl['schedule_date']))) {
                                            $alarm = true;
                                            $class = 'dashboard-noti-danger';
                                        } 
                                    ?>
                                    <tr>
                                        <td><?php echo $pl['product']; ?></td>
                                        <td><?php echo $pl['part']; ?></td>
                                        <td><?php echo $pl['planned_part_no']; ?></td>
                                        <td><?php echo $pl['supplier']; ?></td>
                                        <td><?php echo $pl['test']; ?></td>
                                        <td><?php echo $pl['schedule_date'] ? date('jS M', strtotime($pl['schedule_date'])) : '--'; 
										$res = $CI->plan_model->get_part_plan($pl['planned_part_no'],$pl['schedule_date']);
										?></td>
                                        <td class="text-center <?php if($res['no_inspection'] != 'NO')
												{ echo $class; } ?>">
											<?php 
												
												//print_r($res['no_inspection']);
												
												if($res['no_inspection'] == 'NO')
												{ echo 'No Lot'; 
											
												}											
												else {	echo $pl['status']; }
											?>
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

<div class="modal fade" id="change-date-modal" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo base_url(); ?>assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($plan)) { ?>
    <script>
        $(window).load(function() {
            groupTable($('table tr:has(td)'),0,4);
            $('table .deleted').remove();
        });
    </script>
<?php } ?>

<?php if($alarm) { ?>
    <script>
        $(window).load(function() {
            var audio = new Audio('<?php echo base_url(); ?>assets/alarm.mp3');
            audio.addEventListener('ended', function() {
                this.currentTime = 0;
                this.play();
            }, false);
            audio.play();
        });
    </script>
<?php } ?>


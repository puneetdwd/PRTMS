<style>
    .easy-pie-chart .number canvas {
        height:60px !important;
        line-height:60px !important;
    }
    .progress-info .progress {
        display: block;
        height: 10px;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
        margin-top: 0;
    }
    .progress-info .status {
        color: #aab5bc;
        font-size: 18px;
        font-weight: 600;
        margin-top: 5px;
        text-transform: uppercase;
    }
</style>
<div class="page-content">
    <div class="breadcrumbs">
        <h1>
            <?php echo $this->session->userdata('name'); ?>
            <small>Welcome to your dashboard</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="#">Home</a>
            </li>
            <li class="active">Dashboard</li>
        </ol>
        
    </div>
        
    <?php if($this->session->flashdata('error')) {?>
        <div class="alert alert-danger">
           <i class="icon-remove"></i>
           <?php echo $this->session->flashdata('error');?>
        </div>
    <?php } else if($this->session->flashdata('success')) { ?>
        <div class="alert alert-success">
            <i class="icon-ok"></i>
           <?php echo $this->session->flashdata('success');?>
        </div>
    <?php } ?>

    
    <div class="row">
        <div class="col-md-12">
            <div class="mt-element-ribbon bg-grey-steel">
                <div class="ribbon ribbon-clip ribbon-color-danger uppercase" style="font-size: 20px;">
                    <div class="ribbon-sub ribbon-clip"></div> On Going Tests
                </div>
                
                <div class="ribbon-content" style="padding-top: 40px;">
                    <?php if(empty($on_going_tests)) { ?>
                        <div style="font-size: 20px;text-align:center;">No on going test</div>
                    <?php } else { ?>
                        <table class="table table-hover table-light dashboard-table">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Product Name</th>
                                    <th>Part Name</th>
                                    <th>Part No</th>
                                    <th>Supplier Name</th>
                                    <th>Chamber Name</th>
                                    <th>Test Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th class="no_sort"></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($on_going_tests as $on_going_test) { ?>
                                    <?php 
                                        $total_duration = strtotime($on_going_test['end_date'])-strtotime($on_going_test['start_date']);
                                        $total_duration = $total_duration/3600;
                                        
                                        $duration_completed = strtotime(date('Y-m-d H:i:s'))-strtotime($on_going_test['start_date']);
                                        $duration_completed = $duration_completed/3600;

                                        $progress = round(($duration_completed/$total_duration)*100, 1);
                                        if($progress > 100) {
                                            $progress = 100;
                                        }
                                    ?>
                                    <tr class="<?php if($progress == 100) { ?>dashboard-noti-success<?php } ?>">
                                        <td><?php echo $on_going_test['stage_code']; ?></td>
                                        <td><?php echo $on_going_test['product_name']; ?></td>
                                        <td><?php echo $on_going_test['part_name']; ?></td>
                                        <td><?php echo $on_going_test['part_no']; ?></td>
                                        <td><?php echo $on_going_test['supplier_name']; ?></td>
                                        <td><?php echo $on_going_test['chamber_name']; ?></td>
                                        <td><?php echo $on_going_test['test_name']; ?></td>
                                        
                                        <td><?php echo date('jS M, Y h:i A', strtotime($on_going_test['start_date'])); ?></td>
                                        <td nowrap>
                                            <?php echo date('jS M, Y h:i A', strtotime($on_going_test['end_date'])); ?>
                                            <div class="progress-info">
                                                <div class="progress">
                                                    <span class="progress-bar progress-bar-success green-jungle" style="width: <?php echo $progress; ?>%;">
                                                        <span class="sr-only"><?php echo $progress; ?>% progress</span>
                                                    </span>
                                                </div>
                                                <div class="status">
                                                    <div class="status-number pull-right font-red-sunglo"> <?php echo $progress; ?>% Complete </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td nowrap>
											<?php if(empty($on_going_test['retest_id'])){ ?>										
                                            <a class="button small gray" 
                                                href="<?php echo base_url()."apps/on_going/".$on_going_test['code'];?>">
                                                View
                                            </a>
                                            <?php } ?>
											<?php if($on_going_test['retest_id']){ ?>
											<a class="button small gray" 
                                                href="<?php echo base_url()."apps/on_going_retest/".$on_going_test['code'];?>">
                                                Retest
                                            </a>
											<?php } ?>
                                            <a class="button small" href="<?php echo base_url().'apps/mark_as_abort/'.$on_going_test['code'];?>" data-confirm="Are you sure you want to cancel this Test?">
                                                Stop
                                            </a>
											
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                                
												if($on_going_test['no_of_observations'] == $on_going_test['observation_done']) {
                                                    $class = 'fa fa-smile-o text-success';
                                                    $div_class = '';
                                                } else if($on_going_test['max_index'] !== '0' && $on_going_test['observation_done'] != ($on_going_test['max_index'] + 1)) {
                                                    $class = 'fa fa-frown-o text-danger';
                                                    $div_class = 'dashboard-noti-danger';
                                                } else if($on_going_test['max_index'] === '0' && empty($on_going_test['max_observation_at'])) {
                                                    $class = 'fa fa-frown-o text-danger';
                                                    $div_class = 'dashboard-noti-danger';
                                                } else {
                                                    $color = '';
                                                    $key = $on_going_test['max_index'];
                                                    
                                                    $dur = ($on_going_test['observation_frequency']*($key+1)); 
                                                    $ob_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours', 
                                                    strtotime($on_going_test['start_date'])));
                                                    
                                                    $diff = strtotime($ob_time)- strtotime(date('Y-m-d H:i:s'));
                                                    
                                                    if($diff < 0) {
                                                        $class = 'fa fa-frown-o text-danger';
                                                        $div_class = 'dashboard-noti-danger';
                                                    } else {
                                                        $diff = $diff/3600;
                                                        if($diff < 2) {
                                                            $class = 'fa fa-meh-o text-warning';
                                                            $div_class = 'dashboard-noti-warning';
                                                        } else {
                                                            $class = 'fa fa-smile-o text-success';
                                                            $div_class = '';
                                                        }
                                                    }
                                                }
												
                                            ?>
                                            <div class="<?php echo $div_class; ?>" style="padding:5px;">
                                                <i class="<?php echo $class; ?>" style="font-size: 40px; font-weight: bold; line-height:40px;"></i>
                                            </div>
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

</div>
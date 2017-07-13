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
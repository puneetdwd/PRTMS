<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Chamber Wise Test Count Report
        </h1>
        
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
    
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" border="1">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Test Name</th>
                                    <th>Test Start Date</th>
                                    <th>Test End Date</th>
                                    <th>Test Judgement</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn=0; foreach($reports as $report) { $sn++; ?>
                                    <tr>
                                        <td><?php echo $sn; ?></td>
                                        <td><?php echo $report['test_name']; ?></td>
                                        <td><?php echo $report['start_date']; ?></td>
                                        <td><?php echo $report['end_date']; ?></td>
                                        <td><?php echo $report['judgement']; ?></td>
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


<div class="modal fade bs-modal-lg" id="view-test-modal" tabindex="-1" role="dialog" aria-hidden="true">
    
</div>
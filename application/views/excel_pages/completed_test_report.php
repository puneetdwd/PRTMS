<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h1>
            Completed Test Report
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
                                    <th>Event</th>
                                    <th>Product Name</th>
                                    <th>Part Name</th>
                                    <th>Test Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Chamber Category</th>
                                    <th>Chamber Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reports as $report) { ?>
                                    <tr>
                                        <td><?php echo $report['stage_name']; ?></td>
                                        <td><?php echo $report['product_name']; ?></td>
                                        <td><?php echo $report['part_name']; ?></td>
                                        <td><?php echo $report['test_name']; ?></td>
                                        <td><?php echo $report['start_date']; ?></td>
                                        <td><?php echo $report['end_date']; ?></td>
                                        <td><?php echo $report['chamber_category']; ?></td>
                                        <td><?php echo $report['chamber_name']; ?></td>
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
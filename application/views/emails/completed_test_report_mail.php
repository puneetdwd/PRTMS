<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <div class="breadcrumbs">
        <h3 style="text-align: center;">
            Completed Test Report
        </h3>
    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
    
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <p>Hi,<br><br>
                       Please find the Completed Test Report below - 
                    </p>
                    <br><br><br>
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" border="1">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Event</th>
                                    <th>Product Name</th>
                                    <th>Part Name</th>
                                    <th>Supplier Name</th>
                                    <th>Chamber Name</th>
                                    <th>Test Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn=0; foreach($reports as $report) { $sn++; ?>
                                    <tr>
                                        <td><?php echo $sn; ?></td>
                                        <td><?php echo $report['stage_name']; ?></td>
                                        <td><?php echo $report['product_name']; ?></td>
                                        <td><?php echo $report['part_name']; ?></td>
                                        <td><?php echo $report['supplier_name']; ?></td>
                                        <td><?php echo $report['chamber_name']; ?></td>
                                        <td><?php echo $report['test_name']; ?></td>
                                        <td><?php echo $report['start_date']; ?></td>
                                        <td><?php echo $report['end_date']; ?></td>
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

<!--Popup Start-->
<div class="modal fade bs-modal-lg" id="view-test-modal" tabindex="-1" role="dialog" aria-hidden="true">
    
</div>
<!--Popup End-->
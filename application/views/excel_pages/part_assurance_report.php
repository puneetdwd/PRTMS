<style>
    .table.table-light > thead > tr > th {
        font-size: 14px;
        font-weight: 700;
    }
</style>

<div class="page-content">
    <!-- BEGIN PAGE HEADER-->
    <!--<div class="breadcrumbs">
        <h3 style="text-align:center;">
            Mass Production Part Assurance Report
        </h3>
        
    </div>-->
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
    
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <?php if(empty($reports_common)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        <table class="table table-hover table-light" border="1">
                            <tr>
                                <td colspan="5" style="vertical-align:middle;"><h3>Mass Production Part Assurance Report</h3></td>
                                <td colspan="4" align="right" style="vertical-align:middle;"><b>Product Name : </b>
                                    <?php echo $reports_common['product_name']; ?>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="table table-hover table-light" border="1">
                            <tr>
                                <td colspan="3"><b>Part Name &nbsp;&nbsp;&nbsp;&nbsp;: </b>
                                    <?php echo $reports_common['part_name']; ?>
                                </td>
                                <td colspan="3"><b>Part Number &nbsp;&nbsp;&nbsp;&nbsp;: </b>
                                    <?php echo $reports_common['part_no']; ?>
                                </td>
                                <td colspan="3"><b>Month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </b>
                                    <?php $date = strtotime($year."-".$month."-15");
                                          echo date("M'Y", $date);
                                    ?>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3"><b>Lot/ASN No. : </b>
                                    <?php echo $reports_common['lot_no']; ?>
                                </td>
                                <td colspan="3"><b>Supplier Name : </b>
                                    <?php echo $reports_common['supplier_name']; ?>
                                </td>
                                <td colspan="3"><b>Sample Qty : </b>
                                    <?php echo $samples; ?>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-hover table-light" border="2">
                            <tr>
                                <td colspan="9"><b>Judgement &nbsp;&nbsp;: </b>
                                    <?php echo $judgement; ?>
                                </td>
                            </tr>
                        </table>
                    <?php } ?>
                    
                </div>
            </div>
            <br>
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <?php if(empty($reports)) { ?>
                        <p class="text-center">No Record Available.</p>
                    <?php } else { ?>
                        
                        
                        <table class="table table-hover table-light" border="1" style="width:400px">
                            <thead>
                                <tr><th colspan="9" align="center">Test Details</th></tr>
                                <tr>
                                    <th width="5%">Sr No</th>
                                    <th width="10%">Name</th>
                                    <th width="25%">Method</th>
                                    <th width="15%">Judgement</th>
                                    <th width="5%">Samples</th>
                                    <th width="10%">Start Date</th>
                                    <th width="10%">End Date</th>
                                    <th width="10%">Result</th>
                                    <th width="10%">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn=0; foreach($reports as $report) { $sn++; ?>
                                    <tr>
                                        <td width="5%" align="center" style="vertical-align:middle;"><?php echo $sn; ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo $report['test_name']; ?></td>
                                        <td width="25%" style="vertical-align:middle;"><?php echo $report['method']; ?></td>
                                        <td width="15%" align="center" style="vertical-align:middle;"><?php echo $report['judgement']; ?></td>
                                        <td width="5%" align="center" style="vertical-align:middle;"><?php echo $report['samples']; ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo explode(" ",$report['start_date'])[0]; ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo explode(" ",$report['end_date'])[0]; ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo strtoupper($report['observation_result']); ?></td>
                                        <td width="10%" align="center" style="vertical-align:middle;"><?php echo " "; ?></td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td rowspan="4" colspan="9" valign="top"><b>Comment</b></td>
                                    </tr>
                            </tbody>
                        </table>
                        
                        <table class="table table-hover table-light">
                            <tr>
                                <td colspan="3">&nbsp;</td>
                                <td colspan="2"><b>Checked By</b></td>
                                <td colspan="2"><b>Verified By</b></td>
                                <td colspan="2"><b>Approved By</b></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                        <table class="table table-hover table-light">
                            <tr>
                                <td colspan="8">LG (ILP) QAS 009 (02042015)-00</td>
                                <td><b>LGE PUNE</b></td>
                            </tr>
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
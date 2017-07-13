<div class="modal-header">
    <h4 class="modal-title">Change Start Date</h4>
</div>
<form action="<?php echo base_url().'dashboard/change_date/'.$test['code']; ?>" class="start-date-form form-horizontal" method="post">
    <div class="modal-body">
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            Please fill lot size.
        </div>
        <div class="form-group">
            <label class="control-label col-md-4">Start Date</label>
            <div class="col-md-8">
                <div class="input-group input-medium date date-picker-ajax" data-date-format="yyyy-mm-dd">
                    <input type="text" name="start_date" class="form-control" readonly value="<?php echo date('Y-m-d', strtotime($test['start_date'])); ?>">
                    <span class="input-group-btn">
                        <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="modal-footer">
        <button type="button" class="adjust-production-modal-close button white" data-dismiss="modal">Close</button>
        <button type="submit" class="button">Save</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('.date-picker-ajax').datepicker();
    });
</script>
$(document).ready(function() {

    var base_url = $('#base_url').val();
    
    if($('#dashboard-test-stats').length > 0) {
        var smile_count = $('#dashboard-test-stats .fa-smile-o').length;
        var warning_count = $('#dashboard-test-stats .fa-meh-o').length;
        var danger_count = $('#dashboard-test-stats .fa-frown-o').length;
        
        $('#smile-count').text(' = '+smile_count);
        $('#warning-count').text(' = '+warning_count);
        $('#danger-count').text(' = '+danger_count);
    }
    
    $('#add-user-type-sel').change(function() {
        var portlet_id = $('#product-part-selector').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var user_type = $('#add-user-type-sel :selected').val();
        
        if(user_type == 'Chamber') {
            $('#add-user-chamber').removeAttr('disabled');
            $('#add-user-chamber').closest('.col-md-6').show();
        } else if(user_type == 'Product') {
            $('#add-user-product').removeAttr('disabled');
            $('#add-user-product').closest('.col-md-6').show();
        }else {
            $('#add-user-chamber').attr('disabled', 'disabled');
            $('#add-user-chamber').closest('.col-md-6').hide();
        }
        
        App.unblockUI('#'+portlet_id);
    });
    
    $('#product-part-selector').change(function() {
        var portlet_id = $('#product-part-selector').closest('.portlet').attr('id');
              //  alert(portlet_id);
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector :selected').val();
		// alert(product);
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_parts_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector :selected').val() != '') {
                    $('#part-selector').select2('val', null);
                }
                
                $('#part-selector').html('');
                
                $('#part-selector').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector').append($('<option>', { 
                        value: item.name,
                        text : item.name, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	
    $('#product-part-selector1').change(function() {
        var portlet_id = $('#product-part-selector1').closest('.portlet').attr('id');
              //  alert(portlet_id);
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector1 :selected').val();
		// alert(product);
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_parts_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector1 :selected').val() != '') {
                    $('#part-selector1').select2('val', null);
                }
                
                $('#part-selector1').html('');
                
                $('#part-selector1').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector1').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	//part number from its name
    $('#part-selector').change(function() {
        var portlet_id = $('#part-selector').closest('.portlet').attr('id');
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var part = $('#part-selector :selected').val();
        var product = $('#product-part-selector :selected').val();
		/* alert(part);
		alert(product);  */
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_part_number_by_part',
            data: { part: part, product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector_number :selected').val() != '') {
                    $('#part-selector_number').select2('val', null);
                }
				
				//alert(resp.parts);
                
                $('#part-selector_number').html('');
                $('#part-selector_number').append('<option value=""></option>');
				$.each(resp.parts, function (i, item) {
                    $('#part-selector_number').append($('<option>', { 
                        value: item.id,
                        text : item.part_no, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	//end part number from its name
    
	//Start Part-supplier
	$('#part-selector_number').change(function() {
        var portlet_id = $('#part-selector_number').closest('.portlet').attr('id');
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var part = $('#part-selector_number :selected').val();
        /* alert(part);
		alert(product); */
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_suppliers_by_part',
            data: { part: part},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector_supplier :selected').val() != '') {
                    $('#part-selector_supplier').select2('val', null);
                }
                
                $('#part-selector_supplier').html('');
                $('#part-selector_supplier').append('<option value=""></option>');
				$.each(resp.parts, function (i, item) {
                    $('#part-selector_supplier').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	//End Part-supplier
	
    $('.part-supplier-selector').change(function() {
        var portlet_id = $('.part-supplier-selector').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var part = $('#part-selector_number :selected').val();
        var product = $('#product-part-selector :selected').val();
        var chamber = $('#start-monitoring-chamber-sel :selected').val();
        //alert(product);
        
        $.ajax({
            type: 'POST',
            url: base_url+'apps/get_suppliers_by_part',
            data: { part: part, product: product, chamber: chamber},
            dataType: 'json',
            success: function(resp) {
                if($('#part-based-supplier-selector :selected').val() != '') {
                    $('#part-based-supplier-selector').select2('val', null);
                }
                
                $('#part-based-supplier-selector').html('');
                
                $('#part-based-supplier-selector').append('<option value=""></option>');
                $.each(resp.suppliers, function (i, item) {
                    $('#part-based-supplier-selector').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                }); 
                
                if($('#part-based-test-selector :selected').val() != '') {
                    $('#part-based-test-selector').select2('val', null);
                }
                
                $('#part-based-test-selector').html('');
                
                $('#part-based-test-selector').append('<option value=""></option>');
                $.each(resp.tests, function (i, item) {
                    $('#part-based-test-selector').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                });
                
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
	$('.part-test_mon-selector').change(function() {
        var portlet_id = $('.part-supplier-selector').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var part = $('#part-selector_number :selected').val();
       // var product = $('#product-part-selector :selected').val();
       // var chamber = $('#start-monitoring-chamber-sel :selected').val();
        //alert(product);
        
        $.ajax({
            type: 'POST',
            url: base_url+'apps/get_tests_by_partid',			
            data: { part: part},
            dataType: 'json',
            success: function(resp) {
               
                
                if($('#part-based-test-selector :selected').val() != '') {
                    $('#part-based-test-selector').select2('val', null);
                }
                
                $('#part-based-test-selector').html('');
                
                $('#part-based-test-selector').append('<option value=""></option>');
                $.each(resp.tests, function (i, item) {
                    $('#part-based-test-selector').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                });
                
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    //
	
	
    $('#part-based-test-selector').change(function() {
        var portlet_id = $('.part-supplier-selector').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var test = $('#part-based-test-selector :selected').val();
        
        $.ajax({
            type: 'POST',
            url: base_url+'apps/get_test_duration',
            data: { test: test},
            dataType: 'json',
            success: function(resp) {
                if(resp.test) {
                    $('#start-test-duration').val(resp.test.duration);
                    
                    $('#start-test-code-text').html(resp.test.code);
                    $('#start-test-name-text').html(resp.test.name);
                    $('#start-test-duration-text').html(resp.test.duration+' hrs');
                    $('#start-test-method-text').html(resp.test.method);
                    $('#start-test-judgement-text').html(resp.test.judgement);
                    
                    $('#start-test-details').show();
                }
                
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	
	
	//Start Mapping Part-supplier
	$('#product-part-selector_map').change(function() {
        var portlet_id = $('#product-part-selector_map').closest('.portlet').attr('id');
              //  alert(portlet_id);
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector_map :selected').val();
		// alert(product);
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_parts_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector_map :selected').val() != '') {
                    $('#part-selector_map').select2('val', null);
                }
                
                $('#part-selector_map').html('');
                
                $('#part-selector_map').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector_map').append($('<option>', { 
                        value: item.name,
                        text : item.name, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	
	$('#part-selector_map').change(function() {
        var portlet_id = $('#part-selector_map').closest('.portlet').attr('id');
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var part = $('#part-selector_map :selected').val();
        var product = $('#product-part-selector_map :selected').val();
		//alert(part);
		//alert(product); 
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_part_number_by_part',
            data: { part: part, product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector_number_map :selected').val() != '') {
                    $('#part-selector_number_map').select2('val', null);
                }
				
				//alert(resp);
                
                $('#part-selector_number_map').html('');
                $('#part-selector_number_map').append('<option value=""></option>');
				$.each(resp.parts, function (i, item) {
                    $('#part-selector_number_map').append($('<option>', { 
                        value: item.id,
                        text : item.part_no, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	
	//PTC
	$('#product-part-selector_ptc').change(function() {
        var portlet_id = $('#product-part-selector_ptc').closest('.portlet').attr('id');
              //  alert(portlet_id);
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var product = $('#product-part-selector_ptc :selected').val();
		// alert(product);
        $.ajax({
            type: 'POST',
            url: base_url+'products/get_parts_by_product',
            data: { product: product},
            dataType: 'json',
            success: function(resp) {
                if($('#part-selector_ptc :selected').val() != '') {
                    $('#part-selector_ptc').select2('val', null);
                }
                
                $('#part-selector_ptc').html('');
                
                $('#part-selector_ptc').append('<option value=""></option>');
                $.each(resp.parts, function (i, item) {
                    $('#part-selector_ptc').append($('<option>', { 
                        value: item.name,
                        text : item.name, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	
	//Category-Chamber selector
	$('#catagory-chamber_selector_map').change(function() {
        var portlet_id = $('#catagory-chamber_selector_map').closest('.portlet').attr('id');
              //  alert(portlet_id);
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var chamber_cat = $('#catagory-chamber_selector_map :selected').val();
		// alert(chamber_cat);
        $.ajax({
            type: 'POST',
            url: base_url+'tests/get_chamber_by_category',
            data: { chamber_cat: chamber_cat},
            dataType: 'json',
            success: function(resp) {
                if($('#chamber_selector_map :selected').val() != '') {
                    $('#chamber_selector_map').select2('val', null);
                }
                
                $('#chamber_selector_map').html('');
                
                $('#chamber_selector_map').append('<option value=""></option>');
                $.each(resp.chambers, function (i, item) {
                    $('#chamber_selector_map').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                });
                App.unblockUI('#'+portlet_id);
            }
        });
    });
	
	//End Mapping Part-supplier
	
	//Part - test
	$('.part-test-selector_plan').change(function() {
        var portlet_id = $('.part-test-selector_plan').closest('.portlet').attr('id');
        
        App.blockUI({
            target: '#'+portlet_id,
            boxed: true
        });
        
        var part = $('#part-selector_number :selected').val();
       // var product = $('#product-part-selector :selected').val();
       /// var chamber = $('#start-monitoring-chamber-sel :selected').val();
        //alert(part);
        
        $.ajax({
            type: 'POST',
            url: base_url+'apps/get_tests_by_partid',
            data: { part: part},
            dataType: 'json',
            success: function(resp) {
                if($('#part-test_selector :selected').val() != '') {
                    $('#part-test_selector').select2('val', null);
                }
                
                $('#part-test_selector').html('');
                
                $('#part-test_selector').append('<option value=""></option>');
                $.each(resp.tests, function (i, item) {
                    $('#part-test_selector').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                }); 
                
                /* if($('#part-based-test-selector :selected').val() != '') {
                    $('#part-based-test-selector').select2('val', null);
                }
                
                $('#part-based-test-selector').html('');
                
                $('#part-based-test-selector').append('<option value=""></option>');
                $.each(resp.tests, function (i, item) {
                    $('#part-based-test-selector').append($('<option>', { 
                        value: item.id,
                        text : item.name, 
                    }));
                }); */
                
                App.unblockUI('#'+portlet_id);
            }
        });
    });
    
	
	//Part - test
    if($('.dashboard-noti-warning').length > 0) {
        addPulsateWarning();
    }

    if($('.dashboard-noti-danger').length > 0) {
        addPulsateDanger();
    }

    if($('.dashboard-noti-success').length > 0) {
        addPulsateSuccess();
    }
    
    if($('.observation-modal-btn').length > 0) {
        $('.observation-modal-btn').click(function() {
            $('#observation_index').val($(this).attr('data-index'));
            
            $('#observation-modal').modal('show');
        });
    }
    
    if($('.view-test-modal-btn').length > 0) {
        $('.view-test-modal-btn').click(function() {
            //$('#observation_index').val($(this).attr('data-index'));
            
            var code = $(this).attr('data-index');
            // alert(code);
            $.ajax({
                url: base_url+"apps/view_test_ajax/"+code,
                async: false,
                type: "POST",
                data: "type=article",
                dataType: "html",
                success: function(data) {
                  $('#view-test-modal').html(data);
                }
            }),
            
            $('#view-test-modal').modal('show');
        });
    }
	
	 if($('.view-test-modal-btn1').length > 0) {
        $('.view-test-modal-btn1').click(function() {
            //$('#observation_index').val($(this).attr('data-index'));
            var code = $(this).attr('data-index');
           
            $.ajax({
                url: base_url+"apps/view_test_ajax_completed/"+code,
                async: false,
                type: "POST",
                data: "type=article",
                dataType: "html",
                success: function(data) {
				 // alert(code);exit;
                  $('#view-test-modal1').html(data);
                }
            }),
            $('#view-test-modal1').modal('show');
        });
    } 

    $('#observation-form').submit(function() {
        if($(this).valid()) {
            var ob_result = $('#observation-id').val();
            
            if(ob_result == 'NG') {
                bootbox.dialog({
                    message: 'Are you sure you want to make this as NG?',
                    title: "Confirmation box",
                    buttons: {
                        confirm: {
                            label: "Yes",
                            className: "red",
                            callback: function() {
                                
                                $('#observation-form')[0].submit();
                            }
                        },
                        cancel: {
                            label: "No",
                            className: "blue"
                        }
                    }
                });
                
                return false;
            }
        }
    });
    
});

function groupTable($rows, startIndex, total){
    if (total === 0){
        return;
    }

    var i , currentIndex = startIndex, count=1, lst=[];
    var tds = $rows.find('td:eq('+ currentIndex +')');
    var ctrl = $(tds[0]);
    lst.push($rows[0]);
    for (i=1;i<=tds.length;i++){
        if (ctrl.text() ==  $(tds[i]).text()){
            count++;
            $(tds[i]).addClass('deleted');
            lst.push($rows[i]);
        } else {
            if (count>1){
                ctrl.attr('rowspan',count);
                groupTable($(lst),startIndex+1,total-1)
            }
            count=1;
            lst = [];
            ctrl=$(tds[i]);
            lst.push($rows[i]);
        }
    }
}

function addPulsateWarning() {
    $('.dashboard-noti-warning').pulsate({
        color: "#fdbe41",
        reach: 100,
        speed: 1000,
        glow: true
    });
}

function addPulsateDanger() {
    $('.dashboard-noti-danger').pulsate({
        color: "#ed6b75",
        reach: 120,
        speed: 800,
        glow: true
    });
}

function addPulsateSuccess() {
    $('.dashboard-noti-success').pulsate({
        color: "#36c6d3",
        reach: 120,
        speed: 800,
        glow: true
    });
}

function printPage(id) {
	//alert(id);
    var html="<html>";
    html+= document.getElementById(id).innerHTML;
    html+="</html>";
    var printWin = window.open('','','left=0,top=0,width=500,height=500,toolbar=0,scrollbars=0,status =0');
    printWin.document.write(html);
    printWin.document.close();
    printWin.focus();
    printWin.print();
    printWin.close();
}

	function no_inspection(id) {
			var c = document.getElementById('no_inspec');
			//var id = $('#no_inspec').attr('data-index');  
			//alert(id);exit;			
			//alert(base_url+'plans/submit_inspection_status/'+id);
			if(c.checked){
			var s = 'NO';
			$.ajax({
				type: 'POST',
				url: 'submit_inspection_status/'+id,
				data: { id : id ,s:s},
				dataType: 'json',
				success: function() {
					//alert('no insp');
				},
			});
		}else{
			var s = 'YES';
			$.ajax({
				type: 'POST',
				url: 'submit_inspection_status/'+id,
				data: { id : id ,s:s},
				dataType: 'json',
				success: function() {
					//alert('no insp');
				},
			});
		}
	}
	
	
function save_foolproof_data(checkpoint_id){
    var base_url = $('#base_url').val();
    var all_results = $('#result_'+checkpoint_id).val();
    var all_values = $('#values_'+checkpoint_id).val();
    
    var lsl = $('#lsl_'+checkpoint_id).val();
    var usl = $('#usl_'+checkpoint_id).val();
    var np = '';
    
    all_results = (all_results) ? all_results : 0;
    all_values = (all_values) ? all_values : 0;
    
	var formData = new FormData();
    formData.append('checkpoint_id', checkpoint_id);    
    
    if ($('#np_'+checkpoint_id).is(":checked")){
        //alert("checked");
        np = $('#np_'+checkpoint_id).val();
        if(all_results == 0){
            all_values = np;
        }else if(all_values == 0){
            all_results = np;
        }
        formData.append('image', '');
        
    }else{
        
        if(lsl != '' || usl != ''){
            if(all_values == 0){
                bootbox.dialog({
                    message: 'Please fill value before submit.',
                    title: 'Alert',
                    buttons: {
                        confirm: {
                            label: "OK",
                            className: "button"
                        }
                    }
                });

                $('#values_'+checkpoint_id).css('border','1px solid #e35b5a');

                return false;
            }
        }
        
        if (!$('#capture_'+checkpoint_id).val()) {
            bootbox.dialog({
                message: 'Please Upload Proper Image.',
                title: 'Alert',
                buttons: {
                    confirm: {
                        label: "OK",
                        className: "button"
                    }
                }
            });

            $('#capture_'+checkpoint_id).closest('label').css('border','1px solid #e35b5a');
            $('#capture_'+checkpoint_id).closest('label').css('color','#e35b5a');

            return false;
        }else{
            var image = $('#capture_'+checkpoint_id)[0].files[0];
            var image_name = $('#capture_'+checkpoint_id)[0].files[0].name;
            $('#capture_'+checkpoint_id).closest('label').css('border','none');
            $('#capture_'+checkpoint_id).closest('label').css('border-color','#EEE #CCC #CCC #EEE');
            $('#capture_'+checkpoint_id).closest('label').css('color','#000');
        }
        
        formData.append('image', image, image_name);
        
    }
    
    formData.append('all_results', all_results);
    formData.append('all_values', all_values);
    
    //alert(all_results+' '+all_values);
    $('#button_'+checkpoint_id).css('display','none');
    $.ajax({
        type: 'POST',
        url: base_url+'fool_proof/save_result',
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(resp) {
            //alert("Success");
            if(all_results == 0){
                $('#values_'+checkpoint_id).attr('disabled','true');
            }else if(all_values == 0){
                $('#result_'+checkpoint_id).attr('disabled','true');
            }
            
            $('#np_'+checkpoint_id).attr('disabled','true');
            $('#capture_'+checkpoint_id).closest('label').css('display','none');
            if(all_values == 'NP' || all_results == 'NP'){
                $('#capture_'+checkpoint_id).closest('td').html('NP');
            }else{
                $('#capture_'+checkpoint_id).closest('td').html('<img src='+base_url+'assets/foolproof_captured/'+image_name+' alt=image height=70 width=100 />');
            }
            $('#button_'+checkpoint_id).css('display','none');
        },
        error: function(jqXHR, textStatus, errorMessage) {
           alert("something went wrong. Please try again."); // Optional
           $('#button_'+checkpoint_id).css('display','block');
        }
    });
}

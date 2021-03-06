<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plans extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'plans'));
        $this->template->write_view('footer', 'templates/footer');

    }
    
    public function screen() {
        $data = array();
        $this->load->model('Plan_model');
        $data['plan'] = $this->Plan_model->get_month_plan(date('Y-m-01'), array());
       // echo  $this->db->last_query();exit;
        $this->template->write_view('content', 'plans/monthly_plan_screen', $data);
        $this->template->render();
    }
    
    public function upload() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            $validate->set_rules('plan_month', 'Plan Month', 'trim|required|xss_clean');
            if($validate->run() === TRUE) {
                $product_id = $this->input->post('product_id');
                $plan_month = $this->input->post('plan_month');
                
                if(!empty($_FILES['plan_excel']['name'])) {
                    $output = $this->upload_file('plan_excel', 'plan_month', "assets/uploads/");

                    //echo "<pre>";print_r($output);exit;
                    if($output['status'] == 'success') {
                        $excel = $this->parse_monthly_plan($product_id, $plan_month, $output['file']);
                        if($excel) {
                            $this->session->set_flashdata('success', 'Plan Successfully uploaded.');
                            redirect(base_url().'plans/display?plan_month='.$plan_month.'&product_id='.$product_id);
                        } else {
                            $data['error'] = 'Incorrect Excel format. Please check';
                        }
                        
                    } else {
                        $data['error'] = $output['error'];
                    }

                }
                
            } else {
                $data['error'] = validation_errors();
            }

        }
        
        $this->template->write_view('content', 'plans/upload', $data);
        $this->template->render();
    }
    
    public function copy_plan() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            $validate->set_rules('from_month', 'From Month', 'trim|required|xss_clean');
            $validate->set_rules('to_month', 'To Month', 'trim|required|xss_clean');
            if($validate->run() === TRUE) {
                $product_id = $this->input->post('product_id');
                $from_month = $this->input->post('from_month');
                $to_month = $this->input->post('to_month');
                
                $this->load->model('Plan_model');
                
                $this->Plan_model->copy_plan($product_id, $from_month, $to_month);
                $this->session->set_flashdata('success', 'Plan Successfully copied.');
                redirect(base_url().'plans/copy_plan');
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $this->template->write_view('content', 'plans/copy_plan', $data);
        $this->template->render();
    }
    
    public function monthly_plan_export() {
		//echo 'Plan';
		 $this->load->model('Plan_model');
		$filters = @$_SESSION['plan_filters'] ;
		$plan_month = @$_SESSION['plan_month'] ;
		$data['plan_date'] = $plan_month;
		$data['plan'] = $this->Plan_model->get_month_plan($plan_month, $filters);
		$str = $this->load->view('excel_pages/display_plan', $data, true);
		
		header('Content-Type: application/force-download');
        header('Content-disposition: attachment; filename=monthly_plan_report.xls');
            
		header("Pragma: ");
        header("Cache-Control: ");
        echo $str;     
	}
	
    public function display() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        $data['parts_num'] = $this->Product_model->get_all_parts();
       
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();
        
        $this->load->model('Plan_model');
        
        $filters = array();
        if($this->input->post()) {
            $plan_month = $this->input->post('plan_month');
            $filters = $this->input->post();
			$_SESSION['plan_filters'] = $filters;			
			$_SESSION['plan_month'] = $plan_month;			
            $data['plan'] = $this->Plan_model->get_month_plan($plan_month, $filters);
            //echo $this->db->last_query();exit;
        } else if($this->input->get('plan_month')) {
            $plan_month = $this->input->get('plan_month');
            
            $filters = array('product_id' => $this->input->get('product_id'));
            $data['plan'] = $this->Plan_model->get_month_plan($this->input->get('plan_month'), $filters);
			//echo $this->db->last_query();exit;
        }
        
        if(!empty($filters['product_id'])) {
            $data['parts'] = $this->Product_model->get_all_product_parts($filters['product_id']);
        }
		if(!empty($filters['part_id1'])){
				//$data['parts_num'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
				//$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['tests'] = $this->Test_model->get_tests_by_part($filters['part_id1']);
        
			}
        if(!empty($filters['part_id'])){
				$data['parts_num'] = $this->Product_model->get_part_num_by_part($filters['part_id'],$filters['product_id']);
			}
        $data['filters'] = $filters;
        $data['plan_month'] = isset($plan_month) ? $plan_month : '';
            
        
        $this->template->write_view('content', 'plans/display', $data);
        $this->template->render();
    }
    public function part_no_inspection() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();
        
        $this->load->model('Plan_model');
        
        $filters = array();
        if($this->input->post()) {
            $plan_month = $this->input->post('plan_month');
            $filters = $this->input->post();			
            $data['plan'] = $this->Plan_model->get_month_plan_no_insp($plan_month, $filters);
            //echo $this->db->last_query();exit;
        } else if($this->input->get('plan_month')) {
            $plan_month = $this->input->get('plan_month');
            
            $filters = array('product_id' => $this->input->get('product_id'));
            $data['plan'] = $this->Plan_model->get_month_plan_no_insp($this->input->get('plan_month'), $filters);
        }
        
        if(!empty($filters['product_id'])) {
            $data['parts'] = $this->Product_model->get_all_product_parts($filters['product_id']);
        }
        
        $data['filters'] = $filters;
        $data['plan_month'] = isset($plan_month) ? $plan_month : '';
            
        
        $this->template->write_view('content', 'plans/part_no_inspection', $data);
        $this->template->render();
    }
    
    public function change_date($id) {
        if($this->input->post('schedule_date')) {
            $response = $this->Plan_model->update_test($id, $this->input->post('schedule_date'));
            if($response) {
                $this->session->set_flashdata('success', 'Date successfully changed.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            }
            
            redirect(base_url());
        } else {
            $data = array('test' => $on_going);
            echo $this->load->view('change_date_ajax', $data);
        }
        
    }
    
	/* public function submit_inspection_status($id) {
		
		echo $id;
		if($id) {
            $this->load->model('Plan_model');
            $resp = $this->Plan_model->mark_no_inspection($id);
			
			//echo $this->db->last_query(); exit;
        }
			// echo $this->input->post('part').'123';print_r($data['parts']);exit;
         
        echo exit;
    } */
	
	public function submit_inspection_status() {
		//s=>NO => for NO Part in Company means NO Inspection
		//s=>YES => for Part in Company means there is Inspection
		// echo $this->input->post('id');
		//echo $this->input->post('s');
		 
		 if($this->input->post()) {
            $this->load->model('Plan_model');
            $res = $this->Plan_model->mark_no_inspection($this->input->post('myear'),$this->input->post('sid'),$this->input->post('pid'),$this->input->post('ppid'),$this->input->post('s'));
			//echo $this->db->last_query();exit;
		}
		exit;
    }
    
    public function parse_monthly_plan($product_id, $month_year, $file_name) {
        //$file_name = 'assets/uploads/'.$file_name;
        //echo $month_year;//2017-11-01
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[2]) || count($arr[2]) < 6) {
            return FALSE;
        }
        
        
        $this->load->model('Product_model');
        $this->load->model('Supplier_model');
        $this->load->model('Plan_model');
        $this->load->model('Test_model');
        
        $p = '';
        $s = '';
        $part_id = '';
        $supplier_id = '';
        $date = '';
        
		
		
        //$mappings = array();
       
        $tests = array();
        $full_data = array();
        $plans = array();
		 
		 
        foreach($arr as $no => $row) {
		//Error
		//Prepare Header for error excel
		if($no == 1){
				$headers = array();
				$headers = $row;
				$headers['H'] = 'Error';
				//print_r($headers);exit;
				continue;
		}
		//End Prepare Header  for error excel
		if($no <= 2)
                continue;
          
		//echo trim($row['G']);exit;	
		
		//Start prepare error lines
		
		$content_error = array();
		if(!empty(trim($row['D']))) 
		{ 
			$part_exist = $this->Product_model->get_product_part_by_code_num($product_id,trim($row['D']));
			
			$part_id = !empty($part_exist) ? $part_exist['id'] : '';      
				
			//Get Plan for this Part_id for current month_year
			
			if($part_id == ''){
				$content_error[] = 'Planned Part Number not found.'; 
			}
			else{
				/* $plan_part = $this->Plan_model->get_plan_by_part($part_id,$month_year);
				if(!empty($plan_part))
					$content_error[] = "Part plan found for this month."; 					
				 */		
				$tests = $this->Test_model->get_tests_by_part($part_id);
				if(empty($tests))
					$content_error[] = "PTC Mapping not found."; 
					
			}
		}
		if(!empty(trim($row['E']))) 
		{ 
			 $exist_supplier = $this->Supplier_model->get_supplier_by_code(trim($row['E']));
			
			if(empty($exist_supplier)) 
			{
				$content_error[] = 'Supplier Code not found.'; 
				
			}
			else if($exist_supplier['id'] != '' && $part_id != ''){
				$exist_sp = $this->Supplier_model->get_sp($product_id,$exist_supplier['id'],$part_id);
				if(empty($exist_sp)) 
				{
					$content_error[] = 'Part Supplier mapping not found.'; 					
				}			
			}			
		}
		
		if(!empty(trim($row['G']))) 
		{ 
			$month_year_array = explode('-',$month_year);
			$schedule_date_array = explode('-',trim($row['G']));
			/* print_r($month_year_array);
			print_r($schedule_date_array);
			exit;
			 */
			if($month_year_array[1] != $schedule_date_array[0])
			{
				$content_error[] = 'Date does not lie in selected month.';
				
			}
		}
				
		//prepare error lines
		
		
		$temp = array();
		if(!empty($content_error)){
			
			$temp['Sr_no'] = trim($row['A']);
			$temp['Part_Code'] = trim($row['B']);
			$temp['Component_Name'] = trim($row['C']);
			$temp['Planed_Part_no'] = trim($row['D']);
			$temp['Supplier_Code'] = trim($row['E']);
			$temp['Supplier_Name'] = trim($row['F']);
			$temp['Schedule_date'] = trim($row['G']);
			$temp['error']    	   = implode(",",$content_error);
			$full_data[]       	   = $temp;
		}	
		//End Error
		
		
		
		    $row['B'] = str_replace("\n", ' ', $row['B']);
            $row['D'] = str_replace("\n", ' ', $row['D']);
            if($p !== trim($row['D']) && !empty($row['D'])) {
                //echo trim($row['D']);exit;
				$p = $row['D'];
                // $exists = $this->Product_model->get_product_part_by_code($product_id, $p);
                $exists = $this->Product_model->get_product_part_by_code_num($product_id, $p);
                $part_id = !empty($exists) ? $exists['id'] : '';
                if(!empty($part_id)) {
                    $tests = $this->Test_model->get_tests_by_part($part_id);
					//echo "<pre>";print_r($tests);exit;					
					/* 
					
					$plan_part = $this->Plan_model->get_plan_by_part($part_id,$month_year);
					if(!empty($plan_part)) {
						continue;
					} */
					
                }
            }
            //echo "<pre>";print_r($tests);
            if(empty($part_id)) {
                continue;
            }
			
            
            if($s !== trim($row['E'])) {
                if(empty($row['E'])) {
                    continue;
                }
                
                $supplier = array();
                $supplier['supplier_no'] = trim($row['E']);
                $supplier['name'] = trim($row['F']);
                
                $exists = $this->Supplier_model->get_supplier_by_code($supplier['supplier_no']);
                if(empty($exists)) {                    
						//$supplier_id = $this->Supplier_model->add_supplier($supplier, '');
						continue;
					
                } else 
                    $supplier_id = $exists['id'];
                }
				if($supplier_id != '' && $part_id != ''){
					$exist_sp = $this->Supplier_model->get_sp($product_id,$supplier_id,$part_id);
					//print_r($exist_sp);exit;
					if(empty($exist_sp)) 
					{
						continue;			
					}			
				}	
                /* $mapping = array();
                $mapping['supplier_id'] = $supplier_id;
                $mapping['product_id'] = $product_id;
                $mapping['part_id'] = $part_id;
                $mapping['created'] = date("Y-m-d H:i:s");
                
                $mappings[] = $mapping; */
            
            if(!empty(trim($row['G']))) 
			{ 
				
				if($month_year_array[1] != $schedule_date_array[0])
				{
					//echo 'not as selected';exit;
					continue;
					
				}
			}
            if($date !== trim($row['G']) && !empty($row['G'])) {
                $date = trim($row['G']);                
                $date = date_create_from_format('m-d-y', $date)->format('Y-m-d');
            }
			if(!empty($tests)) {
                $plan = array();
                $plan['month_year'] = $month_year;
                $plan['supplier_id'] = $supplier_id;
                $plan['product_id'] = $product_id;
                $plan['part_id'] = $part_id;
                $plan['planned_part_no'] = $row['D'];
                $plan['schedule_date'] = $date;
                $plan['created'] = date("Y-m-d H:i:s");
                foreach($tests as $test) {
                    $plan['test_id'] = $test['id'];                    
                    $plans[] = $plan;
                }                
            }
			
		} 
			
			/*if(!empty($mappings)) {
				$this->Supplier_model->insert_sp_mappings($mappings);
				$this->Supplier_model->remove_dups();
			}*/
			$this->Plan_model->delete_plan($product_id, $month_year);			
			if(!empty($plans)) {
				$this->Plan_model->insert_monthly_plan($plans, $month_year);
			}
			
		
		
		if(!empty($full_data)){			 
				$this->create_excel($headers, $full_data, 'plan_error_file');			
		}
		return TRUE;
		} 
    }
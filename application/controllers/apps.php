<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apps extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
    
    public function start_test() {
        $data = array();
        $this->load->model('Apps_model');

        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();
        
        $this->load->model('Chamber_model');
        $data['chambers'] = $this->Chamber_model->get_all_chambers();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        $data['parts'] = $this->Product_model->get_all_parts();
        
        $this->load->model('Stage_model');
        $data['stages'] = $this->Stage_model->get_all_stages();
        
		// print_r();exit;
		
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('chamber_id', 'Chamber', 'trim|required|xss_clean');
            $validate->set_rules('stage_id', 'Event', 'trim|required|xss_clean');
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            $validate->set_rules('part_id', 'Part Name', 'trim|required|xss_clean');
           // $validate->set_rules('part_no', 'Part No', 'trim|required|xss_clean');
            $validate->set_rules('supplier_id', 'Supplier', 'trim|required|xss_clean');
            $validate->set_rules('test_id', 'Test', 'trim|required|xss_clean');
            $validate->set_rules('samples', 'Samples', 'trim|required|xss_clean');
            $validate->set_rules('duration', 'Duration', 'trim|required|xss_clean');
            $validate->set_rules('observation_frequency', 'Observation Frequency', 'trim|required|xss_clean');

            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
				$part_num =  $this->Product_model->get_part_number_by_id($post_data['product_id'],$post_data['part_id']);
                $post_data['part_num'] = $part_num['part_no'];				
				/* echo 'app=>';
				print_r($post_data); */
                $post_data['start_date'] = date('Y-m-d H:i:s');
                $post_data['end_date'] = date('Y-m-d H:i:s', strtotime('+'.($post_data['duration']).' hours'));
                $post_data['no_of_observations'] = floor($post_data['duration']/$post_data['observation_frequency'])+1;
                
               $response = $this->Apps_model->update_test($post_data);
			   
                if($response) {
                    $this->Apps_model->add_observation(array('observation_index' => 0, 'test_id' => $response));
					//echo $response;exit;
                    $this->session->set_flashdata('success', 'Test successfully started.');
                    redirect(base_url());
                } else {
                    $data['error'] = 'Something went wrong, Please try again';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $this->template->write_view('content', 'apps/start_test', $data);
        $this->template->render();
    }
    
    public function on_going($code) {
        $data = array();
        $this->load->model('Apps_model');
		//echo $this->chamber_ids;
        $data['test'] = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), $code);
		//echo '<pre>';print_r($data['test']);exit;
        if(empty($data['test'])) {
            redirect(base_url());
        }
        
        $test = $data['test'];
        
        $total_duration = strtotime($test['end_date'])-strtotime($test['start_date']);
        $total_duration = $total_duration/3600;
        $duration_completed = strtotime(date('Y-m-d H:i:s'))-strtotime($test['start_date']);
        $duration_completed = $duration_completed/3600;

        $data['progress'] = round(($duration_completed/$total_duration)*100, 1);
        if($data['progress'] > 100) {
            $data['progress'] = 100;
        }
        
        $observations = $this->Apps_model->get_observations($test['id']);
        $f_observations = array();
        
        $total_obs = $test['no_of_observations']*$test['samples'];
        //exit;
        foreach($observations as $ob_key => $ob) {
            foreach($ob as $col => $val) {
                if(!isset($f_observations[$col])) {
                    $f_observations[$col] = array_fill(0, $total_obs, '');
                }
                $f_observations[$col][$ob['observation_index']] = $val;
            }
        }
        
        if(!isset($f_observations['allowed'])) {
            $f_observations['allowed'] = array_fill(0, $total_obs, '');
        }
        
        $s = 0;
        for($i = 0; $i < $test['no_of_observations']; $i++) {
            for($y = 0; $y < $test['samples']; $y++) {
                $f_observations['sample'][] = $y+1;
            }
                
            if($i === 0) {
                for($z = 0; $z < $test['samples']; $z++) {
                    $f_observations['allowed'][$s] = 'Yes';
                    $s++;
                }
            } else {
                $dur = ($test['observation_frequency']*($i)) - 2;
                $allowed_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours', strtotime($test['start_date'])));
                
                if(strtotime($allowed_time) <= strtotime('now')) {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'Yes';
                        $s++;
                    }
                } else {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'No';
                        $s++;
                    }
                }
            }
        }

        /* foreach($f_observations['allowed'] as $k => $v) {
            if($k === 0) {
                $f_observations['allowed'][0] = 'Yes';
            } else {
                $dur = ($test['observation_frequency']*($k)) - 2;
                $allowed_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours', strtotime($test['start_date'])));
                
                if(strtotime($allowed_time) <= strtotime('now')) {
                    $f_observations['allowed'][$k] = 'Yes';
                } else {
                    //echo "1";exit;
                    $f_observations['allowed'][$k] = 'No';
                }
            }
            //$f_observations['allowed'][$k] = $allowed_time;
        } */
        
        /* echo "<pre>";
        print_r($f_observations);
        exit; */
        
        $data['observations'] = $f_observations;

        $this->load->model('Test_model');
        $allowed_chambers = explode(',', $this->session->userdata('chamber_ids'));
        $switch_chambers = $this->Test_model->get_chambers_by_part_test($test['part_id'], $test['test_id'], $allowed_chambers);
        $data['switch_chambers'] = $switch_chambers;
        
        $this->template->write_view('content', 'apps/on_going', $data);
        $this->template->render();
    }
    
    public function on_going_retest($code) {
        $data = array();
        $this->load->model('Apps_model');
		//Insert This row again in same table
		//$test_id = $tests['id'];
		/*
		$obs_res = $this->Apps_model->get_test_obv_by_test_id($test_id);
		//echo $this->db->last_query();
		foreach($obs_res as $obs){
			$res_obv[] = $this->Apps_model->copy_observations_by_id($obs['id']);
		}
		exit; */
		
		//Uncomment following line
		//`retest_started` 
		
		$test_code = $this->Apps_model->get_test_by_code($code);
		
		$test_code1 = $this->Apps_model->get_test_by_code_asc($code);		
		//print_r($test_code1['id']);exit;
		$d['retest_started'] = '1';
        $this->Apps_model->update_test($d,$test_code1['id']);   
		
		if(count($test_code)  < 2){
			
			$res = $this->Apps_model->copy_test_by_code($code);
			$result_test = $this->Apps_model->get_test_by_id($res);
			$update_data['start_date'] = date('Y-m-d H:i:s');
            $update_data['end_date'] = date('Y-m-d H:i:s', strtotime('+'.($result_test['duration']).' hours'));
			// $update_data['end_date']
            $this->Apps_model->update_test($update_data,$res);   
		 
		}
		//exit;
		$data['test'] = $this->Apps_model->on_going_retest($this->chamber_ids, date('Y-m-d'), $code);
		
		//echo '<pre>';print_r($data['test']);exit;
		
	
		//End Insertion
		
        if(empty($data['test'])) {
            redirect(base_url());
        }
        
        $test = $data['test'];
        
		if($test['id'] && count($test_code)  < 2) 
		{
			//Uncomment this ->
			$this->Apps_model->add_retest_observation(array('observation_index' => 0, 'test_id' => $test['id']));
			
		} 
		
		//exit;
        $total_duration = strtotime($test['end_date'])-strtotime($test['start_date']);
        $total_duration = $total_duration/3600;
        
        $duration_completed = strtotime(date('Y-m-d H:i:s'))-strtotime($test['start_date']);
        $duration_completed = $duration_completed/3600;

        $data['progress'] = round(($duration_completed/$total_duration)*100, 1);
        if($data['progress'] > 100) {
            $data['progress'] = 100;
        }
        
        $observations = $this->Apps_model->get_observations($test['id']);
		/* echo $this->db->last_query();
		echo '<pre>';print_r($observations);exit;
         */
		$f_observations = array();
        
        $total_obs = $test['no_of_observations']*$test['samples'];
        foreach($observations as $ob_key => $ob) {
            foreach($ob as $col => $val) {
                if(!isset($f_observations[$col])) {
                    $f_observations[$col] = array_fill(0, $total_obs, '');
                }
                $f_observations[$col][$ob['observation_index']] = $val;
            }
        }
        
        if(!isset($f_observations['allowed'])) {
            $f_observations['allowed'] = array_fill(0, $total_obs, '');
        }
        
        $s = 0;
        for($i = 0; $i < $test['no_of_observations']; $i++) {
            for($y = 0; $y < $test['samples']; $y++) {
                $f_observations['sample'][] = $y+1;
            }
                
            if($i === 0) {
                for($z = 0; $z < $test['samples']; $z++) {
                    $f_observations['allowed'][$s] = 'Yes';
                    $s++;
                }
            } else {
                $dur = ($test['observation_frequency']*($i)) - 2;
                $allowed_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours', strtotime($test['start_date'])));
                
                if(strtotime($allowed_time) <= strtotime('now')) {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'Yes';
                        $s++;
                    }
                } else {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'No';
                        $s++;
                    }
                }
            }
        }

        
        $data['observations'] = $f_observations;

        $this->load->model('Test_model');
        $allowed_chambers = explode(',', $this->session->userdata('chamber_ids'));
        $switch_chambers = $this->Test_model->get_chambers_by_part_test($test['part_id'], $test['test_id'], $allowed_chambers);
        $data['switch_chambers'] = $switch_chambers;
        
        $this->template->write_view('content', 'apps/on_going', $data);
        $this->template->render();
    }
    
    public function view_test_ajax($code) {
        $data = array();
        $this->load->model('Apps_model');
        $data['test'] = $this->Apps_model->get_test($code);
		//echo $code.'<pre>';print_r($data['test']);exit;
        if(empty($data['test'])) {
            redirect(base_url());
        }
        
        $test = $data['test'];
        
        $total_duration = strtotime($test['end_date'])-strtotime($test['start_date']);
        $total_duration = $total_duration/3600;
        
        $duration_completed = strtotime(date('Y-m-d H:i:s'))-strtotime($test['start_date']);
        $duration_completed = $duration_completed/3600;

        $data['progress'] = round(($duration_completed/$total_duration)*100, 1);
        if($data['progress'] > 100) {
            $data['progress'] = 100;
        }
        $observations = $this->Apps_model->get_observations($test['id']);
		//print_r($observations);exit;
        $f_observations = array();
        
        $total_obs = $test['no_of_observations']*$test['samples'];
        foreach($observations as $ob_key => $ob) {
            foreach($ob as $col => $val) {
                if(!isset($f_observations[$col])) {
                    $f_observations[$col] = array_fill(0, $total_obs, '');
                }
                $f_observations[$col][$ob['observation_index']] = $val;
            }
        }
        
        if(!isset($f_observations['allowed'])) {
            $f_observations['allowed'] = array_fill(0, $total_obs, '');
        }
        
        $s = 0;
        for($i = 0; $i < $test['no_of_observations']; $i++) {
            for($y = 0; $y < $test['samples']; $y++) {
                $f_observations['sample'][] = $y+1;
            }
                
            if($i === 0) {
                for($z = 0; $z < $test['samples']; $z++) {
                    $f_observations['allowed'][$s] = 'Yes';
                    $s++;
                }
            } else {
                $dur = ($test['observation_frequency']*($i)) - 2;
                $allowed_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours', strtotime($test['start_date'])));
                
                if(strtotime($allowed_time) <= strtotime('now')) {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'Yes';
                        $s++;
                    }
                } else {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'No';
                        $s++;
                    }
                }
            }
        }
        
        $data['observations'] = $f_observations;

        $this->load->model('Test_model');
        $allowed_chambers = explode(',', $this->session->userdata('chamber_ids'));
        $switch_chambers = $this->Test_model->get_chambers_by_part_test($test['part_id'], $test['test_id'], $allowed_chambers);
        $data['switch_chambers'] = $switch_chambers;
        
        $this->load->view('reports/view_test',$data);
    }
    public function view_test_ajax_completed($code) {
        $data = array();
        $this->load->model('Apps_model');
        $data['test'] = $this->Apps_model->get_test($code);
        if(empty($data['test'])) {
            redirect(base_url());
        }
        
        $test = $data['test'];
        
        $total_duration = strtotime($test['end_date'])-strtotime($test['start_date']);
        $total_duration = $total_duration/3600;
        
        $duration_completed = strtotime(date('Y-m-d H:i:s'))-strtotime($test['start_date']);
        $duration_completed = $duration_completed/3600;

        $data['progress'] = round(($duration_completed/$total_duration)*100, 1);
        if($data['progress'] > 100) {
            $data['progress'] = 100;
        }
        $observations = $this->Apps_model->get_observations($test['id']);
        $f_observations = array();
        
        $total_obs = $test['no_of_observations']*$test['samples'];
        foreach($observations as $ob_key => $ob) {
            foreach($ob as $col => $val) {
                if(!isset($f_observations[$col])) {
                    $f_observations[$col] = array_fill(0, $total_obs, '');
                }
                $f_observations[$col][$ob['observation_index']] = $val;
            }
        }
        
        if(!isset($f_observations['allowed'])) {
            $f_observations['allowed'] = array_fill(0, $total_obs, '');
        }
        
        $s = 0;
        for($i = 0; $i < $test['no_of_observations']; $i++) {
            for($y = 0; $y < $test['samples']; $y++) {
                $f_observations['sample'][] = $y+1;
            }
                
            if($i === 0) {
                for($z = 0; $z < $test['samples']; $z++) {
                    $f_observations['allowed'][$s] = 'Yes';
                    $s++;
                }
            } else {
                $dur = ($test['observation_frequency']*($i)) - 2;
                $allowed_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours', strtotime($test['start_date'])));
                
                if(strtotime($allowed_time) <= strtotime('now')) {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'Yes';
                        $s++;
                    }
                } else {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'No';
                        $s++;
                    }
                }
            }
        }
        
        $data['observations'] = $f_observations;

        $this->load->model('Test_model');
        $allowed_chambers = explode(',', $this->session->userdata('chamber_ids'));
        $switch_chambers = $this->Test_model->get_chambers_by_part_test($test['part_id'], $test['test_id'], $allowed_chambers);
        $data['switch_chambers'] = $switch_chambers;
        // echo '<pre>';print_r($data);exit;
        // $this->load->view('reports/view_test',$data);
        $this->load->view('apps/completed_test',$data);
        //$this->template->write_view('content', 'apps/on_going', $data);
        //$this->template->render();
    }
    
    public function mark_as_abort($code) {
        $this->load->model('Apps_model');
        $on_going = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), $code);
        if(empty($on_going)) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        $response = $this->Apps_model->update_test(array('aborted' => 1), $on_going['id']);
        if($response) {
            $this->session->set_flashdata('success', 'Test successfully marked aborted.');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
    public function mark_as_complete($code) {
		// print_r($_FILES);exit;
        $this->load->model('Apps_model');
        $on_going = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), $code);
        if(empty($on_going)) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        
        if($on_going_test['no_of_observations'] != $on_going_test['observation_done']) {
            $this->session->set_flashdata('error', 'Please fill all the required observation.');
            redirect(base_url().'apps/on_going/'.$code);
        }
        
        $response = $this->Apps_model->update_test(array('completed' => 1), $on_going['id']);
        if($response) {
            $this->session->set_flashdata('success', 'Test successfully marked completed.');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
	public function mark_as_skiped($code) {
		// print_r($_FILES);exit;
        $this->load->model('Apps_model');
        $on_going = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), $code);
        if(empty($on_going)) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Apps_model->update_test(array('skip_test' => 1,'skip_remark' => $this->input->post('skip_remark'),'completed' => 1), $on_going['id']);
        if($response) {
            $this->session->set_flashdata('success', 'Test successfully Skiped. Go for another Test');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    public function mark_as_approved($code) {
		//echo $code;exit;
		$this->load->model('Apps_model');
		$post_data = $this->input->post();
		$remark = $post_data['appr_test_remark'];
        $comp_test = $this->Apps_model->completed_test($_SESSION['product_switch']['id'],date('Y-m-d'), $code);//product_id->2
        /* echo '<pre>';print_r($comp_test);
		exit; */
		if(empty($comp_test)) {
            redirect($_SERVER['HTTP_REFERER']);
        }
        $response = $this->Apps_model->update_test(array('appr_test_remark' => $remark ,'is_approved' => 1,'approved_by' => $this->session->userdata('name')), $comp_test['id']);
		//echo $response." ". $comp_test['id'];print_r($comp_test);exit;
        if($response) {
            $this->session->set_flashdata('success', 'Test successfully marked Approved.');
            redirect(base_url().'dashboard/approver_dashboard');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
	public function sent_to_retest($code) {
        $this->load->model('Apps_model');
		
		$post_data = $this->input->post();
		$remark = $post_data['retest_remark'];
				
        /* $on_going = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), $code);
        if(empty($on_going)) {
            redirect($_SERVER['HTTP_REFERER']);
        } 
        $response = $this->Apps_model->update_test(array('aborted' => 1), $on_going['id']);
		*/
        $comp_test = $this->Apps_model->completed_test($_SESSION['product_switch']['id'],date('Y-m-d'), $code);
		//echo '<pre>';print_r($comp_test);exit;
        if(empty($comp_test)) {
            redirect($_SERVER['HTTP_REFERER']);
        }
		
		//Store Retest ID to link old test
		$response = $this->Apps_model->update_test(array('retest_id' => $comp_test['id'] ,'retest_remark' => $remark, 'approved_by' => '','completed' => 0,'is_approved' => 0), $comp_test['id']);
		
		
		
		
        //$response = $this->Apps_model->update_test(array('retest_remark' => $remark 'approved_by' => '','is_approved' => 0), $comp_test['id']);
		 //echo $code.$this->db->last_query();
		// echo $response;
		// exit;
        if($response) {
            $this->session->set_flashdata('success', 'Test successfully marked for retest.');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
	
    public function extent_test($code) {
        if($this->input->post('extended_hrs')) {

            $this->load->model('Apps_model');
            $on_going = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), $code);
            if(empty($on_going)) {
                redirect($_SERVER['HTTP_REFERER']);
            }
            
            $update_data = array();
            $update_data['extended_hrs'] = $this->input->post('extended_hrs');
            $update_data['duration'] = $on_going['duration'] + $this->input->post('extended_hrs');
            $update_data['extended_on'] = date('Y-m-d H:i:s');
            $update_data['end_date'] = date('Y-m-d H:i:s', strtotime('+'.$this->input->post('extended_hrs').' hours', strtotime($on_going['end_date'])));
            
            $response = $this->Apps_model->update_test($update_data, $on_going['id']);
            if($response) {
                $this->session->set_flashdata('success', 'Test successfully Extended.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            }
            
        }
        
        redirect(base_url().'apps/on_going/'.$code);
    }
    
    public function switch_test_chamber($code) {
        if($this->input->post('chamber_id')) {
            $this->load->model('Apps_model');
            $on_going = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), $code);
            if(empty($on_going)) {
                redirect($_SERVER['HTTP_REFERER']);
            }
            
            $update_data = array();
            $update_data['chamber_id'] = $this->input->post('chamber_id');
            $update_data['switched_on'] = date('Y-m-d H:i:s');
            $update_data['switched_from'] = $on_going['chamber_id'];
            
            $response = $this->Apps_model->update_test($update_data, $on_going['id']);
            if($response) {
                $this->session->set_flashdata('success', 'Test Chamber successfully Switched.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            }
            
        }
        
        redirect(base_url().'apps/on_going/'.$code);
    }
    
    public function add_observation($code) {
		//echo $code.'<pre>';print_r($this->input->post());exit;
        if($this->input->post()) {
            $post_data = $this->input->post();
			
				//test Image Upload
				$test_img = $_FILES['test_img']['name'];      
				$fullpath = 'assets/test_images/';				
				if($_FILES['test_img']['name'] != '') {			
					$config['upload_path'] = $fullpath;
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['file_name'] = $_FILES['test_img']['name'];
					
					//Load upload library and initialize configuration
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('test_img')){
						$uploadData = $this->upload->data();
						$test_img = $uploadData['file_name'];
					}
				}
							
				//End Image Upload
				
			
            $this->load->model('Apps_model');
            $on_going = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), $code);
			//print_r($on_going);exit;
            if(empty($on_going)) {
                redirect($_SERVER['HTTP_REFERER']);
            }
			if($test_img){
				$post_data['test_img'] = $test_img;
				$test_image['test_img'] = $test_img;
				$this->Apps_model->update_test($test_image, $on_going['id']);
			}	
            
            $post_data['test_id'] = $on_going['id'];
            $post_data['observation_at'] = date('Y-m-d H:i:s');
            
            $observation_index = $post_data['observation_index'];
            $exists = $this->Apps_model->observation_index_exists($on_going['id'], $observation_index);
			/* print_r($exists);//exit;
			print_r($post_data);exit;
             */
            $id = !empty($exists) ? $exists['id'] : '';		
			
			
			$response = $this->Apps_model->add_observation($post_data, $id);
            if($response) {
				//Start Code for SMS in case of NG
				$r = strtoupper($post_data['observation_result']);
				if($r == 'NG'){
					//SMS needs to send to part Supplier in case of NG
					//print_r($on_going);exit;..will get part, supplier,test detail
					
					    $this->load->model('Product_model');
					    $this->load->model('user_model');
                        $phone_numbers = $this->Product_model->get_all_phone_numbers($on_going['supplier_id']);
						
						$sms = $on_going['supplier_name']." PRTMS - Inspn Rslt NG<br>Part No. -".$on_going['part_no']."(".$on_going['test_name'];
                        $sms .= ")<br>Defect-".$on_going['test_judgement'];
                            
                        if(!empty($phone_numbers)) {
                            $to = array();
							
                            foreach($phone_numbers as $phone_number) {
                                $to[] = $phone_number['phone_number'];
                            }
                            
                            $to = implode(',', $to);
                            $ip_address = $this->get_server_ip();
                            if($ip_address == '202.154.175.50'){
                                
                                if(isset($to) && isset($sms)){
                                    $sms1= urlencode($sms);
                                    $to1 = urlencode($to);
                                    $data = array('to' => $to1, 'sms' => $sms1);
                                    $url = "http://10.101.0.80:90/PRTMS/apps/send_sms_redirect";    	
                                    //$url = "http://localhost/PRTMS_NEW/apps/send_sms_redirect";    	

                                    $ch = curl_init();
                                            curl_setopt_array($ch, array(
                                            CURLOPT_URL => $url,
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_POSTFIELDS => $data,
                                    ));
                                    //get response
                                    $output = curl_exec($ch);
                                    $flag = true;
                                    //Print error if any
                                    if(curl_errno($ch))
                                    {
                                            $flag = false;
                                    }
                                    curl_close($ch);
                                }
                            }else{
                                $this->send_sms($to, $sms);
                            }
                        }
							///NG mail MAil
							//echo 'hi';exit;
							$users = $this->user_model->get_users_admins_productwise($on_going['product_id'],$this->session->userdata('username'));
							/*  echo $tdis->db->last_query();
							print_r($users);exit; 
							  */foreach($users as $user) {
								
								$toemail = $user['email_id'];
								$subject = "PRTMS - NG Part - ".$on_going['part_no'];
								$mail_content = "Hello All,<br>".
								"
								<br><br>
								<html>
									<body>
									<b>PRTMS Inspection Result - NG mail</b>	<br><br><br>							
									<table style='text-align:left'>
										<tr>
											<th>Part No.</th> 
											<td>".$on_going['part_no']."</td>
										</tr>									  
										<tr>									  
											<th>Supplier </th>
											<td>".$on_going['supplier_name']."</td>
										</tr>
										<tr>
											 <th>Inspector </th>
											<td>".$user['first_name']." ".$user['first_name']."</td>
										</tr>
										<tr>
											<th>Test Name </th>
											<td>".$on_going['test_name']."</td>
										</tr>
										<tr>
											<th>Test Judgment </th>
											<td>".$on_going['test_judgement']."</td>									   
										</tr>
									</table>
								</body>
								</html>
								"."<br><br>Thanks,<br>PRTMS Administrator,<br>LG Electronics, Pune<br><br><br><br>
								<i>(This is system genrated mail. Please do not reply.)</i>
								";
								$this->sendMail($toemail,$subject,$mail_content);
								//echo $mail_content;exit;
							}
							//End mail
                    
				}
				//End Code for SMS in case of NG
				$this->session->set_flashdata('success', 'Test Observation successfully Recorded.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            }
        }
        
        redirect(base_url().'apps/on_going/'.$code);
    }
    
    public function add_retest_observation($code) {
		//print_r($this->input->post());exit;
        if($this->input->post()) {
            $post_data = $this->input->post();
			
				//test Image Upload
				$test_img = $_FILES['test_img']['name'];      
				$fullpath = 'assets/test_images/';				
				if($_FILES['test_img']['name'] != '') {			
					$config['upload_path'] = $fullpath;
					$config['allowed_types'] = 'jpg|jpeg|png|gif';
					$config['file_name'] = $_FILES['test_img']['name'];
					
					//Load upload library and initialize configuration
					$this->load->library('upload',$config);
					$this->upload->initialize($config);
					
					if($this->upload->do_upload('test_img')){
						$uploadData = $this->upload->data();
						$test_img = $uploadData['file_name'];
					}
				}
							
				//End Image Upload
				
			
            $this->load->model('Apps_model');
            $on_going = $this->Apps_model->on_going_retest($this->chamber_ids, date('Y-m-d'), $code);
			//print_r($on_going);exit;
            if(empty($on_going)) {
                redirect($_SERVER['HTTP_REFERER']);
            }
            if($test_img){
				$post_data['test_img'] = $test_img;
				$test_image['test_img'] = $test_img;
				$this->Apps_model->update_test($test_image, $on_going['id']);
		
			}	

            $post_data['test_id'] = $on_going['id'];
            $post_data['observation_at'] = date('Y-m-d H:i:s');
            
            $observation_index = $post_data['observation_index'];
            $exists = $this->Apps_model->observation_index_exists($on_going['id'], $observation_index);
            
            $id = !empty($exists) ? $exists['id'] : '';		
			
			
			$response = $this->Apps_model->add_observation($post_data, $id);
            if($response) {
				//Start Code for SMS in case of NG
				if($post_data['observation_result'] == 'NG'){
					//SMS needs to send to part Supplier in case of NG
					//print_r($on_going);exit;..will get part, supplier,test detail
					
					    $this->load->model('Product_model');
					    $this->load->model('user_model');
                        $phone_numbers = $this->Product_model->get_all_phone_numbers($on_going['supplier_id']);
						
						$sms = $on_going['supplier_name']." PRTMS - Inspn Rslt NG<br>Part No. -".$on_going['part_no']."(".$on_going['test_name'];
                        $sms .= ")<br>Defect-".$on_going['test_judgement'];
                            
                        if(!empty($phone_numbers)) {
                            $to = array();
							
                            foreach($phone_numbers as $phone_number) {
                                $to[] = $phone_number['phone_number'];
                            }
                            
                            $to = implode(',', $to);
                            $ip_address = $this->get_server_ip();
                            if($ip_address == '202.154.175.50'){
                                
                                if(isset($to) && isset($sms)){
                                    $sms1= urlencode($sms);
                                    $to1 = urlencode($to);
                                    $data = array('to' => $to1, 'sms' => $sms1);
                                    $url = "http://10.101.0.80:90/PRTMS/apps/send_sms_redirect";    	
                                    //$url = "http://localhost/PRTMS_NEW/apps/send_sms_redirect";    	

                                    $ch = curl_init();
                                            curl_setopt_array($ch, array(
                                            CURLOPT_URL => $url,
                                            CURLOPT_RETURNTRANSFER => true,
                                            CURLOPT_POSTFIELDS => $data,
                                    ));
                                    //get response
                                    $output = curl_exec($ch);
                                    $flag = true;
                                    //Print error if any
                                    if(curl_errno($ch))
                                    {
                                            $flag = false;
                                    }
                                    curl_close($ch);
                                }
                            }else{
                                $this->send_sms($to, $sms);
                            }
                        }
							///NG mail MAil
							//echo 'hi';exit;
							$users = $this->user_model->get_users_admins_productwise($on_going['product_id'],$this->session->userdata('username'));
							/*  echo $tdis->db->last_query();
							print_r($users);exit; 
							  */foreach($users as $user) {
								
								$toemail = $user['email_id'];
								$subject = "PRTMS - NG Part - ".$on_going['part_no'];
								$mail_content = "Hello All,<br>".
								"
								<br><br>
								<html>
									<body>
									<b>PRTMS Inspection Result - NG mail</b>	<br><br><br>							
									<table style='text-align:left'>
										<tr>
											<th>Part No.</th> 
											<td>".$on_going['part_no']."</td>
										</tr>									  
										<tr>									  
											<th>Supplier </th>
											<td>".$on_going['supplier_name']."</td>
										</tr>
										<tr>
											 <th>Inspector </th>
											<td>".$user['first_name']." ".$user['first_name']."</td>
										</tr>
										<tr>
											<th>Test Name </th>
											<td>".$on_going['test_name']."</td>
										</tr>
										<tr>
											<th>Test Judgment </th>
											<td>".$on_going['test_judgement']."</td>									   
										</tr>
									</table>
								</body>
								</html>
								"."<br><br>Thanks,<br>PRTMS Administrator,<br>LG Electronics, Pune<br><br><br><br>
								<i>(This is system genrated mail. Please do not reply.)</i>
								";
								$this->sendMail($toemail,$subject,$mail_content);
								//echo $mail_content;exit;
							}
							//End mail
                    
				}
				//End Code for SMS in case of NG
				$this->session->set_flashdata('success', 'Test Observation successfully Recorded.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            }
        }
        
        redirect(base_url().'apps/on_going_retest/'.$code);
    }
    
    public function get_suppliers_by_part() {
        $data = array('suppliers' => array());
        
        if($this->input->post('part')) {
            $this->load->model('Supplier_model');
            $data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($this->input->post('part'));

            $this->load->model('Product_model');
            $part = $this->Product_model->get_product_part($this->input->post('product'), $this->input->post('part'));

            $this->load->model('Test_model');
            // $data['tests'] = $this->Test_model->get_tests_by_part_chamber($part['id'], $this->input->post('chamber'));
            $data['tests'] = $this->Test_model->get_tests_by_part_chamber($part['id'], $this->input->post('chamber'));
        }
        
        echo json_encode($data);
    }
	public function get_tests_by_partid() {
        $data = array('tests' => array());
        
        if($this->input->post('part')) {
            $this->load->model('Test_model');
            // $data['tests'] = $this->Test_model->get_tests_by_part_chamber($part['id'], $this->input->post('chamber'));
            // $data['tests'] = $this->Test_model->get_tests_by_part($this->input->post('part'),$this->input->post('product'));
            $data['tests'] = $this->Test_model->get_tests_by_part($this->input->post('part'));
        }
        
        echo json_encode($data);
    }
    
    public function get_test_duration() {
        $data = array('test' => array());
        
        if($this->input->post('test')) {
            $this->load->model('Test_model');
            $data['test'] = $this->Test_model->get_test($this->input->post('test'));
        }
        
        echo json_encode($data);
    }
	
	 public function view_completed_test($code) {
        $data = array();
        $this->load->model('Apps_model');
        $data['test'] = $this->Apps_model->view_completed_test($this->chamber_ids, date('Y-m-d'), $code);
		//echo '<pre>';print_r($data['test']);exit;
        if(empty($data['test'])) {
            redirect(base_url());
        }
        
        $test = $data['test'];
        
        $total_duration = strtotime($test['end_date'])-strtotime($test['start_date']);
        $total_duration = $total_duration/3600;
        
        $duration_completed = strtotime(date('Y-m-d H:i:s'))-strtotime($test['start_date']);
        $duration_completed = $duration_completed/3600;

        $data['progress'] = round(($duration_completed/$total_duration)*100, 1);
        if($data['progress'] > 100) {
            $data['progress'] = 100;
        }
        
        $observations = $this->Apps_model->get_observations($test['id']);
        $f_observations = array();
        
        $total_obs = $test['no_of_observations']*$test['samples'];
        foreach($observations as $ob_key => $ob) {
            foreach($ob as $col => $val) {
                if(!isset($f_observations[$col])) {
                    $f_observations[$col] = array_fill(0, $total_obs, '');
                }
                $f_observations[$col][$ob['observation_index']] = $val;
            }
        }
        
        if(!isset($f_observations['allowed'])) {
            $f_observations['allowed'] = array_fill(0, $total_obs, '');
        }
        
        $s = 0;
        for($i = 0; $i < $test['no_of_observations']; $i++) {
            for($y = 0; $y < $test['samples']; $y++) {
                $f_observations['sample'][] = $y+1;
            }
                
            if($i === 0) {
                for($z = 0; $z < $test['samples']; $z++) {
                    $f_observations['allowed'][$s] = 'Yes';
                    $s++;
                }
            } else {
                $dur = ($test['observation_frequency']*($i)) - 2;
                $allowed_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours', strtotime($test['start_date'])));
                
                if(strtotime($allowed_time) <= strtotime('now')) {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'Yes';
                        $s++;
                    }
                } else {
                    for($z = 0; $z < $test['samples']; $z++) {
                        $f_observations['allowed'][$s] = 'No';
                        $s++;
                    }
                }
            }
        }

        /* foreach($f_observations['allowed'] as $k => $v) {
            if($k === 0) {
                $f_observations['allowed'][0] = 'Yes';
            } else {
                $dur = ($test['observation_frequency']*($k)) - 2;
                $allowed_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours', strtotime($test['start_date'])));
                
                if(strtotime($allowed_time) <= strtotime('now')) {
                    $f_observations['allowed'][$k] = 'Yes';
                } else {
                    //echo "1";exit;
                    $f_observations['allowed'][$k] = 'No';
                }
            }
            //$f_observations['allowed'][$k] = $allowed_time;
        } */
        
        /* echo "<pre>";
        print_r($f_observations);
        exit; */
        
        $data['observations'] = $f_observations;

        $this->load->model('Test_model');
        $allowed_chambers = explode(',', $this->session->userdata('chamber_ids'));
        $switch_chambers = $this->Test_model->get_chambers_by_part_test($test['part_id'], $test['test_id'], $allowed_chambers);
        $data['switch_chambers'] = $switch_chambers;
        
        $this->template->write_view('content', 'apps/completed_test', $data);
        $this->template->render();
    }
   
   public function send_sms_redirect() {
        $user = 'Lgelectronic';
        $password = 'Sid2014!';
        $sender = "LGEILP";
        
        $sms = $this->input->post('sms');
        $to = $this->input->post('to');
        $message = $sms;

        //API URL
        $url="http://193.105.74.58/api/v3/sendsms/plain?user=".$user."&password=".$password."&sender=".$sender."&SMSText=".$message."&GSM=".$to;
        
        // init the resource
        $ch = curl_init();
        
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ));

        //get response
        $output = curl_exec($ch);

        $flag = true;
        //Print error if any
        if(curl_errno($ch))
        {
            $flag = false;
        }
        
        curl_close($ch);
        redirect($_SERVER['HTTP_REFERER']);
    }
	
	
	function submit_appr_image(){
		 print_r($this->input->post('formData'));
		exit; 
		if($this->input->post()){

            $this->load->model('Test_model');
            $test = $this->Test_model->get_test($this->input->post('test_id'));
            print_r($test);exit;
           /*  if($this->input->post('all_results') == 'NP'){
                //echo "here 1";
                $data['all_results'] = $this->input->post('all_results');
                $data['all_values'] = '';
                $data['result'] = $this->input->post('all_results');
            }else if($this->input->post('all_values') == 'NP'){
                //echo "here 2";
                $data['all_results'] = '';
                $data['all_values'] = $this->input->post('all_values');
                $data['result'] = $this->input->post('all_values');
            }else{
                //echo "here 3 ".$this->input->post('all_results')."end ";
                if($this->input->post('all_results') === '0'){
                    echo "here 4";
                    $data['all_results'] = '';
                    $data['all_values'] = $this->input->post('all_values');
                    if(($this->input->post('all_values') > $checkpoint['usl']) || ($this->input->post('all_values') < $checkpoint['lsl'])){
                        $data['result'] = 'NG';
                    }else{
                        $data['result'] = 'OK';
                    }
                }else{
                    //echo "here 5";
                    $data['all_results'] = $this->input->post('all_results');
                    $data['all_values'] = '';
                    $data['result'] = $this->input->post('all_results');
                }
            } */
            
            //$post    = $this->input->post('image');
            //$post    = json_decode($post, true);
            if($_FILES){
                $upload = $this->upload_image($_FILES);
                if($upload){
                    $data['image'] = $_FILES['image']['name'];
                }else{
                    return false;
                }
            }else{
                $data['image'] = '';
            }
            
            //print_r($data);
            
            $data = array_merge($test_id,$data);
            
            $this->foolproof_model->insert_result($data);
            //echo $this->db->last_query();
            return true;
            //redirect($_SERVER['HTTP_REFERER']);
        }else{
            return false;
        }
	}
    
    function upload_image($image){
        $target_dir = "assets/test_images/";
        $target_file = $target_dir . basename($image['image']['name']);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        $check = getimagesize($image['image']['tmp_name']);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            move_uploaded_file($image['image']['tmp_name'], $target_file);
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        
        return $uploadOk;
    }
	function test()
	{
		$this->load->model('product_model');
		$this->product_model->get_part_numbers_by_name(2,'Motor AC');
		echo $this->db->last_query();exit;
	}
    
}
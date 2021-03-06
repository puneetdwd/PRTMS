<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct(true);
        //echo $this->chamber_ids;
        //render template
        $this->template->write('title', 'PRTMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header');
        $this->template->write_view('footer', 'templates/footer');
			//echo 'hi testdfxs'.$this->user_type;exit;

    }

    public function index() {
			$data = array();
        if($this->user_type == 'Admin') {
            $this->load->model('Apps_model');
            $data['on_going_tests'] = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'));
			
            $this->template->write_view('content', 'dashboard', $data);
            $this->template->render();

            //$filters['product_id'] = $this->product_id;

		} else if($this->user_type == 'Chamber') {
            $data = $this->chamber_dashboard();            
            $this->template->write_view('content', 'chamber_dashboard', $data);
            $this->template->render();
        }
		else if($this->user_type == 'Approver') {
			//echo 'Hi Approver';exit;
            $data = $this->approver_dashboard();
            
            /* $this->template->write_view('content', 'approver_dashboard', $data);
            $this->template->render(); */ 
        }
		else if($this->user_type == 'Product') {
			redirect(base_url().'reports/completed_test_report');			
        }
		else if($this->user_type == 'Testing') {
			redirect(base_url().'plans/display'); // logged in redirect to index page.
        }
		else if($this->user_type == 'SQA') {
			//echo 'Hi Approver';
            // $data = $this->sqa_dashboard();
            $data = array();
            $this->template->write_view('content', 'sqa_dashboard', $data);
            $this->template->render(); 
        }
    }
    
    public function dashboard_screen($page = 1) {
        $data = array();
        $this->load->model('Apps_model');
        
        $per_page = 9;
        $limit = ' LIMIT '.($page-1)*$per_page.', '.$per_page;
        $data['on_going_tests'] = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), '', $limit);
        $gt = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'));
		//to calculate smiley status
		$s=0;$w=0;$d=0;
		foreach($gt as $on_going_test) { 
			if($on_going_test['no_of_observations'] == ($on_going_test['observation_done']/$on_going_test['samples']))
			{
				//echo 1;
				//$class = 'fa fa-smile-o text-success';
				//$div_class = '';
				$s++;
			} else if($on_going_test['max_index'] !== '0' && $on_going_test['observation_done'] != ($on_going_test['max_index'] + 1)) {
				//echo 2;
				//$class = 'fa fa-frown-o text-danger';
				//$div_class = 'dashboard-noti-danger';
				$d++;
			} else if($on_going_test['max_index'] === '0' && empty($on_going_test['max_observation_at'])) {
				//echo 3;
				//$class = 'fa fa-frown-o text-danger';
				//$div_class = 'dashboard-noti-danger';
				$d++;
			} else {
				//echo 4;
				$color = '';
				
				$key = $on_going_test['max_index'];				
				$key = floor($key/$on_going_test['samples']);
				
				$dur = ($on_going_test['observation_frequency']*($key+1)); 
				$ob_time = date('Y-m-d H:i:s', strtotime('+'.$dur.' hours',strtotime($on_going_test['start_date'])));
				
				$diff = strtotime($ob_time)- strtotime(date('Y-m-d H:i:s'));
				//echo $ob_time.' '.($diff/3600).' ';
				//echo $on_going_test['observation_frequency'].' '.$key;
				if($diff < 0) {
					//$class = 'fa fa-frown-o text-danger';
					//$div_class = 'dashboard-noti-danger';
					$d++;
				} else {
					$diff = $diff/3600;
					if($diff < 2) {
						//$class = 'fa fa-meh-o text-warning';
						//$div_class = 'dashboard-noti-warning';
						$w++;
					} else {
						
						//$class = 'fa fa-smile-o text-success';
						//$div_class = '';
						$s++;
					}
				}
			}
		}
		$data['d'] = $d;
		$data['s'] = $s;
		$data['w'] = $w;
		//to calculate smiley status
		
		if (!$this->input->is_ajax_request()) {
            $count = $this->Apps_model->on_going_test_count($this->chamber_ids);
            //echo $this->db->last_query();exit;
            $data['total'] = ceil($count/$per_page);
            $this->template->write_view('content', 'dashboard_screen', $data);
            $this->template->render();
        } else {
            $this->load->view('dashboard_screen_ajax', $data);
        }
    }
    
    public function change_date($code) {
        $this->load->model('Apps_model');
        $on_going = $this->Apps_model->on_going_test($this->chamber_ids, '', $code);
        if(empty($on_going)) {
            return false;
        }
        
        if($this->input->post('start_date')) {
            
            $update_data = array();
            $update_data['start_date'] = $this->input->post('start_date').' '.date('H:i:s');
            $update_data['end_date'] = date('Y-m-d H:i:s', strtotime('+'.$on_going['duration'].' hours', strtotime($update_data['start_date'])));
            
            $response = $this->Apps_model->update_test($update_data, $on_going['id']);
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

    private function chamber_dashboard() {
        $data = array();
        $this->load->model('Apps_model');
        $data['on_going_tests'] = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'));
		//echo "<pre>";print_r($data['on_going_tests']);exit;
        // echo $this->db->last_query();exit;
        return $data;
    }

	public  function approver_dashboard() {
        $data = array();
        $this->load->model('Apps_model');
        $this->load->model('Product_model');
		if(empty($_SESSION['product_switch']['id']))
		{
			$product = $this->Product_model->get_product(1);		
			$_SESSION['product_switch'] = $product;
		}
        $data['completed_tests'] = $this->Apps_model->completed_test($_SESSION['product_switch']['id'], date('Y-m-d'));$this->template->write_view('content', 'approver_dashboard', $data);
		// echo '<pre>';print_r($data['completed_tests'] );exit;
        $this->template->render();  
       
    }
}
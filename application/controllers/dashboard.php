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
			//echo 'Hi Approver';
            $data = $this->approver_dashboard();
            
            $this->template->write_view('content', 'approver_dashboard', $data);
            $this->template->render(); 
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
        
        $per_page = 10;
        $limit = ' LIMIT '.($page-1)*$per_page.', '.$per_page;
        $data['on_going_tests'] = $this->Apps_model->on_going_test($this->chamber_ids, date('Y-m-d'), '', $limit);
        echo "<pre>";print_r($data['on_going_tests']);exit;
        //echo $this->db->last_query();exit;
        if (!$this->input->is_ajax_request()) {
            $count = $this->Apps_model->on_going_test_count($this->chamber_ids);
            ///echo $this->db->last_query();exit;
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
        //echo $this->chamber_ids.$this->db->last_query();exit;
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
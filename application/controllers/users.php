<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');
    }

    public function index() {
        $this->is_admin_user();
        $this->load->model('User_model');
        $data['users'] = $this->User_model->get_all_users();
		//echo '<pre>';print_r($data['users']);exit;
        $this->template->write_view('content', 'users/index', $data);
        $this->template->render();
    }

    public function add($username = '') {
        $this->is_admin_user();
        $data = array();
        
        $this->load->model('Chamber_model');
        $data['chambers'] = $this->Chamber_model->get_all_chambers();
		
		$this->load->model('Product_model');
        $products = $this->Product_model->get_all_products();		
        $data['products'] = $products;
			
        $this->load->model('User_model');

        if(!empty($username)) {
            $user = $this->User_model->get_user($username);
            if(!$user)
                redirect(base_url().'users');

            $data['user'] = $user;
        }

        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
            $validate->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
            $validate->set_rules('username', 'Username', 'trim|required|xss_clean');
            $validate->set_rules('email_id', 'email_id', 'trim|required|xss_clean');

            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
                if(!empty($post_data['chamber_id'])) {
                    $post_data['chamber_id']    = implode(',', $post_data['chamber_id']);
                }
				if(!empty($post_data['product_id'])) {
                    $post_data['product_id']    = implode(',', $post_data['product_id']);
                }

                $id = !empty($user['id']) ? $user['id'] : '';

                $exists = $this->User_model->is_username_exists($post_data['username'], $id);
                if(!$exists){

                    $user_id = $this->User_model->update_user($post_data, $id);
                    if($user_id) {

                        $this->session->set_flashdata('success', 'User successfully added.');
                        redirect(base_url().'users');
                    } else {
                        $data['error'] = 'Something went wrong, Please try again.';
                    }

                } else {
                    $data['error'] = 'Username already exists.';
                }

            } else {
                $data['error'] = validation_errors();
            }
        }

				//print_r($data);exit;
        $this->template->write_view('content', 'users/add_user', $data);
        $this->template->render();
    }

    public function view($username) {
        $this->is_admin_user();
        $this->load->model('User_model');
        $user = $this->User_model->get_user($username);
        if(empty($user)) {
            redirect(base_url().'users');
        }
        $data['user'] = $user;

        $this->template->write_view('content', 'users/view_user', $data);
        $this->template->render();
    }

    public function login() {
        if($this->session->userdata('is_logged_in')) {
            redirect(base_url());
        }

        $data = array();

        if($this->input->post()) {
            $this->load->model('User_model');
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('username', 'Username', 'trim|required|xss_clean');
            $validate->set_rules('password', 'Password', 'trim|required|xss_clean');

            if($validate->run() === TRUE) {
                $response = $this->User_model->login_check($this->input->post('username'), $this->input->post('password'));

                if($response['status'] === 'SUCCESS') {
                    redirect(base_url().'dashboard'); // logged in redirect to index page.
                } else {
                   $data['error'] = $response['message'];
                }

            } else {
                $data['error'] = 'form_error';
            }

        }

        $this->load->view('users/login', $data);
    }

    public function logout() {
        $url = base_url().'login';

        //render template
        $this->session->destroy();
        redirect($url);
    }

    public function change_password() {
        $this->is_logged();
        $data = array();

        if($this->input->post()) {
            $this->load->model('User_model', 'User_model');
            $username = $this->session->userdata('username');

            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('old', 'Old Password', 'trim|required|xss_clean');
            $validate->set_rules('new', 'New Password', 'trim|required|xss_clean');
            $validate->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');

            if($validate->run() === TRUE) {
                $post_data = $this->input->post();

                if($post_data['new'] === $post_data['confirm_password']) {
                    $user = $this->User_model->login_check($username, $this->input->post('old'), true);

                    if($user) {
                        $changed = $this->User_model->change_password($this->id, $this->input->post('new'));

                        if($changed) {
                            $this->session->set_flashdata('success', 'Password successfully updated.');
                            redirect(base_url());
                        } else {
                            $data['error'] = 'Something went wrong, Please try again.';
                        }

                    } else {
                        $data['error'] = 'Old doesn\'t match, Please provide correct password';
                    }

                } else {
                    $data['error'] = 'New Password and Confirm Password doesn\'t match';
                }

            } else {
                $data['error'] = validation_errors();
            }
        }

        $this->template->write_view('content', 'users/change_password', $data);
        $this->template->render();
    }

    public function switch_chamber($chamber_id) {
        $this->load->model('Chamber_model');
        $chamber = $this->Chamber_model->get_chamber($chamber_id);
        if(empty($chamber)) {
            $this->session->set_flashdata('error', 'Invalid Chamber');
            redirect(base_url());
        }
        
        $chamber_ids = $this->session->userdata('chamber_ids');
        $chamber_ids = explode(',', $chamber_ids);
        if(!in_array($chamber_id, $chamber_ids)) {
            $this->session->set_flashdata('error', 'Access Denied.');
            redirect(base_url());
        }
        
        $this->session->set_userdata('chamber_id', $chamber['id']);
        $this->session->set_userdata('chamber_name', $chamber['name']);
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    
	 public function switch_product($product_id) {
		$this->load->model('Product_model');
        $product = $this->Product_model->get_product($product_id);
		//print_r($product);exit;
        if(empty($product)) {
            $this->session->set_flashdata('error', 'Invalid Product');
            redirect(base_url());
        }
        
        //echo $product_ids = $this->session->userdata('product_ids');exit;
        //$product_ids = explode(',', $product_ids);
        /* if(!in_array($product_id, $product_ids)) {
            $this->session->set_flashdata('error', 'Access Denied.');
            redirect(base_url());
        } */
        
		/* echo $this->session->set_userdata('product_id', $product['id']);
        echo $this->session->set_userdata('product_name', $product['name']);
         */
		$_SESSION['product_switch'] = $product;
		/* $product = $_SESSION['product_switch'];
		print_r($_SESSION['product_switch']);
        exit; */ 
			
		/* echo $this->session->set_userdata('product_id',1);
        echo $this->session->set_userdata('product_name', 'he');
         */
		
        redirect($_SERVER['HTTP_REFERER']);
    }
    
   
    public function status($username, $status) {
        $this->is_admin_user();
        $this->load->model('User_model');
        if($this->User_model->change_status($username, $status)) {
            $this->session->set_flashdata('success', 'User marked as '.$status);
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, Please try again.');
        }

        redirect(base_url().'users');
    }
}
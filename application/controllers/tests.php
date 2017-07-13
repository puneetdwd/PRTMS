<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tests extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true, 'Admin');

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $data = array();
        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();

        $this->template->write_view('content', 'tests/index', $data);
        $this->template->render();
    }
    
    public function add_test($test_id = '') {
        $data = array();
        $this->load->model('Test_model');
        
        if(!empty($test_id)) {
            $test = $this->Test_model->get_test($test_id);
            if(empty($test))
                redirect(base_url().'tests');

            $data['test'] = $test;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Test_model->add_test($post_data, $test_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Test successfully '.(($test_id) ? 'updated' : 'added').'.');
                redirect(base_url().'tests');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'tests/add_test', $data);
        $this->template->render();
    }
    
    public function ptc_mappings() {
        $data = array();
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        $data['parts'] = $this->Product_model->get_all_parts();
        
        $this->load->model('Chamber_model');
        $data['chambers'] = $this->Chamber_model->get_all_chambers();
        $data['categories'] = $this->Chamber_model->get_chamber_categories();
        
        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();
        
        $filters = $this->input->post() ? $this->input->post() : array() ;
        $data['ptc_mappings'] = $this->Test_model->get_ptc_mappings($filters);
        
        $this->template->write_view('content', 'tests/ptc_mappings', $data);
        $this->template->render();
    }
    
    public function add_ptc_mapping($ptc_mapping_id = '') {
        $data = array();
        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();
        
        $this->load->model('Chamber_model');
        $data['chambers'] = $this->Chamber_model->get_all_chambers();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        $this->load->model('Category_model');
        $data['categories'] = $this->Category_model->get_all_categories();
        
        if(!empty($ptc_mappings_id)) {
            $ptc_mapping = $this->Test_model->get_ptc_mapping($ptc_mapping_id);
            if(empty($ptc_mapping))
                redirect(base_url().'tests/ptc_mappings');

            $data['ptc_mapping'] = $ptc_mapping;
        }
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            $validate->set_rules('part_category_id', 'Part', 'trim|required|xss_clean');
            $validate->set_rules('test_id', 'Test', 'trim|required|xss_clean');
            $validate->set_rules('chamber_id', 'Chamber', 'required|xss_clean');
            
            if($validate->run() === TRUE) {
                $post_data = $this->input->post();
                echo "<pre>"; print_r($post_data); exit;
                $chambers = $this->input->post('chamber_id');
                $this->Test_model->delete_ptc_mapping_by_partcatgory_chamber(
                    $post_data['product_id'], $post_data['part_category_id'], $post_data['test_id'], $chambers);
                
                foreach($chambers as $chamber) {
                    $update_data = array();
                    $update_data['product_id'] = $post_data['product_id'];
                    $update_data['part_category_id'] = $post_data['part_category_id'];
                    $update_data['test_id'] = $post_data['test_id'];
                    $update_data['chamber_id'] = $chamber;
                    
                    $this->Test_model->add_ptc_mapping($update_data, $ptc_mapping_id);
                }
                
                $this->session->set_flashdata('success', 'Part-Test-Chamber Mapping successfully '.(($ptc_mapping_id) ? 'updated' : 'added').'.');
                redirect(base_url().'tests/ptc_mappings');
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $this->template->write_view('content', 'tests/add_ptc_mapping', $data);
        $this->template->render();
    }

    public function delete_ptc_mapping($ptc_mapping_id) {
        if(!empty($ptc_mapping_id)) {
            $this->load->model('Test_model');
            $this->Test_model->delete_ptc_mapping($ptc_mapping_id);
        }
        
        redirect(base_url().'tests/ptc_mappings');
    }
}
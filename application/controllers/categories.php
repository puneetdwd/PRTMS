<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true, 'Admin');

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $data = array();
        $this->load->model('Category_model');
        $data['categories'] = $this->Category_model->get_all_categories();

        $this->template->write_view('content', 'categories/index', $data);
        $this->template->render();
    }
    
    public function add_category($category_id = '') {
        $data = array();
        $this->load->model('Category_model');
        
        if(!empty($category_id)) {
            $category = $this->Category_model->get_category($category_id);
            if(empty($category))
                redirect(base_url().'categories');

            $data['category'] = $category;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Category_model->add_category($post_data, $category_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Part Category successfully '.(($category_id) ? 'updated' : 'added').'.');
                redirect(base_url().'categories');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'categories/add_category', $data);
        $this->template->render();
    }
    
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chambers extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true, 'Admin');

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $data = array();
        $this->load->model('Chamber_model');
        $data['chambers'] = $this->Chamber_model->get_all_chambers();

        $this->template->write_view('content', 'chambers/index', $data);
        $this->template->render();
    }
    
    public function add_chamber($chamber_id = '') {
        $data = array();
        $this->load->model('Chamber_model');
        
        if(!empty($chamber_id)) {
            $chamber = $this->Chamber_model->get_chamber($chamber_id);
            if(empty($chamber))
                redirect(base_url().'chambers');

            $data['chamber'] = $chamber;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Chamber_model->add_chamber($post_data, $chamber_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Chamber successfully '.(($chamber_id) ? 'updated' : 'added').'.');
                redirect(base_url().'chambers');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'chambers/add_chamber', $data);
        $this->template->render();
    }
    
}
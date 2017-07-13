<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stages extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true, 'Admin');

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $data = array();
        $this->load->model('Stage_model');
        $data['stages'] = $this->Stage_model->get_all_stages();

        $this->template->write_view('content', 'stages/index', $data);
        $this->template->render();
    }
    
    public function add_stage($stage_id = '') {
        $data = array();
        $this->load->model('Stage_model');
        
        if(!empty($stage_id)) {
            $stage = $this->Stage_model->get_stage($stage_id);
            if(empty($stage))
                redirect(base_url().'stages');

            $data['stage'] = $stage;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Stage_model->add_stage($post_data, $stage_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Monitoring stage successfully '.(($stage_id) ? 'updated' : 'added').'.');
                redirect(base_url().'stages');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'stages/add_stage', $data);
        $this->template->render();
    }
    
}
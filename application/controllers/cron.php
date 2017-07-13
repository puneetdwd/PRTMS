<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cron extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);
        
        if($this->router->fetch_method() != 'get_parts_by_product') {
            $this->is_admin_user();
        }

        //render template
        $this->template->write('title', 'PRTMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $subject = 'Cron Test - '.date('jS F, Y H:i:s', strtotime('now'));
        $to = "puneet.dwivedi@crgroup.co.in";
        $this->sendMail($to, $subject, 'Testing');
    }
    
    public function completed_test_report_mail(){
        
        $data = array();
        
        $this->load->model('report_model');
        $filters = array() ;
        $data['reports'] = $this->report_model->get_completed_test_report($filters);
        
        $msg = $this->load->view('emails/completed_test_report_mail', $data, true);
        
        $subject = 'PRTMS - Completed Test Report';
        $to = 'puneet.dwivedi@crgroup.co.in';
        
        echo $msg; exit;
        
        if($this->sendMail($to, $subject, $msg)){
            echo "Mail Sent";
        }else{
            echo "Mail Not Sent";
        }
        
        return 0;
        
    }
    
}
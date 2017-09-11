<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cron extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);
        
        if($this->router->fetch_method() != 'get_parts_by_product') {
            $this->is_admin_user();
        }
		$this->load->model('report_model');
		$this->load->model('user_model');   
       
        //render template
        $this->template->write('title', 'PRTMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
   /*  public function index() {
        $subject = 'Cron Test - '.date('jS F, Y H:i:s', strtotime('now'));
        $to = "komal@crgroup.co.in";
        $this->sendMail($to, $subject, 'Testing');
    } */
    
    public function completed_test_report_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_users_admins_chambers();
		//$filters['start_date'] = date('Y-m-d',time() - 60 * 60 * 24);//24
		$filters['end_date'] = '%'.date('Y-m-d',time() - 60 * 60 * 24).'%';
		$data['reports'] = $this->report_model->get_completed_test_report_mail($filters);
		//print_r($data['reports']);exit;2017-02-14
		$data['yesterday'] = date('jS M, Y', strtotime(date('Y-m-d',time() - 60 * 60 * 24)));
		$mail_content = $this->load->view('emails/completed_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Completed Test Report of ".$data['yesterday'];
			$this->sendMail($toemail,$subject,$mail_content);
			//echo $mail_content;exit;
		}
		
		//echo $this->email->print_debugger();exit;
    }
	
    public function approved_test_report_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_users_admins_approver();
		
		//$filters['start_date'] = date('Y-m-d',time() - 60 * 60 * 24);
		$filters['end_date'] = date('Y-m-d',time() - 60 * 60 * 24);
		$data['reports'] = $this->report_model->get_approved_test_report_mail($filters);
		$data['yesterday'] = date('jS M, Y', strtotime($filters['end_date']));
		$mail_content = $this->load->view('emails/approved_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Approved Test Report";
			$this->sendMail($toemail,$subject,$mail_content);
			//echo $mail_content;exit;
		}
		//echo $this->email->print_debugger();exit;
    }
	
	public function incomplete_test_report_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_users_admins_chambers();
		//echo '<pre>';print_r($admins);exit;
		$filters['start_date'] = date('Y-m-01');
		$filters['end_date'] = date('Y-m-d',time() - 60 * 60 * 24);
		
		$data['reports'] = $this->report_model->get_incompleted_test_report_mail($filters);
		//echo $this->db->last_query();exit;
		$data['yesterday'] = date('jS M, Y', strtotime($filters['end_date']));
		$st = date('jS M, Y', strtotime($filters['start_date']));
		$end = date('jS M, Y', strtotime($filters['end_date']));
		$mail_content = $this->load->view('emails/incompleted_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Incomplete Test Report from ".$st." to ".$end;
			$this->sendMail($toemail,$subject,$mail_content);	
			//echo $mail_content;exit;
		}
		//echo $this->email->print_debugger();exit;

    }
    
}
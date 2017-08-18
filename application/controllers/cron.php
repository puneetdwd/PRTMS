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
		$admins = $this->user_model->get_all_users();
		$filters['start_date'] = date('Y-m-d',time() - 60 * 60 * 24 * 60);//24
		$filters['end_date'] = date('Y-m-d',time() - 60 * 60 * 24 * 30);
		$data['reports'] = $this->report_model->get_completed_test_report($filters);
		$data['yesterday'] = date('jS M, Y', strtotime(date('Y-m-d',time() - 60 * 60 * 24)));
		$mail_content = $this->load->view('emails/completed_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Completed Test Report";
			$this->sendMail($toemail,$subject,$mail_content);
	// echo $mail_content;exit;
		}
		
		//echo $this->email->print_debugger();exit;
    }
	
    public function approved_test_report_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_all_users();
		$filters['start_date'] = date('Y-m-d',time() - 60 * 60 * 24);
		$filters['end_date'] = date('Y-m-d',time() - 60 * 60 * 24);
		$data['reports'] = $this->report_model->get_approved_test_report($filters);
		$data['yesterday'] = date('jS M, Y', strtotime(date('Y-m-d',time() - 60 * 60 * 24)));
		$mail_content = $this->load->view('emails/approved_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Completed Test Report";
			$this->sendMail($toemail,$subject,$mail_content);
	
		}
		//echo $this->email->print_debugger();exit;

    }
	public function pending_test_report_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_all_users();
		//$filters['start_date'] = date('Y-m-d',time() - 60 * 60 * 24);
		//$filters['end_date'] = date('Y-m-d',time() - 60 * 60 * 24  * 30);
		$data['reports'] = $this->report_model->get_pending_test_report(date('Y-m-d',time() - 60 * 60 * 24));
		//echo $this->db->last_query();exit;
		$data['yesterday'] = date('jS M, Y', strtotime(date('Y-m-d',time() - 60 * 60 * 24)));
		$mail_content = $this->load->view('emails/pending_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Pending Test Report";
			$this->sendMail($toemail,$subject,$mail_content);
	
		//echo $mail_content;exit;
		}
		//echo $this->email->print_debugger();exit;

    }
    
}
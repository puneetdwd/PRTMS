<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cron extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);
        
        if($this->router->fetch_method() != 'get_parts_by_product') {
            $this->is_admin_user();
        }
		$this->load->model('report_model');
		$this->load->model('user_model');   
		$this->load->model('plan_model');   
       
        //render template
        /* $this->template->write('title', 'PRTMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');
 */
    }
        
    public function completed_test_report_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_users_admins_chambers();
		//$filters['start_date'] = '%'.date('Y-m-01').'%';
		$filters['end_date'] = '%'.date('Y-m-d',time() - 60 * 60 * 24).'%';
		$data['reports'] = $this->report_model->get_completed_test_report_mail($filters);
		$data['yesterday'] = date('jS M, Y', strtotime(date('Y-m-d',time() - 60 * 60 * 24)));
		$mail_content = $this->load->view('emails/completed_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Completed Test Report of ".$data['yesterday'];
			$this->sendMail($toemail,$subject,$mail_content);
			//echo $mail_content;exit;
		}
	}
	
    /*
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
		}
			//echo $mail_content;exit;
		//echo $this->email->print_debugger();exit;
    }
	*/
	public function incomplete_test_report_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_users_admins_chambers();
		$filters['start_date'] = date('Y-m-01');
		$filters['end_date'] = date('Y-m-d',time() - 60 * 60 * 24);
		$data['reports'] = $this->report_model->get_incompleted_test_report_mail($filters);
		$data['yesterday'] = date('jS M, Y', strtotime($filters['end_date']));
		$st = date('jS M, Y', strtotime($filters['start_date']));
		$end = date('jS M, Y', strtotime($filters['end_date']));
		$mail_content = $this->load->view('emails/incompleted_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Incomplete Test Report from ".$st." to ".$end;
			$this->sendMail($toemail,$subject,$mail_content);	
		}
	}
	
	
	public function get_pending_test_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_users_admins_chambers();
		$data['pending_tests'] = $this->plan_model->get_month_plan_mail(date('Y-m-01'), array());
		$data['yesterday'] = date('jS M, Y', strtotime(date('Y-m-d')));
		$mail_content = $this->load->view('emails/pending_test_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			$subject = "Pending Test Report";
			$this->sendMail($toemail,$subject,$mail_content);
	
		}
	}
    
    
}
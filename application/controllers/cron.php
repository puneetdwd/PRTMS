<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cron extends CI_Controller{
        
    public function __construct() {
        parent::__construct(true);
        
		$this->load->model('report_model');
		$this->load->model('user_model');   
		$this->load->model('plan_model');   

    }
	
	public function send_sms($to, $sms) {
        $user = 'Lgelectronic';
        $password = 'Sid2014!';
        $sender = "LGEILP";
        $message = urlencode($sms);

        //API URL
        $url="http://193.105.74.58/api/v3/sendsms/plain?user=".$user."&password=".$password."&sender=".$sender."&SMSText=".$message."&GSM=".$to;
        //echo $url;
        // init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //get response
        $output = curl_exec($ch);

        $flag = true;
        //Print error if any
        if(curl_errno($ch))
        {
            $flag = false;
        }
        //echo $flag;exit;
        curl_close($ch);
        return $flag;
    }
	
	function sendMail($to, $subject, $message, $bcc = '', $attachment = '', $cc = '') {
        $this->load->library('email');
        $this->email->clear(TRUE);
        
        $this->email->from('noreply@lge.com', 'LG PRTMS');
        //$this->email->from('komal@crgroup.co.in', 'Test');
        $this->email->to($to);
        $this->email->subject($subject);
        
        if(!empty($bcc)) {
            $this->email->bcc($bcc);
        }
        
        if(!empty($cc)) {
            $this->email->cc($cc);
        }
        
        if(!empty($attachment)) {
            $this->email->attach($attachment);
        }

        $this->email->message($message);

        return $this->email->send();
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
			//$toemail = 'puneet.dwivedi@crgroup.co.in,anil.gore@lge.com,komal@crgroup.co.in';
			$subject = "Completed Test Report of ".$data['yesterday'];
			$this->sendMail($toemail,$subject,$mail_content);
			//exit;
		}
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
			//$toemail = 'puneet.dwivedi@crgroup.co.in,anil.gore@lge.com,komal@crgroup.co.in';
			$subject = "Approved Test Report";
			$this->sendMail($toemail,$subject,$mail_content);
			//exit;
		}
    }
	
	public function inprogress_test_report_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_users_admins_chambers();
		$filters['start_date'] = date('Y-m-01');
		$filters['end_date'] = date('Y-m-d',time() - 60 * 60 * 24);
		$data['reports'] = $this->report_model->get_inprogress_test_report_mail($filters);
		
		//echo $this->db->last_query(); exit;
		
		$data['yesterday'] = date('jS M, Y', strtotime($filters['end_date']));
		$st = date('jS M, Y', strtotime($filters['start_date']));
		$end = date('jS M, Y', strtotime($filters['end_date']));
		$mail_content = $this->load->view('emails/inprogress_test_report_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			//$toemail = 'puneet.dwivedi@crgroup.co.in,anil.gore@lge.com,komal@crgroup.co.in';
			$subject = "Inprogress Test Report from ".$st." to ".$end;
			$this->sendMail($toemail,$subject,$mail_content);	
			//echo $mail_content;exit;
		}
	}
	
	
	public function get_pending_test_mail(){
        $data = array();
        $filters = array();
		$admins = $this->user_model->get_users_admins_chambers();
		$data['pending_tests'] = $this->plan_model->get_month_plan_mail(date('Y-m-01'), array());
		
		//echo $this->db->last_query(); exit;
		
		$data['today'] = date('jS M, Y', strtotime(date('Y-m-d')));
		$mail_content = $this->load->view('emails/pending_test_mail', $data,true);
		$this->load->library('email');
		foreach($admins as $admin) {
			
			$toemail = $admin['email_id'];
			//$toemail = 'puneet.dwivedi@crgroup.co.in,anil.gore@lge.com,komal@crgroup.co.in';
			$subject = "Pending Test Report";
			$this->sendMail($toemail,$subject,$mail_content);
			//exit;
	
		}
	}
    
    
}
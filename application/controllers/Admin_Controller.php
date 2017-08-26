<?php
/** 
* My Controller Class 
* 
* @package IACT
* @filename My_Controller.php
* @category My_Controller
**/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {

    function __construct($auth = false, $access = '') {
        parent::__construct();

        if($auth) {
            $this->is_logged();
        }

        if($access === 'Admin') {
            $this->is_admin_user();
        } else if($access === 'Dashboard') {
            $this->is_dashboard_user();
        } else if($access === 'Chamber') {
            $this->is_chamber_user();
        }

        $this->id = $this->session->userdata('id');
        $this->name = $this->session->userdata('name');
        $this->username = $this->session->userdata('username');
        $this->user_type = $this->session->userdata('user_type');
        $this->chamber_id = $this->session->userdata('chamber_id');
        $this->chamber_ids = $this->session->userdata('chamber_ids');
        $this->product_id = $this->session->userdata('product_id');
        $this->product_ids = $this->session->userdata('product_ids');

    }

    /**
     * @method: is_logged()
     * @access: public
     * @category : My_Controller
     * Desc : this method is used to check if user is logged in or not
     */
    function is_logged() {
        if(!$this->session->userdata('is_logged_in')) {
            redirect(base_url().'login');
        }
    }

    /**
     * @method: is_admin_user()
     * @access: public
     * @category : My_Controller
     * Desc : this method is used to check if user has Admin access
     */
    function is_admin_user() {

        if($this->session->userdata('user_type') != 'Admin' && $this->session->userdata('user_type') != 'Testing' && $this->session->userdata('user_type') != 'Product' && $this->session->userdata('user_type') != 'Approver') {
			
			            
			// && $this->session->userdata('user_type') != 'Chamber'
            $this->session->set_flashdata('error', 'Access Denied');
            redirect(base_url());
        }

    }

    /**
     * @method: is_employee()
     * @access: public
     * @category : My_Controller
     * Desc : this method is used to check if user is employee or not
     */
    function is_dashboard_user() {

        if($this->session->userdata('user_type') !== 'Dashboard') {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect(base_url());
        }

    }
    
    /**
     * @method: is_employee()
     * @access: public
     * @category : My_Controller
     * Desc : this method is used to check if user is employee or not
     */
    function is_chamber_user() {

        if($this->session->userdata('user_type') !== 'Chamber') {
            $this->session->set_flashdata('error', 'Access Denied');
            redirect(base_url());
        }

    }

    function print_array($var) {
        echo "<pre>";
        print_r($var);
        exit;
    }
    
    function upload_file($file_field, $file_name, $upload_path, $file_types = 'xls|xlsx') {
        if(!is_dir($upload_path)) {
            mkdir($upload_path);
        }
            
        $config['upload_path'] = $upload_path;
        if($file_field !== 'sampling_excel') {
            $config['file_name'] = $file_name.'_'.strtotime('now');
        } else {
            $config['file_name'] = $file_name;
        }
        
        $config['allowed_types'] = $file_types;
        $config['overwrite'] = True;

        $this->load->library('upload', $config);

        if(!$this->upload->do_upload($file_field)) {

            if(!$this->upload->is_allowed_filetype()) {
                $error = "The file type you are attempting to upload is not allowed.";
            } else {
                $error = $this->upload->display_errors();
            }

            $result = array(
                'status' => 'error',
                'error' => $error
            );

        } else {
            $upload_data = $this->upload->data();
            $result = array(
                'status' => 'success',
                'file' => $upload_path.$upload_data['file_name']			 
            );
			$this->load->model('user_model');
			
			$file_name = ucwords(str_replace('_',' ',$file_name));
			
			$upload =  $this->user_model->add_uploads_detail($result,$this->session->userdata('name'),$this->session->userdata('user_type'),$file_name);
        }
       // $this->print_array($result);exit;
        return $result;
    }
    
    function upload_photo($field, $upload_path, $filename) {
        $response = array('status' => 'error', 'error' => 'Invalid parameters');

        if(!empty($_FILES[$field]['name']) && !empty($upload_path)) {
            //upload wallpaper.

            if(!is_dir($upload_path)) {
                mkdir($upload_path);
            }

            $config['upload_path'] = $upload_path;
            if(!empty($filename)) {
                $config['file_name'] = $filename;
            }
            $config['allowed_types'] = 'png|jpg|JPG|jpeg|';
            $config['overwrite'] = True;

            $this->load->library('upload', $config);

            if(!$this->upload->do_upload($field)) {
                $response['status'] = 'error';

                if(!$this->upload->is_allowed_filetype()) {
                    $response['error'] = "The file type you are attempting to upload is not allowed.";
                } else {
                    $response['error'] = $this->upload->display_errors();
                }

            } else {
                $upload_data = $this->upload->data();
                $response = array(
                    'status' => 'success',
                    'file' => $upload_path.$upload_data['file_name']
                );
            }

        }

        return $response;
    }
    
   /*  function sendMail($to, $subject, $message, $attachment = '') {
        $this->load->library('email');

        $this->email->from('info@crgroup.co.in');
        $this->email->to($to);
        $this->email->subject($subject);

        $this->email->message($message);
        
        if($attachment) {
            $this->email->attach($attachment);
        }
        
        $return = $this->email->send();
        if (!$return) {
            echo "error";
            ob_start();
            show_error($this->email->print_debugger());
            $error = ob_end_clean();
            $errors[] = $error;
        }else{
            echo "done";
        }
        //print_r($return); 
        exit;
        return $this->email->send();
    } */
	function sendMail($to, $subject, $message, $bcc = '', $attachment = '', $cc = '') {
        $this->load->library('email');
        $this->email->clear(TRUE);
        
       //$this->email->from('noreply@lge.com', 'LG PRTMS');
       $this->email->from('komal@crgroup.co.in', 'Test');
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
    
	
	 function get_server_ip() {                                      // Function to get the client IP address
        $ipaddress = '';
        /*if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];*/
		if(isset($_SERVER['SERVER_ADDR']))
			$ipaddress = $_SERVER['SERVER_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
	public function send_sms($to, $sms) {
        $user = 'Lgelectronic';
        $password = 'Sid2014!';
        $sender = "LGEILP";
        $message = urlencode($sms);

        /* //Prepare you post parameters
        $postData = array(
            'user' => 'Lgelectronic',
            'password' => 'Sid2014!',
            'sender' => $senderId,
            'SMSText' => $message,
            'GSM' => $to
        ); */

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
        //Ignore SSL certificate verification
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

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
    
    public function send_sms_redirect($to, $sms) {
        $user = 'Lgelectronic';
        $password = 'Sid2014!';
        $sender = "LGEILP";
        $message = urlencode($sms);

        /* //Prepare you post parameters
        $postData = array(
            'user' => 'Lgelectronic',
            'password' => 'Sid2014!',
            'sender' => $senderId,
            'SMSText' => $message,
            'GSM' => $to
        ); */

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
        //Ignore SSL certificate verification
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

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
        //return $flag;
        redirect($_SERVER['HTTP_REFERER']);
    }

}
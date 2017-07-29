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

        if($this->session->userdata('user_type') !== 'Admin' && $this->session->userdata('user_type') !== 'Testing') {
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
        }
        
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
    
    function sendMail($to, $subject, $message, $attachment = '') {
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
    }
}
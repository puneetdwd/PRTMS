<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plans extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'plans'));
        $this->template->write_view('footer', 'templates/footer');

    }
    
    public function screen() {
        $data = array();
        $this->load->model('Plan_model');
        $data['plan'] = $this->Plan_model->get_month_plan(date('Y-m-01'), array());
        
        $this->template->write_view('content', 'plans/monthly_plan_screen', $data);
        $this->template->render();
    }
    
    public function upload() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            $validate->set_rules('plan_month', 'Plan Month', 'trim|required|xss_clean');
            if($validate->run() === TRUE) {
                $product_id = $this->input->post('product_id');
                $plan_month = $this->input->post('plan_month');
                
                if(!empty($_FILES['plan_excel']['name'])) {
                    $output = $this->upload_file('plan_excel', 'plan_month', "assets/uploads/");

                    //echo "<pre>";print_r($output);exit;
                    if($output['status'] == 'success') {
                        $excel = $this->parse_monthly_plan($product_id, $plan_month, $output['file']);
                        if($excel) {
                            $this->session->set_flashdata('success', 'Plan Successfully uploaded.');
                            redirect(base_url().'plans/display?plan_month='.$plan_month.'&product_id='.$product_id);
                        } else {
                            $data['error'] = 'Incorrect Excel format. Please check';
                        }
                        
                    } else {
                        $data['error'] = $output['error'];
                    }

                }
                
            } else {
                $data['error'] = validation_errors();
            }

        }
        
        $this->template->write_view('content', 'plans/upload', $data);
        $this->template->render();
    }
    
    public function copy_plan() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            $validate->set_rules('from_month', 'From Month', 'trim|required|xss_clean');
            $validate->set_rules('to_month', 'To Month', 'trim|required|xss_clean');
            if($validate->run() === TRUE) {
                $product_id = $this->input->post('product_id');
                $from_month = $this->input->post('from_month');
                $to_month = $this->input->post('to_month');
                
                $this->load->model('Plan_model');
                
                $this->Plan_model->copy_plan($product_id, $from_month, $to_month);
                $this->session->set_flashdata('success', 'Plan Successfully copied.');
                redirect(base_url().'plans/copy_plan');
            } else {
                $data['error'] = validation_errors();
            }
        }
        
        $this->template->write_view('content', 'plans/copy_plan', $data);
        $this->template->render();
    }
    
    public function display() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();
        
        $this->load->model('Plan_model');
        
        $filters = array();
        if($this->input->post()) {
            $plan_month = $this->input->post('plan_month');
            $filters = $this->input->post();
            $data['plan'] = $this->Plan_model->get_month_plan($plan_month, $filters);
            
        } else if($this->input->get('plan_month')) {
            $plan_month = $this->input->get('plan_month');
            
            $filters = array('product_id' => $this->input->get('product_id'));
            $data['plan'] = $this->Plan_model->get_month_plan($this->input->get('plan_month'), $filters);
        }
        
        if(!empty($filters['product_id'])) {
            $data['parts'] = $this->Product_model->get_all_product_parts($filters['product_id']);
        }
        
        $data['filters'] = $filters;
        $data['plan_month'] = isset($plan_month) ? $plan_month : '';
            
        
        $this->template->write_view('content', 'plans/display', $data);
        $this->template->render();
    }
    
    public function change_date($id) {
        if($this->input->post('schedule_date')) {
            $response = $this->Plan_model->update_test($id, $this->input->post('schedule_date'));
            if($response) {
                $this->session->set_flashdata('success', 'Date successfully changed.');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong. Please try again');
            }
            
            redirect(base_url());
        } else {
            $data = array('test' => $on_going);
            echo $this->load->view('change_date_ajax', $data);
        }
        
    }
    
    public function parse_monthly_plan($product_id, $month_year, $file_name) {
        //$file_name = 'assets/uploads/'.$file_name;
        
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[2]) || count($arr[2]) < 6) {
            return FALSE;
        }
        
        //echo "<pre>";print_r($arr);exit;
        
        $this->load->model('Product_model');
        $this->load->model('Supplier_model');
        $this->load->model('Plan_model');
        $this->load->model('Test_model');
        
        $p = '';
        $s = '';
        $part_id = '';
        $supplier_id = '';
        $date = '';
        
        $mappings = array();
        $plans = array();
        $tests = array();
        foreach($arr as $no => $row) {
            if($no <= 2)
                continue;
            
            $row['B'] = str_replace("\n", ' ', $row['B']);
            $row['D'] = str_replace("\n", ' ', $row['D']);
            
            if($p !== trim($row['B']) && !empty($row['B'])) {
                $p = $row['B'];
                
                $exists = $this->Product_model->get_product_part_by_code($product_id, $p);
                $part_id = !empty($exists) ? $exists['id'] : '';
                if(!empty($part_id)) {
                    $tests = $this->Test_model->get_tests_by_part($part_id);
                    //echo "<pre>";print_r();exit;
                }
            }
            
            if(empty($part_id)) {
                continue;
            }
            
            if($s !== trim($row['E'])) {
                if(empty($row['E'])) {
                    continue;
                }
                
                $supplier = array();
                $supplier['supplier_no'] = trim($row['E']);
                $supplier['name'] = trim($row['F']);
                
                $exists = $this->Supplier_model->get_supplier_by_code($supplier['supplier_no']);
                if(empty($exists)) {
                    $supplier_id = $this->Supplier_model->add_supplier($supplier, '');
                } else {
                    $supplier_id = $exists['id'];
                }
                
                $mapping = array();
                $mapping['supplier_id'] = $supplier_id;
                $mapping['product_id'] = $product_id;
                $mapping['part_id'] = $part_id;
                $mapping['created'] = date("Y-m-d H:i:s");
                
                $mappings[] = $mapping;
            }
            
            if($date !== trim($row['G']) && !empty($row['G'])) {
                $date = trim($row['G']);
                
                $date = date_create_from_format('m-d-y', $date)->format('Y-m-d');
            }

            if(!empty($tests)) {
                $plan = array();
                $plan['month_year'] = $month_year;
                $plan['supplier_id'] = $supplier_id;
                $plan['product_id'] = $product_id;
                $plan['part_id'] = $part_id;
                $plan['planned_part_no'] = $row['D'];
                $plan['schedule_date'] = $date;
                $plan['created'] = date("Y-m-d H:i:s");
                foreach($tests as $test) {
                    $plan['test_id'] = $test['id'];
                    
                    $plans[] = $plan;
                }

                
            }
        }

        if(!empty($mappings)) {
            $this->Supplier_model->insert_sp_mappings($mappings);
            $this->Supplier_model->remove_dups();
        }

        $this->Plan_model->delete_plan($product_id, $month_year);
        if(!empty($plans)) {
            $this->Plan_model->insert_monthly_plan($plans, $month_year);
        }

        return TRUE;
    }
}
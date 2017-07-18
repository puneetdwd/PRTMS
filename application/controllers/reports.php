<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);
        
        if($this->router->fetch_method() != 'get_parts_by_product') {
            $this->is_admin_user();
        }

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        /*$data = array();
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();

        $this->template->write_view('content', 'products/index', $data);
        $this->template->render();*/
    }
    
    public function completed_test_report(){
        
        $data = array();
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        $data['parts'] = $this->Product_model->get_all_parts();
        
        $this->load->model('Chamber_model');
        $data['chambers'] = $this->Chamber_model->get_all_chambers();
        $data['categories'] = $this->Chamber_model->get_chamber_categories();
        
        $this->load->model('Stage_model');
        $data['stages'] = $this->Stage_model->get_all_stages();
        
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        //print_r($data['suppliers']); exit;
        
        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();
        
        $filters = $this->input->post() ? $this->input->post() : array() ;
        
        if($filters){
        
            $this->load->model('report_model');
            $data['reports'] = $this->report_model->get_completed_test_report($filters);
        
        }
        
        //echo $this->db->last_query(); exit;
        
        $_SESSION['ctr_filters'] = $filters;
        
        $this->template->write_view('content', 'reports/completed_test_report', $data);
        $this->template->render();
        
    }
    
    public function chamber_wise_test_count_report(){
        
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        $data['parts'] = $this->Product_model->get_all_parts();
        
        $this->load->model('Chamber_model');
        $data['chambers'] = $this->Chamber_model->get_all_chambers();
        $data['categories'] = $this->Chamber_model->get_chamber_categories();
        
        $this->load->model('report_model');
        $filters = $this->input->post() ? $this->input->post() : array() ;
        $data['reports'] = $this->report_model->completed_test_count_report($filters);
        
        $_SESSION['cwtcr_filters'] = $filters;
        
        $this->template->write_view('content', 'reports/chamber_wise_test_count_report', $data);
        $this->template->render();
        
    }
    
    public function check_tests($chamber_id){
        
        $data = array();
        
        $filters = $_SESSION['cwtcr_filters'] ;
        
        $this->load->model('report_model');
        
        $data['reports'] = $this->report_model->get_test_by_chamber_id($chamber_id, $filters);
        $data['chamber_id'] = $chamber_id;
        
        $this->template->write_view('content', 'reports/check_tests', $data);
        $this->template->render();
        
    }
    
    public function view_test($test_id){
        
        $data = array();
        
        $this->load->model('report_model');
        
        $data['reports'] = $this->report_model->get_completed_test_details($test_id);
        
        $this->template->write_view('content', 'reports/check_tests', $data);
        $this->template->render();
        
    }
    
    public function part_assurance_report(){
        
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        $data['parts'] = $this->Product_model->get_all_parts();

        $this->load->model('Chamber_model');
        $data['chambers'] = $this->Chamber_model->get_all_chambers();
        $data['categories'] = $this->Chamber_model->get_chamber_categories();
        
        $this->load->model('Stage_model');
        $data['stages'] = $this->Stage_model->get_all_stages();
        
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $filters = $this->input->post() ? $this->input->post() : array() ;
        $_SESSION['par_filters'] = $filters;
        
        if(!empty($filters)){
            // print_r($filters);exit;
			// Array ( [month] => 4 [year] => 2017 [stage_id] => 3 [product_id] => 2 [part_id] => PCB Assembly Main [part_id1] => 7 [supplier_id] => 14 ) 
            $this->load->model('report_model');
            $data['reports_common'] = $this->report_model->get_common_details_part_based_test_report($filters);
			//echo "<pre>"; print_r($filters); exit;
			//echo $this->db->last_query(); exit;
            $data['reports_event'] = $this->report_model->get_event($filters['stage_id']);
			//$data['reports_common']['event_name'] = $data['reports_event']['name'];
			///print_r($data['reports_common']);exit;
            $data['reports'] = $this->report_model->get_part_based_test_report($filters);
            $samples = 0;
            $judgement = 'OK';
            foreach($data['reports'] as $rep){
                $samples = $samples + $rep['samples'];
                if(strcasecmp($rep['observation_result'],"NG") == 0){
                    $judgement = 'NG';
                }
            }
            $data['samples'] = $samples;
            $data['judgement'] = $judgement;
        }
        
        $this->template->write_view('content', 'reports/part_assurance_report', $data);
        $this->template->render();
    }
    
    public function export_excel($excel_page, $filters = array()) {
        $data = array();
        
        //$filters = unserialize($filters);
        
        if($excel_page == 'part_assurance_report'){
            
            $filters = @$_SESSION['par_filters'] ;
            //unset($_SESSION['par_filters']);
            
            //echo "<pre>"; print_r($filters); exit;
            $this->load->model('report_model');
            $data['reports_common'] = $this->report_model->get_common_details_part_based_test_report($filters);
            $data['reports'] = $this->report_model->get_part_based_test_report($filters);
            $samples = 0;
            $judgement = 'OK';
            
            foreach($data['reports'] as $rep){
                $samples = $samples + $rep['samples'];
                if(strcasecmp($rep['observation_result'],"NG") == 0){
                    $judgement = 'NG';
                }
            }
            $data['samples'] = $samples;
            $data['judgement'] = $judgement;
            $data['month'] = $filters['month'];
            $data['year'] = $filters['year'];
            $data['export'] = true;
            $str = $this->load->view('excel_pages/part_assurance_report', $data, true);
            
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=Part_Assurance_Report.xls');
            
        }else if($excel_page == 'completed_test_report'){
            
            $filters = @$_SESSION['ctr_filters'] ;
            //unset($_SESSION['ctr_filters']);
            
            $this->load->model('report_model');
            //$filters = $this->input->post() ? $this->input->post() : array() ;
            $data['reports'] = $this->report_model->get_completed_test_report($filters);
            $str = $this->load->view('excel_pages/completed_test_report', $data, true);
            
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=completed_test_report.xls');
            
        }else if($excel_page == 'chamber_wise_test_count_report'){
            
            $filters = @$_SESSION['cwtcr_filters'] ;
            //unset($_SESSION['cwtcr_filters']);
            
            $this->load->model('report_model');
            //$filters = $this->input->post() ? $this->input->post() : array() ;
            $data['reports'] = $this->report_model->completed_test_count_report($filters);
            $str = $this->load->view('excel_pages/chamber_wise_test_count_report', $data, true);
            
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=chamber_wise_test_count_report.xls');
            
        }else{
            return 0;
        }
        
        // Fix for crappy IE bug in download.
        header("Pragma: ");
        header("Cache-Control: ");
        echo $str;
    }
    
    public function export_excel_check_tests($chamber_id) {
        $data = array();
        
        $filters = $_SESSION['cwtcr_filters'] ;
        
        $this->load->model('report_model');
        $data['reports'] = $this->report_model->get_test_by_chamber_id($chamber_id, $filters);
        $str = $this->load->view('excel_pages/check_tests', $data, true);

        header('Content-Type: application/force-download');
        header('Content-disposition: attachment; filename=check_tests.xls');
        
        // Fix for crappy IE bug in download.
        header("Pragma: ");
        header("Cache-Control: ");
        echo $str;
    }
    
}
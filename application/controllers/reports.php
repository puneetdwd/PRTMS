<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);
        
        if($this->router->fetch_method() != 'get_parts_by_product') {
            $this->is_admin_user();
        }
		//print_r($_SESSION['product_ids'] );exit;
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
		if($this->user_type == 'Product'){
			// echo $_SESSION['product_switch']['id'];exit;
			if(!empty($_SESSION['product_switch']['id']))
				$data['products'] = $this->Product_model->get_product_session($_SESSION['product_switch']['id']);
			else	
				$data['products'] = $this->Product_model->get_all_products_by_user($this->username);
		}
        $data['parts'] = $this->Product_model->get_all_parts();
        $data['parts_num'] = $this->Product_model->get_all_parts();
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
			
			//echo '<pre>';print_r($filters);exit;
			
			//Array ( [start_date] => [end_date] => [product_id] => 1 [part_id] => Adaptor [part_id1] => 40 [stage_id] => 3 [test_id] => 6 [chamber_category] => Electrical [chamber_id] => 7 [supplier_id] => 116 )
			
            $this->load->model('report_model');
            $data['reports'] = $this->report_model->get_completed_test_report($filters);
			
			

			if(!empty($filters['product_id'])){
				$data['parts'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
			}
			if(!empty($filters['part_id1'])){
				
				//$data['parts_num'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
				//$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['tests'] = $this->Test_model->get_tests_by_part($filters['part_id1']);
        
			}
			if(!empty($filters['part_id'])){
				$data['parts_num'] = $this->Product_model->get_part_num_by_part($filters['part_id'],$filters['product_id']);
			}
        
        }
        //echo '<pre>';print_r($filters);exit;
        
        
        $_SESSION['ctr_filters'] = $filters;
        
        $this->template->write_view('content', 'reports/completed_test_report', $data);
        $this->template->render();
        
    }
    public function approved_test_report(){
        
        $data = array();
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
		if($this->user_type == 'Product'){
			// echo $_SESSION['product_switch']['id'];exit;
			if(!empty($_SESSION['product_switch']['id']))
				$data['products'] = $this->Product_model->get_product_session($_SESSION['product_switch']['id']);
			else	
				$data['products'] = $this->Product_model->get_all_products_by_user($this->username);
		}
        $data['parts'] = $this->Product_model->get_all_parts();
        $data['parts_num'] = $this->Product_model->get_all_parts();
       
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

			if(!empty($filters['product_id'])){
				$data['parts'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
			}
			if(!empty($filters['part_id1'])){
				//$data['parts_num'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
				//$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['tests'] = $this->Test_model->get_tests_by_part($filters['part_id1']);
        
			}
			if(!empty($filters['part_id'])){
				$data['parts_num'] = $this->Product_model->get_part_num_by_part($filters['part_id'],$filters['product_id']);
			}
        
            $this->load->model('report_model');
            $data['reports'] = $this->report_model->get_approved_test_report($filters);
        
        }
       // echo '<pre>';print_r($data['reports']);
        //echo $this->db->last_query(); 
		//exit;
        
        $_SESSION['ctr_filters'] = $filters;
        
        $this->template->write_view('content', 'reports/approved_test_report', $data);
        $this->template->render();
        
    }
    
    public function chamber_wise_test_count_report(){
        
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
		if($this->user_type == 'Product'){
			
        $data['products'] = $this->Product_model->get_all_products_by_user($this->username);
		//print_r($data['products']);exit;
		}
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
    public function no_lot_report() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
		$data['parts'] = $this->Product_model->get_all_parts();
        $data['parts_num'] = $this->Product_model->get_all_parts();
       
        if($this->user_type == 'Product'){
			
        $data['products'] = $this->Product_model->get_all_products_by_user($this->username);
		//print_r($data['products']);exit;
		}
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $this->load->model('Test_model');
        $data['tests'] = $this->Test_model->get_all_tests();
        
        $this->load->model('Plan_model');
        $this->load->model('report_model');
        
        $filters = array();
        if($this->input->post()) {
            $plan_month = $this->input->post('plan_month');
            $filters = $this->input->post();
			//print_r($filters);exit;
            $data['plan'] = $this->report_model->get_no_lot_plan($plan_month, $filters);
			
			if(!empty($filters['product_id'])){
				$data['parts'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
			}
			if(!empty($filters['part_id1'])){
				//$data['parts_num'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
				//$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['tests'] = $this->Test_model->get_tests_by_part($filters['part_id1']);
        
			}
			if(!empty($filters['part_id'])){
				$data['parts_num'] = $this->Product_model->get_part_num_by_part($filters['part_id'],$filters['product_id']);
			}
            
        } else if($this->input->get('plan_month')) {
            $plan_month = $this->input->get('plan_month');            
            $filters = array('product_id' => $this->input->get('product_id'));
            $data['plan'] = $this->report_model->get_no_lot_plan($this->input->get('plan_month'), $filters);
        }
        
        /*  if(!empty($filters['product_id'])) {
            $data['parts'] = $this->Product_model->get_all_product_parts($filters['product_id']);
        } */
        
        $data['filters'] = $filters;
		 $_SESSION['nl_filters'] = $filters;
        
        $data['plan_month'] = isset($plan_month) ? $plan_month : '';
            
        
        $this->template->write_view('content', 'reports/no_lot_report', $data);
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
		if($this->user_type == 'Product'){
			
        $data['products'] = $this->Product_model->get_all_products_by_user($this->username);
		//print_r($data['products']);exit;
		}
        $data['parts'] = $this->Product_model->get_all_parts();
		$data['parts_num'] = $this->Product_model->get_all_parts();
       
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
			
			if(!empty($filters['product_id'])){
				$data['parts'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
			}
			if(!empty($filters['part_id1'])){
				//$data['parts_num'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
				//$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				$data['suppliers'] = $this->Supplier_model->get_suppliers_by_part($filters['part_id1']);
				//$data['tests'] = $this->Test_model->get_tests_by_part($filters['part_id1']);
        
			}
			if(!empty($filters['part_id'])){
				$data['parts_num'] = $this->Product_model->get_part_num_by_part($filters['part_id'],$filters['product_id']);
			}
			
            $this->load->model('report_model');
            $data['reports_common'] = $this->report_model->get_common_details_part_based_test_report($filters);
			$data['reports_event'] = $this->report_model->get_event($filters['stage_id']);
			$data['reports'] = $this->report_model->get_part_based_test_report($filters);
			/* echo $this->db->last_query();
			exit; */
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
        //echo '<pre>';print_r($data['reports']);exit;
        $this->template->write_view('content', 'reports/part_assurance_report', $data);
        $this->template->render();
    }
    
    public function export_excel($excel_page, $filters = array()) {
        $data = array();
        // echo $excel_page;exit;
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
			$data['reports_event'] = $this->report_model->get_event($filters['stage_id']);
            $data['samples'] = $samples;
            $data['judgement'] = $judgement;
            $data['month'] = $filters['month'];
            $data['year'] = $filters['year'];
            $data['export'] = true;
			// echo "<pre>";print_r($data);
            $str = $this->load->view('excel_pages/part_assurance_report', $data, true);
            
            header('Content-Type: application/force-download; charset=utf-8');
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
            
        }else if($excel_page == 'approved_test_report'){
            
            $filters = @$_SESSION['ctr_filters'] ;
            //unset($_SESSION['ctr_filters']);
            
            $this->load->model('report_model');
            //$filters = $this->input->post() ? $this->input->post() : array() ;
            $data['reports'] = $this->report_model->get_approved_test_report($filters);
            $str = $this->load->view('excel_pages/approved_test_report', $data, true);
            
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=approved_test_report.xls');
            
        }else if($excel_page == 'chamber_wise_test_count_report'){
            
            $filters = @$_SESSION['cwtcr_filters'] ;
            //unset($_SESSION['cwtcr_filters']);
            
            $this->load->model('report_model');
            //$filters = $this->input->post() ? $this->input->post() : array() ;
            $data['reports'] = $this->report_model->completed_test_count_report($filters);
            $str = $this->load->view('excel_pages/chamber_wise_test_count_report', $data, true);
            
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=chamber_wise_test_count_report.xls');
            
        }
		else if($excel_page == 'no_lot_report'){
            $this->load->model('report_model');
        
            $filters = @$_SESSION['nl_filters'] ;
            
            $this->load->model('report_model');
            $plan_month = $filters['plan_month'];
			$data['plan'] = $this->report_model->get_no_lot_plan($plan_month, $filters);
			$str = $this->load->view('excel_pages/no_lot_report', $data, true);
            
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=no_lot_report.xls');
            
        }else if($excel_page == 'part_test_summary_report'){
            $this->load->model('report_model');
			$this->load->model('Plan_model');
        
            $filters = @$_SESSION['pts_filters'] ;
            $this->load->model('report_model');
			/* if()
			$data['reports'] = $this->report_model->get_part_based_test_report_count($filters);
			 */
			if($this->user_type == 'Product')
				$data['reports'] = $this->report_model->get_part_based_test_report_count_by_user($filters,$this->username);
			else
				$data['reports'] = $this->report_model->get_part_based_test_report_count($filters);
		
           // print_r($filters);exit;
            //print_r($data['reports']);
			 //exit;
			 /* $insp_status = array();
			$reports1 =  $data['reports'];
			foreach($reports1 as $report1){
				
					$insp_status = $this->Plan_model->get_no_inspection_by_part($report1['part_no'],$filters['start_date'],$filters['end_date']);
					if(!empty($insp_status))
						echo $insp_status['insp_cnt'];
					else
						echo '0';
			} */
			
			$str = $this->load->view('excel_pages/part_test_summary_report', $data, true);
            
            header('Content-Type: application/force-download');
            header('Content-disposition: attachment; filename=part_test_summary_report.xls');
            
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
    public function part_test_summary_report() {
        $data = array();        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
		if($this->user_type == 'Product'){
			
        $data['products'] = $this->Product_model->get_all_products_by_user($this->username);
		//print_r($data['products']);exit;
		}
        $data['parts'] = $this->Product_model->get_all_parts();
        $data['parts_num'] = $this->Product_model->get_all_parts();
       
        $this->load->model('Plan_model');
        $this->load->model('report_model');
        $filters = $this->input->post() ? $this->input->post() : array() ;
		//echo "fdbf";exit;
        //print_r($filters);exit;
		if($this->input->post())
		{
			
			/* if(!empty($filters['product_id'])){
				$data['parts'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
			}
			if(!empty($filters['part_id'])){
				$data['parts'] = $this->Product_model->get_part_num_by_part($filters['part_id'],$filters['product_id']);
			} */	
			
			if(!empty($filters['product_id'])){
				$data['parts'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
			}
			
			if(!empty($filters['part_id'])){
				$data['parts_num'] = $this->Product_model->get_part_num_by_part($filters['part_id'],$filters['product_id']);
			}
			
			
			if($this->user_type == 'Product')
				$data['reports'] = $this->report_model->get_part_based_test_report_count_by_user($filters,$this->username);
			else
				$data['reports'] = $this->report_model->get_part_based_test_report_count($filters);
		}
		//	echo $this->db->last_query();exit;
		//echo '<pre>'; print_r($data['reports']);exit;
        $_SESSION['pts_filters'] = $filters;
		//print_r($_SESSION['pts_filters']);exit;
        /* $reports1 =  $data['reports'];
		foreach($reports1 as $report1){
			
				$data['res'] = $this->Plan_model->get_no_inspection_by_part($report1['part_no'],$filters['start_date'],$filters['end_date']);
				if(!empty($data['res']))
					echo $data['res']['insp_cnt'];
				else
					echo '0';
		} */
			
			
        $this->template->write_view('content', 'reports/part_test_summary_report', $data);
        $this->template->render();
    }
    
	function print_page($report){
            
		if(($this->input->post('report') == 'completed_test_report') || $report == 'completed_test_report'){
            $filters = @$_SESSION['ctr_filters'] ;
            //unset($_SESSION['ctr_filters']);
            
            $this->load->model('report_model');
            //$filters = $this->input->post() ? $this->input->post() : array() ;
            $data['reports'] = $this->report_model->get_completed_test_report($filters);
            $data['str'] = $this->load->view('excel_pages/completed_test_report', $data, true);
			echo json_encode($data);
			
		}
	}
}
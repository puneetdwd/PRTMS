<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true, 'Admin');

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $data = array();
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();

        $this->template->write_view('content', 'suppliers/index', $data);
        $this->template->render();
    }
    
    public function add_supplier($supplier_id = '') {
        $data = array();
        $this->load->model('Supplier_model');
        
        if(!empty($supplier_id)) {
            $supplier = $this->Supplier_model->get_supplier($supplier_id);
            if(empty($supplier))
                redirect(base_url().'suppliers');

            $data['supplier'] = $supplier;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Supplier_model->add_supplier($post_data, $supplier_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Supplier successfully '.(($supplier_id) ? 'updated' : 'added').'.');
                redirect(base_url().'suppliers');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'suppliers/add_supplier', $data);
        $this->template->render();
    }
    
    public function upload_suppliers() {
        $data = array();
        $this->load->model('Supplier_model');
        
        if($this->input->post()) {
             
            if(!empty($_FILES['supplier_excel']['name'])) {
                $output = $this->upload_file('supplier_excel', 'suppliers', "assets/uploads/");

                if($output['status'] == 'success') {
                    $res = $this->parse_suppliers($output['file']);
                    
                    if($res) {
                        $this->session->set_flashdata('success', 'Suppliers successfully uploaded.');
                        redirect(base_url().'suppliers');
                    } else {
                        $data['error'] = 'Error while uploading excel';
                    }
                } else {
                    $data['error'] = $output['error'];
                }

            }
        }
        
        $this->template->write_view('content', 'suppliers/upload_suppliers', $data);
        $this->template->render();
    }
        
    public function sp_mappings() {
        $data = array();
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        $data['parts'] = $this->Product_model->get_all_parts();
        $data['parts_num'] = $this->Product_model->get_all_parts();
       
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $filters = $this->input->post() ? $this->input->post() : array() ;
		if(!empty($filters['product_id'])){
			$data['parts'] = $this->Product_model->get_all_parts_by_product($filters['product_id']);
		}
		
		if(!empty($filters['part_id1'])){
			$data['parts_num'] = $this->Product_model->get_part_num_by_part($filters['part_id1'],$filters['product_id']);
		}
		
        $data['sp_mappings'] = $this->Supplier_model->get_all_sp_mappings($filters);

        $this->template->write_view('content', 'suppliers/sp_mappings', $data);
        $this->template->render();
    }
    
    public function add_sp_mapping($sp_mapping_id = '') {
        $data = array();
        $this->load->model('Supplier_model');
        $data['suppliers'] = $this->Supplier_model->get_all_suppliers();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        if(!empty($sp_mappings_id)) {
            $sp_mapping = $this->Supplier_model->get_sp_mapping($sp_mapping_id);
            if(empty($sp_mapping))
                redirect(base_url().'sp_mappings');

            $data['sp_mapping'] = $sp_mapping;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Supplier_model->add_sp_mapping($post_data, $sp_mapping_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Supplier-Part Mapping successfully '.(($sp_mapping_id) ? 'updated' : 'added').'.');
                redirect(base_url().'suppliers/sp_mappings');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'suppliers/add_sp_mapping', $data);
        $this->template->render();
    }
    
    private function parse_suppliers($file_name) {
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[1])) {
            return FALSE;
        }
        
        $suppliers = array();
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;
            
            if(!trim($row['A']))
                continue;
            
            $temp = array();
            $temp['supplier_no']    = trim($row['A']);
            $temp['name']           = trim($row['B']);
            $temp['created']        = date("Y-m-d H:i:s");

            $exists = $this->Supplier_model->get_supplier_by_code(trim($row['A']));
            
            if(!empty($exists)){
                $this->Supplier_model->add_supplier($suppliers, $exists['id']);
            }else{
                $suppliers[]        = $temp;
            }
            
        }

        $this->load->model('Product_model');
        $this->Supplier_model->insert_suppliers($suppliers);
        
        return TRUE;
    }
}
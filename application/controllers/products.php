<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Admin_Controller {
        
    public function __construct() {
        parent::__construct(true);
        
        if($this->router->fetch_method() != 'get_parts_by_product') {
            //$this->is_admin_user();
        }

        //render template
        $this->template->write('title', 'PMS | '.$this->user_type.' Dashboard');
        $this->template->write_view('header', 'templates/header', array('page' => 'masters'));
        $this->template->write_view('footer', 'templates/footer');

    }
        
    public function index() {
        $data = array();
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();

        $this->template->write_view('content', 'products/index', $data);
        $this->template->render();
    }
    
    public function ptc_master() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            if($validate->run() === TRUE) {
                $product_id = $this->input->post('product_id');
                
                if(!empty($_FILES['master_excel']['name'])) {
                    $output = $this->upload_file('master_excel', 'ptc_master', "assets/masters/");

                    if($output['status'] == 'success') {
                        $excel = $this->parse_ptc_master($product_id, $output['file']);

                        if($excel) {
                            $this->session->set_flashdata('success', 'Master Successfully uploaded.');
                            redirect(base_url().'tests/ptc_mappings');
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
        
        $this->template->write_view('content', 'products/ptc_master', $data);
        $this->template->render();
    }
    
    public function sp_master() {
        $data = array();
        
        $this->load->model('Product_model');
        $data['products'] = $this->Product_model->get_all_products();
        
        if($this->input->post()) {
            $this->load->library('form_validation');

            $validate = $this->form_validation;
            $validate->set_rules('product_id', 'Product', 'trim|required|xss_clean');
            if($validate->run() === TRUE) {
                $product_id = $this->input->post('product_id');
                
                if(!empty($_FILES['master_excel']['name'])) {
                    $output = $this->upload_file('master_excel', 'sp_master', "assets/masters/");

                    if($output['status'] == 'success') {
                        $excel = $this->parse_sp_master($product_id, $output['file']);
                        if($excel) {
                            $this->session->set_flashdata('success', 'Master Successfully uploaded.');
                            redirect(base_url().'suppliers/sp_mappings');
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
        
        $this->template->write_view('content', 'products/sp_master', $data);
        $this->template->render();
    }
    
    public function add_product($product_id = '') {
        $data = array();
        $this->load->model('Product_model');
        
        if(!empty($product_id)) {
            $product = $this->Product_model->get_product($product_id);
            if(empty($product))
                redirect(base_url().'products');

            $data['product'] = $product;
        }
        
        if($this->input->post()) {
            $post_data = $this->input->post();
            
            $response = $this->Product_model->add_product($post_data, $product_id); 
            if($response) {
                $this->session->set_flashdata('success', 'Product successfully '.(($product_id) ? 'updated' : 'added').'.');
                redirect(base_url().'products');
            } else {
                $data['error'] = 'Something went wrong, Please try again';
            }
        }
        
        $this->template->write_view('content', 'products/add_product', $data);
        $this->template->render();
    }
    
    public function parts($product_id) {
        $data = array();
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
        $data['parts'] = $this->Product_model->get_all_product_parts_new($product_id);

        $this->template->write_view('content', 'products/parts', $data);
        $this->template->render();
    }
    
	    
    public function add_product_part($product_id, $part_id = '') {
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');

        $data['product'] = $product;
		$num = $this->input->post('part_no');
		if($this->input->post('part_no')){
			$part_num_record = $this->Product_model->get_product_part_by_code_num($product_id, $num);
			//print_r($part_num_record);
			if(empty($part_id) && !empty($part_num_record)) {
				$this->session->set_flashdata('success', 'Record with same Part No. found.');
				redirect(base_url().'products/parts/'.$product['id']);
			}
		}
        if(!empty($part_id)) {
			//echo 'HI';exit;
            $part = $this->Product_model->get_product_part($product_id, $part_id);
            if(empty($part))
                redirect(base_url().'products/parts/'.$product['id']);

            $data['part'] = $part;
        }
        
        $this->load->model('Category_model');
        $data['categories'] = $this->Category_model->get_all_categories();
        
        if($this->input->post()) {
			//echo 'HIqq';exit;
            $post_data = $this->input->post();
            $post_data['product_id'] = $product['id'];
            // print_r($post_data);exit;
            
			$fullpath = 'assets/part_reference_files/';
			//for Product directory
			// print_r($_FILES);exit;
			if($_FILES['img_file']['name'] != '') {			
				//echo $_FILES['img_file']['name'];exit;
			 
				
				$config['upload_path'] = $fullpath;
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['file_name'] = uniqid() .$_FILES['img_file']['name'];
				$post_data['img_file'] = $config['file_name'];
				
				//Load upload library and initialize configuration
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				
				if($this->upload->do_upload('img_file')){
					$uploadData = $this->upload->data();
					$img_file = $uploadData['file_name'];
				}
			}///end img/file upload
			
			$response = $this->Product_model->update_product_part($post_data, $part_id); 
				if($response) {
					$this->session->set_flashdata('success', 'Product part successfully '.(($part_id) ? 'updated' : 'added').'.');
					redirect(base_url().'products/parts/'.$product_id);
				} else {
					$data['error'] = 'Something went wrong, Please try again';
				}	
			
			}
		
        $this->template->write_view('content', 'products/add_product_part', $data);
        $this->template->render();
    }

    public function upload_product_parts($product_id) {
        $data = array();
        $this->load->model('Product_model');
        
        $product = $this->Product_model->get_product($product_id);
        if(empty($product))
            redirect(base_url().'products');
        
        $data['product'] = $product;
        
        if($this->input->post()) {
             
            if(!empty($_FILES['parts_excel']['name'])) {
                $output = $this->upload_file('parts_excel', 'product_parts', "assets/uploads/");

                if($output['status'] == 'success') {
                    $res = $this->parse_parts($product_id, $output['file']);
                    //echo $res;exit;
                    if($res) {
                        $this->session->set_flashdata('success', 'Parts successfully uploaded.');
                        redirect(base_url().'products/parts/'.$product_id);
                    } else {
                        $data['error'] = 'Error while uploading excel';
                    }
                } else {
                    $data['error'] = $output['error'];
                }

            }
        }
        
        $this->template->write_view('content', 'products/upload_parts', $data);
        $this->template->render();
    }
    
    public function delete_product_part($product_id, $part_id) {
        if($this->product_id) {
            $product_id = $this->product_id;
        }
        
        $this->load->model('Product_model');

        $part = $this->Product_model->get_product_part($product_id, $part_id);
        if(empty($part))
            redirect(base_url().'products/parts/'.$product['id']);
            
        $deleted = $this->Product_model->update_product_part(array('is_deleted' => 1), $part_id); 
        if($deleted) {
            $this->session->set_flashdata('success', 'Product Part deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, please try again.');
        }
        
        redirect(base_url().'products/parts/'.$product_id);
    }

    public function get_parts_by_product() {
        $data = array('parts' => array());        
        if($this->input->post('product')) {
            $this->load->model('Product_model');
            $data['parts'] = $this->Product_model->get_all_product_parts($this->input->post('product'));
        }       
        echo json_encode($data);
    }
	public function get_part_number_by_part() {
        $data = array('parts' => array());
        if($this->input->post('part')) {
            $this->load->model('Product_model');
            $data['parts'] = $this->Product_model->get_part_num_by_part($this->input->post('part'),$this->input->post('product'));
		}
		echo json_encode($data);
    }
	
	 public function get_suppliers_by_part() {
        $data = array('suppliers' => array());
        
        if($this->input->post('part')) {
            $this->load->model('Supplier_model');
            $data['parts'] = $this->Supplier_model->get_suppliers_by_part($this->input->post('part'));

			//echo $this->db->last_query(); exit;
           }
        
        echo json_encode($data);
    }
    

    private function parse_ptc_master_old($product_id, $file_name) {
        //$file_name = 'assets/masters/'.$file_name;
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        $this->load->model('Product_model');
        $this->load->model('Test_model');
        $this->load->model('Chamber_model');
        
        $chambers_ex_index = array('A', 'B', 'C', 'D');
        
        
        $p = '';
        $part_id = '';
        $test_id = '';
        $chamber_header = array();
        
        $parts = array();
        $tests = array();
        
        $chambers = array();
        $mappings = array();
        
        foreach($arr as $no => $row) {
            if($no == 1 || $no == 3)
                continue;
            
            if($no == 2) {
                $category = null;
                foreach($row as $k => $v) {
                    if(in_array($k, $chambers_ex_index))
                        continue;
                    
                    if(!empty($v) && $v != $category) {
                        $category = $v;
                    }
                    
                    $categories[$k] = $category;
                }
            } else if($no === 4) {
                foreach($row as $k => $v) {
                    if(in_array($k, $chambers_ex_index))
                        continue;
                    
                    $temp = array();
                    $temp['name']       = $arr[3][$k];
                    $temp['code']       = $arr[3][$k];
                    $temp['category']   = $categories[$k];
                    $temp['detail']     = $v;
                    
                    $exists = $this->Chamber_model->get_chamber_by_name($temp['name']);
                    if(empty($exists)) {
                        $temp['id'] = $this->Chamber_model->add_chamber($temp, '');
                    } else {
                        $temp['id'] = $exists['id'];
                    }
                    $chamber_header[$k] = $temp['id'];
                    
                    $chambers[] = $temp;
                }
                
            } else {
                $row['B'] = str_replace("\n", ' ', $row['B']);
                $row['C'] = str_replace("\n", ' ', $row['C']);
                $row['D'] = str_replace("\n", ' ', $row['D']);
                
                if($p !== trim($row['B']) && !empty($row['B'])) {
                    $p = $row['B'];
                    $part = array();
                    $part['name'] = $p;
                    $part['product_id'] = $product_id;
                    
                    $exists = $this->Product_model->get_product_part_by_name($product_id, $p);
                    if(empty($exists)) {
                        $part_id = $this->Product_model->update_product_part($part, '');
                    } else {
                        $part_id = $exists['id'];
                    }
                    $part['id'] = $part_id;
                    $parts[] = $part;
                }
                
                if(!empty($row['C'])) {
                    $test = array();
                    $test['name'] = trim($row['C']);
                    $test['method'] = trim($row['D']);
                    
                    $exists = $this->Test_model->get_test_by_name($test['name']);
                    if(empty($exists)) {
                        $test_id = $this->Test_model->add_test($test, '');
                    } else {
                        $test_id = $exists['id'];
                    }
                    
                    $test['id'] = $test_id;
                    $tests[] = $test;
                } else {
                    continue;
                }
                
                foreach($chamber_header as $col => $chamber_id) {
                    if(trim($row[$col]) != 1) {
                        continue;
                    }
                    
                    $mapping = array();
                    $mapping['test_id'] = $test_id;
                    $mapping['product_id'] = $product_id;
                    $mapping['part_id'] = $part_id;
                    $mapping['chamber_id'] = $chamber_id;
                    
                    $mappings[] = $mapping;
                }
            }
        }
        
        if(!empty($mappings)) {
            $this->Test_model->insert_ptc_mappings($mappings);
            $this->Test_model->remove_dups();
        }
    }

    private function parse_ptc_master($product_id, $file_name) {
        //$file_name = 'assets/masters/'.$file_name;
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[2]) || count($arr[2]) < 6) {
            return FALSE;
        }
        
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->model('Chamber_model');
        $this->load->model('Test_model');
        
        $p = '';
        $test_id = '';
        $part_id = '';

        $parts = array();
        $mappings = array();
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;
            
            $row['B'] = str_replace("\n", ' ', $row['B']);
            $row['D'] = str_replace("\n", ' ', $row['D']);
            $row['E'] = str_replace("\n", ' ', $row['E']);
            $row['F'] = str_replace("\n", ' ', $row['F']);
            $row['G'] = str_replace("\n", ' ', $row['G']);
            $row['H'] = str_replace("\n", ' ', $row['H']);
            $row['I'] = str_replace("\n", ' ', $row['I']);
            $row['J'] = str_replace("\n", ' ', $row['J']);

            if($p !== trim($row['D']) && !empty($row['D'])) {
                $p = $row['D'];
                
                $exists = $this->Product_model->get_product_part_by_code_num($product_id, $p);
                $part_id = !empty($exists) ? $exists['id'] : '';
            }
            //print_r($exists);exit;
            if(empty($part_id)) {
                continue;
            }
                
            $test = array();
            $test['code'] = trim($row['E']);
            $test['name'] = trim($row['F']);
            $test['method'] = trim($row['G']);
            $test['judgement'] = trim($row['H']);
            $test['duration'] = trim($row['I']);
			// $test['part_chamber_category'] = trim($row['J']);
            //print_r($test);exit;
            $exists = $this->Test_model->get_test_by_code($test['code']);
            $test_id = !empty($exists) ? $exists['id'] : '';
            $test_id = $this->Test_model->add_test($test, $test_id);
            
            if(empty($row['J'])) {
                continue;
            }
            
			$chamber_category = trim($row['J']);	
			
            $chamber_cat_id = $this->Product_model->get_part_catagory_id_by_name($chamber_category);
			//print_r($chamber_cat_id);exit;
            $chambers = $this->Chamber_model->get_chambers_by_category($chamber_category);
            if(empty($chambers)) {
                continue;
            }
            
            foreach($chambers as $chamber) {                
                $mapping = array();
                $mapping['test_id'] = $test_id;
                $mapping['product_id'] = $product_id;
                $mapping['part_id'] = $part_id;
                $mapping['chamber_id'] = $chamber['id'];
                $mapping['part_category_id'] = $chamber_cat_id['id'];
                $mapping['created'] = date("Y-m-d H:i:s");
                $mappings[] = $mapping;
            }
			//exit;
        }
		//echo '<pre>';print_r($mappings);
        
        if(!empty($mappings)) {
            $this->Test_model->insert_ptc_mappings($mappings);
            $this->Test_model->remove_dups();
        }        
        return true;
    }
    
    private function parse_sp_master($product_id, $file_name) {
        //$file_name = 'assets/masters/'.$file_name;
        
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[2]) || count($arr[2]) < 4) {
            return FALSE;
        }
        
        $this->load->model('Product_model');
        $this->load->model('Supplier_model');
        
        $p = '';
        $part_id = '';
        
        $mappings = array();
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;
			//print_r($row);exit;
            $row['B'] = str_replace("\n", ' ', $row['B']);
            
            if($p !== trim($row['B']) && !empty($row['B'])) {
                $p = $row['B'];
               // $n = $row['D'];
                // $exists = $this->Product_model->get_product_part_by_code($product_id, $p);
                $exists = $this->Product_model->get_product_part_by_code_num($product_id, $p);
                $part_id = !empty($exists) ? $exists['id'] : '';
            }
            
            if(empty($part_id)) {
                continue;
            }
            //echo '123';exit;
            //$supplier['part_no'] = trim($row['D']);
			
			
			
            $supplier = array();
            $supplier['supplier_no'] = trim($row['C']);
            $supplier['name'] = trim($row['D']);
            $exists = $this->Supplier_model->get_supplier_by_code($supplier['supplier_no']);
		//echo '<pre>';print_r($mappings);exit;
            if(empty($exists)) {
                $supplier_id = $this->Supplier_model->add_supplier($supplier, '');
            } else {
                $this->Supplier_model->add_supplier($supplier, $exists['id']);
                $supplier_id = $exists['id'];
            }
            $mapping = array();
            $mapping['supplier_id'] = $supplier_id;
            $mapping['product_id'] = $product_id;
            $mapping['part_id'] = $part_id;
            
            $mappings[] = $mapping;
        }
		
        if(!empty($mappings)) {
            $this->Supplier_model->insert_sp_mappings($mappings);
            $this->Supplier_model->remove_dups();
        }
            // echo $this->db->last_query();exit;
        
        return TRUE;
    }
    
    private function parse_sp_master_old($product_id, $file_name) {
        //$file_name = 'assets/masters/'.$file_name;
        
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
        
        if(empty($arr) || !isset($arr[2]) || count($arr[2]) < 4) {
            return FALSE;
        }
        
        $this->load->model('Product_model');
        $this->load->model('Supplier_model');
        $this->load->model('Category_model');
        
        $p = '';
        $c = '';
        $category_id = '';
        $part_id = '';
        
        $mappings = array();
        foreach($arr as $no => $row) {
            if($no == 1)
                continue;
            
            $row['B'] = str_replace("\n", ' ', $row['B']);
            $row['C'] = str_replace("\n", ' ', $row['C']);
            $row['D'] = str_replace("\n", ' ', $row['D']);
            
            if($c !== trim($row['B']) && !empty($row['B'])) {
                $c = $row['B'];
                $exists = $this->Category_model->get_category_by_name($c);
                if(empty($exists)) {
                    $category_id = $this->Category_model->add_category(array('name' => $c), '');
                } else {
                    $category_id = $exists['id'];
                }
                
            }
            
            if($p !== trim($row['C']) && !empty($row['C'])) {
                $p = $row['C'];
                $part = array();
                $part['name'] = $p;
                $part['category_id'] = $category_id;
                $part['product_id'] = $product_id;
                
                $exists = $this->Product_model->get_product_part_by_name($product_id, $p);
                $part_id = !empty($exists) ? $exists['id'] : '';
                $part_id = $this->Product_model->update_product_part($part, $part_id);
            }
            
            if(empty($row['D'])) {
                continue;
            }
            $supplier = array();
            $supplier['name'] = trim($row['D']);
            
            $exists = $this->Supplier_model->get_supplier_by_name($supplier['name']);
            if(empty($exists)) {
                $supplier_id = $this->Supplier_model->add_supplier($supplier, '');
            } else {
                $supplier_id = $exists['id'];
            }
            
            $mapping = array();
            $mapping['supplier_id'] = $supplier_id;
            $mapping['product_id'] = $product_id;
            $mapping['part_id'] = $part_id;
            
            $mappings[] = $mapping;
        }
        
        if(!empty($mappings)) {
            $this->Supplier_model->insert_sp_mappings($mappings);
            $this->Supplier_model->remove_dups();
        }
        
        return TRUE;
    }

    private function parse_parts($product_id, $file_name) {
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file_name);
        
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        $arr = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true,true);
        if(empty($arr) || !isset($arr[1])) {
            return FALSE;
        }
        
        $parts = array();
        $category = null;
        foreach($arr as $no => $row) {
			///echo '1';
			//print_r($row);
            if($no == 1)
                continue;
            
            if(!isset($category)) {
                $category = trim($row['A']);
            }
            
            if(!empty($row['A']) && $category != $row['A']) {
                $category = $row['A'];
            }
            
            if(!trim($row['B']))
                continue;
			
			
			if(!trim($row['D']))
                continue;
            
			if(!empty($row['D']))
			{
				$part_num_record = $this->Product_model->get_product_part_by_code_num($product_id, trim($row['D']));
				if(!empty($part_num_record)) {
					continue;
				}
			}
			
            
            $temp = array();
            $temp['product_id']     = $product_id;
            $temp['category']       = $category;
            $temp['code']           = trim($row['B']);
            $temp['name']           = trim($row['C']);
            $temp['part_no']        = trim($row['D']);
            $temp['img_file']       = trim($row['E']);
            $temp['created']        = date("Y-m-d H:i:s");
           // print_r($temp);exit;
            // $exists = $this->Product_model->get_product_part_by_code_num($temp['product_id'], $temp['code'],$temp['part_no']);
            $exists = $this->Product_model->get_product_part_by_code_num($temp['product_id'],$temp['part_no']);
			//echo '<pre>';print_r($exists);
            if(!empty($exists)) {
              $this->Product_model->update_product_part($parts, $exists['id']);
                
            }else{
                $parts[] = $temp;
				$this->load->model('Product_model');
				echo $res1 =  $this->Product_model->insert_parts($parts, $product_id);
            }
            //echo $this->db->last_query();
        }
		//exit;

         // print_r($res1);
        // print_r($temp);exit;
        return TRUE;
    }
	
	
}
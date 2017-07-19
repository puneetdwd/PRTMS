<?php
class report_model extends CI_Model {

    function add_test($data, $test_id){
        $needed_array = array('code', 'name', 'method', 'judgement', 'duration');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($test_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('tests', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $test_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('tests', $data)) ? $test_id : False);
        }
        
    }
        
    function get_all_tests(){
        $sql = 'SELECT id, code, name, method, judgement, duration FROM tests';
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_test($id) {
        $this->db->where('id', $id);

        return $this->db->get('tests')->row_array();
    }
	function get_event($id) {
        $this->db->where('id', $id);

        return $this->db->get('stages')->row_array();
    }
    
    function get_completed_test_report($filters = array()){
        
        $sql = "SELECT t.id as test_record_id, t.code, c.name as chamber_name, t.start_date, t.end_date, c.category as chamber_category, 
                t.part_no, p.name as product_name, pp.name as part_name, s.name as supplier_name, ts.name as test_name, st.name as stage_name 
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.completed = 1";
        
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $sql .= ' AND t.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id'])) {
            $sql .= ' AND t.part_id = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_id1'])) {
            $sql .= ' AND t.part_id = ?';
            $pass_array[] = $filters['part_id1'];
        }
        
        if(!empty($filters['test_id'])) {
            $sql .= ' AND t.test_id = ?';
            $pass_array[] = $filters['test_id'];
        }
        
        if(!empty($filters['chamber_id'])) {
            $sql .= ' AND t.chamber_id = ?';
            $pass_array[] = $filters['chamber_id'];
        }
        
        if(!empty($filters['chamber_category'])) {
            $sql .= ' AND c.category = ?';
            $pass_array[] = $filters['chamber_category'];
        }
        
        if(!empty($filters['stage_id'])) {
            $sql .= ' AND t.stage_id = ?';
            $pass_array[] = $filters['stage_id'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $sql .= ' AND t.supplier_id = ?';
            $pass_array[] = $filters['supplier_id'];
        }
        
        if(!empty($filters['start_date'])) {
            $sql .= ' AND t.start_date >= ?';
            $pass_array[] = $filters['start_date'];
        }
        
        if(!empty($filters['end_date'])) {
            $sql .= ' AND t.start_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        //echo $sql; exit;
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function completed_test_count_report($filters = array()){
         print_r($filters);exit;
        $sql = "SELECT t.chamber_id, c.name as chamber_name, c.category as chamber_category, COUNT(t.id) as test_record_count
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                WHERE t.completed = 1";
        
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $sql .= ' AND t.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id'])) {
            $sql .= ' AND t.part_id = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['chamber_id'])) {
            $sql .= ' AND t.chamber_id = ?';
            $pass_array[] = $filters['chamber_id'];
        }
        
        if(!empty($filters['chamber_category'])) {
            $sql .= ' AND c.category = ?';
            $pass_array[] = $filters['chamber_category'];
        }
        
        if(!empty($filters['start_date'])) {
            $sql .= ' AND t.start_date >= ?';
            $pass_array[] = $filters['start_date'];
        }
        
        if(!empty($filters['end_date'])) {
            $sql .= ' AND t.start_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        $sql .= " GROUP BY t.chamber_id";
        
        //echo $sql; exit;
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_test_by_chamber_id($chamber_id, $filters = array()){
        
        $sql = "SELECT t.id as test_record_id, t.code, ts.id as test_id, ts.code as test_code, ts.name as test_name, ts.judgement,
                t.start_date, t.end_date, c.name as chamber_name, c.category as chamber_category
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                WHERE t.chamber_id = ".$chamber_id;
        
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $sql .= ' AND t.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id'])) {
            $sql .= ' AND t.part_id = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['chamber_id'])) {
            $sql .= ' AND t.chamber_id = ?';
            $pass_array[] = $filters['chamber_id'];
        }
        
        if(!empty($filters['chamber_category'])) {
            $sql .= ' AND c.category = ?';
            $pass_array[] = $filters['chamber_category'];
        }
        
        if(!empty($filters['start_date'])) {
            $sql .= ' AND t.start_date >= ?';
            $pass_array[] = $filters['start_date'];
        }
        
        if(!empty($filters['end_date'])) {
            $sql .= ' AND t.start_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_completed_test_details($test_id){
        
        $sql = "SELECT t.id as test_record_id, ts.id as test_id, ts.code as test_code, ts.name as test_name, 
                c.name as chamber_name, c.category as chamber_category
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                WHERE t.completed = 1";
        
        $pass_array = array();
        
        if(!empty($filters['chamber_id'])) {
            $sql .= ' AND t.chamber_id = ?';
            $pass_array[] = $filters['chamber_id'];
        }
        
        if(!empty($filters['chamber_category'])) {
            $sql .= ' AND c.category = ?';
            $pass_array[] = $filters['chamber_category'];
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_common_details_part_based_test_report($filters = array()){
        $sql = "SELECT pp.part_no, t.lot_no,st.name as event, p.name as product_name, pp.name as part_name, s.name as supplier_name, 
                t.samples
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.completed = 1";
        
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $sql .= ' AND t.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id1'])) {
			$sql .= ' AND t.part_id = ?';
            $pass_array[] = $filters['part_id1'];
        }
		if(!empty($filters['chamber_id'])) {
            $sql .= ' AND t.chamber_id = ?';
            $pass_array[] = $filters['chamber_id'];
        }
        
        if(!empty($filters['chamber_category'])) {
            $sql .= ' AND c.category = ?';
            $pass_array[] = $filters['chamber_category'];
        }
        
        if(!empty($filters['stage_id'])) {
			
            $sql .= ' AND t.stage_id = ?';
            $pass_array[] = $filters['stage_id'];
        }
        
        if(!empty($filters['start_date'])) {
            $sql .= ' AND t.start_date >= ?';
            $pass_array[] = $filters['start_date'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $sql .= ' AND t.supplier_id = ?';
            $pass_array[] = $filters['supplier_id'];
        } 
        
        if(!empty($filters['end_date'])) {
            $sql .= ' AND t.start_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        $sql .= " ORDER by t.part_id DESC limit 0,1";
         return $this->db->query($sql, $pass_array)->row_array();
	}
    
    function get_part_based_test_report($filters = array()){
        
		$sql = "SELECT t.id as test_record_id, t.code, t.samples, ts.name as test_name, ts.method, ts.judgement, c.name as chamber_name, 
                t.start_date, t.end_date, tt.observation_result, c.category as chamber_category, st.name as stage_name
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN test_observations tt ON tt.test_id = t.id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.completed = 1";
        
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $sql .= ' AND t.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id1'])) {
            $sql .= ' AND t.part_id = ?';
            $pass_array[] = $filters['part_id1'];
        } 
        if(!empty($filters['chamber_id'])) {
            $sql .= ' AND t.chamber_id = ?';
            $pass_array[] = $filters['chamber_id'];
        }
        
        if(!empty($filters['chamber_category'])) {
            $sql .= ' AND c.category = ?';
            $pass_array[] = $filters['chamber_category'];
        }
        
        if(!empty($filters['stage_id'])) {
            $sql .= ' AND t.stage_id = ?';
            $pass_array[] = $filters['stage_id'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $sql .= ' AND t.supplier_id = ?';
            $pass_array[] = $filters['supplier_id'];
        }
        
        if(!empty($filters['month']) && !empty($filters['year']) ) {
            $sql .= ' AND t.start_date >= ? AND t.start_date <= ?';
            $pass_array[] = $filters['year']."-".$filters['month']."-01";
            $pass_array[] = $filters['year']."-".$filters['month']."-".date('t', strtotime($filters['year']."-".$filters['month']."-15"));
        }
        $sql .= ' GROUP BY t.id';
        return $this->db->query($sql, $pass_array)->result_array();
	}
    
}
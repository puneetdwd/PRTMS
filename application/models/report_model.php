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
        //print_r($filters);exit;
        $sql = "SELECT t.id as test_record_id,
		t.appr_test_remark,t.retest_remark,t.skip_remark,t.skip_remark,t.test_img,t.samples,
		t.code,ts.test_set, c.name as chamber_name, t.start_date, t.end_date, t.lot_no, 	o.assistant_name,o.observation_result,t.is_approved,t.approved_by, c.category as chamber_category, 
                pp.part_no, p.name as product_name,p.code as product_code, pp.name as part_name, s.name as supplier_name, ts.name as test_name, st.name as stage_name
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN test_observations o ON t.id = o.test_id 
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
            $sql .= ' AND pp.name = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_id1'])) {
            $sql .= ' AND pp.id = ?';
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
            $sql .= ' AND t.end_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        //echo $sql; exit;
        $sql .= " GROUP BY t.id,pp.id  order by st.id,p.id asc";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    function get_completed_test_report_mail($filters = array()){
        //print_r($filters);exit;
        $sql = "SELECT t.id as test_record_id,
		t.appr_test_remark,t.retest_remark,t.skip_remark,t.skip_remark,
		t.code,ts.test_set, c.name as chamber_name, t.start_date, t.end_date, t.lot_no, 	o.assistant_name,o.observation_result,t.is_approved,t.approved_by, c.category as chamber_category, 
                pp.part_no, p.name as product_name,p.code as product_code, pp.name as part_name, s.name as supplier_name, ts.name as test_name, st.name as stage_name
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN test_observations o ON t.id = o.test_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.completed = 1";
				
		/* if(!empty($filters['start_date'])) {
            $sql .= ' AND t.end_date >= ?';
            $end_date = $filters['start_date'];
        } */
		if(!empty($filters['end_date'])) {
            $sql .= ' AND t.end_date like ?';
            $end_date = $filters['end_date'];
        }
        
        $sql .= "  GROUP BY t.id,pp.id order by st.id,p.id asc";
        //echo $sql; exit;
        
        return $this->db->query($sql, $end_date)->result_array();
    }
    /* function get_inprogress_test_report_mail($filters = array()){
        //print_r($filters);exit;
        $sql = "SELECT t.id as test_record_id,
		t.appr_test_remark,t.retest_remark,t.skip_remark,t.skip_remark,
		t.code,ts.test_set, c.name as chamber_name, t.start_date, t.end_date, t.lot_no, 	o.assistant_name,o.observation_result,t.is_approved,t.approved_by, c.category as chamber_category, 
                pp.part_no, p.name as product_name,p.code as product_code, pp.name as part_name, s.name as supplier_name, ts.name as test_name, st.name as stage_name
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN test_observations o ON t.id = o.test_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.completed = 0 and t.aborted = 0  ";
				
		
		if(!empty($filters['end_date'])) {
            $sql .= ' AND t.end_date >= ?';			
            $end_date = $filters['end_date'];
        }
        $date = array($end_date);
        $sql .= "  GROUP BY t.id,pp.id ";
        //echo $sql; exit;
        
        return $this->db->query($sql, $date)->result_array();
    }
     */
	 function get_inprogress_test_report_mail($filters = array()){
        //print_r($filters);exit;
        $sql = "SELECT t.id as test_record_id,
		t.appr_test_remark,t.retest_remark,t.skip_remark,t.skip_remark,
		t.code,ts.test_set, c.name as chamber_name, t.start_date, t.end_date, t.lot_no, 	o.assistant_name,o.observation_result,t.is_approved,t.approved_by, c.category as chamber_category, 
                pp.part_no, p.name as product_name,p.code as product_code, pp.name as part_name, s.name as supplier_name, ts.name as test_name, st.name as stage_name
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN test_observations o ON t.id = o.test_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.completed = 0 and t.aborted = 0 AND p.name is not null AND pp.id is not null ";
				
		/*if(!empty($filters['start_date'])) {
            $sql .= ' AND t.end_date >= ?';			
            $start_date = $filters['start_date'];
        }*/
		if(!empty($filters['end_date'])) {
            $sql .= ' AND t.end_date >= ?';			
            $end_date = $filters['end_date'];
        }
        $date = array($end_date);
        $sql .= "  GROUP BY t.id,pp.id order by st.id,p.id asc";
        //echo $sql; exit;
        
        return $this->db->query($sql, $date)->result_array();
    }
    
    function get_approved_test_report($filters = array()){
        //print_r($filters);exit;
        $sql = "SELECT t.id as test_record_id,
		t.appr_test_remark,t.retest_remark,t.skip_remark,t.test_img,
		t.code,ts.test_set, c.name as chamber_name, t.start_date, t.end_date, t.lot_no, 	o.assistant_name,o.observation_result,t.is_approved,t.approved_by, c.category as chamber_category, 
                pp.part_no, p.name as product_name,p.code as product_code, pp.name as part_name, s.name as supplier_name, ts.name as test_name, st.name as stage_name
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN test_observations o ON t.id = o.test_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.is_approved = 1";
				
				/*  ,
				CASE 
					WHEN MAX(o.observation_result) = 'OK' THEN 'OK'
					WHEN MAX(o.observation_result) = 'NG' THEN 'NG'
				END as result */
				
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $sql .= ' AND t.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        
		if(!empty($filters['part_id'])) {
            $sql .= ' AND pp.name = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_id1'])) {
            $sql .= ' AND pp.id = ?';
            $pass_array[] = $filters['part_id1'];
        }
        
        if(!empty($filters['test_id'])) {
            $sql .= ' AND pp.test_id = ?';
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
        $sql .= " GROUP BY t.id,pp.id";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    function get_approved_test_report_mail($filters = array()){
        //print_r($filters);exit;
        $sql = "SELECT t.id as test_record_id,
		t.appr_test_remark,t.retest_remark,t.skip_remark,
		t.code,ts.test_set, c.name as chamber_name, t.start_date, t.end_date, t.lot_no, 	o.assistant_name,o.observation_result,t.is_approved,t.approved_by, c.category as chamber_category, 
                pp.part_no, p.name as product_name,p.code as product_code, pp.name as part_name, s.name as supplier_name, ts.name as test_name, st.name as stage_name
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN test_observations o ON t.id = o.test_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.is_approved = 1";
			
        if(!empty($filters['end_date'])) {
            $sql .= ' AND t.end_date >= ? and t.end_date <= ? ';
            $pass_array[] = $filters['end_date']." 00:00:00";
			$pass_array[] = $filters['end_date']." 23:59:59";
        }
        
        //echo $sql; exit;
        $sql .= " GROUP BY t.id,pp.id order by st.id,p.id asc";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    function get_pending_test_report($date){
        //print_r($filters);exit;
        $sql = "SELECT * from 
		(SELECT mp.id, mp.`month_year`, mp.`supplier_id`, mp.`product_id`, mp.`part_id`, 
        mp.`planned_part_no`, mp.`test_id`, mp.schedule_date,mp.no_inspection,
        p.name as product, s.name as supplier, pp.name as part,
        t.name as test,
        CASE 
            WHEN MAX(tr.completed) IS NULL THEN 'Pending'
            WHEN MAX(tr.completed) = 0 THEN 'In Progress'
            WHEN MAX(tr.completed) = 1 THEN 'Completed'
        END as status
        FROM monthly_plan mp
        INNER JOIN suppliers s
        ON s.id = mp.supplier_id
        INNER JOIN products p
        ON p.id = mp.product_id
        INNER JOIN product_parts pp
        ON mp.part_id = pp.id
        INNER JOIN tests t
        ON t.id = mp.test_id
        LEFT JOIN test_records tr
        ON (
            mp.`month_year` = DATE_FORMAT(tr.`start_date`, '%Y-%m-01')
            AND mp.`supplier_id` = tr.supplier_id
            AND mp.product_id = tr.product_id
            AND mp.part_id = tr.part_id
            AND mp.test_id = tr.test_id
            AND tr.aborted = 0
        )
        WHERE mp.no_inspection != 'NO' AND mp.schedule_date <= ? ";
		
		$sql .= " GROUP BY mp.`month_year`, mp.product_id, mp.part_id, mp.`supplier_id`, mp.test_id
        ORDER BY pp.name, s.name, t.name asc) as res WHERE res.status = 'Pending'";
        
		/*$sql = "SELECT DISTINCT monthly_plan.part_id,
				monthly_plan.* FROM monthly_plan
				
				LEFT OUTER JOIN test_records 
				ON monthly_plan.part_id = test_records.part_id 
				
				where monthly_plan.no_inspection != 'YES' 
				AND test_records.`start_date` < ";
	*/
	/*  ,
				CASE 
					WHEN MAX(o.observation_result) = 'OK' THEN 'OK'
					WHEN MAX(o.observation_result) = 'NG' THEN 'NG'
				END as result */
		
        
       /*  if(!empty($date)) {
            $sql .= ' AND t.start_date >= ?';
            $pass_array[] = $filters['start_date'];
        } 
        
		$sql .= "GROUP BY mp.`month_year`, mp.product_id, mp.part_id, mp.`supplier_id`, mp.test_id
        ORDER BY pp.name, s.name, t.name";
        */
        
        return $this->db->query($sql, $date)->result_array();
    }
    
    function completed_test_count_report($filters = array()){
        
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
                WHERE t.aborted = 0 AND t.chamber_id = ".$chamber_id;
			
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
        
        $sql .= " ORDER by t.part_id DESC limit 0,1";
         return $this->db->query($sql, $pass_array)->row_array();
	}
    
    function get_part_based_test_report($filters = array()){
        
		$sql = "SELECT t.id as test_record_id, t.code, t.samples, ts.name as test_name, ts.method, ts.judgement, c.name as chamber_name, t.test_img,t.skip_remark,t.retest_remark,
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
            $sql .= ' AND t.start_date >= ? AND t.end_date <= ?';
            $pass_array[] = $filters['year']."-".$filters['month']."-01";
            $pass_array[] = $filters['year']."-".$filters['month']."-".date('t', strtotime($filters['year']."-".$filters['month']."-15"));
        }
        $sql .= ' GROUP BY t.id';
        return $this->db->query($sql, $pass_array)->result_array();
	}
	function get_part_based_test_report_new($filters = array(),$testss = array()){
        //print_r($testss);exit;
		$sql = "SELECT t.id as test_record_id,ts.id as test_iid, t.code, t.samples, ts.name as test_name, ts.method, ts.judgement, c.name as chamber_name, t.test_img,t.skip_remark,t.retest_remark,t.appr_test_remark,
                t.start_date, t.end_date, tt.observation_result, c.category as chamber_category, st.name as stage_name
                FROM `test_records` t 
                LEFT JOIN chambers c ON c.id = t.chamber_id 
                LEFT JOIN products p ON p.id = t.product_id 
                LEFT JOIN product_parts pp ON pp.id = t.part_id 
                LEFT JOIN suppliers s ON s.id = t.supplier_id 
                LEFT JOIN tests ts ON ts.id = t.test_id 
                LEFT JOIN test_observations tt ON tt.test_id = t.id 
                LEFT JOIN stages st ON st.id = t.stage_id
                WHERE t.is_approved = 1 ";
        
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
            $sql .= ' AND t.start_date BETWEEN  ? AND  ?';
            $pass_array[] = $filters['year']."-".$filters['month']."-01"." 00:00:00";
            $pass_array[] = $filters['year']."-".$filters['month']."-".date('t', strtotime($filters['year']."-".$filters['month']."-15"))." 23:59:59";
        }
        $sql .= ' GROUP BY t.id';
        return $this->db->query($sql, $pass_array)->result_array();
	}
	function get_approver($test_record_id ){		
		
		$sql = "SELECT * FROM `test_records` t 
                WHERE id =  ? ";        
        $sql .= ' GROUP BY t.id';
        return $this->db->query($sql, $test_record_id)->row_array();
		
	}
	function get_checker($t ){
		$sql = "SELECT max(assistant_name) as assistant_name FROM `test_observations` tt 
                WHERE test_id = ? ";        
        $sql .= ' GROUP BY tt.test_id';
        return $this->db->query($sql, $t)->row_array();
		
	}
	
	function get_part_based_test_report_count($filters = array()){
        
		//$sql = "SELECT t.*,count(t.part_id) as Part_test, mp.* FROM `test_records` as t INNER JOIN monthly_plan mp on t.part_id = mp.part_id";
        $sql = "SELECT t.start_date,t.end_date,t.product_id,pp.part_no,pp.name as part_name,t.start_date,count(t.part_id) as test_cnt,t.test_id,t.part_id 
		FROM `test_records` as t 
		inner join product_parts as pp
		WHERE pp.part_no IS NOT NULL ";
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
			$sql .= ' AND t.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id'])) {
            $sql .= ' AND pp.name = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_id1'])) {
            $sql .= ' AND pp.id = ?';
            $pass_array[] = $filters['part_id1'];
        }
		if(!empty($filters['start_date'])) {
            $sql .= ' AND t.start_date >= ?';
            $pass_array[] = $filters['start_date'];
        }
        
        if(!empty($filters['end_date'])) {
            $sql .= ' AND t.start_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        $sql .= '  group by pp.id';
		//echo $sql;
        return $this->db->query($sql, $pass_array)->result_array();
	}
	
	function get_part_based_test_report_count_new($filters = array()){
        
		//$sql = "SELECT t.*,count(t.part_id) as Part_test, mp.* FROM `test_records` as t INNER JOIN monthly_plan mp on t.part_id = mp.part_id";
        $sql = "SELECT p.name as product,st.name as st_name,pp.name as part_name,pp.part_no,tr.id,COUNT(*) as test_cnt,tr.start_date,tr.end_date FROM `test_records` tr
		INNER JOIN products p ON tr.product_id = p.id
		INNER JOIN product_parts pp ON pp.id = tr.part_id
		INNER JOIN stages st ON st.id = tr.stage_id 
		WHERE tr.is_approved = 1 ";
        
		$pass_array = array();
        //print_r($filters);
        if(!empty($filters['product_id'])) {
			$sql .= ' AND p.id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
		if(!empty($filters['stage_id'])) {
			$sql .= ' AND st.id = ?';
            $pass_array[] = $filters['stage_id'];
        }
		
        if(!empty($filters['part_id'])) {
            $sql .= ' AND pp.name = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_id1'])) {
            $sql .= ' AND pp.id = ?';
            $pass_array[] = $filters['part_id1'];
        }
		if(!empty($filters['start_date'])) {
            $sql .= ' AND tr.end_date >= ?';
            $pass_array[] = $filters['start_date'];
        }
        
        if(!empty($filters['end_date'])) {
            $sql .= ' AND tr.end_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        $sql .= '  group by pp.id order by p.id asc';
		//echo $sql;
        return $this->db->query($sql, $pass_array)->result_array();
	}
	function get_part_based_test_report_count_new_by_user($filters = array(),$user){
        
		//$sql = "SELECT t.*,count(t.part_id) as Part_test, mp.* FROM `test_records` as t INNER JOIN monthly_plan mp on t.part_id = mp.part_id";
        $sql = "SELECT p.name as product,st.name as st_name,pp.name as part_name,pp.part_no,tr.id,COUNT(*) as test_cnt,tr.start_date,tr.end_date FROM `test_records` tr
		INNER JOIN products p ON tr.product_id = p.id
		INNER JOIN product_parts pp ON pp.id = tr.part_id
		INNER JOIN stages st ON st.id = tr.stage_id 
		LEFT JOIN users u
        ON FIND_IN_SET(tr.product_id, u.product_id) 
		WHERE tr.is_approved = 1 
		AND u.username = '".$user."'";
		
		$pass_array = array();
        
        if(!empty($filters['product_id'])) {
			$sql .= ' AND p.id = ?';
            $pass_array[] = $filters['product_id'];
        }

		if(!empty($filters['stage_id'])) {
			$sql .= ' AND st.stage_id = ?';
            $pass_array[] = $filters['stage_id'];
        }
        
        if(!empty($filters['part_id'])) {
            $sql .= ' AND pp.name = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_id1'])) {
            $sql .= ' AND pp.id = ?';
            $pass_array[] = $filters['part_id1'];
        }
		if(!empty($filters['start_date'])) {
            $sql .= ' AND tr.end_date >= ?';
            $pass_array[] = $filters['start_date'];
        }
        
        if(!empty($filters['end_date'])) {
            $sql .= ' AND tr.end_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        $sql .= '  group by pp.id order by p.id asc';
		//echo $sql;
        return $this->db->query($sql, $pass_array)->result_array();
	}
	
	function get_part_based_test_report_count_by_user($filters = array(),$user){
        
		//$sql = "SELECT t.*,count(t.part_id) as Part_test, mp.* FROM `test_records` as t INNER JOIN monthly_plan mp on t.part_id = mp.part_id";
        $sql = "SELECT t.start_date,t.end_date,t.product_id,pp.name as part_name,pp.part_no,t.start_date,count(t.part_id) as test_cnt,t.test_id,t.part_id 
		FROM `test_records` as t 
		inner join product_parts as pp
		LEFT JOIN users u
        ON FIND_IN_SET(t.product_id, u.product_id)
        
		WHERE u.username = '".$user."'";
		$sql .= " AND t.part_no IS NOT NULL ";
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
			$sql .= ' AND t.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id'])) {
            $sql .= ' AND pp.name = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['part_id1'])) {
            $sql .= ' AND pp.id = ?';
            $pass_array[] = $filters['part_id1'];
        }
		
		if(!empty($filters['start_date'])) {
            $sql .= ' AND t.start_date >= ?';
            $pass_array[] = $filters['start_date'];
        }
        
        if(!empty($filters['end_date'])) {
            $sql .= ' AND t.start_date <= ?';
            $pass_array[] = $filters['end_date'];
        }
        
        $sql .= '  group by pp.id';
		//echo $sql;
        return $this->db->query($sql, $pass_array)->result_array();
	}
	
	function get_no_lot_plan($month_year, $filters) {
        $sql = "SELECT mp.id, mp.`month_year`, mp.`supplier_id`, mp.`product_id`, mp.`part_id`, 
        mp.`planned_part_no`, mp.`test_id`, mp.schedule_date,mp.no_inspection,
        p.name as product, s.name as supplier, pp.name as part,
        t.name as test,
        CASE 
            WHEN MAX(tr.completed) IS NULL THEN 'Pending'
            WHEN MAX(tr.completed) = 0 THEN 'In Progress'
            WHEN MAX(tr.completed) = 1 THEN 'Completed'
        END as status
        FROM monthly_plan mp
        INNER JOIN suppliers s
        ON s.id = mp.supplier_id
        INNER JOIN products p
        ON p.id = mp.product_id
        INNER JOIN product_parts pp
        ON mp.part_id = pp.id
        INNER JOIN tests t
        ON t.id = mp.test_id
        LEFT JOIN test_records tr
        ON (
            mp.`month_year` = DATE_FORMAT(tr.`start_date`, '%Y-%m-01')
            AND mp.`supplier_id` = tr.supplier_id
            AND mp.product_id = tr.product_id
            AND mp.part_id = tr.part_id
            AND mp.test_id = tr.test_id
            AND tr.aborted = 0
        )
        WHERE mp.no_inspection = 'NO' AND mp.month_year = ?";
        
        
        $pass_array = array($month_year);
        if(!empty($filters['product_id'])) {
            $sql .= " AND mp.product_id = ?";
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $sql .= " AND mp.supplier_id = ?";
            $pass_array[] = $filters['supplier_id'];
        }
         if(!empty($filters['part_id'])) {
            $sql .= " AND pp.name = ?";
            $pass_array[] = $filters['part_id'];
        }
         if(!empty($filters['part_id1'])) {
            $sql .= " AND mp.part_id = ?";
            $pass_array[] = $filters['part_id1'];
        }
        if(!empty($filters['test_id'])) {
            $sql .= " AND mp.test_id = ?";
            $pass_array[] = $filters['test_id'];
        }
        
        $sql .= "GROUP BY mp.`month_year`, mp.product_id, mp.part_id, mp.`supplier_id`, mp.test_id
        ORDER BY pp.name, s.name, t.name asc";
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
	
    
}
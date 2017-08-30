<?php
class Apps_model extends CI_Model {

    function update_test($data, $id = ''){
		//echo 'app_mod1=>';
		$num = $data['part_num'];
        $needed_array = array('chamber_id', 'product_id',  'part_no','part_id', 'supplier_id', 
        'test_id', 'samples', 'duration', 'observation_frequency', 'no_of_observations', 'start_date', 'end_date',
        'aborted', 'completed','is_approved','appr_test_remark','approved_by','retest_remark','retest_id', 'extended_on', 'extended_hrs', 'switched_on', 'switched_from', 'stage_id', 'lot_no', 'test_img', 'skip_test','skip_remark');
        $data = array_intersect_key($data, array_flip($needed_array));
		$data['part_no'] = $num;
        if(empty($id)) {
            $data['created'] = date("Y-m-d H:i:s");
            $data['code'] = time();
		//echo 'app_mod2=>';echo $id.'<pre>';print_r($data);exit;
            return (($this->db->insert('test_records', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $id);
            $data['modified'] = date("Y-m-d H:i:s");            
            return (($this->db->update('test_records', $data)) ? $id : False);
        }        
    }
    
    function on_going_test_count($chamber_ids) {
        $sql = "SELECT count(tr.id) as count
        FROM test_records tr
        WHERE FIND_IN_SET(tr.chamber_id, ?)
        AND aborted = 0
        AND completed = 0
        AND skip_test != 1";
        
        $pass_array = array($chamber_ids);
        $result = $this->db->query($sql, $pass_array);
        return $result->row_array()['count'];
    }
    
    function on_going_test($chamber_ids, $date, $code = '', $limit = '') {
        $sql = "SELECT tr.*, p.name as product_name, pp.img_file as img_file,
        pp.name as part_name, pp.part_no as part_no, s.name as supplier_name,
        t.name as test_name, t.method as test_method, t.judgement as test_judgement,
		t.display_temp_set as display_temp_set,
		t.humidity_set as humidity_set,
		t.pressure_set as pressure_set,
		t.set_volt as set_volt,
        c.name as chamber_name, c.category as chamber_category, c.detail as chamber_spec,
        st.name as stage_name, st.code as stage_code,
        MAX(o.observation_index) as max_index, MAX(o.observation_at) as max_observation_at,
        count(o.observation_at) as observation_done
        FROM test_records tr
        INNER JOIN products p
        ON tr.product_id = p.id
        INNER JOIN product_parts pp
        ON tr.part_id = pp.id
        INNER JOIN suppliers s
        ON tr.supplier_id = s.id
        INNER JOIN tests t
        ON tr.test_id = t.id
        INNER JOIN chambers c
        ON tr.chamber_id = c.id
        INNER JOIN stages st
        ON tr.stage_id = st.id
        LEFT JOIN test_observations o
        ON tr.id = o.test_id
        WHERE FIND_IN_SET(tr.chamber_id, ?)
        AND aborted = 0
        AND completed = 0
        AND skip_test != 1";
        
        $pass_array = array($chamber_ids);
        if($code) {
            $sql .= " AND tr.code = ?";
            $pass_array[] = $code;
        }
        
        $sql .= " GROUP BY tr.id ".$limit;
        $result = $this->db->query($sql, $pass_array);
        
        return ($code) ? $result->row_array() : $result->result_array();
    }
    function on_going_retest($chamber_ids, $date, $code = '', $limit = '') {
        $sql = "SELECT tr.*, p.name as product_name, pp.img_file as img_file,
        pp.name as part_name, pp.part_no as part_no, s.name as supplier_name,
        t.name as test_name, t.method as test_method, t.judgement as test_judgement,
		t.display_temp_set as display_temp_set,
		t.humidity_set as humidity_set,
		t.pressure_set as pressure_set,
		t.set_volt as set_volt,
        c.name as chamber_name, c.category as chamber_category, c.detail as chamber_spec,
        st.name as stage_name, st.code as stage_code,
        MAX(o.observation_index) as max_index, MAX(o.observation_at) as max_observation_at,
        count(o.observation_at) as observation_done
        FROM test_records tr
        INNER JOIN products p
        ON tr.product_id = p.id
        INNER JOIN product_parts pp
        ON tr.part_id = pp.id
        INNER JOIN suppliers s
        ON tr.supplier_id = s.id
        INNER JOIN tests t
        ON tr.test_id = t.id
        INNER JOIN chambers c
        ON tr.chamber_id = c.id
        INNER JOIN stages st
        ON tr.stage_id = st.id
        LEFT JOIN test_observations o
        ON tr.id = o.test_id
        WHERE FIND_IN_SET(tr.chamber_id, ?)
        ";
		 $pass_array = array($chamber_ids);
        if($code) {
            $sql .= " AND tr.code = ?";
            $pass_array[] = $code;
        }
        
        $sql .= " GROUP BY tr.id order by id desc".$limit;
        $result = $this->db->query($sql, $pass_array);
        
        return $result->row_array();
    }
    
    function get_test($code = '') {
        $sql = "SELECT tr.*, p.name as product_name,
        pp.name as part_name,pp.part_no as part_num, s.name as supplier_name,
        t.name as test_name, t.method as test_method, t.judgement as test_judgement, t.test_set as test_set,
		t.display_temp_set as display_temp_set,
		t.humidity_set as humidity_set,
		t.pressure_set as pressure_set,
		t.set_volt as set_volt,
		c.name as chamber_name, c.category as chamber_category, c.detail as chamber_spec,
        st.name as stage_name, st.code as stage_code,
        MAX(o.observation_index) as max_index, MAX(o.observation_at) as max_observation_at,
        count(o.observation_at) as observation_done
        FROM test_records tr 
        INNER JOIN products p ON tr.product_id = p.id
        INNER JOIN product_parts pp ON tr.part_id = pp.id
        INNER JOIN suppliers s ON tr.supplier_id = s.id
        INNER JOIN tests t ON tr.test_id = t.id
        INNER JOIN chambers c ON tr.chamber_id = c.id
        INNER JOIN stages st ON tr.stage_id = st.id
        LEFT JOIN test_observations o ON tr.id = o.test_id
        WHERE aborted = 0";
        
        if($code) {
            $sql .= " AND tr.code like ?";
            $pass_array[] = $code;
        }
        
        $sql .= " GROUP BY tr.id";
        $result = $this->db->query($sql, $pass_array);
        
        return ($code) ? $result->row_array() : $result->result_array();
    }
	function get_test_completed($code = '') {
        $sql = "SELECT tr.*, p.name as product_name,
        pp.name as part_name, s.name as supplier_name,
        t.name as test_name, t.method as test_method, t.judgement as test_judgement,
        c.name as chamber_name, c.category as chamber_category, c.detail as chamber_spec,
        st.name as stage_name, st.code as stage_code,
        MAX(o.observation_index) as max_index, MAX(o.observation_at) as max_observation_at,
        count(o.observation_at) as observation_done
        FROM test_records tr 
        INNER JOIN products p ON tr.product_id = p.id
        INNER JOIN product_parts pp ON tr.part_id = pp.id
        INNER JOIN suppliers s ON tr.supplier_id = s.id
        INNER JOIN tests t ON tr.test_id = t.id
        INNER JOIN chambers c ON tr.chamber_id = c.id
        INNER JOIN stages st ON tr.stage_id = st.id
        LEFT JOIN test_observations o ON tr.id = o.test_id
        ";
        
        if($code) {
            $sql .= " AND tr.code = ?";
            $pass_array[] = $code;
        }
        
        $sql .= " GROUP BY tr.id";
        $result = $this->db->query($sql, $pass_array);
        echo $this->db->last_query();exit;
        return ($code) ? $result->row_array() : $result->result_array();
    }

    function add_observation($data, $id = '') {
        $needed_array = array('observation_index', 'test_id', 'observation_at', 'observation_result', 'check_items', 'display_temp_set', 'display_temp_act', 'humidity_set', 'humidity_act', 'pressure_set', 'pressure_act', 'ph_act', 'appearance', 'current', 'set_volt', 'power_watt', 'act_volt', 'torque_rpm', 'rust', 'colour', 'crack', 'adhesion', 'fog', 'salt_water_level', 'test_img', 'assistant_name');
        $data = array_intersect_key($data, array_flip($needed_array));
		// print_r($data);exit;
        if(empty($id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('test_observations', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('test_observations', $data)) ? $id : False);
        }
    }
    function add_retest_observation($data, $id = '') {
        $needed_array = array('observation_index', 'test_id', 'observation_at', 'observation_result', 'check_items', 'display_temp_set', 'display_temp_act', 'humidity_set', 'humidity_act', 'pressure_set', 'pressure_act', 'ph_act', 'appearance', 'current', 'set_volt', 'power_watt', 'act_volt', 'torque_rpm', 'rust', 'colour', 'crack', 'adhesion', 'fog', 'salt_water_level', 'test_img', 'assistant_name');
        $data = array_intersect_key($data, array_flip($needed_array));
		// print_r($data);exit;
        if(empty($id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('test_observations', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('test_observations', $data)) ? $id : False);
        }
    }
    
    function get_observations($test_id) {
        $this->db->where('test_id', $test_id);
        
        return $this->db->get('test_observations')->result_array();
    }
    
    function observation_index_exists($test_id, $observation_index) {
        $this->db->where('test_id', $test_id);
        $this->db->where('observation_index', $observation_index);
        
        return $this->db->get('test_observations')->row_array();
    }
	//for Approver
	function completed_test($product_id, $date, $code = '', $limit = '') {
		$sql = "SELECT tr.*,st.name as event_name,
		t.name as test_name, t.method as test_method, t.judgement as test_judgement,t.test_set as test_set,
        c.name as chamber_name, c.category as chamber_category, c.detail as chamber_spec,
        p.name as product_name,
		pp.name as part_name,pp.part_no as part_no,
		s.name as supplier_name
		FROM test_records tr
		INNER JOIN products p ON tr.product_id = p.id 
		INNER JOIN product_parts pp ON pp.id = tr.part_id
		INNER JOIN tests t ON tr.test_id = t.id       
		INNER JOIN chambers c ON tr.chamber_id = c.id   
		INNER JOIN stages st ON tr.stage_id = st.id        		
		INNER JOIN suppliers s ON tr.supplier_id = s.id 
		WHERE tr.completed = 1 AND tr.is_approved = 0 AND tr.product_id = ? ";
		$pass_array = array($product_id);
        if($code) {
            $sql .= " AND tr.code = ?";
            $pass_array[] = $code;
        }
        
        $sql .= " GROUP BY tr.id ".$limit;
        $result = $this->db->query($sql, $pass_array);
        //echo $this->db->last_query();exit;
        
        return ($code) ? $result->row_array() : $result->result_array();
       
       // return $result->result_array();
    }
    function view_completed_test($chamber_ids, $date, $code = '', $limit = '') {
		//echo $code;exit;
        $sql = "SELECT tr.*, p.name as product_name, pp.img_file as img_file,
        pp.name as part_name, s.name as supplier_name,
        t.name as test_name, t.method as test_method, t.judgement as test_judgement,t.test_set as test_set,
        c.name as chamber_name, c.category as chamber_category, c.detail as chamber_spec,
        st.name as stage_name, st.code as stage_code,
        MAX(o.observation_index) as max_index, MAX(o.observation_at) as max_observation_at,
        count(o.observation_at) as observation_done
        FROM test_records tr
        INNER JOIN products p
        ON tr.product_id = p.id
        INNER JOIN product_parts pp
        ON tr.part_id = pp.id
        INNER JOIN suppliers s
        ON tr.supplier_id = s.id
        INNER JOIN tests t
        ON tr.test_id = t.id
        INNER JOIN chambers c
        ON tr.chamber_id = c.id
        INNER JOIN stages st
        ON tr.stage_id = st.id
        LEFT JOIN test_observations o
        ON tr.id = o.test_id";
        
        $pass_array = array();
        if($code) {
            $sql .= " WHERE tr.code = ?";
            $pass_array[] = $code;
        }
        
        $sql .= " GROUP BY tr.id ".$limit;
        $result = $this->db->query($sql, $pass_array);
        //echo $this->db->last_query();exit;
        return ($code) ? $result->row_array() : $result->result_array();
    }
	
	function get_test_by_code($code) {
		//echo $code;exit;
        $sql = "SELECT * from test_records";
        
        $pass_array = array();
        if($code) {
            $sql .= " WHERE code = ?";
            $pass_array[] = $code;
        }
        
        $result = $this->db->query($sql, $pass_array);
        //echo $this->db->last_query();exit;
        return $result->result_array();
    }  
	function get_test_by_id($id) {
		//echo $code;exit;
        $sql = "SELECT * from test_records";
        
        $pass_array = array();
        if($id) {
            $sql .= " WHERE id = ?";
            $pass_array[] = $id;
        }
        
        $result = $this->db->query($sql, $pass_array);
        //echo $this->db->last_query();exit;
        return $result->row_array();
    }    
	function get_test_obv_by_test_id($test_id) {
		//echo $code;exit;
        $sql = "SELECT * from test_observations";
        
        $pass_array = array();
        if($test_id) {
            $sql .= " WHERE test_id = ?";
            $pass_array[] = $test_id;
        }
        
        $result = $this->db->query($sql, $pass_array);
        //echo $this->db->last_query();exit;
        return $result->result_array();
    }    
	
	function copy_test_by_code($code) {
		$sql = "
		INSERT INTO test_records(
		code,chamber_id,product_id,part_id,part_no, supplier_id,test_id,stage_id,samples,duration, observation_frequency,no_of_observations,lot_no, test_img,start_date,end_date,extended_on,extended_hrs, switched_on,switched_from,aborted,completed, skip_test,is_approved,appr_test_remark,approved_by, retest_remark,retest_id,skip_remark,created,modified) 
		
		SELECT code,chamber_id,product_id,part_id,part_no, supplier_id,test_id,stage_id,samples,duration, observation_frequency,no_of_observations,lot_no, test_img,start_date,end_date,extended_on,extended_hrs, switched_on,switched_from,aborted,completed, skip_test,is_approved,appr_test_remark,approved_by, retest_remark,retest_id,skip_remark,created,modified FROM test_records	
		";
        
        $pass_array = array();
        if($code) {
            $sql .= " WHERE code = ?";
            $pass_array[] = $code;
        }
        $this->db->query($sql, $pass_array);
        //echo $this->db->last_query();exit;
        return $this->db->insert_id();
    }
	function copy_observations_by_id($test_id) {
			
		$sql = "
		INSERT INTO test_observations(
		observation_index,test_id,observation_at,observation_result,check_items, display_temp_set,display_temp_act,humidity_set,humidity_act, pressure_set,pressure_act,ph_act, appearance,current,set_volt,power_watt,act_volt, torque_rpm,rust,colour,crack, adhesion,fog,salt_water_level,test_img, assistant_name,created,modified) 
		
		SELECT observation_index,test_id,observation_at,observation_result,check_items, display_temp_set,display_temp_act,humidity_set,humidity_act, pressure_set,pressure_act,ph_act, appearance,current,set_volt,power_watt,act_volt, torque_rpm,rust,colour,crack, adhesion,fog,salt_water_level,test_img, assistant_name,created,modified FROM test_observations	
		";
        
        $pass_array = array();
        if($test_id) {
            $sql .= " WHERE test_id = ?";
            $pass_array[] = $test_id;
        }
        $this->db->query($sql, $pass_array);
        //echo $this->db->last_query();exit;
        return $this->db->insert_id();
    }    
}
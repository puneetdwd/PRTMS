<?php
class Test_model extends CI_Model {

    function add_test($data, $test_id){
        $needed_array = array('code', 'name', 'method', 'judgement', 'duration', 'test_set');
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
        
    function get_all_tests() {
        $sql = 'SELECT id, code, name, method, judgement, duration FROM tests';
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_test($id) {
        $this->db->where('id', $id);

        return $this->db->get('tests')->row_array();
    }
    
    function get_test_by_code($code) {
        $this->db->where('code', $code);

        return $this->db->get('tests')->row_array();
    }
    
    function get_test_by_name($name) {
        $this->db->where('name', $name);

        return $this->db->get('tests')->row_array();
    }

    function get_ptc_mappings($filters = array()) {
        $sql = "SELECT ptc.*, p.name as product_name, 
        pp.name as part_name, 
        t.name as test_name, 
        c.name as chamber_name, c.category as chamber_category
        FROM ptc_mappings ptc
        INNER JOIN products p
        ON ptc.product_id = p.id
        INNER JOIN tests t
        ON ptc.test_id = t.id
        INNER JOIN product_parts pp
        ON ptc.part_id = pp.id
        INNER JOIN chambers c
        ON ptc.chamber_id = c.id";
        
        $wheres = array();
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $wheres[] = 'ptc.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id'])) {
            $wheres[] = 'ptc.part_id = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['test_id'])) {
            $wheres[] = 'ptc.test_id = ?';
            $pass_array[] = $filters['test_id'];
        }
        
        if(!empty($filters['chamber_id'])) {
            $wheres[] = 'ptc.chamber_id = ?';
            $pass_array[] = $filters['chamber_id'];
        }
        
        if(!empty($filters['chamber_category'])) {
            $wheres[] = 'c.category = ?';
            $pass_array[] = $filters['chamber_category'];
        }
        
        if(!empty($wheres)) {
            $sql .= " WHERE ".implode(' AND ', $wheres);
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function get_tests_by_partcategory_chamber($part_category_id, $chamber_id) {
        $sql = "SELECT t.id, t.name
        FROM ptc_mappings ptc
        INNER JOIN tests t
        ON ptc.test_id = t.id
        WHERE ptc.part_category_id = ?
        AND ptc.chamber_id = ?";
        
        return $this->db->query($sql, array($part_category_id, $chamber_id))->result_array();
    }
    
    function get_tests_by_part_chamber($part_id, $chamber_id) {
        $sql = "SELECT t.id, t.name
        FROM ptc_mappings ptc
        INNER JOIN tests t
        ON ptc.test_id = t.id
        WHERE ptc.part_id = ?
        AND ptc.chamber_id = ?";
        
        return $this->db->query($sql, array($part_id, $chamber_id))->result_array();
    }
    
    function get_tests_by_part($part_id) {
        $sql = "SELECT DISTINCT t.id, t.name
        FROM ptc_mappings ptc
        INNER JOIN tests t
        ON ptc.test_id = t.id
        WHERE ptc.part_id = ?";
        
        return $this->db->query($sql, array($part_id))->result_array();
    }
    
    function get_chambers_by_part_test($part_id, $test_id, $allowed_chambers = array()) {
        $sql = "SELECT c.id, c.name
        FROM ptc_mappings ptc
        INNER JOIN chambers c
        ON ptc.chamber_id = c.id
        WHERE ptc.part_id = ?
        AND ptc.test_id = ?";
        
        $pass_array = array($part_id, $test_id);
        if(!empty($allowed_chambers)) {
            $sql .= " AND ptc.chamber_id IN (". implode(',', array_fill(0, count($allowed_chambers), '?')).")";
            $pass_array = array_merge($pass_array, $allowed_chambers);
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }
    
    function insert_ptc_mappings($data) {
        $this->db->insert_batch('ptc_mappings', $data);
    }
    
    function remove_dups() {
        $sql = "DELETE FROM ptc_mappings WHERE id NOT IN (
            SELECT * FROM (
                SELECT min(id) FROM ptc_mappings GROUP BY product_id, part_id, test_id, chamber_id
            ) as sub
        )";
        
        return $this->db->query($sql);
    }
    
    function add_ptc_mapping($data, $ptc_mapping_id){
        $needed_array = array('product_id', 'part_id', 'test_id', 'chamber_id');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($ptc_mapping_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('ptc_mappings', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $ptc_mapping_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('ptc_mappings', $data)) ? $ptc_mapping_id : False);
        }
        
    }

    function delete_ptc_mapping($ptc_mapping_id) {
        if(!empty($ptc_mapping_id)) {
            $this->db->where('id', $ptc_mapping_id);
            $this->db->delete('ptc_mappings');
            
            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
    
    function delete_ptc_mapping_by_partcatgory_chamber($product_id, $part_category_id, $test_id, $chamber_ids = array()) {
        if(!empty($part_category_id) && !empty($test_id)) {
            $this->db->where('product_id', $product_id);
            $this->db->where('part_category_id', $part_category_id);
            $this->db->where('test_id', $test_id);
            
            if(!empty($chamber_ids)) {
                $this->db->where_in('chamber_id', $chamber_ids);
            }
            
            $this->db->delete('ptc_mappings');
            
            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
}
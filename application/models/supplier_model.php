<?php
class Supplier_model extends CI_Model {

    function add_supplier($data, $supplier_id){
        $needed_array = array('name', 'supplier_no');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(!empty($data['name'])) {
            $data['name'] = ucwords(strtolower($data['name']));
        }
        
        if(empty($supplier_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('suppliers', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $supplier_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('suppliers', $data)) ? $supplier_id : False);
        }
        
    }
        
    function get_all_suppliers(){
        $sql = 'SELECT id, name, supplier_no FROM suppliers';
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_supplier($id) {
        $this->db->where('id', $id);

        return $this->db->get('suppliers')->row_array();
    }

    function get_supplier_by_name($name) {
        $this->db->where('name', $name);
        $this->db->where('is_deleted', 0);
        
        return $this->db->get('suppliers')->row_array();
    }

    function get_supplier_by_code($code) {
        $this->db->where('supplier_no', $code);
        $this->db->where('is_deleted', 0);
        
        return $this->db->get('suppliers')->row_array();
    }
    
    function get_all_sp_mappings($filters) {
        $sql = "SELECT sp.*, s.name as supplier_name, s.supplier_no,
        pp.name as part_name,pp.part_no as part_no, p.name as product_name
        FROM sp_mappings sp
        INNER JOIN suppliers s
        ON sp.supplier_id = s.id
        INNER JOIN product_parts pp
        ON sp.part_id = pp.id
        INNER JOIN products p
        ON pp.product_id = p.id";
        
        $wheres = array();
        $pass_array = array();
        
        if(!empty($filters['product_id'])) {
            $wheres[] = 'sp.product_id = ?';
            $pass_array[] = $filters['product_id'];
        }
        
        if(!empty($filters['part_id'])) {
            $wheres[] = 'sp.part_id = ?';
            $pass_array[] = $filters['part_id'];
        }
        
        if(!empty($filters['supplier_id'])) {
            $wheres[] = 'sp.supplier_id = ?';
            $pass_array[] = $filters['supplier_id'];
        }
        
        if(!empty($wheres)) {
            $sql .= " WHERE ".implode(' AND ', $wheres);
        }
        
        return $this->db->query($sql, $pass_array)->result_array();
    }

    function get_sp_mapping($sp_mapping) {
        $sql = "SELECT sp.*, s.name as supplier_name, s.supplier_no,
        pp.name as part_name
        FROM sp_mappings sp
        INNER JOIN suppliers s
        ON sp.supplier_id = s.id
        INNER JOIN product_parts pp
        ON sp.part_id = pp.id
        WHERE sp.id = ?";
        
        return $this->db->query($sql, array($sp_mapping))->result_array();
    }
    
    function get_suppliers_by_part($part_id) {
        $sql = "SELECT s.id, s.name, s.supplier_no
        FROM sp_mappings sp
        INNER JOIN suppliers s
        ON sp.supplier_id = s.id
        WHERE sp.part_id = ?";
        
        return $this->db->query($sql, array($part_id))->result_array();
    }
    
    function insert_sp_mappings($data) {
        $this->db->insert_batch('sp_mappings', $data);
    }
    
    function remove_dups() {
        $sql = "DELETE FROM sp_mappings WHERE id NOT IN (
            SELECT * FROM (
                SELECT min(id) FROM sp_mappings GROUP BY supplier_id, part_id
            ) as sub
        )";
        
        return $this->db->query($sql);
    }
    
    function add_sp_mapping($data, $sp_mapping_id){
        $needed_array = array('supplier_id', 'product_id', 'part_id');
        $data = array_intersect_key($data, array_flip($needed_array));
		//print_r($data);exit;
        if(empty($sp_mapping_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('sp_mappings', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $sp_mapping_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('sp_mappings', $data)) ? $sp_mapping_id : False);
        }
        
    }
    
    function insert_suppliers($suppliers) {
        $this->db->insert_batch('suppliers', $suppliers);
        
        $this->remove_dups_suppliers();
    }
    
    function remove_dups_suppliers() {
        $sql = "DELETE FROM suppliers 
        WHERE id NOT IN (
            SELECT * FROM (
                SELECT MIN(id) 
                FROM suppliers 
                GROUP BY supplier_no, name
            ) as d
        )";
        
        return $this->db->query($sql, array($product_id, $product_id));
    }
}
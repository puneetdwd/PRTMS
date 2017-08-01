<?php
class Product_model extends CI_Model {

    function add_product($data, $product_id){
        $needed_array = array( 'name', 'code');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($product_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('products', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $product_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('products', $data)) ? $product_id : False);
        }
        
    }
        
    function get_all_products(){
        $sql = 'SELECT id, name, code FROM products';
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_product($id) {
        $this->db->where('id', $id);

        return $this->db->get('products')->row_array();
    }
	function get_product_session($id) {
        $this->db->where('id', $id);

        return $this->db->get('products')->result_array();
    }

    function get_all_product_parts($product_id) {
        $sql = "SELECT pp.*
        FROM product_parts pp
        WHERE pp.is_deleted = 0
        AND pp.product_id = ?
        ORDER BY pp.name";
        
        return $this->db->query($sql, array($product_id))->result_array();
    }
    
	function get_part_num_by_part($part_name,$product_id) {
		$sql = "SELECT pp.*
        FROM product_parts pp
        WHERE pp.is_deleted = 0
        AND pp.name like ? AND pp.product_id = ?
        ORDER BY pp.name";        
		
        return $this->db->query($sql, array($part_name,$product_id))->result_array();
    }
    
    function get_all_parts() {
       $sql = "SELECT pp.*, p.name as product_name, 
       p.code as product_code
       FROM product_parts as pp
       INNER JOIN products as p
       ON pp.product_id = p.id";
       
       return $this->db->query($sql)->result_array();
    }
    
    function get_product_part($product_id, $id) {
        $sql = "SELECT pp.*
        FROM product_parts pp
        WHERE pp.is_deleted = 0
        AND pp.product_id = ?
        AND pp.id = ?";
        
        return $this->db->query($sql, array($product_id, $id))->row_array();
    }
    
    function get_product_parts_by_category($product_id, $category) {
        $this->db->where('product_id', $product_id);
        $this->db->where('category', $category);
        
        return $this->db->get('product_parts')->result_array();
    }
    
    function get_product_part_by_name($product_id, $name) {
        $this->db->where('name', $name);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_deleted', 0);
        
        return $this->db->get('product_parts')->row_array();
    }

    function get_product_part_by_code($product_id, $code) {
        $this->db->where('code', $code);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_deleted', 0);
        
        return $this->db->get('product_parts')->row_array();
    }

	function get_product_part_by_code_num($product_id, $num) {
        //$this->db->where('code', $code);
        $this->db->where('part_no', $num);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_deleted', 0);
        
        return $this->db->get('product_parts')->row_array();
    }
    
	function get_part_numbers_by_name($product_id, $name) {
		
        $this->db->where('name', $name);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_deleted', 0);
        
        return $this->db->get('product_parts')->result_array();
    }
    function get_part_number_by_id($product_id, $id) {
		
        $this->db->where('id', $id);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_deleted', 0);
        
        return $this->db->get('product_parts')->row_array();
    }
    
    function update_product_part($data, $part_id){
        $needed_array = array('code', 'name', 'part_no','img_file', 'category', 'product_id', 'is_deleted');
        $data = array_intersect_key($data, array_flip($needed_array));
		 //print_r($data);exit;
        if(empty($part_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('product_parts', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $part_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('product_parts', $data)) ? $part_id : False);
        }
		
    }

    function insert_parts($parts, $product_id) {
        //print_r($parts);exit;
        $this->db->insert_batch('product_parts', $parts);
        $this->remove_dups_parts($product_id);
		
    }
    
    function remove_dups_parts($product_id) {
        $sql = "DELETE FROM product_parts 
        WHERE id NOT IN (
            SELECT * FROM (
                SELECT MIN(id) 
                FROM product_parts 
                WHERE product_id = ? 
                GROUP BY product_id, part_no
            ) as d
        ) AND product_id = ?";
        
        return $this->db->query($sql, array($product_id, $product_id));
    }
	
	 function allowed_products($username) {
        $sql = "SELECT u.*, 
        GROUP_CONCAT(c.id ORDER BY c.name SEPARATOR ',') as chamber_ids,
        GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ',') as chamber_name ,
		GROUP_CONCAT(p.id ORDER BY p.name SEPARATOR ',') as product_ids,
        GROUP_CONCAT(p.name ORDER BY p.name SEPARATOR ',') as product_name 
        FROM users u
        LEFT JOIN chambers c
        ON FIND_IN_SET(c.id, u.chamber_id)
        LEFT JOIN products p
        ON FIND_IN_SET(p.id, u.product_id)
        WHERE u.username = ?
        GROUP BY u.id";
        
        $pass_array = array($username);

        return $this->db->query($sql, $pass_array)->row_array();
    }
	
	function get_all_products_by_user($username){
	$sql = "SELECT p.*
        FROM products p
        LEFT JOIN users u
        ON FIND_IN_SET(p.id, u.product_id)
        WHERE u.username = ?
        GROUP BY p.id";
        
        $pass_array = array($username);

        return $this->db->query($sql, $pass_array)->result_array();	
	}
}
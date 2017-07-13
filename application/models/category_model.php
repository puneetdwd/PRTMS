<?php
class Category_model extends CI_Model {

    function add_category($data, $category_id){
        $needed_array = array('name');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($category_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('part_categories', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $category_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('part_categories', $data)) ? $category_id : False);
        }
        
    }
        
    function get_all_categories(){
        $sql = 'SELECT id, name FROM part_categories';
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_category($id) {
        $this->db->where('id', $id);

        return $this->db->get('part_categories')->row_array();
    }
    
    function get_category_by_name($name) {
        $this->db->where('name', $name);

        return $this->db->get('part_categories')->row_array();
    }

}
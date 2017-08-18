<?php
class Chamber_model extends CI_Model {

    function add_chamber($data, $chamber_id){
        $needed_array = array( 'name', 'code', 'category', 'detail');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($chamber_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('chambers', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $chamber_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('chambers', $data)) ? $chamber_id : False);
        }
        
    }
        
    function get_all_chambers(){
        $sql = 'SELECT id, name, code, category, detail FROM chambers';
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_chamber_categories() {
        $sql = 'SELECT DISTINCT category FROM chambers';        
        return $this->db->query($sql)->result_array();
    }
    
    function get_chamber($id) {
        $this->db->where('id', $id);
        return $this->db->get('chambers')->row_array();
    }
    
    function get_chamber_by_name($name) {
        $this->db->where('name', $name);

        return $this->db->get('chambers')->row_array();
    }
    
    function get_chambers_by_category($category) {
        $this->db->where('category', $category);

        return $this->db->get('chambers')->result_array();
    }

}
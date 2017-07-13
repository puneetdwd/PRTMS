<?php
class Stage_model extends CI_Model {

    function add_stage($data, $stage_id){
        $needed_array = array( 'name', 'code');
        $data = array_intersect_key($data, array_flip($needed_array));

        if(empty($stage_id)) {
            $data['created'] = date("Y-m-d H:i:s");
            return (($this->db->insert('stages', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $stage_id);
            $data['modified'] = date("Y-m-d H:i:s");
            
            return (($this->db->update('stages', $data)) ? $stage_id : False);
        }
        
    }
        
    function get_all_stages(){
        $sql = 'SELECT id, name, code FROM stages';
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_stage($id) {
        $this->db->where('id', $id);

        return $this->db->get('stages')->row_array();
    }
    
    function get_stage_by_name($name) {
        $this->db->where('name', $name);

        return $this->db->get('stages')->row_array();
    }

}
<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();

        require_once APPPATH .'libraries/pass_compat/password.php';
        $this->load->database();
    }

    function get_all_users() {
        $sql = "SELECT u.*, 
        GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ', ') as chamber_name, 
        GROUP_CONCAT(p.name ORDER BY p.name SEPARATOR ', ') as product_name 
        FROM users u
        LEFT JOIN chambers c
        ON FIND_IN_SET(c.id, u.chamber_id)
        LEFT JOIN products p
        ON FIND_IN_SET(p.id, u.product_id)
        GROUP BY u.id";
        
        $pass_array = array();
        
        $users = $this->db->query($sql, $pass_array);
        return $users->result_array();
    }

    function get_user($username) {
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
    
    function get_user_by_type($user_type) {
        $this->db->where('user_type', $user_type);
        
        return $this->db->get('users')->result_array();
    }

    function is_username_exists($username, $id = '') {
        if(!empty($id)) {
            $this->db->where('id !=', $id);
        }

        $this->db->where('username', $username);

        return $this->db->count_all_results('users');
    }

    function update_user($data, $user_id = '') {
        //filter unwanted fields while inserting in table.
        $needed_array = array('chamber_id', 'product_id', 'first_name', 'last_name', 'username', 'password', 'user_type', 'is_active');
        $data = array_intersect_key($data, array_flip($needed_array));
		//print_r($data);exit;
        if(!empty($data['password'])) {
            $cost = $this->config->item('hash_cost');
            $data['password'] = password_hash(SALT .$data['password'], PASSWORD_BCRYPT, array('cost' => $cost));
        } else {
            unset($data['password']);
        }

        if(empty($user_id)) {
            $data['created'] = date("Y-m-d H:i:s");

            return (($this->db->insert('users', $data)) ? $this->db->insert_id() : False);
        } else {
            $this->db->where('id', $user_id);
            $data['modified'] = date("Y-m-d H:i:s");

            return (($this->db->update('users', $data)) ? $user_id : False);
        }
    }

    function login_check($username, $password, $only_check = false) {
        if (empty($username) || empty($password)) {
            return False;
        }

        $response['status'] = 'ERROR';
        $response['message'] = 'Invalid Credentials';

        $user = $this->get_user($username);

        if (!empty($user)) {

            if (password_verify(SALT .$password, $user['password'])) {
                if(!$user['is_active']) {
                    $response['message'] = 'Your acount has been deactivated.';
                } else {

                    $response['status'] = 'SUCCESS';
                    
                    if(!$only_check) {
                        $data = array(
                            'is_logged_in' => True,
                            'id' => $user['id'],
                            'first_name' => $user['first_name'],
                            'last_name' => $user['last_name'],
                            'name' => $user['first_name'].' '.$user['last_name'],
                            'username' => $user['username'],
                            'user_type' => $user['user_type'],
                            'chamber_ids' => $user['chamber_id'],
                        );
                        
                        if($user['user_type'] != 'Admin') {
                            $chamber_ids = explode(',', $user['chamber_ids']);
                            $chamber_names = explode(',', $user['chamber_name']);
                            
                            $chambers = array();
                            
                            if(count($chamber_ids)) {
                                foreach($chamber_ids as $k => $cid) {
                                    if($k === 0) {
                                        $data['chamber_id']     = $cid;
                                        $data['chamber_name']   = $chamber_names[$k];
                                    }
                                    
                                    $temp = array();
                                    $temp['id'] = $cid;
                                    $temp['name'] = $chamber_names[$k];
                                    
                                    $chambers[] = $temp;
                                }

                            }
                            
                            $data['chambers'] = $chambers;
                        } else {
                            $chs = "SELECT GROUP_CONCAT(c.id ORDER BY c.name SEPARATOR ',') as chamber_ids
                            FROM chambers c";
                            
                            $chs = $this->db->query($chs)->row_array();
                            $data['chamber_ids'] = $chs['chamber_ids'];
                        }

                        $this->session->set_userdata($data);
                    }
                    return $response;
                }
            }
        }

        return $response;
    }

    function change_password($id, $password) {
        if(!empty($password)) {
            $cost = $this->config->item('hash_cost');
            $password = password_hash(SALT .$password, PASSWORD_BCRYPT, array('cost' => $cost));

            $this->db->where('id', $id);
            $this->db->set('password', $password);

            $this->db->update('users');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }

        }

        return False;
    }

    function change_status($username, $status) {
        if(!empty($username) && !empty($status)) {
            $user_active = ($status == 'active') ? 1 : 0;
            
            $this->db->where('username', $username);
            $this->db->set('is_active', $user_active);
            $this->db->update('users');

            if($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }
}
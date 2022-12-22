<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function add_user($data){
        $this->db->insert('users', $data);
    }

    public function get_user_employee($employee_id){
        return $this->db->get_where('users', ['employee_id' => $employee_id])->row_array();
    }

    public function get_user_by_id($user_id){
        return $this->db->get_where('users', ['user_id' => $user_id])->row_array();
    }

    public function update_user($user_id, $data){
        $this->db->set($data)
                ->where('user_id', $user_id)
                ->update('users');
    }

}

/* End of file Users_model.php */

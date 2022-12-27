<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

    public function get_department(){
        return $this->db->get('department')->result_array();
    }

    public function count_department(){
        return $this->db->count_all('department');
    }

    public function get_department_by_id($department_id){
        return $this->db->get_where('department',['department_id' => $department_id])->row_array();
    }

    public function add_department($data){
        $this->db->insert('department', $data);
    }

    public function update_department($department_id, $data){
        $this->db->set($data)
                ->where('department_id', $department_id)
                ->update('department');
    }

    public function remove_department($department_id){
        $this->db->delete('department', ['department_id' => $department_id]);
    }

}

/* End of file Department_model.php */

<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function get_employee(){
        return $this->db->select('*')
                        ->from('employee')
                        ->join('department','department.department_id = employee.department_id')
                        ->join('users','users.employee_id = employee.employee_id')
                        ->get()
                        ->result_array();
    }

    public function get_employee_aktif($aktif){
        return $this->db->select('*')
                        ->from('employee')
                        ->join('department','department.department_id = employee.department_id')
                        ->join('users','users.employee_id = employee.employee_id')
                        ->where('is_active', $aktif)
                        ->get()
                        ->result_array();
    }

    public function get_employee_with_aktif($aktif){
        return $this->db->select('*')
                        ->from('employee')
                        ->join('department','department.department_id = employee.department_id')
                        ->join('users','users.employee_id = employee.employee_id')
                        ->where('is_active', $aktif)
                        ->get()
                        ->num_rows();
    }

    public function get_employee_with_user($employee_id){
        return $this->db->select('employee.*, users.email, users.user_id, users.is_active, department.name_department')
                        ->from('employee')
                        ->where('employee.employee_id', $employee_id)
                        ->join('department','department.department_id = employee.department_id')
                        ->join('users','users.employee_id = employee.employee_id')
                        ->get()
                        ->row_array();
    }

    public function get_employee_by_id($employee_id){
        return $this->db->get_where('employee', ['employee_id' => $employee_id])->row_array();
    }

    public function check_employee_by_department($department_id){
        return $this->db->get_where('employee', ['department_id' => $department_id])->row_array();
    }

    public function get_last_employee(){
        return $this->db->query("SHOW TABLE STATUS WHERE name='employee'")->row_array();
    }

    public function add_employe($data){
        $this->db->insert('employee',$data);
    }

    public function update_profile($employee_id, $data){
        $this->db->set($data)
                ->where('employee_id', $employee_id)
                ->update('employee');
    }

}

/* End of file Employee_model.php */

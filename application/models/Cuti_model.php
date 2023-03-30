<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti_model extends CI_Model {

    public function get_cuti($employee_id = ''){
        $this->db->select('cuti.*, e.employee_id , e.image_profile , e.full_name, e.remaining_days_off as total_day')
                ->from('cuti')
                ->join('employee as e', 'e.employee_id = cuti.employee_id');
        if ($employee_id != '') {
            $this->db->where('cuti.employee_id', $employee_id);
        }
        $this->db->order_by('cuti_id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_cuti_by_id($cuti_id){
        return $this->db->get_where('cuti', ['cuti_id' => $cuti_id])->row_array();
    }

    public function get_cuti_datenow($employee_id, $date){
        return $this->db->get_where('cuti', ['employee_id' => $employee_id, 'submission_date' => $date])->row_array();
    }

    public function get_count_cuti_pending(){
        return $this->db->get_where('cuti', ['cuti_status' => 'P'])->num_rows();
    }

    public function add_cuti($data){
        $this->db->insert('cuti',$data);
    }

    public function update_cuti($cuti_id, $data){
        $this->db->set($data)
                ->where('cuti_id', $cuti_id)
                ->update('cuti');
    }
    public function delete_cuti($cuti_id){
        $this->db->delete('cuti', ['cuti_id' => $cuti_id]);
    }

}
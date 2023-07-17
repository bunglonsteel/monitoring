<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Cleanliness_model extends CI_Model {

    public function get(){
        return $this->db->get('cleanliness')->result_array();
    }

    public function get_cleanliness_by_id($cleanliness_id){
        return $this->db->get_where('cleanliness', ['cleanliness_id' => $cleanliness_id])->row_array();
    }

    public function get_cleanliness_progress(){
        return $this->db->select('*')
                        ->from('cleanliness_progress as cp')
                        ->join('cleanliness as c', 'c.cleanliness_id = cp.cleanliness_id')
                        ->where('cp.cleanliness_date', date('Y-m-d'))
                        ->order_by('cp.cleanliness_progress_id','DESC')
                        ->get()
                        ->result_array();
    }

    public function get_laporan_by_month($bulan){
        return $this->db->select("employee_id, 
                                    DATE_FORMAT(cleanliness_date, '%m-%Y') as month, 
                                    COUNT(DISTINCT cleanliness_date) as total_date,
                                    sum(if(cleanliness_status,1,0)) as selesai,
                                    sum(if(cleanliness_status = 'P',1,0)) as not_yet_review,
                                    sum(if(cleanliness_status = 'D',1,0)) as must_be_improved,
                                    sum(if(cleanliness_status = 'G',1,0)) as good,
                                    sum(if(cleanliness_status = 'VG',1,0)) as very_good,
                                    ")
                        ->from('cleanliness_progress')
                        ->where('DATE_FORMAT(cleanliness_date, "%m-%Y")=', $bulan)
                        ->group_by('employee_id')
                        ->get()
                        ->row_array();
    }

    public function get_cleanliness_progress_by($array){
        return $this->db->get_where('cleanliness_progress', $array)->row_array();
    }

    public function get_in($table, $key, $where_in)
    {
        return $this->db->from($table)
            ->where_in($key, $where_in)
            ->get();
    }

    public function add($table, $data){
        $this->db->insert($table, $data);
    }

    public function update($table, $array ,$data){
        $this->db->set($data)
                ->where($array)
                ->update($table);
    }

    public function delete($table, $array){
        $this->db->delete($table, $array);
    }

}

/* End of file Cleanliness_model.php */

<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Notes_model extends CI_Model {

    public function get($table){
        return $this->db->get($table)->result_array();
    }

    public function get_notes($user = false){
        $this->db->select('n.*, nc.*, nct.*')
                    ->from('notes as n')
                    ->join('notes_client as nc', 'n.notes_client_id = nc.notes_client_id')
                    ->join('notes_category as nct', 'n.notes_category_id = nct.notes_category_id');
        if ($user) {
            $this->db->where('n.notes_status', 'PUB');
        }

        return $this->db->order_by('notes_id','desc')
                    ->get()
                    ->result_array();
    }

    public function get_notes_client(){
        return $this->db->select('nc.*, ns.*')
                    ->from('notes_client as nc')
                    ->join('notes_standard as ns', 'nc.notes_standard_id = ns.notes_standard_id')
                    ->get()
                    ->result_array();
    }

    public function check_notes($notes_id){
        return $this->db->get_where('notes', ['notes_id' => $notes_id])->row_array();
    }

    public function check_notes_standard($standard_name, $ns_id){
        if($ns_id){
            $this->db->select('ns.*, nc.*')
                    ->from('notes_standard as ns')
                    ->join('notes_client as nc', 'nc.notes_standard_id = ns.notes_standard_id')
                    ->where('nc.notes_standard_id', $ns_id);
        } else {
            $this->db->select('*')
                    ->from('notes_standard')
                    ->where('notes_standard', $standard_name);
        }

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function check_notes_client($notes_client, $notes_standard_id, $nc_id){
        if($nc_id){
            $this->db->select('nc.*, n.*')
                    ->from('notes_client as nc')
                    ->join('notes as n', 'nc.notes_client_id = n.notes_client_id')
                    ->where('n.notes_client_id', $nc_id);
        } else {
            $this->db->select('*')
                    ->from('notes_client')
                    ->where('notes_standard_id', $notes_standard_id)
                    ->where('notes_client', $notes_client);
        }

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function check_notes_category($category_name, $cat_id){
        if($cat_id){
            $this->db->select('n.*, nc.*')
                    ->from('notes as n')
                    ->join('notes_category as nc', 'nc.notes_category_id = n.notes_category_id')
                    ->where('nc.notes_category_id', $cat_id);
        } else {
            $this->db->select('*')
                    ->from('notes_category')
                    ->where('notes_category_name', $category_name);
        }

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    public function add($table, $data){
        $this->db->insert($table, $data);
    }

    public function remove($table, $data){
        $this->db->delete($table, $data);
    }

    public function update($table, $query, $data){
        $this->db->set($data)
                ->where($query)
                ->update($table);
    }

}

/* End of file Notes_model.php */

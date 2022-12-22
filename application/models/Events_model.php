<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Events_model extends CI_Model {

    public function get($table){
        return $this->db->get($table)->result_array();
    }

    public function add($table, $data){
        $this->db->insert($table, $data);
    }

    public function update($table, $event_id, $data){
        $this->db->set($data)
                ->where('event_id', $event_id)
                ->update($table);
    }

    public function delete($table, $event_check){
        $this->db->delete($table, $event_check);
    }

    public function get_event_by_id($table, $event_check){
        return $this->db->get_where($table, $event_check)->row_array();
    }
}

/* End of file Events_model.php */

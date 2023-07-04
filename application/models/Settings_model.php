<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function get_settings()
    {
        return $this->db->get_where('settings',['id_settings'=> 1])->row_array();
    }
    
    public function update_settings($data){
        $this->db->set($data)
                ->where('id_settings', 1)
                ->update('settings');
    }

    public function get_option($option)
    { 
        return $this->db->get_where('options', ['option_type' => $option])->row();
    }
}

/* End of file Settings_model.php */

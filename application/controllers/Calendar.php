<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('Employee_model');
        $this->load->model('Settings_model');
        $this->load->model('Department_model');
        $this->load->model('Absensi_model');
        $this->load->model('Cuti_model');
        
    }

    public function index()
    {   
        if ($this->session->userdata('role_id') == 2) {
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        }
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['absensi'] = $this->Absensi_model->get_absensi();

        $birth_employee = $this->db->select("u.employee_id, u.is_active, e.employee_id, e.full_name, e.image_profile, DATE_FORMAT(e.birth_date, '-%m-%d') as birth")
                            ->from('users as u')
                            ->join('employee as e', 'e.employee_id = u.employee_id')
                            ->where('u.is_active', 1)
                            ->get()
                            ->result_array();

        $cuti = $this->db->select("c.employee_id, c.cuti_type, c.start_date, c.end_date, c.cuti_status, e.full_name, e.image_profile")
                            ->from('cuti as c')
                            ->join('employee as e', 'c.employee_id = e.employee_id')
                            ->where("(c.cuti_status='A' OR c.cuti_status='AC')", null)
                            ->get()
                            ->result_array();

        $events = $this->db->select("e.event_title, e.start_date, e.end_date, e.event_location")
                            ->from('events as e')
                            ->where('e.end_date >=', date('Y-m-d'))
                            ->get()
                            ->result_array();

                            // var_dump(json_encode($events));die;

        $data['employee_list'] = json_encode($birth_employee);
        $data['cuti_list'] = json_encode($cuti);
        $data['event_list'] = json_encode($events);

        $data['title'] = 'Calendar';
        $data['slug'] = 'Calendar';
        $data['judul'] = 'Calendar Hari ini';
        render_template('calendar', $data);
    }

}

/* End of file Calendar.php */

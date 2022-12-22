<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        check_login();
        $this->load->model('Settings_model');
        $this->load->model('Employee_model');
        $this->load->model('Absensi_model');
        $this->load->model('Department_model');
    }
    
    public function index() {
        $data['settings'] = $this->Settings_model->get_settings();
        $data['title'] = 'Dashboard';

        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        if ($this->session->userdata('role_id') == 2) {
            
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
            
            $data['total_hadir'] = $this->Absensi_model->count_absensi_by_day(1);
            $data['total_izin'] = $this->Absensi_model->count_absensi_by_day(2);
            $data['total_sakit'] = $this->Absensi_model->count_absensi_by_day(3);
            $data['total_department'] = $this->Department_model->count_department();
            $data['total_karyawan_aktif'] = $this->Employee_model->get_employee_with_aktif(1);
            $data['total_karyawan_keluar'] = $this->Employee_model->get_employee_with_aktif(0);
            $grafik = $this->Absensi_model->get_absensi_per_month();

            // var_dump($grafik);die;
            foreach ($grafik as $value) {
                $data['tgl'][] = $value['date'];
                $data['hadir'][] = $value['hadir'];
                $data['izin'][] = $value['izin'];
                $data['sakit'][] = $value['sakit'];
            }

            // var_dump($data['sakit']);die;
            
            render_template('admin/dashboard', $data);
        } else {
            $data['total_izin'] = $this->Absensi_model->count_absensi_by_employee($data['employee']['employee_id'],2);
            // var_dump( $data['total_izin']);die;
            $data['total_sakit'] = $this->Absensi_model->count_absensi_by_employee($data['employee']['employee_id'],3);
            $data['check_absen'] = $this->Absensi_model->check_absensi_employee($data['employee']['employee_id']);
            render_template('users/dashboard', $data);
        }
    }

}

/* End of file Dashboard.php */

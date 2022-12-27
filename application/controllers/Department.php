<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        
        check_login();
        check_user_acces();
        $this->load->model('Settings_model');
        $this->load->model('Department_model');
        $this->load->model('Employee_model');
        
    }
    

    public function index()
    {
        $this->load->model('Cuti_model');
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['department'] = $this->Department_model->get_department();

        $data['title'] = 'Department';
        $data['slug'] = 'Department';
        $data['judul'] = 'Department / Bagian';
        render_template('admin/department', $data);
    }

    public function tambah_department(){

        $this->form_validation->set_rules('name_department', 'Department', 'trim|required|is_unique[department.name_department]');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            if ($this->form_validation->run() == false) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible fade show fs-7">', '</div>'),
                    'buttontext' => 'Oke, tutup'
                ];
            } else {

                $nama_department = $this->input->post('name_department', TRUE);
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Department berhasil ditambahkan.',
                    'buttontext' => 'Oke, tutup'
                ];
                $this->Department_model->add_department(['name_department' => $nama_department]);
            }
            echo json_encode($message);
        }
    }

    public function edit_department($department_id = ''){

        $this->form_validation->set_rules('name_department', 'Department', 'trim|required|is_unique[department.name_department]');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            if ($this->form_validation->run() == false) {
                $message = [
                    'errors' => 'true',
                    'title' => 'Gagal!',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible fade show fs-7">', '</div>'),
                    'csrfHash' => $this->security->get_csrf_hash(),
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $chek_department = $this->Department_model->get_department_by_id($department_id);
                if ($chek_department) {
                    $nama_department = $this->input->post('name_department', TRUE);
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Department berhasil diupdate.',
                        'buttontext' => 'Oke, Terimakasih'
                    ];
                    $this->Department_model->update_department($department_id, ['name_department' => $nama_department]);
                } else {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Department tidak ada mohon maaf.',
                        'buttontext' => 'Oke, tutup'
                    ];
                }
            }
            echo json_encode($message);
        }
    }

    public function hapus_department($department_id){

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            $check = $this->Employee_model->check_employee_by_department($department_id);
            // var_dump($check);die;
            if ($check == null) {
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Department berhasil dihapus.',
                    'buttontext' => 'Oke, Terimakasih'
                ];
                $this->Department_model->remove_department($department_id);
            } else {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Department gagal dihapus karena terdapat karyawan aktif.',
                    'buttontext' => 'Oke, tutup'
                ];
            }
            echo json_encode($message);
        }
    }
}

/* End of file Department.php */

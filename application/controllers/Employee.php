<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct()
        {
            parent::__construct();
            check_login();
            check_user_acces();
            $this->load->model('Employee_model');
            $this->load->model('Settings_model');
            $this->load->model('Department_model');
            $this->load->model('Users_model');
            
        }

    public function index()
    {
        $this->load->model('Cuti_model');
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['list_employee'] = $this->Employee_model->get_employee();
        $data['department'] = $this->Department_model->get_department();

        // var_dump($data['list_employee']);die;
        // $result = $this->db->query("SHOW TABLE STATUS WHERE name='employee'")->row_array();
        // var_dump($result['Auto_increment']);die;
        // // $data = mysql_fetch_assoc($result);
        // // $next_increment = $data['Auto_increment'];

        $data['title'] = 'Karyawan';
        $data['slug'] = 'Karyawan';
        $data['judul'] = 'Karyawan / Pegawai';
        render_template('admin/employee', $data);
    }

    public function add_employee(){
        $this->form_validation->set_rules('fullname', 'Nama lengkap', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
        $this->form_validation->set_rules('department', 'Department', 'trim|required|max_length[1]|callback_select_check');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required|max_length[1]|callback_select_check');
        $this->form_validation->set_rules('newpassword', 'Password', 'trim|required|matches[repassword]|min_length[6]');
        $this->form_validation->set_rules('repassword', 'Ulangi Password', 'trim|required|matches[newpassword]|min_length[6]');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            if ($this->form_validation->run() == false) {
                $message = [
                    'errors' => 'true',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                ];
                
            } else {
                $last_employee = $this->Employee_model->get_last_employee();

                $fullname   = $this->input->post('fullname', TRUE);
                $department = $this->input->post('department', TRUE);
                $gender     = $this->input->post('gender', TRUE);
                $email      = $this->input->post('email', TRUE);
                $password   = $this->input->post('newpassword', TRUE);

                $employee = [
                    'full_name' => htmlspecialchars($fullname) ,
                    'department_id' => htmlspecialchars($department),
                    'gender' => htmlspecialchars($gender),
                    'join_date' => date('Y-m-d'),
                    'image_profile' => 'default.jpg'
                ];

                $user = [
                    'role_id' => 1,
                    'employee_id' => $last_employee['Auto_increment'],
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'is_active' => 1,
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d'),
                ];

                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Karyawan berhasil ditambahkan.',
                    'buttontext' => 'Oke, terimakasih'
                ];

                $this->Employee_model->add_employe($employee);
                $this->Users_model->add_user($user);
            }
            echo json_encode($message);
        }
    }

    function select_check($str){
        if ($str == '0'){
                $this->form_validation->set_message('select_check', 'The {field} field is required.');
                return FALSE;
        }else{
                return TRUE;
        }
    }

    public function show_profile($employee_id){

        $employee = $this->Employee_model->get_employee_with_user($employee_id);

        if (!$this->input->is_ajax_request()) {

            exit('No direct script access allowed');
        } else {
            $message = [
                'success' => 'true',
                'title' => 'Gagal!',
                'desc' => $employee,
                'csrf_name' => $this->security->get_csrf_token_name(),
                'csrf_hash' => $this->security->get_csrf_hash(),
                'buttontext' => 'Oke, tutup'
            ];

            echo json_encode($message);
        }
    }

    public function update_pass($user_id){
        $user_employee = $this->Users_model->get_user_by_id($user_id);

        if (!$this->input->is_ajax_request()) {

            exit('No direct script access allowed');
        } else {
            
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $password   = $this->input->post('password', TRUE);

            if ($this->form_validation->run() == FALSE) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => validation_errors('<p class="fs-7">','</p'),
                    'buttontext' => 'Oke, tutup'
                ];
            } else {

                if ($user_employee['user_id'] == $user_id) {
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Password berhasil di ubah.',
                        'buttontext' => 'Oke, tutup'
                    ];
                    $data = [
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    ];

                    $this->Users_model->update_user($user_id, $data);
                }
            }
            

            echo json_encode($message);
        }
    }

    public function activation($user_id, $is_active){
        check_user_acces();
        $user = $this->Users_model->get_user_by_id($user_id);

        if (!$this->input->is_ajax_request()) {

            exit('No direct script access allowed');
        } else {
            $notif = $is_active == 1 ? 'aktifkan' : 'nonaktif';
            if ($user['user_id'] == $user_id && $is_active != $user['is_active']) {
                $message = [
                    'success' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Karyawan berhasil di ' . $notif,
                    'buttontext' => 'Oke, terimakasih'
                ];

                $data = [
                    'is_active' => $is_active
                ];

                $this->Users_model->update_user($user_id, $data);
            } else {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Anda tidak bisa menonaktifkan akun ini.',
                    'buttontext' => 'Oke, tutup'
                ];
            }

            echo json_encode($message);
        }
    }

    public function update_department($employee_id){
        $employee = $this->Employee_model->get_employee_by_id($employee_id);

        if (!$this->input->is_ajax_request()) {

            exit('No direct script access allowed');
        } else {

        }
    }

}

/* End of file Employee.php */

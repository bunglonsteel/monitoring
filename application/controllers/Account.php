<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_acces();
        $this->load->model('Settings_model');
        $this->load->model('Employee_model');
        $this->load->model('Users_model');
        $this->load->model('Department_model');
        
    }

    public function index(){
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['department'] = $this->Department_model->get_department_by_id($data['employee']['department_id']);
        $data['user'] = $this->Users_model->get_user_employee($data['employee']['employee_id']);

        // // var_dump($data['employee']);die;
        // // var_dump($data['department']);die;
        // // var_dump($data['department']);die;
        // // var_dump($data['user']);die;
        $data['title'] = 'Pengaturan';
        render_template('users/account', $data);
    }

    public function update_information($employee_id){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            if ($employee_id != $this->session->userdata('employee_id')) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Mau ngedit yang mana cuy.',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $this->form_validation->set_rules('fullname', 'Nama lengkap', 'trim|required');
                $this->form_validation->set_rules('contact', 'No. Kontak', 'trim|required|max_length[15]');
                $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required|max_length[1]|callback_select_check');
                $this->form_validation->set_rules('birth', 'Tanggal Lahir', 'trim');
                $this->form_validation->set_rules('last_education', 'Pendidikan Terakhir', 'trim|required|callback_select_check');
                $this->form_validation->set_rules('address', 'Alamat', 'trim|required|max_length[255]');
                $this->form_validation->set_rules('bio', 'Bio', 'trim|max_length[255]');
    
                
                $fullname   = $this->input->post('fullname', TRUE);
                $contact   = $this->input->post('contact', TRUE);
                $gender   = $this->input->post('gender', TRUE);
                $birth   = $this->input->post('birth', TRUE);
                $last_education   = $this->input->post('last_education', TRUE);
                $address   = $this->input->post('address', TRUE);
                $bio   = $this->input->post('bio', TRUE);

                // var_dump($birth);die;

                if ($this->form_validation->run() == false) {
                    $message = [
                        'errors' => 'true',
                        'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                        'csrfname' => $this->security->get_csrf_token_name(),
                        'csrfhash' => $this->security->get_csrf_hash()
                    ];
                } else {
                    $data = [
                        'full_name' => htmlspecialchars($fullname),
                        'contact' => htmlspecialchars($contact),
                        'gender' => htmlspecialchars($gender),
                        'birth_date' => $birth,
                        'last_education' => htmlspecialchars($last_education),
                        'address' => htmlspecialchars($address),
                        'bio' => htmlspecialchars($bio)
                    ];

                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Informasi berhasil di update.',
                        'buttontext' => 'Oke, terimakasih'
                    ];

                    $this->Employee_model->update_profile($employee_id, $data);
                }
            }

            echo json_encode($message);
        }
    }

    public function update_password($user_id){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $user_password = $this->Users_model->get_user_by_id($user_id);
            
            $this->form_validation->set_rules('oldpassword', 'Password lama', 'trim|required');
            $this->form_validation->set_rules('newpassword', 'Password baru', 'trim|required|min_length[6]|matches[repassword]');
            $this->form_validation->set_rules('repassword', 'Ulangi password baru', 'trim|required|min_length[6]|matches[newpassword]');

            $old_password   = $this->input->post('oldpassword', TRUE);
            $new_password   = $this->input->post('newpassword', TRUE);

            if ( !password_verify($old_password, $user_password['password'])) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Password lama salah',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {

                if ($this->form_validation->run() == false) {
                    $message = [
                        'errors' => 'true',
                        'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    ];
                } else {
                    $data = [
                        'password' => password_hash($new_password, PASSWORD_DEFAULT),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Password berhasil di update.',
                        'buttontext' => 'Oke, terimakasih'
                    ];

                    $this->Users_model->update_user($user_id, $data);
                }
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

    public function update_image($employee_id){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $employee = $this->Employee_model->get_employee_by_id($employee_id);
            $upload_image = $_FILES['image_profile']['name'];

            // var_dump($upload_image);die;
            if ($upload_image) {
                $config['allowed_types']    = 'gif|jpg|png|jpeg';
                $config['max_size']         = '1000';
                $config['upload_path']      = './public/image/users/';
                $config['file_ext_tolower'] = TRUE;
                $config['encrypt_name']     = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image_profile')) {
                    $old_image = $employee['image_profile'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'public/image/users/' . $old_image);
                    }
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' =>  'Foto berhasil di update.',
                        'buttontext' => 'Oke, tutup'
                    ];

                    $new_image = $this->upload->data('file_name');
                    $this->Employee_model->update_profile($employee_id, ['image_profile'=> $new_image]);
                } else {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' =>  $this->upload->display_errors('<p class="fs-7">','</p>'),
                        'buttontext' => 'Oke, tutup'
                    ];
                }
                echo json_encode($message);
            }
        }
    }

}

/* End of file Account.php */

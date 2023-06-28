<?php 


defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login();
        check_user_acces();
        $this->load->model('Users_model');
        $this->load->model('Settings_model');
        $this->load->model('Employee_model');
        
    }

    public function index()
    {
        $this->load->model('Cuti_model');
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['user'] = $this->Users_model->get_user_employee($this->session->userdata('employee_id'));

        $data['title'] = 'Pengaturan';
        $data['slug'] = 'Pengaturan';
        $data['judul'] = 'Pengaturan Web';
        render_template('admin/settings', $data);
    }


    public function update_site(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
                $this->form_validation->set_rules('site_name', 'Nama situs', 'trim|required');
                $this->form_validation->set_rules('site_title', 'Judul situs', 'trim|required');
                $this->form_validation->set_rules('no_tlp', 'No. Kontak', 'trim|required');
                $this->form_validation->set_rules('description', 'Deskripsi', 'trim|required');
    
                
                $site_name  = $this->input->post('site_name', TRUE);
                $site_title = $this->input->post('site_title', TRUE);
                $contact    = $this->input->post('no_tlp', TRUE);
                $desc       = $this->input->post('description', TRUE);

                if ($this->form_validation->run() == false) {
                    $message = [
                        'errors' => 'true',
                        'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    ];
                } else {
                    $data = [
                        'site_name' => htmlspecialchars($site_name),
                        'site_title' => htmlspecialchars($site_title),
                        'description' => htmlspecialchars($desc),
                        'contact' => htmlspecialchars($contact)
                    ];

                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Pengaturan berhasil di update.',
                        'buttontext' => 'Oke, terimakasih'
                    ];

                    $this->Settings_model->update_settings($data);
                }

            echo json_encode($message);
        }
    }

    public function update_akun($type, $user_id){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            if ($type == 'email') {
                
            $this->form_validation->set_rules('email', 'Alamat email', 'trim|required|is_unique[users.email]');
            $email  = $this->input->post('email', TRUE);
                if ($this->form_validation->run() == false) {
                    $message = [
                        'errors' => 'true',
                        'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    ];
                } else {
                    $data = [
                        'email' => htmlspecialchars($email),
                    ];
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Email berhasil di update.',
                        'buttontext' => 'Oke, terimakasih'
                    ];
                    $this->Users_model->update_user($user_id, $data);
                }

            } else {
                $this->form_validation->set_rules('newpassword', 'Password baru', 'trim|required|min_length[6]|matches[repassword]');
                $this->form_validation->set_rules('repassword', 'Ulangi password baru', 'trim|required|min_length[6]|matches[newpassword]');

                $new_password   = $this->input->post('newpassword', TRUE);
                if ($this->form_validation->run() == false) {
                    $message = [
                        'errors' => 'true',
                        'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    ];
                } else {
                    $data = [
                        'password' => password_hash($new_password, PASSWORD_DEFAULT),
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

    public function update_logo(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            $setting = $this->Settings_model->get_settings();

            $logo_image = $_FILES['logo']['name'];
            $logo_text_image = $_FILES['logo_text']['name'];
            $favicon_image = $_FILES['favicon']['name'];

            // var_dump($upload_image);die;
            $config['allowed_types']    = 'gif|jpg|png|jpeg';
            $config['max_size']         = '500';
            $config['upload_path']      = './public/image/default/';
            $config['file_ext_tolower'] = TRUE;
            $config['encrypt_name']     = TRUE;

            $this->load->library('upload', $config);
            if ($logo_image) {

                $old_logo = $setting['logo'];

                $message = $this->_uploaded(['logo'],$this->upload->do_upload('logo'), $old_logo,  'logo-square.jpeg');

            }
            if ($logo_text_image) {

                $old_logo_text = $setting['logo_text'];
                $message = $this->_uploaded(['logo_text'],$this->upload->do_upload('logo_text'), $old_logo_text,  'logo-text.png');

            }
            if ($favicon_image) {
                $old_favicon = $setting['favicon'];
                $message = $this->_uploaded(['favicon'],$this->upload->do_upload('favicon'), $old_favicon,  'logo-square.jpeg');

            }
            echo json_encode($message);
        }
    }

    public function update_whatsapp(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->form_validation->set_rules('no_wa', 'No Whatsapp', 'trim|required');
            $this->form_validation->set_rules('token_api', 'Token API', 'trim|required');

            $no_tlp    = $this->input->post('no_wa', TRUE);
            $token_api = $this->input->post('token_api', TRUE);

            if ($this->form_validation->run() == false) {
                $output = [
                    'errors'    => 'true',
                    'message'   => validation_errors(
                        '<div class="alert alert-danger alert-dismissible fs-8 py-2_5" role="alert">',
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
                    ),
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $this->Settings_model->update_settings(['whatsapp_api' => $token_api]);
                $output = [
                    'success'   => true,
                    'message'   => 'Token API berhasil diperbarui, terimakasih.',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }

    private function _uploaded($field = [], $do_upload='', $old_image='',  $default=''){

        if ($do_upload != '') {
            if ($old_image != $default) {
                unlink(FCPATH . 'public/image/default/' . $old_image);
            }
            
            $new_image = $this->upload->data('file_name');
            $this->Settings_model->update_settings(array_fill_keys($field, $new_image));

            $message = [
                'success' => 'true',
                'title' => 'Berhasil!',
                'desc' => 'Image logo berhasil di update.',
                'buttontext' => 'Oke, terimakasih'
            ];

            return $message;
                    
        }else {
            return $message = [
                'error' => 'true',
                'title' => 'Gagal!',
                'desc' =>  $this->upload->display_errors('<p class="fs-7">','</p>'),
                'buttontext' => 'Oke, tutup'
            ];
        }
    }
}

/* End of file Settings.php */

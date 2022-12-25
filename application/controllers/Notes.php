<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends CI_Controller {


    public function __construct() {
        parent::__construct();
        check_login();
        $this->load->model('Settings_model');
        $this->load->model('Employee_model');
        $this->load->model('Cuti_model');
        $this->load->model('Notes_model');
    }

    public function index() {
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        if ($this->session->userdata('role_id') == 2) {
            $data['notes']  = $this->Notes_model->get_notes();
        } else {
            $data['notes']  = $this->Notes_model->get_notes(true);
        }
        
        // print_r($data['notes']);die;

        $data['title'] = 'Catatan';
        $data['slug'] = 'Catatan';
        $data['judul'] = 'Standar Pekerjaan';
        render_template('notes/notes', $data);
    }

    public function detail($notes_id) {
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        $data['notes_content']  = $this->Notes_model->check_notes($notes_id);

        $data['title'] = 'Catatan';
        render_template('notes/notes-detail', $data);
    }

    public function notes_standard() {
        check_user_acces();
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        $data['notes_standard']  = $this->Notes_model->get('notes_standard');

        $data['title'] = 'Catatan Standar';
        $data['slug'] = 'Catatan Standar';
        $data['judul'] = 'Catatan Standar';
        render_template('notes/notes-standard', $data);
    }

    public function notes_category() {
        check_user_acces();
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        $data['notes_category']  = $this->Notes_model->get('notes_category');
        // var_dump($data['notes_section']);die;

        $data['title'] = 'Catatan Kategori';
        $data['slug'] = 'Catatan Kategori';
        $data['judul'] = 'Catatan Kategori';
        render_template('notes/notes-category', $data);
    }

    public function notes_client() {
        check_user_acces();
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        $data['notes_client']  = $this->Notes_model->get_notes_client();
        $data['notes_standar']  = $this->Notes_model->get('notes_standard');
        // var_dump($data['notes_client']);
        // print_r($data['notes_client']);
        // die;
        $data['title'] = 'Client';
        $data['slug'] = 'Client';
        $data['judul'] = 'Catatan Client';
        render_template('notes/notes-client', $data);
    }

    public function add_notes(){
        check_user_acces();
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['notes_client'] = $this->Notes_model->get('notes_client');
        $data['notes_category'] = $this->Notes_model->get('notes_category');

        $data['title'] = 'Tambah Catatan';

        $this->form_validation->set_rules('notes_title', 'Judul', 'trim|required');
		$this->form_validation->set_rules('notes_client', 'Notes Client', 'trim|callback_select_check');
		$this->form_validation->set_rules('notes_category', 'Kategori', 'trim|callback_select_check');
		$this->form_validation->set_rules('notes_status', 'Status', 'trim|callback_select_check');
		$this->form_validation->set_rules('notes_content', 'Konten', 'trim');
		
		if ($this->form_validation->run() == false) {
            render_template('notes/add-notes', $data);
		} else {
            $notes_title    = trim(htmlspecialchars($this->input->post('notes_title', TRUE)));
            $notes_client_id   = htmlspecialchars($this->input->post('notes_client', TRUE));
            $notes_category_id = htmlspecialchars($this->input->post('notes_category', TRUE));
            $notes_status   = htmlspecialchars($this->input->post('notes_status', TRUE));
            $notes_content  = $this->input->post('notes_content', TRUE);

            $content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $notes_content);
            $dom = new DOMDocument();
                
            $dom->loadHTML($content);
            $script = $dom->getElementsByTagName('h2');
            foreach($script as $key => $item){
                $add_id = 'heading-'. $key;
                $item->setAttribute('id', $add_id);
            }
            $html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));;
            
            $data = [
                'notes_client_id' => $notes_client_id,
                'notes_category_id' => $notes_category_id,
                'notes_title' => $notes_title,
                'notes_date' => date('Y-m-d'),
                'notes_content' => $html,
                'notes_status' => $notes_status
            ];

            $this->Notes_model->add('notes', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-wth-icon alert-dismissible mb-4 show fade fs-7" role="alert">
                                            <span class="alert-icon-wrap fs-5"><i class="zmdi zmdi-check" style="margin-top: 2px;"></i></span> Catatan berhasil ditambahkan.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        ');
            redirect('notes');
        }
    }

    public function add_notes_standard(){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            
            $this->form_validation->set_rules('notes_standard', 'Standar Catatan', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $message = [
                    'errors' => 'true',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    'csrfHash' => $this->security->get_csrf_hash()
                ];
            } else {
                
                $standard_name    = trim(htmlspecialchars($this->input->post('notes_standard', TRUE)));
                $check_notes_standard = $this->Notes_model->check_notes_standard($standard_name, '');
                // var_dump($check_notes_standard);die;
                if ($check_notes_standard) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Catatan standar sudah ada silahkan cek kembali.',
                        'buttontext' => 'Oke, terimakasih'
                    ];
                } else {
                    $data = [
                        'notes_standard' => $standard_name
                    ];
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Catatan standard Berhasil ditambahkan.',
                        'buttontext' => 'Oke, terimakasih'
                    ];

                    $this->Notes_model->add('notes_standard',$data);
                }
            }
        
            echo json_encode($message);
        }
    }

    public function add_notes_client(){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            
            $this->form_validation->set_rules('notes_client', 'Catatan Client', 'trim|required');
            $this->form_validation->set_rules('notes_standard', 'Catatan Standard', 'trim|callback_select_check');

            if ($this->form_validation->run() == FALSE) {
                $message = [
                    'errors' => 'true',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    'csrfHash' => $this->security->get_csrf_hash()
                ];
            } else {
                
                $notes_client    = trim(htmlspecialchars($this->input->post('notes_client', TRUE)));
                $notes_standard    = htmlspecialchars($this->input->post('notes_standard', TRUE));
                $check_notes_client = $this->Notes_model->check_notes_client($notes_client, $notes_standard, '');
                // var_dump($check_notes_standard);die;
                if ($check_notes_client) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Client sudah ada silahkan cek.',
                        'buttontext' => 'Oke, terimakasih'
                    ];
                } else {
                    $data = [
                        'notes_standard_id' => $notes_standard,
                        'notes_client' => $notes_client
                    ];
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Client Berhasil ditambahkan.',
                        'buttontext' => 'Oke, terimakasih'
                    ];

                    $this->Notes_model->add('notes_client',$data);
                }
            }
        
            echo json_encode($message);
        }
    }

    public function add_notes_category(){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            
            $this->form_validation->set_rules('notes_category_name', 'Kategori Catatan', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $message = [
                    'errors' => 'true',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    'csrfHash' => $this->security->get_csrf_hash()
                ];
            } else {
                
                $category_name    = trim(htmlspecialchars($this->input->post('notes_category_name', TRUE)));
                $check_notes_cat = $this->Notes_model->check_notes_category($category_name, '');
                // var_dump($check_notes_standard);die;
                if ($check_notes_cat) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Kategori sudah ada silahkan cek.',
                        'buttontext' => 'Oke, terimakasih'
                    ];
                } else {
                    $data = [
                        'notes_category_name' => $category_name 
                    ];
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Kategori Berhasil ditambahkan.',
                        'buttontext' => 'Oke, terimakasih'
                    ];

                    $this->Notes_model->add('notes_category',$data);
                }
            }
        
            echo json_encode($message);
        }
    }

    // Edit
    public function edit_client(){
        check_user_acces();
        $this->form_validation->set_rules('notes_client', 'Catatan Client', 'trim|required');
        $this->form_validation->set_rules('notes_standard', 'Catatan Standard', 'trim|callback_select_check');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            if ($this->form_validation->run() == false) {
                $message = [
                    'errors' => 'true',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    'csrfHash' => $this->security->get_csrf_hash(),
                ];
                
            } else {
                
                $client_id        = htmlspecialchars($this->input->post('client_id', TRUE));
                $notes_client     = htmlspecialchars($this->input->post('notes_client', TRUE));
                $notes_standard   = htmlspecialchars($this->input->post('notes_standard', TRUE));

                $check_client     = $this->db->get_where('notes_client', ['notes_client_id' => $client_id])->row_array();
                // var_dump($check_client);die;
                if ($check_client == null) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Client tidak ada atau tidak ditemukan.',
                        'buttontext' => 'Oke, terimakasih'
                    ];
                } else {

                    $data = [
                        'notes_standard_id' => $notes_standard,
                        'notes_client' => $notes_client
                    ];
    
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Client berhasil diupdate.',
                        'buttontext' => 'Oke, terimakasih'
                    ];
    
                    $this->Notes_model->update('notes_client', ['notes_client_id' => $client_id],  $data);
                }
            }
            echo json_encode($message);
        }
    }

    public function edit_notes($notes_id = ''){
        check_user_acces();
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['notes_client'] = $this->Notes_model->get('notes_client');
        $data['notes_category'] = $this->Notes_model->get('notes_category');
        $data['notes_edit'] = $this->Notes_model->check_notes($notes_id);
        $data['title'] = 'Tambah Catatan';

        $this->form_validation->set_rules('notes_title', 'Judul', 'trim|required');
		$this->form_validation->set_rules('notes_client', 'Notes Client', 'trim|callback_select_check');
		$this->form_validation->set_rules('notes_category', 'Kategori', 'trim|callback_select_check');
		$this->form_validation->set_rules('notes_status', 'Status', 'trim|callback_select_check');
		$this->form_validation->set_rules('notes_content', 'Konten', 'trim');
		
		if ($this->form_validation->run() == false) {
            render_template('notes/edit-notes', $data);
		} else {
            $notes_title    = trim(htmlspecialchars($this->input->post('notes_title', TRUE)));
            $notes_client_id   = htmlspecialchars($this->input->post('notes_client', TRUE));
            $notes_category_id = htmlspecialchars($this->input->post('notes_category', TRUE));
            $notes_status   = htmlspecialchars($this->input->post('notes_status', TRUE));
            $notes_content  = $this->input->post('notes_content', TRUE);

            $content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $notes_content);
            $dom = new DOMDocument();
            $dom->loadHTML($content);
            $script = $dom->getElementsByTagName('h2');
            foreach($script as $key => $item){
                $add_id = 'heading-'. $key;
                $item->setAttribute('id', $add_id);
            }
            $html = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));;
            
            $data = [
                'notes_client_id' => $notes_client_id,
                'notes_category_id' => $notes_category_id,
                'notes_title' => $notes_title,
                'notes_date' => date('Y-m-d'),
                'notes_content' => $html,
                'notes_status' => $notes_status
            ];

            $this->Notes_model->update('notes', ['notes_id' => $notes_id], $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-wth-icon alert-dismissible mb-4 show fade fs-7" role="alert">
                                            <span class="alert-icon-wrap fs-5"><i class="zmdi zmdi-check" style="margin-top: 2px;"></i></span> Catatan berhasil diupdate.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        ');
            redirect('notes');
        }
    }
    // End Edit

    // Delete
    public function delete_notes($notes_id){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $check_notes = $this->Notes_model->check_notes($notes_id);
            if ($check_notes) {
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Catatan berhasil dihapus.',
                    'buttontext' => 'Oke, terimakasih'
                ];
                // var_dump($check_notes['notes_content']);die;
                preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $check_notes['notes_content'], $urls);
                $urls = $urls[1];
                foreach ($urls as $url) {
                    $img = str_replace(base_url('public/image/notes/'), "", $url);
                    unlink(FCPATH . 'public/image/notes/' . $img);
                }
                $this->Notes_model->remove('notes',['notes_id' => $notes_id]);
            } else {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Catatan tidak atau anda mencoba sesuatu yang tidak ada.',
                    'buttontext' => 'Oke, tutup'
                ];
            }

            echo json_encode($message);
        }
    }

    public function delete_notes_category($notes_category_id){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $check_notes_section = $this->Notes_model->check_notes_category('', $notes_category_id);

            if ($check_notes_section) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Tidak bisa dihapus karena ada bagian catatan didalamnya. Silahkan hapus terlebih dahulu.',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Kategori berhasil dihapus.',
                    'buttontext' => 'Oke, terimakasih'
                ];
                $this->Notes_model->remove('notes_category', ['notes_category_id' => $notes_category_id]);
            }

            echo json_encode($message);
        }
    }

    public function delete_notes_client($notes_client_id){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $check_notes_section = $this->Notes_model->check_notes_client('', '', $notes_client_id);
            if ($check_notes_section) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Tidak bisa dihapus karena ada bagian catatan didalamnya. Silahkan hapus terlebih dahulu.',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Client berhasil dihapus.',
                    'buttontext' => 'Oke, terimakasih'
                ];
                $this->Notes_model->remove('notes_client', ['notes_client_id' => $notes_client_id]);
            }

            echo json_encode($message);
        }
    }

    public function delete_notes_standard($notes_standard_id){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $check_notes_section = $this->Notes_model->check_notes_standard('', $notes_standard_id);

            if ($check_notes_section) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Tidak bisa dihapus karena ada bagian catatan didalamnya. Silahkan hapus terlebih dahulu.',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Standar berhasil dihapus.',
                    'buttontext' => 'Oke, terimakasih'
                ];
                $this->Notes_model->remove('notes_standard', ['notes_standard_id' => $notes_standard_id]);
            }

            echo json_encode($message);
        }
    }
    // End Delete

    function select_check($str){
        if ($str == '0'){
                $this->form_validation->set_message('select_check', 'The {field} field is required.');
                return FALSE;
        }else{
                return TRUE;
        }
    }

    function upload_image_summernote(){
        if($_FILES['file']['name']){
            $config['allowed_types']    = 'jpg|jpeg|png|gif';
            $config['upload_path']      = './public/image/notes/';
            $config['file_ext_tolower'] = TRUE;
            $config['encrypt_name']     = TRUE;
            $config['max_size']         = '1000';

            $this->load->library('upload', $config);
            if(!$this->upload->do_upload('file')){
                $message = '{error:"true", data:"'.strip_tags(str_replace(".","",$this->upload->display_errors())).'",csrfHash:"'.$this->security->get_csrf_hash().'"}';
            }else{
                $file_name = $this->upload->data('file_name');
                $message = '{success:"true", data:"'.base_url('public/image/notes/').$file_name.'",csrfHash:"'.$this->security->get_csrf_hash().'"}';
            }
            echo $message;
        }
    }

    function delete_image_summernote(){

        $target_image = htmlspecialchars($_POST['src']);
        if ($target_image) {
            $file_name = str_replace(base_url('public/image/notes/'), "", $target_image);
            if (unlink(FCPATH . 'public/image/notes/' . $file_name)) {
                echo '{success:"true", data:"'.$file_name.' berhasil dihapus", csrfHash:"'.$this->security->get_csrf_hash().'"}';
            }
        }
    }

}

/* End of file Help.php */

<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Cleanliness extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('Employee_model');
        $this->load->model('Settings_model');
        $this->load->model('Cleanliness_model');
    }

    public function index()
    {   
        check_user_acces();
        if ($this->session->userdata('role_id') == 2) {
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        }
        
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['settings'] = $this->Settings_model->get_settings();
        $data['list_cleanliness'] = $this->Cleanliness_model->get();
        $data['title'] = 'Kebersihan';
        $data['slug'] = 'Kebersihan';
        $data['judul'] = 'Kebersihan';
        render_template('cleanliness/cleanliness', $data);
    }

    public function cleanliness_progress(){   
        
        if ($this->session->userdata('role_id') == 2) {
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        }
        
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['settings'] = $this->Settings_model->get_settings();

        $data['list_cleanliness'] = $this->Cleanliness_model->get();
        $data['check_progress'] = $this->Cleanliness_model->get_cleanliness_progress();

        $data['title'] = 'Progress';
        $data['slug'] = 'Progress';
        $data['judul'] = 'Progress Kebersihan';
        render_template('cleanliness/progress', $data);
    }

    public function add_cleanliness(){
        check_user_acces();
        $this->form_validation->set_rules('cleanliness_name', 'Nama kebersihan', 'trim|required|is_unique[cleanliness.cleanliness_name]');

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            if ($this->form_validation->run() == false) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible fade show fs-7">', '</div>'),
                    'csrfHash' => $this->security->get_csrf_hash(),
                    'buttontext' => 'Oke, tutup'
                ];
            } else {

                $cleanlines_name = strip_tags(htmlspecialchars($this->input->post('cleanliness_name', TRUE)));
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Nama kebersihan berhasil ditambahkan.',
                    'buttontext' => 'Oke, tutup'
                ];
                $this->Cleanliness_model->add('cleanliness', ['cleanliness_name'=> $cleanlines_name]);
            }
            echo json_encode($message);
        }
    }

    public function edit_cleanliness($cleanliness_id = ''){
        check_user_acces();
        $this->form_validation->set_rules('cleanliness_name', 'Nama kebersihan', 'trim|required|is_unique[cleanliness.cleanliness_name]');

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
                $check_cleanliness = $this->Cleanliness_model->get_cleanliness_by_id($cleanliness_id);
                if ($check_cleanliness) {
                    $cleanliness_name = strip_tags(htmlspecialchars($this->input->post('cleanliness_name', TRUE)));
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Nama kebersihan berhasil diupdate.',
                        'buttontext' => 'Oke, Terimakasih'
                    ];
                    $this->Cleanliness_model->update('cleanliness', ['cleanliness_id' => $cleanliness_id ], ['cleanliness_name' => $cleanliness_name]);
                } else {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Kebersihan tidak ada mohon maaf.',
                        'buttontext' => 'Oke, tutup'
                    ];
                }
            }
            echo json_encode($message);
        }
    }

    public function delete_cleanliness($cleanliness_id = ''){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            $check_cleanliness = $this->Cleanliness_model->get_cleanliness_by_id($cleanliness_id);
            // var_dump($check);die;
            if ($check_cleanliness) {
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Kebersihan berhasil dihapus.',
                    'buttontext' => 'Oke, Terimakasih'
                ];
                $this->Cleanliness_model->delete('cleanliness', ['cleanliness_id' => $cleanliness_id]);
            } else {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Tidak ada data yang bisa dihapus.',
                    'buttontext' => 'Oke, tutup'
                ];
            }
            echo json_encode($message);
        }
    }

    public function add_progress(){

        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {

            $cleanliness_id = strip_tags(htmlspecialchars($_REQUEST['id']));
            $employee_id = strip_tags(htmlspecialchars($_REQUEST['employee']));

            $check_employee = $this->Employee_model->get_employee_by_id($employee_id);
            $department_id    = $this->db->get_where('department',['name_department' => 'kebersihan'])->row_array();
            // var_dump($department);die;
            if ($check_employee['department_id'] != $department_id['department_id']) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Anda bukan bagian kebersihan maaf tidak bisa, ini khusus untuk bagian kebersihan.',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $check = $this->Cleanliness_model->get_cleanliness_progress_by(['cleanliness_date' => date('Y-m-d'), 'cleanliness_id' => $cleanliness_id]);
                if ($check != null) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Anda sudah melakukan tugas!!.',
                        'buttontext' => 'Oke, tutup'
                    ];
                } else {

                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Kebersihan berhasil dikerjakan atau ditambahkan.',
                        'buttontext' => 'Oke, tutup'
                    ];

                    $data = [
                        'cleanliness_id' => $cleanliness_id,
                        'employee_id' => $employee_id,
                        'employee_name' => $check_employee['full_name'],
                        'cleanliness_date' => date('Y-m-d'),
                        'cleanliness_status' => 1
                    ];
                    $this->Cleanliness_model->add('cleanliness_progress', $data);
                }
            }
            echo json_encode($message);
        }
    }

    public function rating($cp_id = '', $approvecode = ''){ // enum(P, VG, M, D)
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $cleanliness_pr_id = strip_tags(htmlspecialchars($cp_id));
            $cleanliness_status = strip_tags(htmlspecialchars($approvecode));
            $check_cp = $this->Cleanliness_model->get_cleanliness_progress_by(['cleanliness_progress_id' => $cleanliness_pr_id]);
            // var_dump($check_cp);die;
            
            if ($check_cp == null) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Kebersihan tidak ada!',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Karyawan berhasil diberi rating.',
                    'buttontext' => 'Oke, tutup'
                ];

                $data = [
                    'cleanliness_status' => $cleanliness_status
                ];

                $this->Cleanliness_model->update('cleanliness_progress',['cleanliness_progress_id' => $cleanliness_pr_id], $data);
            }

            echo json_encode($message);
        }
    }

    public function laporan(){
        check_user_acces();
        if ($this->session->userdata('role_id') == 2) {
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        }
        
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['settings'] = $this->Settings_model->get_settings();
        $data['list_cleanliness'] = $this->Cleanliness_model->get();
        $data['title'] = 'Laporan Kebersihan';
        $data['slug'] = 'Laporan';
        $data['judul'] = 'Laporan Kebersihan';
        render_template('cleanliness/laporan-kebersihan', $data);
    }

    public function get_laporan(){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->form_validation->set_rules('filter_month', 'Bulan', 'trim|callback_select_check');

            $bulan = $this->input->post('filter_month', TRUE);
            if ($this->form_validation->run() == FALSE) {
                $message = [
                    'errors' => 'true',
                    'title' => 'Gagal!',
                    'desc' => validation_errors('<p class="fs-7">','</p>'),
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $result = $this->Cleanliness_model->get_laporan_by_month($bulan);
                $semua_kebersihan = $this->db->count_all('cleanliness');

                $total_selesai = $result['selesai'];
                $total_kebersihan = $semua_kebersihan * $result['total_date'];
                $total_kurang = $total_kebersihan - $total_selesai;

                $count_penilaian = ($total_selesai / $total_kebersihan) * 100;
                $penilaian = ($count_penilaian >= 90) ? 3 : (($count_penilaian < 90 && $count_penilaian >= 50) ? 2 : 1);
                // print_r($count_penilaian);die;
                if ($result == null) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Mohon Maaf',
                        'desc' => 'Dibulan ini belum ada yang diselesaikan.',
                        'buttontext' => 'Oke, tutup'
                    ];
                } else {

                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'data' => [
                            'total_selesai' => $total_selesai,
                            'total_kurang' => $total_kurang,
                            'penilaian' => $penilaian,
                        ],
                        'csrfHash' => $this->security->get_csrf_hash()
                    ];
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
}

/* End of file Cleanliness.php */

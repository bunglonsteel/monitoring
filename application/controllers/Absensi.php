<?php

use LDAP\Result;

defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('Employee_model');
        $this->load->model('Settings_model');
        $this->load->model('Department_model');
        $this->load->model('Absensi_model');
        
    }

    public function index()
    {   
        if ($this->session->userdata('role_id') == 2) {
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
            $data['list_employee'] = $this->Employee_model->get_employee_aktif(1);
        }
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['absensi'] = $this->Absensi_model->get_absensi();

        $data['title'] = 'Absensi';
        $data['slug'] = 'Kehadiran';
        $data['judul'] = 'Kehadiran / Absensi';
        render_template('absensi/absensi', $data);
    }

    public function check_in($employee_id, $code_kehadiran){ // 1 Hadir, 2 izin, 3 sakit
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $check_absen = $this->Absensi_model->check_absensi_employee($employee_id, date('Y-m-d'));
            $get_employee = $this->Employee_model->get_employee_by_id($employee_id);
            // var_dump($reason);die;
            // date('w') == 0 || date('w') == 6
            if (date('w') == 0 || date('w') == 6) {
                $message = [
                    'error' => 'true',
                    'title' => 'Absen Gagal!',
                    'desc' => 'Absensi tidak bisa dilakukan di hari sabtu / minggu.',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                if ($check_absen) {
                    $message = [
                        'warning' => 'true',
                        'title' => 'Peringatan!',
                        'desc' => 'Anda sudah melakukan absensi.',
                        'buttontext' => 'Oke, tutup'
                    ];
                } else {
                    $data = [
                        'employee_id' => $employee_id,
                        'department_id' => $get_employee['department_id'],
                        'date' => date('Y-m-d'),
                        'clock_in' => date('Y-m-d H:i:s'),
                        'presence' => $code_kehadiran,
                    ];
                    $message = [
                        'success' => 'true',
                        'title' => 'Absen berhasil!',
                        'desc' => 'Terimakasih telah melakukan absensi.',
                        'buttontext' => 'Oke, tutup'
                    ];
                    $this->Absensi_model->check_in($data);
                }
            }
            echo json_encode($message);
        }
    }

    public function check_out($employee_id){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $check_absen = $this->Absensi_model->check_absensi_employee($employee_id, date('Y-m-d'));
            if (date('w') == 0 || date('w') == 6) {
                $message = [
                    'error' => 'true',
                    'title' => 'Absen Gagal!',
                    'desc' => 'Absensi tidak bisa dilakukan di hari sabtu / minggu.',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                if ($check_absen == null) {
                    $message = [
                        'warning' => 'true',
                        'title' => 'Peringatan!',
                        'desc' => 'Anda belum melakukan absensi.',
                        'buttontext' => 'Oke, tutup'
                    ];
                } else {
                    if ($check_absen['clock_out'] != null) {
                        $message = [
                            'error' => 'true',
                            'title' => 'Peringatan!',
                            'desc' => 'Anda sudah melakukan absensi keluar hari ini!',
                            'buttontext' => 'Oke, tutup'
                        ];
                    } else {
                        $time_to_out = strtotime('+9 hours', strtotime($check_absen['clock_in']));
                        if(date('d H:i') <= date('d H:i', $time_to_out) ){
                            $diff = strtotime(date('Y-m-d H:i:s', $time_to_out)) - strtotime(date('Y-m-d H:i:s'));
                            // var_dump($diff, strtotime($check_absen['clock_in']));die;
                            $jam  = floor($diff / (60 * 60));
                            $menit= $diff - $jam * (60 * 60);

                            $message = [
                                'error' => 'true',
                                'title' => 'Peringatan!',
                                'desc' => 'Maaf anda belum bisa keluar hari ini, aturan 9 jam per hari. Sisa waktu '. $jam . ' Jam ' .floor($menit/60). ' Menit.' ,
                                'buttontext' => 'Oke, tutup'
                            ];
                        } else {
                            $diff = strtotime(date('Y-m-d H:i:s')) - strtotime($check_absen['clock_in']);
                            $jam  = floor($diff / (60 * 60));
                            $menit= $diff - $jam * (60 * 60);
                            $total_kerja = $jam.' Jam '.floor($menit/60).' Menit';
    
                            $message = [
                                'success' => 'true',
                                'title' => 'Absen berhasil!',
                                'desc' => 'Terimakasih telah bekerja dengan maksimal, hati-hati diwaktu pulang dan semoga diberi kesehatan😊',
                                'buttontext' => 'Oke, tutup'
                            ];
    
                            $data = [
                                'clock_out' => date('Y-m-d H:i:s'),
                                'total_hour' => $total_kerja
                            ];
                            
                            $this->Absensi_model->check_out($employee_id, $data);
                        }
                    }
                }
            }
            echo json_encode($message);
        }
    }

    public function check_in_manual(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->form_validation->set_rules('select_name', 'Karyawan', 'trim|callback_select_check');
            $this->form_validation->set_rules('clock_in', 'Tanggal', 'trim|required');

            if ($this->form_validation->run() == false) {
                $message = [
                    'errors' => 'true',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    'csrfhash' => $this->security->get_csrf_hash(),
                ];
                
            } else {
                
                $employee_id = $this->input->post('select_name', TRUE);
                $datetime = $this->input->post('clock_in', TRUE);
                $get_employee = $this->Employee_model->get_employee_by_id($employee_id);
                $check_absen = $this->Absensi_model->check_absensi_employee($employee_id, date('Y-m-d', strtotime($datetime)));
                
                if ($check_absen) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Karyawan ini sudah melakukan absensi.',
                        'buttontext' => 'Oke, tutup'
                    ];
                } else {
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Terimakasih, Anda telah menambahkan absensi masuk untuk <span class="badge badge-soft-success">'.$get_employee['full_name'].'</span>.',
                        'buttontext' => 'Oke, terimakasih'
                    ];

                    $data = [
                        'employee_id' => $employee_id,
                        'department_id' => $get_employee['department_id'],
                        'date' => date('Y-m-d', strtotime($datetime)),
                        'clock_in' => date('Y-m-d H:i:s', strtotime($datetime)),
                        'presence' => 1,
                    ];
                    $this->Absensi_model->check_in($data);
                }
                // var_dump($check_absen);die;
            }
            echo json_encode($message);
        }
    }

    public function check_out_manual(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->form_validation->set_rules('select_name', 'Karyawan', 'trim|callback_select_check');
            $this->form_validation->set_rules('clock_out', 'Tanggal', 'trim|required');

            if ($this->form_validation->run() == false) {
                $message = [
                    'errors' => 'true',
                    'desc' => validation_errors('<div class="alert alert-danger alert-dismissible show fade fs-7" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'),
                    'csrfhash' => $this->security->get_csrf_hash(),
                ];
                
            } else {
                $employee_id = $this->input->post('select_name', TRUE);
                $datetime = $this->input->post('clock_out', TRUE);
                $check_absen = $this->Absensi_model->check_absensi_employee($employee_id, date('Y-m-d', strtotime($datetime)));
                
                if ($check_absen == NULL) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Karyawan belum melakukan absensi masuk, silahkan tambahkan terlebih dahulu.',
                        'buttontext' => 'Oke, tutup'
                    ];
                } else {
                    if ($check_absen['clock_out']) {
                        $diff = strtotime(date('Y-m-d H:i:s', strtotime($datetime))) - strtotime($check_absen['clock_in']);
                        $jam  = floor($diff / (60 * 60));
                        $menit= $diff - $jam * (60 * 60);
                        $total_kerja = $jam.' Jam '.floor($menit/60).' Menit';

                        $message = [
                            'error' => 'true',
                            'title' => 'Gagal!',
                            'desc' => 'Terimakasih, Jam keluar karyawan berhasil dirubah.',
                            'buttontext' => 'Oke, tutup'
                        ];

                        $data = [
                            'clock_out' => date('Y-m-d H:i:s', strtotime($datetime)),
                            'total_hour' => $total_kerja
                        ];
                        $this->Absensi_model->check_out($employee_id, $data);
                    } else if($check_absen['clock_out'] == null && $check_absen['presence'] == 1) {
                        $diff = strtotime(date('Y-m-d H:i:s', strtotime($datetime))) - strtotime($check_absen['clock_in']);
                        $jam  = floor($diff / (60 * 60));
                        $menit= $diff - $jam * (60 * 60);
                        $total_kerja = $jam.' Jam '.floor($menit/60).' Menit';

                        $message = [
                            'success' => 'true',
                            'title' => 'Berhasil!',
                            'desc' => 'Terimakasih, Anda telah menambahkan absensi keluar secara manual.',
                            'buttontext' => 'Oke, terimakasih'
                        ];

                        $data = [
                            'clock_out' => date('Y-m-d H:i:s', strtotime($datetime)),
                            'total_hour' => $total_kerja
                        ];
                        $this->Absensi_model->check_out($employee_id, $data);
                    } else {
                        $message = [
                            'error' => 'true',
                            'title' => 'Gagal!',
                            'desc' => 'Karyawan tidak bisa absensi keluar karena sakit atau izin.',
                            'buttontext' => 'Oke, tutup'
                        ];
                    }
                }
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
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['all_employee'] = $this->Employee_model->get_employee_aktif(1);

        $data['title'] = 'Laporan';
        $data['slug'] = 'Laporan';
        $data['judul'] = 'Laporan Absensi Karyawan';
        render_template('absensi/laporan', $data);
    }

    public function get_laporan(){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->form_validation->set_rules('filter_month', 'Bulan', 'trim|callback_select_check');
            $this->form_validation->set_rules('filter_name', 'Nama Karyawan', 'trim|callback_select_check');

            $bulan = $this->input->post('filter_month', TRUE);
            $employee_id = $this->input->post('filter_name', TRUE);
            if ($this->form_validation->run() == FALSE) {
                $message = [
                    'errors' => 'true',
                    'title' => 'Gagal!',
                    'desc' => validation_errors('<p class="fs-7">','</p>'),
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $result = $this->Absensi_model->get_laporan_by_month($bulan, $employee_id);

                if ($result == null) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Absensi Karyawan belum ada',
                        'buttontext' => 'Oke, tutup'
                    ];
                } else {
                    
                    $total_days = $this->countDays(date('Y',strtotime($result['date'])), date('n',strtotime($result['date'])), array(0, 6), 'day');
                    $total_sat_sun = $this->countDays(date('Y',strtotime($result['date'])), date('n',strtotime($result['date'])), array(0, 6), 'satsun');
                    $total_alpa = $this->countDays(date('Y',strtotime($result['date'])), date('n',strtotime($result['date'])), array(0, 6), 'day') - $result['hadir'];

                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => $result,
                        'total_day' => $total_days,
                        'total_sat_sun' => $total_sat_sun,
                        'total_alpa' => $total_alpa,
                        'csrfhash' => $this->security->get_csrf_hash(),
                        'buttontext' => 'Oke, tutup'
                    ];
                }
            }
            
            echo json_encode($message);
        }
    }
    public function get_laporan_year(){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->form_validation->set_rules('filter_name', 'Nama Karyawan', 'trim|callback_select_check');

            $employee_id = $this->input->post('filter_name', TRUE);
            if ($this->form_validation->run() == FALSE) {
                $message = [
                    'errors' => 'true',
                    'title' => 'Gagal!',
                    'desc' => validation_errors('<p class="fs-7">','</p>'),
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $result = $this->Absensi_model->get_laporan_by_year($employee_id);

                if ($result == null) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Absensi Karyawan belum ada',
                        'buttontext' => 'Oke, tutup'
                    ];
                } else {
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => $result,
                        'total_day' => '-',
                        'total_sat_sun' => '-',
                        'total_alpa' => '-',
                        'csrfhash' => $this->security->get_csrf_hash(),
                        'buttontext' => 'Oke, tutup'
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

    private function countDays($year, $month, $ignore, $type) {
        $day = 0;
        $satsun = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);
        while (date("n", $counter) == $month) {
            if (in_array(date("w", $counter), $ignore) == false) {
                $day++;
            } else {
                $satsun++;
            }
            $counter = strtotime("+1 day", $counter);
        }

        if($type == 'satsun'){
            return $satsun;
        }

        return $day;
    }

}

/* End of file Absensi.php */

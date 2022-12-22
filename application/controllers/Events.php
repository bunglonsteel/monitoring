<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_login();
        // check_user_acces();
        $this->load->model('Employee_model');
        $this->load->model('Settings_model');
        $this->load->model('Events_model');
        
    }

    public function index()
    {   
        $this->load->model('Cuti_model');
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $data['events'] = $this->Events_model->get('events');

        $data['title'] = 'Acara';
        $data['slug'] = 'Acara';
        $data['judul'] = 'Acara';
        render_template('events/events', $data);
    }

    public function add_events(){
        check_user_acces();
        $this->form_validation->set_rules('event_title', 'Judul acara', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('event_location', 'Lokasi acara', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('start_date', 'Mulai acara', 'trim|required|callback_select_date');
        $this->form_validation->set_rules('end_date', 'Berakhir acara', 'trim|required|callback_not_matches');
        $this->form_validation->set_rules('event_description', 'Deskripsi', 'trim|max_length[255]');

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
                
                $event_title     = $this->input->post('event_title', TRUE);
                $event_location  = $this->input->post('event_location', TRUE);
                $start_date      = $this->input->post('start_date', TRUE);
                $end_date        = $this->input->post('end_date', TRUE);
                $description     = $this->input->post('event_description', TRUE);

                    $data = [
                        'event_title' => htmlspecialchars($event_title) ,
                        'event_location' => htmlspecialchars($event_location),
                        'start_date' => htmlspecialchars($start_date),
                        'end_date' => htmlspecialchars($end_date),
                        'event_description' => strip_tags(html_escape($description))
                    ];
    
                    $message = [
                        'warning' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Acara berhasil ditambahkan',
                        'buttontext' => 'Oke, terimakasih'
                    ];
    
                    $this->Events_model->add('events', $data);
            }
            echo json_encode($message);
        }
    }

    public function edit_events(){
        check_user_acces();
        $this->form_validation->set_rules('event_title', 'Judul acara', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('event_location', 'Lokasi acara', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('start_date', 'Mulai acara', 'trim|required|callback_select_date');
        $this->form_validation->set_rules('end_date', 'Berakhir acara', 'trim|required|callback_not_matches');
        $this->form_validation->set_rules('event_description', 'Deskripsi', 'trim|max_length[255]');

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
                
                $event_id        = $this->input->post('event_id', TRUE);
                $event_title     = $this->input->post('event_title', TRUE);
                $event_location  = $this->input->post('event_location', TRUE);
                $start_date      = $this->input->post('start_date', TRUE);
                $end_date        = $this->input->post('end_date', TRUE);
                $description     = $this->input->post('event_description', TRUE);

                $check_event     = $this->Events_model->get_event_by_id('events',['event_id' => $event_id]);
                // var_dump($check_event, $event_id);die;
                if ($check_event == null) {
                    $message = [
                        'error' => 'true',
                        'title' => 'Gagal!',
                        'desc' => 'Acara tidak ada atau tidak ditemukan.',
                        'buttontext' => 'Oke, terimakasih'
                    ];
                } else {
                    $data = [
                        'event_title' => htmlspecialchars($event_title) ,
                        'event_location' => htmlspecialchars($event_location),
                        'start_date' => htmlspecialchars($start_date),
                        'end_date' => htmlspecialchars($end_date),
                        'event_description' => strip_tags(html_escape($description))
                    ];
    
                    $message = [
                        'success' => 'true',
                        'title' => 'Berhasil!',
                        'desc' => 'Acara berhasil diupdate.',
                        'buttontext' => 'Oke, terimakasih'
                    ];
    
                    $this->Events_model->update('events', $event_id,  $data);
                }
            }
            echo json_encode($message);
        }
    }

    public function delete_events($event_id){
        check_user_acces();
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $check_event = $this->Events_model->get_event_by_id('events', ['event_id' => $event_id]);
            // var_dump($check_event);die;
            if ($check_event == null) {
                $message = [
                    'error' => 'true',
                    'title' => 'Gagal!',
                    'desc' => 'Tidak bisa dihapus atau acara tidak ada.',
                    'buttontext' => 'Oke, tutup'
                ];
            } else {
                $message = [
                    'success' => 'true',
                    'title' => 'Berhasil!',
                    'desc' => 'Acara berhasil dihapus.',
                    'buttontext' => 'Oke, terimakasih'
                ];
                $this->Events_model->delete('events', ['event_id' => $event_id]);
            }

            echo json_encode($message);
        }
    }

    function select_date($date){
        if ($date <= date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))))){
                $this->form_validation->set_message('select_date', 'The {field} cannot be less than the current date.');
                return FALSE;
        } else {
                return TRUE;
        }
    }

    function not_matches($date){
        if ($date == $this->input->post('start_date', TRUE)){
            $this->form_validation->set_message('not_matches', 'The {field} cannot be the same as the start date.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

/* End of file Events.php */

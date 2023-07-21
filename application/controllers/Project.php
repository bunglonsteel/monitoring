<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('Employee_model');
        $this->load->model('Settings_model');
        $this->load->model('Project_model', 'project');
    }

    public function index()
    {
        if ($this->session->userdata('role_id') == 2) {
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        }

        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));
        $user = $this->project->get('users', ['email' => $this->session->userdata('email')])->row();
        
        if ($this->input->is_ajax_request()) {
            $results = $this->project->result_data();
            $new_project = [];
            foreach ($results as $result) {
                $teams          = $this->project->get_member(['project_id'=>$result->project_id]);
                $result->leader = array_filter($teams, fn ($lead) => $lead->is_head == "yes")[0];
                $result->team   = $teams;
                $new_project[]  = $result;
            }
            $data = [];
            foreach ($new_project as $res) {
                $team = '';
                foreach ($res->team as $v) {
                    $team .= '
                        <div class="avatar avatar-rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="' . $v->full_name . '">
                            <img src="' . base_url('public/image/users/' . $v->image_profile) . '" alt="user" class="avatar-img">
                        </div>
                    ';
                }

                $percent = $res->completion_percent <= 39 ? "bg-danger" : ($res->completion_percent >= 40 && $res->completion_percent <= 79 ? "bg-warning" : "bg-success");

                $row = [];
                $row[] = $res->project_name;
                $row[] = '
                    <div class="avatar-group avatar-group-sm avatar-group-overlapped me-3">'
                    . $team .
                    '</div>';
                $row[] = $res->deadline ? date('d M Y', strtotime($res->deadline)) : "-";
                $row[] = '
                            <div class="progress rounded-5">
                                <div class="progress-bar ' . $percent . ' rounded-5 fw-bold fs-9" style="width: ' . $res->completion_percent . '%;" role="progressbar" aria-valuenow="' . $res->completion_percent . '" aria-valuemin="0" aria-valuemax="100">
                                    ' . $res->completion_percent . '%
                                </div>
                            </div>
                        ';

                if ($this->session->userdata('role_id') == 2 || $user->user_id == $res->leader->user_id){
                $row[] = '
                            <select class="select_status">
                                <option value="' . $res->project_status . '" selected>' . ucwords($res->project_status) . '</option>
                            </select>
                        ';

                $action = '<button class="btn btn-icon btn-sm btn-soft-dark flush-soft-hover action-edit" type="button" data-id="' . $res->project_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-pencil"></i>
                                </span>
                            </button>
                            ';
                } else {
                $row[]  = ucwords($res->project_status);
                $action = '';
                }

                if ($this->session->userdata('role_id') == 2) {
                    $action.= '<button class="btn btn-icon btn-sm btn-soft-danger flush-soft-hover action-remove" type="button" data-id="' . $res->project_id . '">
                            <span class="icon fs-8">
                                <i class="icon dripicons-trash"></i>
                            </span>
                        </button>';
                }

                $row[] = '<div class="d-flex gap-2">
                                <a href="' . base_url('project/view/'. $res->project_id ). '" class="btn btn-sm btn-soft-dark flush-soft-hover action-show" type="button">
                                    <span class="icon fs-8">
                                        <i class="icon dripicons-preview"></i>
                                        <span>Lihat</span>
                                    </span>
                                </a>
                                '.$action.'
                            </div>';
                $data[] = $row;
            }
            $output = [
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->project->count_all_result(),
                "recordsFiltered" => $this->project->count_filtered(),
                "data"            => $data,
                "csrf_hash"       => $this->security->get_csrf_hash()
            ];
            return $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
        $data['title'] = 'Projects';
        $data['slug'] = 'Projects';
        $data['judul'] = 'Projects';
        render_template('project/project', $data);
    }

    public function task($project_id = "")
    {
        if ($this->input->is_ajax_request()) {
            $results = $this->project->result_data("task", $project_id);
            $data = [];
            foreach (array_values($results) as $res) {

                $status = $res->status == "completed" ? "badge-soft-success" : ($res->status >= "in progress" ? "badge-soft-info" : "badge-soft-secondary");
                if ($res->verify_completed == "yes") {
                    $achievement = '👍';
                } else if($res->verify_completed == "no"){
                    $achievement = '💪';
                }

                if ($this->session->userdata('role_id') == 2){
                    if($res->verify_completed == NULL && $res->status != "todo"){
                        $achievement = '<div class="d-flex gap-2">
                            <button class="btn review btn-icon btn-soft-success border-success btn-xs" data-id="' . $res->task_id . '" data-value="yes">
                                <span class="icon fs-8">
                                    👍
                                </span>
                            </button>
                            <button class="btn review btn-icon btn-soft-warning border-warning btn-xs" data-id="' . $res->task_id . '" data-value="no">
                                <span class="icon fs-8">
                                    💪
                                </span>
                            </button>
                        </div>';
                    } else if($res->verify_completed == NULL){
                        $achievement = "-";
                    }
                } else {
                    if($res->verify_completed == NULL && $res->status != "todo"){
                        $achievement = '<span class="badge badge-soft-warning">Menunggu...</span>';
                    } else if($res->verify_completed == NULL){
                        $achievement = "-";
                    }
                }

                $row = [];
                $row[] = '
                    <div>
                        <p class="fw-bold">'.ucwords($res->task_title).'</p>
                        <p class="fs-8 text-wrap text-limit-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="'.$res->task_description.'">
                            '.$res->task_description.'
                        </p>
                    </div>
                    ';
                $row[] = $res->project_name;
                $row[] = date('d M Y', strtotime($res->start_date));
                $row[] = date('d M Y', strtotime($res->due_date));
                $row[] = $res->status != "completed" ? 
                        '<select class="status_task" style="min-width:120px;">
                            <option value="' . $res->status . '" selected>' . ucwords($res->status) . '</option>
                        </select>' : 
                        '<span class="badge '.$status.'">'
                            . ucwords($res->status) .
                        '</span>';
                $row[] = $res->full_name ? 
                        '<span class="bg-light d-inline-block rounded-pill p-1 pe-3 mr-1 mb-1 fs-8">
                            <div class="avatar avatar-rounded avatar-xxs">
                                <img src="'. base_url("public/image/users/". $res->image_profile).'" alt="<?= $t->fullname ?>" class="avatar-img">
                            </div>
                                '.$res->full_name.'
                        </span>' : "-";
                $row[] = $achievement;
                $row[] = '<div class="d-flex gap-2">
                            <button class="btn btn-sm btn-soft-dark flush-soft-hover show-detail drawer-toggle-link" type="button" data-target="#drawer_push" data-drawer="push-normal" data-id="' . $res->task_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-preview"></i>
                                    <span>Lihat</span>
                                </span>
                            </button>
                            <button class="btn btn-icon btn-sm btn-soft-dark flush-soft-hover edit-task" type="button" data-id="' . $res->task_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-pencil"></i>
                                </span>
                            </button>
                            <button class="btn btn-icon btn-sm btn-soft-danger flush-soft-hover remove-task" type="button" data-id="' . $res->task_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-trash"></i>
                                </span>
                            </button>
                        </div>';
                $data[] = $row;
            }
            $output = [
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->project->count_all_result("task", $project_id),
                "recordsFiltered" => $this->project->count_filtered("task", $project_id),
                "data"            => $data,
                "csrf_hash"       => $this->security->get_csrf_hash()
            ];
            return $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function tasks(){
        check_user_acces();
        if ($this->session->userdata('role_id') == 2) {
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        }

        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        $data['title'] = 'Tugas';
        $data['slug']  = 'Tugas';
        $data['judul'] = 'Tugas';
        render_template('project/tasks', $data);
    }

    public function task_categories(){
        check_user_acces();
        if ($this->session->userdata('role_id') == 2) {
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        }

        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        $data['title'] = 'Tugas Cek Item';
        $data['slug']  = 'Tugas Cek Item';
        $data['judul'] = 'Tugas Cek Item';
        render_template('project/task_categories', $data);
    }

    public function categories(){
        check_user_acces();
        if ($this->input->is_ajax_request()) {
            $results = $this->project->result_data("category");
            // var_dump($results);die;
            $data = [];
            foreach ($results as $key => $res) {

                $row = [];
                $row[] = $key + 1;
                $row[] = $res->parent_id ?  $res->category : $res->category. ' <span class="badge badge-sm badge-primary">Induk</span>';
                $row[] = '<div class="d-flex gap-2">
                            <button class="btn btn-sm btn-soft-dark flush-soft-hover action-edit" type="button" data-id="' . $res->category_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-pencil"></i>
                                    <span> Edit</span>
                                </span>
                            </button>
                            <button class="btn btn-sm btn-soft-danger flush-soft-hover action-remove" type="button" data-id="' . $res->category_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-trash"></i>
                                    <span> Hapus</span>
                                </span>
                            </button>
                        </div>';
                $data[] = $row;
            }
            $output = [
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->project->count_all_result("category"),
                "recordsFiltered" => $this->project->count_filtered("category"),
                "data"            => $data,
                "csrf_hash"       => $this->security->get_csrf_hash()
            ];
            return $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function view($id){
        if ($this->session->userdata('role_id') == 2) {
            $this->load->model('Cuti_model');
            $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        }
        $data['settings'] = $this->Settings_model->get_settings();
        $data['employee'] = $this->Employee_model->get_employee_by_id($this->session->userdata('employee_id'));

        $project = $this->project->get_project(htmlspecialchars($id));
        if (!$project) {
            show_404();
        } else {
            $data['project'] = $project;
            $data['title']   = $project->project_name;
            $data['slug']    = 'Projects';
            $data['judul']   = $project->project_name;
            render_template('project/project_detail', $data);
        }
    }

    public function action($action)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $this->_rules();
            $request = [
                'target'     => $this->input->post('target', TRUE),
                'title'      => $this->input->post('title', TRUE),
                'start_date' => $this->input->post('start_date', TRUE),
                'deadline'   => $this->input->post('deadline', TRUE),
                'leader'     => $this->input->post('leader', TRUE),
                'team'       => $this->input->post('team', TRUE),
                'progress'   => $this->input->post('progress', TRUE),
                'status'     => $this->input->post('status', TRUE),
                'desc'       => $this->input->post('desc'),
            ];

            // var_dump($request);
            // die;

            if ($action == "add") {
                $output = $this->_add($request);
            } else {
                $output = $this->_update($request);
            }

            echo json_encode($output);
        }
    }

    private function _rules()
    {
        $this->form_validation->set_rules(
            'title',
            'Judul Project',
            'trim|required|max_length[150]',
            [
                'required'   => '%s tidak boleh kosong.',
                'max_length' => '%s tidak boleh lebih dari {param} huruf.'
            ]
        );
        $this->form_validation->set_rules(
            'start_date',
            'Tanggal Mulai',
            'trim|required',
            ['required' => '%s tidak boleh kosong.']
        );
        $this->form_validation->set_rules(
            'leader',
            'Leader Team',
            'trim|required',
            ['required' => '%s tidak boleh kosong.']
        );
        $this->form_validation->set_rules(
            'deadline',
            'Deadline',
            'trim'
        );
        $this->form_validation->set_rules(
            'team',
            'Team',
            'trim'
        );
        $this->form_validation->set_rules(
            'progress',
            'Progress',
            'trim|numeric',
            ['numeric' => '%s hanya berupa number yang diperbolehkan.']
        );
        $this->form_validation->set_rules(
            'desc',
            'Deskripsi / Catatan',
            'trim'
        );
    }

    private function _rules_task()
    {
        $this->form_validation->set_rules(
            'title_task',
            'Judul Tugas',
            'trim|required|max_length[150]',
            [
                'required'   => '%s tidak boleh kosong.',
                'max_length' => '%s tidak boleh lebih dari {param} huruf.'
            ]
        );
        $this->form_validation->set_rules(
            'project',
            'Project',
            'trim|required|numeric',
            ['required'   => '%s tidak boleh kosong.']
        );
        $this->form_validation->set_rules(
            'status_task',
            'Status Tugas',
            'trim|required|in_list[doing,partially finished,completed]',
            ['required'   => '%s tidak boleh kosong.']
        );
        $this->form_validation->set_rules(
            'categories[]',
            'Cek Item',
            'trim|required|numeric',
            ['required'   => '%s tidak boleh kosong.']
        );
        $this->form_validation->set_rules(
            'start_date',
            'Tanggal Mulai',
            'trim'
        );
        $this->form_validation->set_rules(
            'due_date',
            'Tanggal Berakhir',
            'trim'
        );
        $this->form_validation->set_rules(
            'description',
            'Deskripsi / Catatan tugas',
            'trim|max_length[255]',
            ['max_length' => '%s tidak boleh lebih dari {param} huruf.']
        );
    }

    private function _rules_task_categories()
    {
        $this->form_validation->set_rules(
            'category',
            'Nama Cek Item',
            'trim|required|max_length[50]',
            [
                'required'   => '%s tidak boleh kosong.',
                'max_length' => '%s tidak boleh lebih dari {param} huruf.'
            ]
        );
        $this->form_validation->set_rules(
            'parent_category',
            'Induk Cek Item',
            'trim|numeric'
        );
    }

    private function _add($request)
    {
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
            $user = $this->project->get('users', ['email' => $this->session->userdata('email')])->row();
            $project = [
                'project_name'        => $request['title'],
                'project_description' => $request['desc'],
                'start_date'          => $request['start_date'],
            ];

            if ($request['deadline']) {
                $project['deadline'] = $request['deadline'];
            }

            $last_id = $this->project->insert('project', $project, true);

            $project_member = [];
            $project_member[] = [
                'project_id' => $last_id,
                'user_id'    => $request['leader'],
                'is_head'    => 'yes',
                'added_by'   => $user->user_id,
            ];

            if ($request['team']) {
                foreach ($request['team'] as $team) {
                    $project_member[] = [
                        'project_id' => $last_id,
                        'user_id'    => $team,
                        'is_head'    => 'no',
                        'added_by'   => $user->user_id,
                    ];
                }
            }

            $this->project->insert_batch('project_member', $project_member);
            $output = [
                'success'   => true,
                'message'   => 'Project berhasil ditambahkan, terimakasih.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ];
        }

        return $output;
    }

    private function _update($request)
    {
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
            $project  = $this->project->get('project', ['project_id' => $request['target']])->row();
            $user     = $this->project->get('users', ['email' => $this->session->userdata('email')])->row();
            $team_old = $this->project->get_not_in('project_member', 'user_id', $request['team'], ['project_id' => $project->project_id, 'is_head' => "no"])->result();

            if ($team_old) {
                $team_old = array_map(fn($v) => $v->user_id, $team_old);
                $this->db->where('project_id', $project->project_id)
                ->where_in('user_id', $team_old)
                ->delete('project_member');
            }
            $teams  = $this->project->get('project_member', ['project_id' => $project->project_id])->result();
            $leader = array_filter($teams, fn ($v) => $v->is_head == "yes")[0];

            $project_team = [];
            if ($request['team']) {
                foreach ($request['team'] as $u) {
                    $team = array_filter($teams, fn ($v) => $u == $v->user_id && $v->is_head == "no");
                    if (!$team) {
                        $project_team[] = (object) [
                            'project_id' => $project->project_id,
                            'user_id'    => $u,
                            'is_head'    => 'no',
                            'added_by'   => $user->user_id,
                        ];
                    }
                }
            }

            $data_project = [
                'project_name'        => $request['title'],
                'project_description' => $request['desc'],
                'project_status'      => $request['status'],
                'start_date'          => $request['start_date'],
                'completion_percent'  => $request['progress'],
            ];
            if ($request['deadline']) {
                $data_project['deadline'] = $request['deadline'];
            }

            $this->project->update('project', $data_project, ['project_id' => $project->project_id]);
            if ($leader->user_id != $request['leader']) {
                $this->project->update('project_member', ['user_id' => $request['leader']], ['project_member_id' => $leader->project_member_id]);
            }
            if ($project_team) {
                $this->project->insert_batch('project_member', $project_team);
            }
            $output = [
                'success'   => true,
                'message'   => 'Project berhasil diperbarui, terimakasih.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ];
        }

        return $output;
    }

    public function action_task($action)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $this->_rules_task();
            $request = [
                'target'      => $this->input->post('target', TRUE),
                'title_task'  => $this->input->post('title_task', TRUE),
                'project'     => $this->input->post('project', TRUE),
                'categories'  => $this->input->post('categories', TRUE),
                'status_task' => $this->input->post('status_task', TRUE),
                'start_date'  => $this->input->post('start_date', TRUE),
                'due_date'    => $this->input->post('due_date', TRUE),
                'desc_task'   => $this->input->post('desc_task', TRUE),
            ];

            if ($action == "add") {
                $output = $this->_add_task($request);
            } else {
                $output = $this->_update_task($request);
            }

            echo json_encode($output);
        }
    }

    private function _add_task($request) {
        if ($this->form_validation->run() == false) {
            $output = [
                'errors'  => 'true',
                'message' => validation_errors(
                    '<div class="alert alert-danger alert-dismissible fs-8 py-2_5" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
                ),
                'csrf_hash' => $this->security->get_csrf_hash(),
            ];
        } else {
            $user = $this->project->get('users', ['email' => $this->session->userdata('email')])->row();
            $team = $this->project->get('project_member', ['project_id' => $request['project'], 'user_id' => $user->user_id])->row();
            if (!$team) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Anda tidak bisa menambah tugas di project ini, silahkan kordinasi bersama leader team untuk menambahkan anda terlebih dahulu.',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $data_task = [
                    'task_title'       => $request['title_task'],
                    'project_id'       => $request['project'],
                    'task_description' => $request['desc_task'],
                    'start_date'       => date('y-m-d'),
                    'due_date'         => date('y-m-d'),
                    'status'           => $request['status_task'],
                    'added_by'         => $user->user_id,
                ];
    
                if ($request['start_date']) {
                    $data_task['start_date'] = $request['start_date'];
                }
    
                if ($request['due_date']) {
                    $data_task['due_date'] = $request['due_date'];
                }
    
                $last_task = $this->project->insert('tasks', $data_task, true);
    
                $groups = [];
                if ($request['categories']) {
                    foreach ($request['categories'] as $group) {
                        $groups[] = [
                            'task_id'          => $last_task,
                            'task_category_id' => $group,
                        ];
                    }
                }
                $this->project->insert_batch('task_group', $groups);
                $output = [
                    'success'   => true,
                    'message'   => 'Tugas berhasil ditambahkan, terimakasih.',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
        }

        return $output;
    }

    private function _update_task($request) {
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
            $task = $this->project->get('tasks', ['task_id' => $request['target']])->row();
            if (!$task) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $user = $this->project->get('users', ['email' => $this->session->userdata('email')])->row();
                $team = $this->project->get('project_member', ['project_id' => $request['project'], 'user_id' => $user->user_id])->row();
                if (!$team) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Anda tidak bisa mengubah tugas di project ini, silahkan kordinasi bersama leader team untuk menambahkan anda terlebih dahulu.',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else { 
                    $data_task = [
                        'task_title'       => $request['title_task'],
                        'task_description' => $request['desc_task'],
                        'start_date'       => $request['start_date'],
                        'due_date'         => $request['due_date'],
                        'status'           => $request['status_task'],
                        'last_update_by'   => $user->user_id,
                    ];
    
                    $this->project->update('tasks', $data_task, ['task_id' => $task->task_id]);
                    $category_old = $this->project->get_not_in('task_group', 'task_category_id', $request['categories'], ['task_id' => $task->task_id])->result();
                    if ($category_old) {
                        $category_old = array_map(fn($v) => $v->task_group_id, $category_old);
    
                        $this->db->where('task_id', $task->task_id)
                        ->where_in('task_group_id', $category_old)
                        ->delete('task_group');
                    }
    
                    $categories = $this->project->get('task_group', ['task_id' => $task->task_id])->result();
                    // var_dump($categories);die;
                    $groups     = [];
                    if ($request['categories']) {
                        foreach ($request['categories'] as $c) {
                            $group = array_filter($categories, fn ($v) => $c == $v->task_category_id);
                            if (!$group) {
                                $groups[] = (object) [
                                    'task_id'          => $task->task_id,
                                    'task_category_id' => $c,
                                ];
                            }
                        }
                    }
    
                    if ($groups) {
                        $this->project->insert_batch('task_group', $groups);
                    }
                    $output = [
                        'success'   => true,
                        'message'   => 'Tugas berhasil diperbarui, terimakasih.',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                }
            }
        }

        return $output;
    }

    public function action_task_categories($action)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $this->_rules_task_categories();
            $request = [
                'target'   => $this->input->post('target', TRUE),
                'category' => $this->input->post('category', TRUE),
                'parent'   => $this->input->post('parent_category', TRUE),
            ];

            if ($action == "add") {
                $output = $this->_add_task_categories($request);
            } else {
                $output = $this->_update_task_categories($request);
            }

            echo json_encode($output);
        }
    }

    private function _add_task_categories($request) {
        if ($this->form_validation->run() == false) {
            $output = [
                'errors'  => 'true',
                'message' => validation_errors(
                    '<div class="alert alert-danger alert-dismissible fs-8 py-2_5" role="alert">',
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>'
                ),
                'csrf_hash' => $this->security->get_csrf_hash(),
            ];
        } else {
            $data['category_name'] = $request['category'];

            if ($request['parent']) {
                $data['parent_id'] = $request['parent'];
            }

            $this->project->insert('task_category', $data);
            $output = [
                'success'   => true,
                'message'   => 'Kategori berhasil ditambahkan, terimakasih.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ];
        }

        return $output;
    }

    private function _update_task_categories($request) {
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
            $task_category  = $this->project->get('task_category', ['task_category_id' => $request['target']])->row();
            if (!$task_category) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $data['category_name'] = $request['category'];

                if ($request['parent']) {
                    $data['parent_id'] = $request['parent'];
                }
                $this->project->update('task_category', $data, ['task_category_id' => $task_category->task_category_id]);
                $output = [
                    'success'   => true,
                    'message'   => 'Kategori berhasil diperbarui, terimakasih.',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
        }

        return $output;
    }

    public function delete()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id     = $this->input->post('id', true);
            $type   = $this->input->post('type', true);

            if ($type == "project") {
                $project = $this->project->get('project', ['project_id' => $id])->row();
                if (!$project) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $result = $this->project->delete('project', ['project_id' => $project->project_id]);
                    $result = $this->project->delete('project_member', ['project_id' => $project->project_id]);
                    if (!$result) {
                        $output = [
                            'error'     => 'true',
                            'message'   => 'Ada kesalahan pada saat ingin menghapus.',
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    } else {
                        $output = [
                            'success'   => 'true',
                            'message'   => "Project berhasil dihapus.",
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    }
                }
            } else if($type == "task"){
                $task = $this->project->get('tasks', ['task_id' => $id])->row();
                if (!$task) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $user = $this->project->get('users', ['email' => $this->session->userdata('email')])->row();
                    if ($task->added_by == $user->user_id) {
                        $result = $this->project->delete('tasks', ['task_id' => $id]);
                        $result = $this->project->delete('task_group', ['task_id' => $id]);
                        if (!$result) {
                            $output = [
                                'error'     => 'true',
                                'message'   => 'Ada kesalahan pada saat update.',
                                'csrf_hash' => $this->security->get_csrf_hash(),
                            ];
                        } else {
                            $output = [
                                'success'   => 'true',
                                'message'   => "Tugas berhasil dihapus.",
                                'csrf_hash' => $this->security->get_csrf_hash(),
                            ];
                        }
                    } else {
                        $output = [
                            'error'     => 'true',
                            'message'   => 'Anda tidak bisa menghapus tugas yang telah dibuat orang lain.',
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    }
                }
            } else {
                $task_category = $this->project->get('task_category', ['task_category_id' => $id])->row();
                if (!$task_category) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $result = $this->project->delete('task_category', ['task_category_id' => $id]);
                    if (!$result) {
                        $output = [
                            'error'     => 'true',
                            'message'   => 'Ada kesalahan pada saat menghapus.',
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    } else {
                        $output = [
                            'success'   => 'true',
                            'message'   => "Kategori berhasil dihapus.",
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    }
                }
            }
            echo json_encode($output);
        }
    }

    public function get_project()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id      = $this->input->post('id');
            $project = $this->project->get_project($id);
            if (!$project) {
                $output = [
                    'error'    => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $output = [
                    'success'   => 'true',
                    'data'      => $project,
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }

    public function get_task()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id               = $this->input->post('id', TRUE);
            $task             = $this->project->get_task($id);
            $task->categories = $this->db->select('tc.task_category_id as id, tc.category_name as name')
                                            ->from('task_group as tg')
                                            ->join('task_category as tc', 'tg.task_category_id = tc.task_category_id')
                                            ->where('tg.task_id', $task->task_id)
                                            ->get()->result();
            if (!$task) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $output = [
                    'success'   => 'true',
                    'data'      => $task,
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }

    public function get_task_category()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id            = $this->input->post('id', TRUE);
            $task_category = $this->project->get('task_category', ['task_category_id' => $id])->row();

            if (!$task_category) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                if ($task_category->parent_id) {
                    $parent = $this->project->get('task_category', ['task_category_id' => $task_category->parent_id])->row();
                    $task_category->parent_name = $parent->category_name;
                }
                $output = [
                    'success'   => 'true',
                    'data'      => $task_category,
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }

    public function select_project()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $user    = $this->project->get('users', ['email' => $this->session->userdata('email')])->row();
            $project = $this->project->select_project($user->user_id);
            if (!$project) {
                $output = [
                    'errors'    => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $output = [
                    'success'   => 'true',
                    'data'      => $project,
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }

    public function select_categories()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $categories = $this->project->select_task_category(true);
            if (!$categories) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $output = [
                    'success'   => 'true',
                    'data'      => $categories,
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }

    public function select_employee()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            
            $employee = $this->Employee_model->select_user();

            if (!$employee) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $output = [
                    'success'   => 'true',
                    'data'      => $employee,
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }

    public function update_status()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id     = $this->input->post('id');
            $type   = $this->input->post('type');
            $status = $this->input->post('status');

            if ($type == "project") {
                $project = $this->project->get('project', ['project_id' => $id])->row();
                if (!$project) {
                    $output = [
                        'error'    => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $result = $this->project->update('project', ['project_status' => $status], ['project_id' => $project->project_id]);
                    if (!$result) {
                        $output = [
                            'error'     => 'true',
                            'message'   => 'Ada kesalahan pada saat update.',
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    } else {
                        $output = [
                            'success'   => 'true',
                            'message'   => "Status berhasil diperbarui.",
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    }
                }
            } else {
                $task = $this->project->get('tasks', ['task_id' => $id])->row();
                if (!$task) {
                    $output = [
                        'error'    => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $user = $this->project->get('users', ['email' => $this->session->userdata('email')])->row();
                    $team = $this->project->get('project_member', ['project_id' => $task->project_id, 'user_id' => $user->user_id])->row();
                    if (!$team) {
                        $output = [
                            'error'     => 'true',
                            'message'   => 'Anda tidak bisa memperbarui status, silahkan kordinasi bersama leader team untuk menambahkan anda terlebih dahulu.',
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    } else {
                        $result = $this->project->update('tasks', ['status' => $status], ['task_id' => $task->task_id]);
                        if (!$result) {
                            $output = [
                                'error'     => 'true',
                                'message'   => 'Ada kesalahan pada saat update.',
                                'csrf_hash' => $this->security->get_csrf_hash(),
                            ];
                        } else {
                            $output = [
                                'success'   => 'true',
                                'message'   => "Status berhasil diperbarui.",
                                'csrf_hash' => $this->security->get_csrf_hash(),
                            ];
                        }
                    }
                }
            }
            echo json_encode($output);
        }
    }

    public function review_task(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id     = $this->input->post('id', true);
            $review = $this->input->post('review', true);
            $task   = $this->project->get('tasks', ['task_id' => $id])->row();
            if (!$task) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $result = $this->project->update('tasks', ['verify_completed' => $review], ['task_id' => $task->task_id]);
                if (!$result) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Ada kesalahan pada saat update.',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $output = [
                        'success'   => 'true',
                        'message'   => "Tugas berhasil direview.",
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                }
            }
            echo json_encode($output);
        }
    }

    public function select_task_categories()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $task_category = $this->project->select_task_category();
            if (!$task_category) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $output = [
                    'success'   => 'true',
                    'data'      => $task_category,
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }
}

/* End of file Controllername.php */

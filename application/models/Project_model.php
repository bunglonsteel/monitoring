<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Project_model extends CI_Model
{

    private $order            = ['project_id', 'project_member_id', 'deadline', 'completion_percent', 'project_status'];
    private $order_task       = ['task_id', 'start_date', 'due_date', 'status', 'added_by', "verify_completed"];
    private $order_categories = ['task_category_id', 'category_name'];

    private function join_table_project()
    {
        $this->db->select('
            p.project_id, 
            p.project_name, 
            p.project_description,
            p.project_status, 
            p.start_date, 
            p.deadline, 
            p.completion_percent,
            p.completed_on,
            pm.user_id as p_user,
            pm.is_head,
            u.user_id,
            e.full_name,
            e.image_profile')
            ->from('project as p')
            ->join('project_member as pm', 'p.project_id = pm.project_id')
            ->join('users as u', 'pm.user_id = u.user_id')
            ->join('employee as e', 'u.employee_id = e.employee_id');
    }

    private function join_table_task(){
        $this->db->select('
        t.*,
        p.project_id,
        p.project_name,
        e.full_name,
        e.image_profile')
        ->from('tasks as t')
        ->join('users as u', 't.added_by = u.user_id', "left")
        ->join('employee as e', 'u.employee_id = e.employee_id', "left")
        ->join("project as p", "t.project_id = p.project_id");
    }

    private function _get_query($type = "project", $where="")
    {
        // $user = $this->get('users', ['email' => $this->session->userdata('email')])->row();
        if ($type == "project") {
            $this->join_table_project();
            if ($this->session->userdata('role_id') == 1) {
                $this->db->where('p.project_status !=', 'not started');
            }
            if (strip_tags(htmlspecialchars($_POST['search']['value']))) {
                $this->db->like('project_name', strip_tags(htmlspecialchars($_POST['search']['value'])));
            }

            if ($_POST['order'][0]['column']) {
                $this->db->order_by($this->order[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
            } else {
                $this->db->order_by('p.project_id', 'DESC');
            }
        } else if($type == "task"){

            $this->join_table_task();
            if ($where) {
                $this->db->where('t.project_id', $where);
            }

            if (strip_tags(htmlspecialchars($_POST['search']['value']))) {
                $this->db->like('task_title', strip_tags(htmlspecialchars($_POST['search']['value'])));
                $this->db->or_like('task_description', strip_tags(htmlspecialchars($_POST['search']['value'])));
            }

            if ($_POST['order'][0]['column']) {
                $this->db->order_by($this->order_task[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
            } else {
                $this->db->order_by('t.task_id', 'DESC');
            }
        } else {
            $this->db->select('task_category_id as category_id, category_name as category, parent_id')
                    ->from('task_category');

            if (strip_tags(htmlspecialchars($_POST['search']['value']))) {
                $this->db->like('category_name', strip_tags(htmlspecialchars($_POST['search']['value'])));
            }

            if ($_POST['order'][0]['column']) {
                $this->db->order_by($this->order_categories[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
            } else {
                $this->db->order_by('task_category_id', 'DESC');
            }
        }
        
    }

    public function result_data($type = "project", $where="")
    {
        $this->_get_query($type, $where);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        return $this->db->get()->result();
    }

    public function count_filtered($type = "project", $where="")
    {
        $this->_get_query($type, $where);
        if ($type == "project") {
            $this->db->group_by('p.project_id');
        }
        return $this->db->get()->num_rows();
    }

    public function count_all_result($type = "project", $where="")
    {
        $this->_get_query($type, $where);
        if ($type == "project") {
            $this->db->group_by('p.project_id');
        }
        return $this->db->count_all_results();
    }

    public function get($table, $where)
    {
        return $this->db->get_where($table, $where);
    }
    public function get_in($table, $key, $where_in, $where)
    {
        return $this->db->from($table)
            ->where($where)
            ->where_in($key, $where_in)
            ->get();
    }
    public function get_not_in($table, $key, $where_in, $where)
    {
        return $this->db->from($table)
            ->where($where)
            ->where_not_in($key, $where_in)
            ->get();
    }

    public function insert($table, $data, $return_id = false)
    {
        $this->db->insert($table, $data);
        if ($return_id) {
            return $this->db->insert_id();
        }
    }

    public function insert_batch($table, $data)
    {
        $this->db->insert_batch($table, $data);
    }

    public function update($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($table, $where)
    {
        $this->db->delete($table, $where);
        return $this->db->affected_rows();
    }

    public function get_project($id)
    {
        $this->join_table_project();
        $this->db->where('p.project_id', $id);
        $result = $this->db->get()->result();

        if ($result) {
            $data  = [];
            foreach ($result as $v) {
                if (isset($data[$v->project_id])) {
                    continue;
                }
                $project_id = $v->project_id;
                $team = array_map(function ($obj) use ($project_id) {
                    if ($obj->project_id == $project_id) {
                        $new                = new stdClass();
                        $new->user          = $obj->user_id;
                        $new->leader        = $obj->is_head;
                        $new->fullname      = $obj->full_name;
                        $new->image_profile = $obj->image_profile;
                        return $new;
                    }
                }, $result);

                $new                      = new stdClass();
                $new->project_id          = $v->project_id;
                $new->project_name        = $v->project_name;
                $new->project_description = $v->project_description;
                $new->project_status      = $v->project_status;
                $new->start_date          = $v->start_date;
                $new->deadline            = $v->deadline;
                $new->completion_percent  = $v->completion_percent;
                $new->completed_on        = $v->completed_on;
                $new->leader              = array_filter($team, fn ($vi) => $vi->leader == "yes")[0];
                $new->team                = [...array_filter($team, fn ($vi) => $vi->leader == "no")];
                $data[$v->project_id]     = $new;
            }
            return array_values($data)[0];
        }
        return false;
    }

    public function get_task($id){
        $this->join_table_task();
        $this->db->where('t.task_id',$id);
        return $this->db->get()->row();
    }

    public function select_project($user_id)
    {
        $this->db->select('p.project_id as id, p.project_name as name')
            ->from('project as p')
            ->join('project_member as pm', 'p.project_id = pm.project_id');
        if ($this->session->userdata('role_id') == 1) {
            $this->db->where('pm.user_id', $user_id);
        }
        $this->db->where('project_status !=', 'not started')
            ->where('project_status !=', 'finished')
            ->group_by('p.project_id');
        if ($this->input->post('search', TRUE)) {
            $this->db->like('project_name', $this->input->post('search', TRUE));
        }
        return $this->db->get()->result();
    }

    public function select_task_category($onlyParent = false)
    {
        $this->db->select('task_category_id as id, category_name as name, parent_id')
            ->from('task_category');
        if ($onlyParent) {
            $this->db->where('parent_id', NULL);
        }
        if ($this->input->post('search', TRUE)) {
            $this->db->like('category_name', $this->input->post('search', TRUE));
        }
        return $this->db->get()->result();
    }
}

/* End of file Project_model.php */

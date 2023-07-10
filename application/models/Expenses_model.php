<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses_model extends CI_Model {

    private $order_expenses           = ['expense_id', 'expense_cat_id', 'date', 'amount', 'note'];
    private $order_expense_categories = ['expense_categories_id', 'name', 'description'];

    private function join_table_expenses(){
        $this->db->select('*')
            ->from('expenses as e')
            ->join('expense_categories as ec', 'e.expense_cat_id = ec.expense_categories_id');
    }

    private function _get_query($type)
    {
        if ($type == "expenses") {
            $this->join_table_expenses();

            if (strip_tags(htmlspecialchars($_POST['search']['value']))) {
                $this->db->like('project_name', strip_tags(htmlspecialchars($_POST['search']['value'])));
            }

            $date = $this->input->post('filter', TRUE);
            if ($date) {
                $date       = explode("-", $date);
                $start_date = date('Y-m-d', strtotime($date[0]));
                $end_date   = date('Y-m-d', strtotime($date[1]));
                $this->db->where("DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'");
            }

            if ($_POST['order'][0]['column']) {
                $this->db->order_by($this->order_expenses[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
            } else {
                $this->db->order_by('e.expense_id', 'DESC');
            }
        } else if($type == "expense_categories"){
            $this->db->select('*')
                    ->from('expense_categories');
            if (strip_tags(htmlspecialchars($_POST['search']['value']))) {
                $this->db->like('task_title', strip_tags(htmlspecialchars($_POST['search']['value'])));
                $this->db->or_like('task_description', strip_tags(htmlspecialchars($_POST['search']['value'])));
            }

            if ($_POST['order'][0]['column']) {
                $this->db->order_by($this->order_expense_categories[$_POST['order'][0]['column']], $_POST['order'][0]['dir']);
            } else {
                $this->db->order_by('expense_categories_id', 'DESC');
            }
        }
    }

    public function result_data($type)
    {
        $this->_get_query($type);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        return $this->db->get()->result();
    }

    public function sum_filtered($time = "month")
    {
        $this->db->select_sum('amount');
        if ($time == "month") {
            $this->db->where('MONTH(date)', date('m'));
            $this->db->where('YEAR(date)', date('Y'));
        } else if($time == "year"){
            $this->db->where('YEAR(date)', date('Y'));
        } else if($time == "filter"){
            $date = $this->input->post('filter', TRUE);
            if ($date) {
                $date       = explode("-", $date);
                $start_date = date('Y-m-d', strtotime($date[0]));
                $end_date   = date('Y-m-d', strtotime($date[1]));
                $this->db->where("DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'");
            }
        }
        return $this->db->get('expenses')->row();
    }

    public function count_filtered($type)
    {
        $this->_get_query($type);
        return $this->db->get()->num_rows();
    }

    public function count_all_result($type)
    {
        $this->_get_query($type);
        return $this->db->count_all_results();
    }

    public function get($table, $where) {
        if ($table == "expenses") {
            $this->db->join('expense_categories as ec','expenses.expense_cat_id = ec.expense_categories_id');
        }
        return $this->db->get_where($table, $where);
    }

    public function insert($table, $data, $return_id = false)
    {
        $this->db->insert($table, $data);
        if ($return_id) {
            return $this->db->insert_id();
        }
    }

    public function update($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function update_set($table, $set_data, $where)
    {
        $this->db->set($set_data['key'], $set_data['set'], FALSE)
                ->where($where)
                ->update($table);
        return $this->db->affected_rows();
    }

    public function delete($table, $where)
    {
        $this->db->delete($table, $where);
        return $this->db->affected_rows();
    }

    public function select_expense_cateogories()
    {
        $this->db->select('ec.expense_categories_id as id, name')->from('expense_categories as ec');
        if ($this->input->post('search', TRUE)) {
            $this->db->like('name', $this->input->post('search', TRUE));
        }
        return $this->db->get()->result();
    }

}

/* End of file Expenses_model.php */

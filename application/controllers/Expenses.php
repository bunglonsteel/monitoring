<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        check_login();
        check_user_acces();
        $this->load->model('Employee_model');
        $this->load->model('Settings_model');
        $this->load->model('Expenses_model', 'expenses');
    }
    

    public function index()
    {
        $this->load->model('Cuti_model');
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings']      = $this->Settings_model->get_settings();

        if ($this->input->is_ajax_request()) {
            $results = $this->expenses->result_data("expenses");
            $data = [];
            foreach ($results as $key => $res) {
                $row = [];
                $row[] = $key + 1 . '.';
                $row[] = $res->name;
                $row[] = date('d M Y', strtotime($res->date));
                $row[] = "Rp. " . htmlspecialchars(number_format($res->amount, 0, ',', '.'));
                $row[] = $res->note;
                $row[] = '<div class="d-flex gap-2">
                            <button class="btn btn-sm btn-soft-dark flush-soft-hover edit" type="button" data-id="' . $res->expense_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-document-edit"></i>
                                    <span>Edit</span>
                                </span>
                            </button>
                            <button class="btn btn-sm btn-soft-danger flush-soft-hover delete" type="button" data-id="' . $res->expense_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-trash"></i>
                                    <span>Hapus</span>
                                </span>
                            </button>
                        </div>';
                $data[] = $row;
            }
            $saldo         = (float) $this->Settings_model->get_option('balance')->option_value | 0;
            $expense_month = (float) $this->expenses->sum_filtered()->amount | 0;
            $expense_year  = (float) $this->expenses->sum_filtered('year')->amount | 0;
            $amount_filter = (float) $this->expenses->sum_filtered('filter')->amount | 0;
            $output        = [
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->expenses->count_all_result("expenses"),
                "recordsFiltered" => $this->expenses->count_filtered("expenses"),
                "data"            => $data,
                "balance"         => "Rp. " . number_format($saldo, 0, ',', '.'),
                "expense_month"   => "Rp. " . number_format($expense_month, 0, ',', '.'),
                "expense_year"    => "Rp. " . number_format($expense_year, 0, ',', '.'),
                "amount_filter"   => "Rp. " . number_format($amount_filter, 0, ',', '.'),
                "csrf_hash"       => $this->security->get_csrf_hash()
            ];
            return $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
        $data['title']   = 'Pengeluaran';
        $data['slug']    = 'Pengeluaran';
        $data['judul']   = 'Pengeluaran';
        render_template('expenses/expenses', $data);
    }

    public function expenses_category() {
        $this->load->model('Cuti_model');
        $data['count_pending'] = $this->Cuti_model->get_count_cuti_pending();
        $data['settings']      = $this->Settings_model->get_settings();

        if ($this->input->is_ajax_request()) {
            $results = $this->expenses->result_data("expense_categories");
            $data = [];
            foreach ($results as $key => $res) {
                $row = [];
                $row[] = $key + 1 . '.';
                $row[] = $res->name;
                $row[] = $res->description;
                $row[] = '<div class="d-flex gap-2">
                            <button class="btn btn-sm btn-soft-dark flush-soft-hover edit" type="button" data-id="' . $res->expense_categories_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-document-edit"></i>
                                    <span>Edit</span>
                                </span>
                            </button>
                            <button class="btn btn-sm btn-soft-danger flush-soft-hover delete" type="button" data-id="' . $res->expense_categories_id . '">
                                <span class="icon fs-8">
                                    <i class="icon dripicons-trash"></i>
                                    <span>Hapus</span>
                                </span>
                            </button>
                        </div>';
                $data[] = $row;
            }
            $output = [
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->expenses->count_all_result("expense_categories"),
                "recordsFiltered" => $this->expenses->count_filtered("expense_categories"),
                "data"            => $data,
                "csrf_hash"       => $this->security->get_csrf_hash()
            ];
            return $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }

        $data['title'] = 'Kategori Pengeluaran';
        $data['slug']  = 'Kategori Pengeluaran';
        $data['judul'] = 'Kategori Pengeluaran';
        render_template('expenses/expenses-category', $data);
    }

    public function action($action)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $this->_rules();
            $request = [
                'target'  => $this->input->post('target', TRUE),
                'expense' => $this->input->post('expense_categories', TRUE),
                'amount'  => $this->input->post('amount', TRUE),
                'date'    => $this->input->post('date', TRUE),
                'note'    => $this->input->post('note', TRUE)
            ];

            if ($action == "add") {
                $this->form_validation->set_rules(
                    'amount',
                    'Jumlah Pengeluaran',
                    'trim|required|numeric|min_length[4]',
                    ['required' => '%s tidak boleh kosong.', 'min_length' => '%s tidak boleh lebih kecil dari Rp. 1.000.']
                );
                $output = $this->_add($request);
            } else {
                $output = $this->_update($request);
            }

            echo json_encode($output);
        }
    }

    public function action_cat($action)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $this->form_validation->set_rules(
                'category',
                'Nama Kategori',
                'trim|required',
                ['required' => '%s tidak boleh kosong.']
            );
            $request = [
                'target'      => $this->input->post('target', TRUE),
                'category'    => $this->input->post('category', TRUE),
                'description' => $this->input->post('description', TRUE),
            ];

            if ($action == "add") {
                $output = $this->_add_cat($request);
            } else {
                $output = $this->_update_cat($request);
            }

            echo json_encode($output);
        }
    }

    private function _rules()
    {
        $this->form_validation->set_rules(
            'expense_categories',
            'Pengeluaran',
            'trim|required|numeric',
            ['required' => '%s tidak boleh kosong.']
        );
        $this->form_validation->set_rules(
            'date',
            'Tanggal',
            'trim',
        );
        $this->form_validation->set_rules(
            'note',
            'Catatan',
            'trim'
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
            // $expenses = $this->project->get('expenses', ['expense_id' => $request['target']])->row();
            $expenses = [
                'expense_cat_id' => $request['expense'],
                'date'           => date('Y-m-d'),
                'amount'         => $request['amount'],
                'note'           => $request['note'],
            ];

            $amount = $request['amount'];

            if ($request['date']) {
                $expenses['date'] = date('Y-m-d', strtotime($request['date']));
            }

            $this->expenses->insert('expenses', $expenses);
            $data_set = [
                "key" => "option_value",
                "set" => "option_value - $amount",
            ];
            $this->expenses->update_set('options', $data_set, ['option_type' => 'balance']);
            $output = [
                'success'   => true,
                'message'   => 'Pengeluaran berhasil ditambahkan, terimakasih.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ];
        }

        return $output;
    }

    private function _add_cat($request)
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
            $category = [
                'name'        => $request['category'],
                'description' => $request['description'],
            ];
            $this->expenses->insert('expense_categories', $category);
            $output = [
                'success'   => true,
                'message'   => 'Kategori pengeluaran berhasil ditambahkan, terimakasih.',
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
            $expense  = $this->expenses->get('expenses', ['expense_id' => $request['target']])->row();
            if (!$expense) {
                $output = [
                    'error'     => true,
                    'message'   => 'Data tidak ditemukan.',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $expenses = [
                    'expense_cat_id' => $request['expense'],
                    'date'           => date('Y-m-d', strtotime($request['date'])),
                    'note'           => $request['note'],
                ];

                $this->expenses->update('expenses', $expenses, ['expense_id' => $expense->expense_id]);
                $output = [
                    'success'   => true,
                    'message'   => 'Pengeluaran berhasil diperbarui, terimakasih.',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
        }

        return $output;
    }

    private function _update_cat($request)
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
            $expense_cat  = $this->expenses->get('expense_categories', ['expense_categories_id' => $request['target']])->row();
            if (!$expense_cat) {
                $output = [
                    'error'     => true,
                    'message'   => 'Data tidak ditemukan.',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $expense_categories = [
                    'name'        => $request['category'],
                    'description' => $request['description'],
                ];

                $this->expenses->update('expense_categories', $expense_categories, ['expense_categories_id' => $expense_cat->expense_categories_id]);
                $output = [
                    'success'   => true,
                    'message'   => 'Kategori Pengeluaran berhasil diperbarui, terimakasih.',
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

            if ($type == "expenses") {
                $expense = $this->expenses->get('expenses', ['expense_id' => $id])->row();
                if (!$expense) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    
                    $result = $this->expenses->delete('expenses', ['expense_id' => $id]);;
                    if (!$result) {
                        $output = [
                            'error'     => 'true',
                            'message'   => 'Ada kesalahan pada saat menghapus.',
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    } else {
                        $data_set = [
                            "key" => "option_value",
                            "set" => "option_value + $expense->amount",
                        ];
                        $this->expenses->update_set('options', $data_set, ['option_type' => 'balance']);
                        $output = [
                            'success'   => 'true',
                            'message'   => "Pengeluaran berhasil dihapus.",
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    }
                }
            } else if($type == "expense_categories"){
                $result = $this->expenses->get('expense_categories', ['expense_categories_id' => $id])->row();
                if (!$result) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $check_expense = $this->expenses->get('expenses', ['expense_cat_id' => $id])->row();
                    if ($check_expense) {
                        $output = [
                            'error'     => 'true',
                            'message'   => 'Kategori ini tidak bisa dihapus karena ada pengeluaran yang memakai kategori ini.',
                            'csrf_hash' => $this->security->get_csrf_hash(),
                        ];
                    } else {
                        $result = $this->expenses->delete('expense_categories', ['expense_categories_id' => $id]);
                        if (!$result) {
                            $output = [
                                'error'     => 'true',
                                'message'   => 'Ada kesalahan pada saat menghapus.',
                                'csrf_hash' => $this->security->get_csrf_hash(),
                            ];
                        } else {
                            $output = [
                                'success'   => 'true',
                                'message'   => "Kategori pengeluaran berhasil dihapus.",
                                'csrf_hash' => $this->security->get_csrf_hash(),
                            ];
                        }
                        
                    }
                }
            }
            echo json_encode($output);
        }
    }

    public function add_saldo()
    {
        $this->form_validation->set_rules(
            'amount',
            'Jumlah Pengeluaran',
            'trim|required|numeric|min_length[4]',
            ['required' => '%s tidak boleh kosong.','min_length' => '%s tidak boleh lebih kecil dari Rp. 1.000.']
        );

        $amount =  $this->input->post('amount', TRUE);

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

            $data_set = [
                "key" => "option_value",
                "set" => "option_value + $amount",
            ];

            $this->expenses->update_set('options', $data_set, ['option_type' => 'balance']);
            $output = [
                'success'   => true,
                'message'   => 'Uang KAS berhasil ditambahkan, terimakasih.',
                'csrf_hash' => $this->security->get_csrf_hash(),
            ];
        }
        echo json_encode($output);
    }

    public function select_expense_cateogories(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $results = $this->expenses->select_expense_cateogories();
            if (!$results) {
                $output = [
                    'error'     => 'true',
                    'message'   => 'Data tidak ditemukan',
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            } else {
                $output = [
                    'success'   => 'true',
                    'data'      => $results,
                    'csrf_hash' => $this->security->get_csrf_hash(),
                ];
            }
            echo json_encode($output);
        }
    }

    public function get(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        } else {
            $id      = $this->input->post('id', TRUE);
            $type    = $this->input->post('type', TRUE);

            if ($type == "expenses") {
                $results = $this->expenses->get('expenses', ['expense_id' => $id])->row();
                if (!$results) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $output = [
                        'success'   => 'true',
                        'data'      => $results,
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                }
            } else if ($type == "expense_categories"){
                $results = $this->expenses->get('expense_categories', ['expense_categories_id' => $id])->row();
                if (!$results) {
                    $output = [
                        'error'     => 'true',
                        'message'   => 'Data tidak ditemukan',
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                } else {
                    $output = [
                        'success'   => 'true',
                        'data'      => $results,
                        'csrf_hash' => $this->security->get_csrf_hash(),
                    ];
                }
            }
            echo json_encode($output);
        }
    }

}

/* End of file Expenses.php */

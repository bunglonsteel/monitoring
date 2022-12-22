<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Settings_model');
		$this->load->library('form_validation');
		
	}
	
	public function index()
	{
		$data['settings'] = $this->Settings_model->get_settings();
		$data['title'] = 'Dashboard';
		
		if ($this->session->userdata('email')) {
			redirect('dashboard');
		}

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		
		if ($this->form_validation->run() == false) {
			
			$this->load->view('auth/login', $data);

		} else {
			$email = strip_tags(html_escape($this->input->post('email', TRUE)));
			$password = strip_tags(html_escape($this->input->post('password', TRUE)));
			$user = $this->db->get_where('users', ['email' => $email])->row_array();

			if ($user) {
				if ($user['is_active'] == 1) {
					if (password_verify($password, $user['password'])) {
						$data = [
							'email' => $user['email'],
							'role_id' => $user['role_id'],
							'employee_id' => $user['employee_id'],
						];
						$this->session->set_userdata($data);
						redirect('dashboard');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger alert-wth-icon alert-dismissible fade show fs-7" role="alert">
						<span class="alert-icon-wrap fs-5"><i class="zmdi zmdi-block" style="margin-top: 2px;"></i></span> Password salah.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>');
						redirect('auth');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-warning alert-wth-icon alert-dismissible show fade fs-7" role="alert">
						<span class="alert-icon-wrap fs-5"><i class="zmdi zmdi-block" style="margin-top: 2px;"></i></span> Akun anda dinonaktifkan!.
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					');
					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-wth-icon alert-dismissible show fade fs-7" role="alert">
					<span class="alert-icon-wrap fs-5"><i class="zmdi zmdi-block" style="margin-top: 2px;"></i></span> Alamat email tidak ada.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				');
				redirect('auth');
			}
		}
	}

	public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('employee_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success fs-7" role="alert">You have been logged out!</div>');
        redirect('auth');
    }

	public function blocked()
    {
        $this->load->view('blocked');
    }

}

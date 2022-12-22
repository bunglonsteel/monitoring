<?php

if (!function_exists('render_template')) {

	function render_template($view, $data = array()) {

		$ci = &get_instance();
		$ci->load->view('layout/header', $data);
		$ci->load->view('layout/topbar', $data);
		$ci->load->view('layout/sidebar', $data);
		$ci->load->view($view, $data);
		$ci->load->view('layout/footer', $data);
		return true;
	}
}
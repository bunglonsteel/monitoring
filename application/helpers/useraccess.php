<?php

if (!function_exists('check_login')) {

	function check_login() {

        $ci=  &get_instance();
        if (!$ci->session->userdata('email')) {
            redirect('auth');
        }
	}
    
    function check_acces(){
        $ci=  &get_instance();
        if($ci->session->userdata('role_id') != 1){
            redirect('blocked');
        }
    }

    function check_user_acces(){
        $ci=  &get_instance();
        if($ci->session->userdata('role_id') != 2){
            redirect('blocked');
        }
    }

}
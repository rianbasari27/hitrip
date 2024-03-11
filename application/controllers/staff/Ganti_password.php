<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ganti_password extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
    }

    public function index() {
        $this->load->view('staff/ganti_pass_view');
    }

    public function proses() {
        $this->form_validation->set_rules('pass_lama', 'Password Lama', 'required|min_length[8]');
        $this->form_validation->set_rules('pass_baru', 'Password Baru', 'required|min_length[8]');
        $this->form_validation->set_rules('pass_konf', 'Konfirmasi Password Baru', 'required|matches[pass_baru]|min_length[8]');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/ganti_password');
        }
        
        $this->load->model('staff');
        //set new password
        $this->staff->changePassword($_SESSION['id_staff'], $_POST['pass_lama'], $_POST['pass_baru']);
        redirect(base_url() . 'staff/ganti_password');
    }

}

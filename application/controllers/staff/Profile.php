<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
    }

    public function index() {
        $this->load->view('staff/profile_view');
    }

    public function ganti_pic() {
        $this->load->model('staff');
        $this->staff->changePic($_SESSION['id_staff'], $_FILES['file']);
        $this->login_lib->refreshSession();
        redirect(base_url() . 'staff/profile');
    }

    public function ubah_profile() {
        $this->load->view('staff/ubah_profile_view');
    }

    public function proses_profile() {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/profile/ubah_profile');
        }

        $this->load->model('staff');
        //set new profile
        $this->staff->changeProfile($_SESSION['id_staff'], $_POST['nama'], $_POST['email']);
        $this->login_lib->refreshSession();
        redirect(base_url() . 'staff/profile/ubah_profile');
    }

}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        $this->load->view('jamaah/login_view');
    }
    public function login_process()
    {
        $this->form_validation->set_rules('ktp_no', 'Nomor KTP', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'login');
        }
        $this->load->model('customer');
        if ($this->customer->setSession($_POST['ktp_no'])) {
            redirect(base_url() . 'home');
        } else {
            redirect(base_url() . 'login');
        }
    }

    public function login_jamaah()
    {
        $noktp =   $this->input->get('ktp_no');

        $this->load->model('customer');
        if ($this->customer->setSession($noktp)) {
            redirect(base_url() . 'home');
        } else {
            redirect(base_url() . 'login');
        }
    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}

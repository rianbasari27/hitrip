<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function index()
    {
        $this->load->view('jamaahv2/login_view');
    }
    public function proses()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Ups...', validation_errors('<li>', '</li>'));
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('customer');
        $result = $this->customer->verifyLoginUser($_POST['username'], $_POST['password']);
        if ($result['type'] == 'green') {
            $this->alert->setJamaah($result['type'], $result['title'], $result['message']);
            redirect(base_url() . 'jamaah/home');
        } else {
            $this->alert->setJamaah($result['type'], $result['title'], $result['message']);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function sign_up() {
        $this->load->view('jamaahv2/sign_up_view');
    }

    public function proses_sign_up() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|trim|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Mohon Maaf', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('customer');
        $this->load->model('registrasi');
        // check username
        $user = $this->registrasi->getUser(null, $_POST['username']);
        if (!empty($user)) {
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Username sudah digunakan !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $result = $this->customer->registerUser($_POST['username'], $_POST['name'], $_POST['email'], $_POST['password']);
        if ($result) {
            $this->alert->setJamaah('green', 'Selamat', 'Registrasi anda berhasil :)');
            redirect(base_url() . 'jamaah/login');
        } else {
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Anda gagal registrasi');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
        
    /* End of file  jamaah/Masuk.php */
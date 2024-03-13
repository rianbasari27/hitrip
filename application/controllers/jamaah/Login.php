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

    public function proses_otp() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'No. Telp', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|trim|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Mohon Maaf', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('registrasi');
        // check username
        $user = $this->registrasi->getUser(null, $_POST['username']);
        if (!empty($user)) {
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Username sudah digunakan !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // check Email
        $user = $this->registrasi->getUser(null, $_POST['Email']);
        if (!empty($user)) {
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Email anda sudah digunakan !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('otp_model');
        $otp = $this->otp_model->send($_POST['no_telp']);
        if (!$otp) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Silahkan masukkan Nomor Kembali');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->session->set_flashdata('data', $_POST);
        redirect(base_url() . 'jamaah/login/otp');
    }

    public function otp() {
        $this->load->view("jamaahv2/otp_verifikasi", $_SESSION['data']);
    }

    public function proses_sign_up() {
        $_POST['otp'] = implode('', array($_POST['otp1'],$_POST['otp2'],$_POST['otp3'],$_POST['otp4'],$_POST['otp5'],$_POST['otp6'],));
        $this->load->model('otp_model');
        $otp = $this->otp_model->verifikasiOtp($_POST['otp'], $_POST['no_telp']);
        if ($otp['color'] == 'red') {
            $this->session->set_flashdata(['data' => $_POST]);
            $this->alert->setJamaah($otp['color'], $otp['title'], $otp['message']);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('customer');
        $result = $this->customer->registerUser($_POST['username'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['no_wa']);
        if ($result) {
            $this->alert->setJamaah('green', 'Selamat', 'Registrasi anda berhasil :)');
            redirect(base_url() . 'jamaah/login');
        } else {
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Anda gagal registrasi');
            redirect(base_url() . 'jamaah/login/sign_up');
        }
    }

    public function resendCode() {
        $this->load->model('otp_model');
        $this->otp_model->send($_GET['no']);

        echo json_decode('success');
    }

    public function forgot() {
        $this->load->view('jamaahv2/forgot_password');
    }

    public function proses_verif_email() {
        $this->load->model('customer');
        $result = $this->customer->sendMail($_POST['email']);
        if (!$result) {
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Email tidak terdaftar pada sistem');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->setJamaah('green', 'Selamat', 'Silahkan cek email untuk melanjutkan reset password');
        redirect(base_url() . 'jamaah/login');

    }

    public function reset_password() {
        $this->load->view('jamaahv2/reset_password', $data = ["email" => $_GET['mail']]);
    }

    public function proses_reset_pass() {
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|trim|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Mohon Maaf', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('customer');
        if (!$this->customer->resetPassword($_POST['email'], $_POST['password'])) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->setJamaah('red', 'Mohon Maaf', 'Proses Reset Password gagal !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->setJamaah('green', 'Selamat', 'Reset password berhasil');
        redirect(base_url() . 'jamaah/login');
    }
}
        
    /* End of file  jamaah/Masuk.php */
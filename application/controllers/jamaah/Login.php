<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function index()
    {
        $this->form_validation->set_rules('username', 'username', 'required|trim');
        $this->form_validation->set_rules('password', 'password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // $this->session->set_flashdata(['form' => $_POST]);
            // $this->alert->setJamaah('red', 'Ups...', validation_errors('<li>', '</li>'));
            // redirect($_SERVER['HTTP_REFERER']);
            $this->load->view('jamaah/login_view');
        } else {
            $this->proses();
        }
    }
    public function proses()
    {
        // $this->form_validation->set_rules('username', 'Username', 'required|trim');
        // $this->form_validation->set_rules('password', 'Password', 'required|trim');

        // if ($this->form_validation->run() == FALSE) {
        //     $this->session->set_flashdata(['form' => $_POST]);
        //     $this->alert->setJamaah('red', 'Ups...', validation_errors('<li>', '</li>'));
        //     redirect($_SERVER['HTTP_REFERER']);
        // }

        $this->load->model('customer');
        $result = $this->customer->verifyLoginUser($_POST['username'], $_POST['password']);
        if ($result['type'] == 'green') {
            $this->alert->toastAlert($result['type'], $result['message']);
            redirect(base_url() . 'jamaah/home');
        } else {
            $this->alert->toastAlert($result['type'], $result['message']);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function sign_up() {
        $this->form_validation->set_rules('username', 'username', 'required|trim');
        $this->form_validation->set_rules('name', 'fullname', 'required|trim');
        $this->form_validation->set_rules('no_wa', 'nomor telepon', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim');
        $this->form_validation->set_rules('password', 'password', 'required|trim');
        $this->form_validation->set_rules('confirmPassword', 'confirm password', 'required|trim|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('jamaah/sign_up_view');
        } else {
            $this->proses_otp();
        }

    }

    public function proses_otp() {
        // $this->form_validation->set_rules('username', 'Username', 'required|trim');
        // $this->form_validation->set_rules('name', 'Name', 'required|trim');
        // $this->form_validation->set_rules('no_telp', 'No. Telp', 'required|trim');
        // $this->form_validation->set_rules('email', 'Email', 'required|trim');
        // $this->form_validation->set_rules('password', 'Password', 'required|trim');
        // $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|trim|matches[password]');
        // if ($this->form_validation->run() == FALSE) {
        //     $this->session->set_flashdata(['form' => $_POST]);
        //     $this->alert->setJamaah('red', 'Mohon Maaf', validation_errors());
        //     redirect($_SERVER['HTTP_REFERER']);
        // }

        $this->load->model('registrasi');
        // check username
        $user = $this->registrasi->getUser(null, $_POST['username']);
        if (!empty($user)) {
            $this->alert->toastAlert('red', 'Username sudah digunakan !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // check Email
        $user = $this->registrasi->getUser(null, null, $_POST['email']);
        if (!empty($user)) {
            $this->alert->toastAlert('red', 'Email anda sudah digunakan !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('otp_model');
        $otp = $this->otp_model->send($_POST['no_wa']);
        if (!$otp) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->toastAlert('red', 'Silahkan masukkan Nomor Kembali');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->session->set_flashdata('data', $_POST);
        redirect(base_url() . 'jamaah/login/otp');
    }

    public function otp() {
        $this->load->view("jamaah/otp_verifikasi", $_SESSION['data']);
    }

    public function proses_sign_up() {
        $_POST['otp'] = implode('', array($_POST['otp1'],$_POST['otp2'],$_POST['otp3'],$_POST['otp4'],$_POST['otp5'],$_POST['otp6'],));
        $this->load->model('otp_model');
        $otp = $this->otp_model->verifikasiOtp($_POST['otp'], $_POST['no_wa']);
        if ($otp['color'] == 'red') {
            $this->session->set_flashdata(['data' => $_POST]);
            $this->alert->toastAlert($otp['color'], $otp['message']);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('customer');
        $result = $this->customer->registerUser($_POST['username'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['no_wa']);
        if ($result) {
            $this->alert->toastAlert('green', 'Registrasi anda berhasil :)');
            redirect(base_url() . 'jamaah/login');
        } else {
            $this->alert->toastAlert('red', 'Anda gagal registrasi');
            redirect(base_url() . 'jamaah/login/sign_up');
        }
    }

    public function resendCode() {
        $this->load->model('otp_model');
        $this->otp_model->send($_GET['no']);

        echo json_decode('success');
    }

    public function forgot() {
        $this->form_validation->set_rules('email', 'Email', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('jamaah/forgot_password');
        } else {
            $this->proses_verif_email();
        }
        // $this->load->view('jamaah/forgot_password');
    }

    public function proses_verif_email() {
        $this->load->model('customer');
        $result = $this->customer->sendEmail($_POST['email']);
        if (!$result) {
            // $this->alert->setJamaah('red', 'Mohon Maaf', 'Email tidak terdaftar pada sistem');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->setJamaah('green', 'Selamat', 'Silahkan cek email untuk melanjutkan reset password');
        redirect(base_url() . 'jamaah/login');

    }

    public function reset_password() {
        $this->load->view('jamaah/reset_password', $data = ["email" => $_GET['mail']]);
    }

    public function proses_reset_pass() {
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|trim|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->toastAlert('red', 'Mohon Maaf', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->model('customer');
        if (!$this->customer->resetPassword($_POST['email'], $_POST['password'])) {
            $this->session->set_flashdata(['form' => $_POST]);
            $this->alert->toastAlert('red', 'Mohon Maaf', 'Proses Reset Password gagal !');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->alert->toastAlert('green', 'Selamat', 'Reset password berhasil');
        redirect(base_url() . 'jamaah/login');
    }
}
        
    /* End of file  jamaah/Masuk.php */
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{    
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            $this->alert->setJamaah('yellow', 'asdasd', 'Anda harus login terlebih dahulu');
            redirect(base_url() . 'jamaah/login');
        }
    }
    
    public function index()
    {
        //cek apakah sudah pernah menampilkan splash
        if (!$this->customer->isSplashSeen()) {
            redirect(base_url() . "jamaah/splash");
        }
        $this->load->model('registrasi');
        $data = $this->registrasi->getUser($_SESSION['id_user']);
        $this->load->view('jamaah/profile_view', $data);
    }

    public function edit_profile() {
        $this->load->model('registrasi');
        $data = $this->registrasi->getUser($_SESSION['id_user']);

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('name', 'fullname', 'required|trim');
        $this->form_validation->set_rules('no_wa', 'nomor telepon', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('jamaah/edit_profile_view', $data);
        } else {
            $this->proses_edit_profile();
        }
    }

    public function proses_edit_profile() {
        
        $this->load->model('registrasi');
        if (!$this->registrasi->daftar($_POST, null, true)) {
            $this->alert->setJamaah('red', 'Error', 'Gagal menyimpan');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->alert->setJamaah('green', 'Sukses', 'Berhasil menyimpan');
            redirect(base_url('jamaah/profile'));
        }
        
    }
    // public function main_menu()
    // {        
    //     $this->load->view('jamaahv2/include/menu-main');
    // }
    // public function colors()
    // {        
    //     $this->load->view('jamaahv2/include/menu-colors');
    // }
    // public function share()
    // {        
    //     $this->load->view('jamaahv2/include/menu-share');
    // }
}
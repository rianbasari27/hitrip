<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        // if (!$this->customer->is_user_logged_in()) {
        //     $this->alert->setJamaah('yellow', 'asdasd', 'Anda harus login terlebih dahulu');
        //     redirect(base_url() . 'jamaah/home');
        // }
    }
    
    public function index()
    {
        //cek apakah sudah pernah menampilkan splash
        if (!$this->customer->isSplashSeen()) {
            redirect(base_url() . "jamaah/splash");
        }
        $this->load->view('jamaah/dash_mobile');
    }

    public function konversi()
    {
        $this->load->view('jamaah/konversi');
    }

    public function promo() {
        $this->load->view('jamaah/detail_promo');
    }
}
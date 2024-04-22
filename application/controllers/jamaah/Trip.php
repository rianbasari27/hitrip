<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Trip extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        // if (!$this->customer->is_user_logged_in()) {
        //     $this->alert->toastAlert('red', 'Anda perlu login!');
        //     redirect(base_url() . 'jamaah/home');
        // }
    }
    
    public function index()
    {
        //cek apakah sudah pernah menampilkan splash
        if (!$this->customer->isSplashSeen()) {
            redirect(base_url() . "jamaah/splash");
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage();
        $data = [
            'paket' => $paket
        ];
        // echo '<pre>';
        // print_r($paket);
        // exit();
        $this->load->view('jamaah/trip_list_view', $data);
    }
}

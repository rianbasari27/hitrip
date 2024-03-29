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
        // $this->load->model('konsultanAuth');
        // if ($this->konsultanAuth->is_user_logged_in()) {
        //     redirect(base_url() . 'konsultan/home');
        // }
    }
    
    public function index()
    {
        //cek apakah sudah pernah menampilkan splash
        if (!$this->customer->isSplashSeen()) {
            redirect(base_url() . "jamaah/splash");
        }
        $this->load->view('jamaah/profile_view');
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
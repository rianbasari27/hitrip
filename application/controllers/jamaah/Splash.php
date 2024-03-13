<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Splash extends CI_Controller
{

    public function index()
    {
        $this->load->view('jamaah/splash_view');
    }
    public function end()
    {
        // JIKA SUDAH MELIHAT SPLASH MAKA SET COOKIE SPLASH_SEEN (KALAU MAU LIHAT SPLASH LAGI CLEAR BROWSER DATA DULU)
        $this->load->model('customer');
        $this->customer->setSplashSeen();
        $this->load->view('jamaah/launcher');
    }
}
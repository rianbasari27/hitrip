<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Discover extends CI_Controller
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

    public function index() {
        $this->load->model('paketUmroh');
        $area = $this->paketUmroh->getAreaTrip();
        $data = [
            'area' => $area,
        ];
        $this->load->view('jamaah/list_area', $data);
    }

    public function list_area() {
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage(null, true, true, false, null, true, null, $_GET['area']);
        $data = [
            'paket' => $paket,
        ];
        $this->load->view('jamaah/list_area_paket', $data);
    }
}
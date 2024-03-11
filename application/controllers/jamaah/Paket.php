<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Paket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home');
        }
        $id_member = $_SESSION['id_member'];

        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];

        $this->load->model('jamaahDashboard');
        $status = $this->jamaahDashboard->getStatus($member);
        if ($status['DPStatus'] == true) {
            redirect(base_url() . 'jamaah/daftar/dp_notice');
        }
    }
    public function index()
    {   
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($_SESSION['paket']['id_paket']);
        if (!$paket) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect(base_url() . 'jamaah/home');
        }
        $this->load->view('jamaahv2/paket_view', $paket);
    }
}
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            $this->alert->toastAlert('red', 'Anda perlu login!');
            redirect(base_url() . 'jamaah/home');
        }
    }
    
    public function index()
    {
        //cek apakah sudah pernah menampilkan splash
        if (!$this->customer->isSplashSeen()) {
            redirect(base_url() . "jamaah/splash");
        }
        $this->load->model('paketUmroh');
        $this->load->model('registrasi');
        $user = $this->registrasi->getUser($_SESSION['id_user']);
        $this->load->view('jamaah/order_view', $user);
    }

    public function paket_aktif() {
        $this->load->model('paketUmroh');
        $this->load->model('registrasi');
        $this->load->model('tarif');
        $member = $this->registrasi->getMember($_GET['idm']);
        // $member = $member[0];
        if (!isset($_GET['id']) || !isset($_GET['idm'])) {
            $this->alert->toastAlert('red', 'Access Denied');
            redirect(base_url() . 'jamaah/home');
        }
        if ($member == null) {
            $this->alert->toastAlert('red', 'Anda tidak terdaftar');
            redirect(base_url() . 'jamaah/home');
        }
        $memberAktif = null;
        foreach ($member as $m) {
            if ($m->id_paket == $_GET['id']) {
                if ($m->lunas == 0) {
                    redirect(base_url() . 'jamaah/daftar/dp_notice');
                }
                $memberAktif = $m;
            }
            // if ($m->lunas == 0) {
            //     $this->alert->toastAlert('red', 'Anda belum melakukan pembayaran');
            //     redirect(base_url() . 'jamaah/order');
            // }
        }
        // echo '<pre>';
        // print_r($memberAktif);
        // exit();
        $paket = $this->paketUmroh->getPackage($_GET['id']);

        $data = [
            'paket' => $paket,
            'member' => $memberAktif,
        ];
        $this->load->view('jamaah/paket_aktif_view', $data);
    }
}
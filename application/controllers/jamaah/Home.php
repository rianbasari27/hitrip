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
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage();
        $paket_terbaru = [];
        if ($paket != null) {
            foreach ($paket as $key => $p) {
            // for ($i = 0; $i < 3; $i++) {
                $paket_terbaru[] = $p;
                // break;
                if ($key == 2) {
                    break;
                }
            }
        }

        $promo = $this->paketUmroh->getDiskonEventPaket();

        $data = [
            'paket' => $paket,
            'paket_terbaru' => $paket_terbaru,
            'promo' => $promo
        ];
        $this->load->view('jamaah/dash_mobile', $data);
    }

    public function konversi()
    {
        $this->load->view('jamaah/konversi');
    }

    public function promo() {
        $this->load->model('paketUmroh');
        $promo = $this->paketUmroh->getDiskonEventPaket($_GET['id']);
        if (!$promo) {
            $this->alert->toastAlert('red', 'Maaf Akses anda ditolak!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->load->view('jamaah/detail_promo', $data = array ( 'promo' => $promo[0] ));
    }
}
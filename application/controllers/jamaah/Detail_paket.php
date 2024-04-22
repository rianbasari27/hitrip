<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Detail_paket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        // if ($this->customer->is_user_logged_in()) {
        //     redirect(base_url() . 'jamaah/home');
        // }
    }

    public function index()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->toastAlert('red', 'Paket tidak ditemukan');
            redirect(base_url() . 'jamaah/home');
        }
        $this->load->model('paketUmroh');
        $this->load->model('registrasi');
        // check if user already registered
        if (isset($_SESSION['id_member'])) {
            $member = $this->registrasi->getMember($_SESSION['id_member']);
            foreach ($member as $m) {
                if ($m->id_paket == $_GET['id']) {
                    redirect(base_url() . 'jamaah/daftar/dp_notice');
                }
            }
        }
        
        $paket = $this->paketUmroh->getPackage($_GET['id']);
        if (!$paket) {
            $this->alert->toastAlert('red', 'Paket tidak ditemukan');
            redirect(base_url() . 'jamaah/home');
        }
        $this->load->view('jamaah/detail_paket_view', $paket);
    }
}
        
    /* End of file  jamaah/Detail_paket.php */
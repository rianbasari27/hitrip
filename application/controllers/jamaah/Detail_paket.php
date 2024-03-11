<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Detail_paket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if ($this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home_user');
        }
    }

    public function index()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect(base_url() . 'jamaah/home');
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($_GET['id']);
        if (!$paket) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect(base_url() . 'jamaah/home');
        }

        // cek id agen
        if (isset($_GET['idg'])) {
            $paket->id_agen = $_GET['idg'];
        } else {
            $paket->id_agen = null;
        }
        $this->load->view('jamaahv2/detail_paket_view', $paket);
    }
}
        
    /* End of file  jamaah/Detail_paket.php */
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Detail_paket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('agen');
        // $agen = $this->agen->getAgen($_GET['idg']);
        // $id_agen = $agen[0]->id_agen ;
        if (!isset($_SESSION['id_agen'])) {
            redirect(base_url() . "jamaah/detail_paket?id=$_GET[id]&idg=$_GET[idg]") ;
        } else {
            return false ;
        }
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }

    public function index()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($_GET['id']);
        if (!$paket) {
            $this->alert->setJamaah('red', 'Ups...', 'Paket tidak ditemukan');
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->view('konsultan/detail_paket_view', $paket);
    }

}
        
    /* End of file  konsultan/Detail_paket.php */
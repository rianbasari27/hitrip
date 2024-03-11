<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Broadcast extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('login_lib');
        if ($this->login_lib->checkSession() == false) {
            redirect(base_url() . 'staff/login');
        }
        //this page only for admin
        if (!($_SESSION['bagian'] == 'Finance' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Manifest')) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
    }

    public function index() {
        if (!isset($_GET['id'])) {
            $this->alert->set('danger', 'Anda tidak memiliki akses untuk halaman tersebut');
            redirect(base_url() . 'staff/dashboard');
        }
        $this->load->model('paketUmroh');
        $paket = $this->paketUmroh->getPackage($_GET['id'], false);
        if (empty($paket)) {
            $this->alert->set('danger', 'Paket tidak ditemukan');
            redirect(base_url() . 'staff/dashboard');
        }


        $this->load->model('bcast');
        $pesan = $this->bcast->getPesan(null, $_GET['id']);
        $data = array(
            'paket' => $paket,
            'pesan' => $pesan
        );
        $this->load->view('staff/broadcast_view', $data);
    }

    public function proses_tambah() {
        $this->form_validation->set_rules('id_paket', 'id_paket', 'trim|required|numeric');
        $this->form_validation->set_rules('pesan', 'Pesan', 'required|trim');
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('tampilkan', 'Status', 'trim|required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/paket');
        }
        $this->load->model('bcast');
        $_POST['pesan'] = str_replace('`', '<br>', $_POST['pesan']);
        $this->bcast->addPost($_POST);
        // $this->bcast->getPesanForWhatsapp($_POST['id_paket']);
        $this->alert->set('success', 'Pesan berhasil di broadcast');
        
        redirect(base_url() . 'staff/broadcast?id='.$_POST['id_paket']);
    }
    
    public function status(){
        $this->form_validation->set_rules('id_broadcast', 'id_broadcast', 'trim|required|numeric');
        $this->form_validation->set_rules('tampilkan', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('color', 'Warna Background', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/paket');
        }
        $this->load->model('bcast');
        $bc = $this->bcast->getPesan($_POST['id_broadcast']);
        $id_paket = $bc->id_paket;
        $this->bcast->updateTampilkan($_POST['id_broadcast'], $_POST);
        $this->alert->set('success', 'Status berhasil diubah');
        redirect(base_url() . 'staff/broadcast?id='.$id_paket);
    }

    public function manasik() {
        $this->load->model('bcast');
        $this->bcast->getPesanForWhatsapp($_GET['id']);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function hapus() {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', validation_errors());
            redirect(base_url() . 'staff/paket');
        }

        $this->load->model('bcast');
        $id = $this->bcast->getPesan($_GET['id']);
        $bc = $this->bcast->deletePost($_GET['id']);
        $id_paket = $id->id_paket;
        $this->alert->set('success', 'Status berhasil dihapus');
        redirect(base_url() . 'staff/broadcast?id='.$id_paket);
    }

}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Konfirmasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer');
        $this->load->model('registrasi');
        if ($this->customer->checkSession() == false) {
            redirect(base_url() . 'login');
        }
    }

    public function index() {
        $id_member = null;
        if (isset($_GET['id'])) {
            $id_member = $_GET['id'];
        }
        if ($id_member == null) {
            $id_member = $_SESSION['id_member'];
        }
        $auth = $this->customer->checkAuthId($id_member);
        if ($auth == false) {
            redirect(base_url() . 'home');
        }
        $this->load->model('paketUmroh');

        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        $paket = $this->paketUmroh->getPackage($member->id_paket, false);
        $this->load->view('jamaah/bayar', array(
            'member' => $member,
            'jamaah' => $jamaah,
            'paket' => $paket
        ));
    }

    public function proses() {
        $this->form_validation->set_rules('id_member', 'id member', 'trim|required|integer');
        $this->form_validation->set_rules('tanggal_bayar', 'tanggal_bayar', 'required');
        $this->form_validation->set_rules('jumlah_bayar', 'jumlah_bayar', 'trim|required|integer');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->set('danger', 'Access Denied');
            redirect(base_url().'home');
        }

        $data = $_POST;
        $auth = $this->customer->checkAuthId($data['id_member']);
        if ($auth == false) {
            redirect(base_url() . 'home');
        }
        $member = $this->registrasi->getMember($data['id_member']);
        
        $data['id_jamaah'] = $member[0]->id_jamaah;
        $data['cara_pembayaran'] = 'Transfer';
        $data['verified'] = '0';

        if (!empty($_FILES['scan_bayar']['name'])) {
            $data['files']['scan_bayar'] = $_FILES['scan_bayar'];
        }
        $this->load->model('tarif');
        $this->tarif->setPembayaran($data);
        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah);
        $this->load->view('jamaah/bayar_sukses', array(
            'member' => $member[0],
            'jamaah' => $jamaah
        ));
        
    }

}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Broadcast_list extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }

    public function index() {
        $this->load->model('bcast');
        $broadcast = $this->bcast->getPesanAgen(null, $_SESSION['id_agen'], 1);
        $data = [
            'broadcast' => $broadcast
        ];
        $this->load->view('konsultan/broadcast_list_view', $data);
    }

    public function single_broadcast() {
        $id = $_GET['id'];
        if ($id == null) {
            $this->alert->setJamaah('red', 'Oops...', 'Pengumuman tidak ditemukan.');
            redirect(base_url() . 'konsultan/broadcast_list');
        }
        $this->load->model('bcast');
        $broadcast = $this->bcast->getPesanAgen($id, $_SESSION['id_agen'], 1);
        $bc1 = explode("|", $broadcast[0]->link1);
        $bc2 = explode("|", $broadcast[0]->link2);
        $bc3 = explode("|", $broadcast[0]->link3);
        $broadcast[0]->nama_link1 = isset($bc1[0]) ? $bc1[0] : null;
        $broadcast[0]->nama_link2 = isset($bc2[0]) ? $bc2[0] : null;
        $broadcast[0]->nama_link3 = isset($bc3[0]) ? $bc3[0] : null;
        $broadcast[0]->link1 = isset($bc1[1]) ? $bc1[1] : null;
        $broadcast[0]->link2 = isset($bc2[1]) ? $bc2[1] : null;
        $broadcast[0]->link3 = isset($bc3[1]) ? $bc3[1] : null;
        $data = [
            'broadcast' => $broadcast
        ];
        $this->load->view('konsultan/single_broadcast_view', $data);
    }
}
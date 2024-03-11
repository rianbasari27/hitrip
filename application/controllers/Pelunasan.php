<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pelunasan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer');
        $this->load->model('registrasi');
        if ($this->customer->checkSession() == false) {
            redirect(base_url() . 'login');
        }
    }
    public function index()
    {
        if (!isset($_GET['id'])) {
            $this->alert->set('danger', 'Forbidden Access');
            redirect(base_url() . 'home');
        }
        $id_member = $_GET['id'];
        $auth = $this->customer->checkAuthId($id_member);
        if ($auth == false) {
            redirect(base_url() . 'home');
        }
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        $status = $this->customer->getStatus($member);



        if ($status['DPStatus'] == true) {
            $this->alert->set('danger', 'Forbidden Access');
            redirect(base_url() . 'home');
        }

        $this->load->model('tarif');
        $data = $this->tarif->getRiwayatBayar($id_member);
        // $bayar = $this->tarif->getPembayaran($id_member,true);
        // $tarif = $this->tarif->calcTariff($id_member);
        $data = array(
            'jamaah' => $jamaah,
            'member' => $member,
            'data' => $data,
            // 'bayar' => $bayar,
            // 'tarif' => $tarif
        );
        // echo '<pre>';
        // print_r($data);
        // echo exit();
        $this->load->view('jamaah/pelunasan_view', $data);
    }
}

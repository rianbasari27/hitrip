<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_program extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('customer');
        $this->load->model('registrasi');
        if ($this->customer->checkSession() == false) {
            redirect(base_url() . 'login');
        }
    }

    public function index() {
        $id_member = $_SESSION['id_member'];
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        $paket = $member->paket_info;
        $data = $paket;
        $data->jamaahData = $jamaah;
        $data->memberData = $member;
        $this->load->view('jamaah/program', $data);
    }
}


<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer');
        $this->load->model('registrasi');
        if ($this->customer->checkSession() == false) {
            redirect(base_url() . 'jamaah/home');
        }
    }

    public function index()
    {

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

        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);

        $status = $this->customer->getStatus($member);
        $this->load->library('calculate');
        $member->paket_info->countdown = $this->calculate->dateDiff($member->paket_info->tanggal_berangkat, date('Y-m-d'));
        $member->paket_info->tanggal_pelunasan = date('d F Y', strtotime($member->paket_info->tanggal_berangkat . ' -45 day'));

        //logistik
        $this->load->model('logistik');
        $logSudahAmbil = $this->logistik->getPerlengkapanSudahAmbil($id_member);
        $logBelumAmbil = $this->logistik->getAmbilList($id_member);

        //get broadcast
        $this->load->model('bcast');
        $broadcast = $this->bcast->getPesan(null, $member->id_paket, 1);

        $data = array(
            'jamaahData' => $jamaah,
            'memberData' => $member,
            'DPStatus' => $status['DPStatus'],
            'dataStatus' => $status['dataStatus'],
            'lunasStatus' => $status['lunasStatus'],
            'displayBroadcast' => $status['displayBroadcast'],
            'logBelumAmbil' => $logBelumAmbil,
            'logSudahAmbil' => $logSudahAmbil['items'],
            'broadcast' => $broadcast
        );
        echo '<pre>';
        print_r($data);
        exit();
        $this->load->view('jamaah/user_view', $data);
    }
}
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Home_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home');
        }
    }

    public function index()
    {

        $id_member = $_SESSION['id_member'];

        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        $this->load->model('jamaahDashboard');
        $status = $this->jamaahDashboard->getStatus($member);
        if ($status['DPStatus'] == true) {
            redirect(base_url() . 'jamaah/daftar/dp_notice');
        }
        $checklistData = $this->jamaahDashboard->getChecklistData($member);
        //logistik
        $this->load->model('logistik');
        $logSudahAmbil = $this->logistik->getPerlengkapanSudahAmbil($id_member);
        $logBelumAmbil = $this->logistik->getAmbilList($id_member);
        $sudahTerjadwal = $this->logistik->getPendingBooking($_SESSION['id_member']);
        $jadwalAmbil = $sudahTerjadwal['dateGroup'];
        $tanggalAmbilPending = '';
        if (!empty($jadwalAmbil)) {
            $tanggalAmbilPending = array_keys($jadwalAmbil)[0];
        }
        $listSiapAmbil = $this->logistik->getPendingBookingStatus($_SESSION['id_member']);
        $jadwalAmbilSiap = $listSiapAmbil['dateGroup'];
        $tanggalAmbilSiap = '';
        if (!empty($jadwalAmbilSiap)) {
            $tanggalAmbilSiap = array_keys($jadwalAmbilSiap)[0];
        }
        //get broadcast
        $this->load->model('bcast');
        $broadcast = $this->bcast->getPesan(null, $member->id_paket, 1);
        $countBc = count($broadcast);
        $tgl_lunas = date('Y-m-d', strtotime($jamaah->member[0]->paket_info->tanggal_pelunasan));
        $jatuh_tempo = $this->calculate->dateDiff($tgl_lunas, date('Y-m-d'));
        $data = array(
            'jamaahData' => $jamaah,
            'memberData' => $member,
            'DPStatus' => $status['DPStatus'],
            'dataStatus' => $status['dataStatus'],
            'lunasStatus' => $status['lunasStatus'],
            'displayBroadcast' => $status['displayBroadcast'],
            'logBelumAmbil' => $logBelumAmbil,
            'logSudahAmbil' => $logSudahAmbil['items'],
            'broadcast' => $broadcast,
            'countBc' => $countBc,
            'checklistData' => $checklistData,
            'jatuhTempo' => $jatuh_tempo,
            'tanggalAmbilPending' => $tanggalAmbilPending,
            'tanggalAmbilSiap' => $tanggalAmbilSiap,
            'listSiapAmbil' => $listSiapAmbil['items']
        );
        $this->load->view('jamaahv2/home_user_view', $data);
    }

    public function single_broadcast() {
        $id = $_GET['id'];
        if ($id == null) {
            $this->alert->setJamaah('red', 'Oops...', 'Pengumuman tidak ditemukan.');
            redirect(base_url() . 'jamaah/home_user');
        }
        $this->load->model('registrasi');
        $this->load->model('bcast');
        $member = $this->registrasi->getMember($_SESSION['id_member']);
        $broadcast = $this->bcast->getPesan($id, $member[0]->id_paket, 1);
        // echo '<pre>';
        // print_r($broadcast);
        // exit();
        
        $data = [
            'broadcast' => $broadcast
        ];
        $this->load->view('jamaahv2/single_broadcast_view', $data);
    }
}
        
    /* End of file  jamaah/home_user.php */
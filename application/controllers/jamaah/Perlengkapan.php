<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Perlengkapan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check if logged in redirect to user page
        $this->load->model('customer');
        if (!$this->customer->is_user_logged_in()) {
            redirect(base_url() . 'jamaah/home');
        }
        $id_member = $_SESSION['id_member'];

        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];

        $this->load->model('jamaahDashboard');
        $status = $this->jamaahDashboard->getStatus($member);
        if ($status['DPStatus'] == true) {
            redirect(base_url() . 'jamaah/daftar/dp_notice');
        }
    }
    public function index()
    {
        $id_member = $_SESSION['id_member'];

        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        if ($member->parent_id != null) {
            $groupMembers = $this->registrasi->getGroupMembers($member->parent_id);
            $statusLengkap = true;
            foreach ($groupMembers as $key => $gm) {
                $tempat_lahir = $groupMembers[$key]->jamaahData->tempat_lahir;
                $tanggal_lahir = $groupMembers[$key]->jamaahData->tanggal_lahir;
                $jenis_kelamin = $groupMembers[$key]->jamaahData->jenis_kelamin;
                $no_wa = $groupMembers[$key]->jamaahData->no_wa;
                if ($jenis_kelamin == null || $tanggal_lahir == null) {
                    $statusLengkap = false;
                }
            }
            if ($statusLengkap == false) {
                $this->alert->setJamaah('red', 'Tidak dapat Ambil Perlengkapan', 'Lengkapi data jamaah terlebih dahulu');
                redirect(base_url() . 'jamaah/daftar/incomplete_data');
            } 
        } else {
            if ($jamaah->jenis_kelamin == null || $jamaah->tanggal_lahir == null) {
                $this->alert->set('red', 'Tidak dapat Ambil Perlengkapan', 'Lengkapi data jamaah terlebih dahulu');
                redirect(base_url() . 'jamaah/daftar/incomplete_data');
            } 
        }
        $this->load->view('jamaahv2/perlengkapan_view');
    }
    public function lihat_ambil()
    {
        $family = $_SESSION['family'];

        $this->load->model('logistik');
        if (empty($family)) {
            $family[$_SESSION['id_member']] = new stdClass();
            $family[$_SESSION['id_member']]->jamaahData = (object)$_SESSION;
        }
        $sudahAmbil = [];
        foreach ($family as $idMember => $fam) {
            $sudahAmbil[] = [
                'infoJamaah' => $fam->jamaahData,
                'items' => $this->logistik->getPerlengkapanSudahAmbil($idMember)
            ];
        }
        $data = [
            'data' => $sudahAmbil
        ];
        $this->load->view('jamaahv2/perlengkapan_sudah_ambil_view', $data, FALSE);
    }
    public function jadwal_ambil()
    {
        $family = $_SESSION['family'];

        $this->load->model('logistik');
        $siapAmbil = [];
        if (empty($family)) {
            $family[$_SESSION['id_member']] = new stdClass();
            $family[$_SESSION['id_member']]->jamaahData = (object)$_SESSION;
        }

        $sudahTerjadwal = $this->logistik->getPendingBooking($_SESSION['id_member']);
        $jadwalAmbil = $sudahTerjadwal['dateGroup'];
        $tanggalAmbil = '';
        $jenisAmbil = '';
        $alamatKirim = '';
        $noKirim = '';
        if (!empty($jadwalAmbil)) {
            $tanggalAmbil = array_keys($jadwalAmbil)[0];
            $jenisAmbil = $jadwalAmbil[$tanggalAmbil][0]->jenis_ambil;
            $alamatKirim = $jadwalAmbil[$tanggalAmbil][0]->alamat_pengiriman;
            $noKirim = $jadwalAmbil[$tanggalAmbil][0]->no_pengiriman;
            if ($jenisAmbil == 'langsung') {
                $jenisAmbil = "Ambil di kantor";
            }
            if ($jenisAmbil == 'pengiriman') {
                $jenisAmbil = "Pengiriman";
            }
        }

        $sudahSiap = $this->logistik->getPendingBookingStatus($_SESSION['id_member']);
        $jadwalSiap = $sudahSiap['dateGroup'];
        $tanggalSiap = '';
        $jenisAmbilSiap = '';
        $alamatKirimSiap = '';
        $noKirimSiap = '';
        if (!empty($jadwalSiap)) {
            $tanggalSiap = array_keys($jadwalSiap)[0];
            $jenisAmbilSiap = $jadwalSiap[$tanggalSiap][0]->jenis_ambil;
            $alamatKirimSiap = $jadwalSiap[$tanggalSiap][0]->alamat_pengiriman;
            $noKirimSiap = $jadwalSiap[$tanggalSiap][0]->no_pengiriman;
            if ($jenisAmbilSiap == 'langsung') {
                $jenisAmbilSiap = "Ambil di kantor";
            }
            if ($jenisAmbilSiap == 'pengiriman') {
                $jenisAmbilSiap = "Pengiriman";
            }
        }
        foreach ($family as $idMember => $fam) {

            $siapAmbil[] = [
                'infoJamaah' => $fam->jamaahData,
                'items' => $this->logistik->getAmbilList($idMember, true)
            ];
        }
        foreach($siapAmbil[0]['items'] as $key => $ambil) {
            $this->db->where('id_logistik', $ambil->id_logistik);
            $this->db->where('id_member', $_SESSION['id_member']);
            $perlMember = $this->db->get('perlengkapan_member')->row();
            if (!empty($perlMember)) {
                if ($perlMember->status =='Siap' || $perlMember->status == "Pending") {
                    unset($siapAmbil[0]['items'][$key]);
                }
            }
        }

        $data = [
            'data' => $siapAmbil,
            'tanggalAmbil' => $tanggalAmbil,
            'tanggalSiap' => $tanggalSiap,
            'jenisAmbil' => $jenisAmbil,
            'alamatKirim' => $alamatKirim,
            'noKirim' => $noKirim,
            'jenisAmbilSiap' => $jenisAmbilSiap,
            'alamatKirimSiap' => $alamatKirimSiap,
            'noKirimSiap' => $noKirimSiap,
        ];
        $this->load->view('jamaahv2/jadwal_ambil_view', $data, FALSE);
    }
    public function proses_jadwal()
    {   
        $this->form_validation->set_rules('date', 'date', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', 'Terjadi kesalahan. Tanggal belum dipilih.');
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        $_POST['tanggal'] = $_POST['date'] . " ". date('H:i:s');

        $idMember = $_SESSION['id_member'];

        $this->load->model('registrasi');
        $dataJamaah = $this->registrasi->getJamaah(null, null, $idMember);
        $dataMember = $dataJamaah->member[0];
        $this->load->model('logistik');
        $familyMember = [];
        if (!empty($dataMember->parent_id)) {
            //get groupMember
            $family = $this->registrasi->getGroupMembers($dataMember->parent_id);

            foreach ($family as $fam) {
                $familyMember[] = $fam->memberData;
            }
        } else {
            $familyMember[] = $dataMember;
        }
        $status = false;
        foreach ($familyMember as $famMember) {
            $items = $this->logistik->getAmbilList($famMember->id_member, true);
            if (empty($items)) {
                continue;
            }
            $itemsPrepared = [];
            foreach ($items as $itm) {
                $itemsPrepared[] = $itm->id_logistik;
            }
            $buatJadwal = $this->logistik->addPerlengkapanPeserta($famMember->id_member, $itemsPrepared, $_POST['tanggal'], 'Pending', $_POST['jenis_ambil'], $_POST['alamat_pengiriman'], $_POST['no_pengiriman']);
            if ($buatJadwal) {
                $status = true;
            }
        }
        if ($status) {
            $this->alert->setJamaah('green', 'Tanggal berhasil dipilih');
        } else {
            $this->alert->setJamaah('red', 'Error. Tanggal gagal dipilih');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function download() {
        $this->load->model('logistik');
        $data = $this->logistik->getRiwayatAmbil($_SESSION['id_member']);
        $paket = $this->paketUmroh->getPackage($data['members'][0]->id_paket, false, false);
        $data['nama_penerima'] = $data['members'][0]->riwayatAmbil['items'][0]->penerima;
        $data['staff'] = $data['members'][0]->riwayatAmbil['items'][0]->staff;
        $this->load->library('date');
        $data['dateNow'] = $this->date->convert_date_indo(date('Y-m-d'));
        $strpos = strpos(strtolower($paket->nama_paket), ' ');
        $firstWord= substr($paket->nama_paket, 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = 'asset/login/images/LOGO-VENTOUR.png';
        if (strtolower($firstWord) == "low" || strtolower($firstWord) == "lcu") {
            $data['jenisPaket'] = true;
            $data['logo'] = 'asset/login/images/LOGO-LCU.png';
        }
        // $data['id'] = $_GET['id'];
        $data['html'] = $this->load->view('staff/kuitansi_perl_view', $data, true);
        $this->load->view('staff/perlengkapan_view', $data);
    }
}
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ambil_perlengkapan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("auth");
        $this->load->library("secret_key");
        $this->load->model('konsultanAuth');
        if (!$this->konsultanAuth->is_user_logged_in()) {
            redirect(base_url() . 'konsultan/login');
        }
    }

    public function index()
    {
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        $check = $this->auth->checkMemberAgen($_SESSION['id_agen'], $id_member);
        if (!$check) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->model('registrasi');
        $member = $this->registrasi->getMember($_GET['id']);
        $jamaah = $this->registrasi->getJamaah($member[0]->id_jamaah);
        $family = $this->registrasi->getGroupMembers($member[0]->parent_id);

        $this->load->model('logistik');
        $siapAmbil = [];
        if (empty($family)) {
            $family[$_GET['id']] = new stdClass();
            $family[$_GET['id']]->jamaahData = (object)$jamaah;
        }

        $sudahTerjadwal = $this->logistik->getPendingBooking($_GET['id']);
        $jadwalAmbil = $sudahTerjadwal['dateGroup'];
        $jenisAmbil = '';
        $alamatKirim = '';
        $noKirim = '';
        $tanggalAmbil = '';
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

        $sudahSiap = $this->logistik->getPendingBookingStatus($_GET['id']);
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
        // echo '<pre>';
        // print_r($siapAmbil);
        // exit();
        // foreach ($siapAmbil[0]['items'] as $key => $ambil) {
        //     $this->db->where('id_logistik', $ambil->id_logistik);
        //     $this->db->where('id_member', $_GET['id']);
        //     $perlMember = $this->db->get('perlengkapan_member')->row();
        //     if (!empty($perlMember)) {
        //         if ($perlMember->status == 'Siap' || $perlMember->status == "Pending") {
        //             unset($siapAmbil[0]['items'][$key]);
        //         }
        //     }
        // }
        $data = [
            'dataAmbil' => $siapAmbil,
            'tanggalAmbil' => $tanggalAmbil,
            'jamaah' => $jamaah,
            'jenisAmbil' => $jenisAmbil,
            'alamatKirim' => $alamatKirim,
            'noKirim' => $noKirim,
            'tanggalSiap' => $tanggalSiap,
            'jenisAmbilSiap' => $jenisAmbilSiap,
            'alamatKirimSiap' => $alamatKirimSiap,
            'noKirimSiap' => $noKirimSiap,
        ];
        $this->load->view('konsultan/ambil_perlengkapan', $data);
    }

    public function proses_ambil()
    {
        $this->form_validation->set_rules('jenis_ambil', 'jenis_ambil', 'required', array(
            "required" => "Silahkan pilih Jenis Pengambilan"
        ));
        $this->form_validation->set_rules('date', 'date', 'required', array(
            "required" => "Silahkan pilih Tanggal"
        ));
        if ($this->form_validation->run() == FALSE) {
            $this->alert->setJamaah('red', "Oops..", validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
            return false;
        }
        $_POST['tanggal'] = $_POST['date'] . " " . date('H:i:s');

        $idMember = $_GET['id'];

        $this->load->model('registrasi');
        $dataJamaah = $this->registrasi->getJamaah(null, null, $idMember);
        $dataMember = $dataJamaah->member[0];
        // echo '<pre>';
        // print_r($dataMember);
        // exit();
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

    public function ambil_kolektif()
    {
        $this->load->model('agen');
        $agenData = $this->agen->getAgen($_SESSION['id_agen']);
        if ($agenData[0]->active != 1) {
            redirect(base_url() . 'konsultan/home/pemb_notice');
        }
        $agen = $this->agen->getJamaahAgen($_SESSION['id_agen'], true);
        $jamaahAgen = $this->agen->getJamaahAgen($_SESSION['id_agen']);
        $data = [
            'agen' => $agen,
            'jamaahAgen' => $jamaahAgen
        ];
        $this->load->view("konsultan/konsultan_perlengkapan_view", $data);
    }

    public function proses_ambil_kolektif()
    {
        if (!isset($_POST['id_member'])) {
            $this->alert->setJamaah('red', 'Error. Silahkan pilih jamaah');
            redirect($_SERVER['HTTP_REFERER']);
        }
        foreach ($_POST['id_member'] as $id_member) {
            $_POST['tanggal'] = $_POST['date'] . " " . date('H:i:s');

            $idMember = $id_member;

            $this->load->model('registrasi');
            $dataJamaah = $this->registrasi->getJamaah(null, null, $idMember);
            $dataMember = $dataJamaah->member[0];
            // echo '<pre>';
            // print_r($dataMember);
            // exit();
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
        }

        if ($status) {
            $this->alert->setJamaah('green', 'Tanggal berhasil dipilih');
        } else {
            $this->alert->setJamaah('red', 'Error. Tanggal gagal dipilih');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function perl_view()
    {
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->view('konsultan/perlengkapan_konsultan_view', $data = ['id_secret' => $_GET['id']]);
    }

    public function lihat_ambil()
    {
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->model('registrasi');
        $jamaah = $this->registrasi->getJamaah(null, null, $id_member);
        $groupMembers = $this->registrasi->getGroupMembers($jamaah->member[0]->parent_id);
        $this->load->model('logistik');
        if (empty($groupMembers)) {
            $groupMembers[$id_member] = new stdClass();
            $groupMembers[$id_member]->jamaahData = (object)$jamaah;
        }
        $sudahAmbil = [];
        foreach ($groupMembers as $idMember => $fam) {
            $sudahAmbil[] = [
                'infoJamaah' => $fam->jamaahData,
                'items' => $this->logistik->getPerlengkapanSudahAmbil($idMember)
            ];
        }
        $data = [
            'data' => $sudahAmbil,
            'id_secret' => $_GET['id']
        ];
        $this->load->view('konsultan/perlengkapan_sudah_ambil_view', $data, FALSE);
    }

    public function download()
    {
        $id_member = $this->secret_key->validate($_GET['id']);
        if (!$id_member) {
            $this->alert->setJamaah('red', 'Oops...', 'Access Denied!');
            redirect(base_url() . 'konsultan/home');
        }
        $this->load->model('logistik');
        $data = $this->logistik->getRiwayatAmbil($id_member);
        $paket = $this->paketUmroh->getPackage($data['members'][0]->id_paket, false, false);
        $data['nama_penerima'] = null;
        $data['staff'] = null;
        foreach ($data['members'] as $key => $d) {
            if (!empty($d->riwayatAmbil['items'])) {
                $data['nama_penerima'] = $d->riwayatAmbil['items'][0]->penerima;
                $data['staff'] = $d->riwayatAmbil['items'][0]->staff;
                break;
            }
        }
        $this->load->library('date');
        $data['dateNow'] = $this->date->convert_date_indo(date('Y-m-d'));
        $strpos = strpos(strtolower($paket->nama_paket), ' ');
        $firstWord = substr($paket->nama_paket, 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = 'asset/login/images/LOGO-VENTOUR.png';
        if (strtolower($firstWord) == "low" || strtolower($firstWord) == "lcu") {
            $data['jenisPaket'] = true;
            $data['logo'] = 'asset/login/images/LOGO-LCU.png';
        }
        // $data['id'] = $_GET['id'];
        $data['html'] = $this->load->view('staff/kuitansi_perl_view', $data, true);
        // echo '<pre>';
        // print_r($data['html']);
        // exit();
        $this->load->view('staff/perlengkapan_view', $data);
    }
}

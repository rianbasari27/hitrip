<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Kuitansi_dl extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function download()
    {

        if (!isset($_SESSION['id_user'])) {
            $this->alert->toastAlert('red', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $this->form_validation->set_data($this->input->get());
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->alert->toastAlert('red', 'Access Denied');
            redirect($_SERVER['HTTP_REFERER']);
        }

        //validate
        // $this->load->library('secret_key');
        // $id_pembayaran = $this->secret_key->validate($_GET['id']);
        // if ($id_pembayaran == false ) {
        //     $this->alert->setJamaah('red', 'Oops..' , 'Access Denied');
        //     redirect(base_url() . 'jamaah/home_user');
        // }

        $this->load->model('auth');
        // $check = $this->auth->checkPembayaran($_SESSION['id_member'], $_GET['id']);
        // if (!$check) {
        //     $this->alert->toastAlert('red', 'Access Denied');
        //     redirect(base_url() . 'jamaah/home');
        // }

        $this->load->model('tarif');
        $data = $this->tarif->getKuitansiData($_GET['id']);
        $strpos = strpos(strtolower($data['nama_paket']), ' ');
        $firstWord= substr($data['nama_paket'], 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = '/asset/appkit/images/hitrip/hitrip-logo.png';
        if (strtolower($firstWord) == "low" || strtolower($firstWord) == "lcu") {
            $data['jenisPaket'] = true;
            $data['logo'] = 'asset/login/images/LOGO-LCU.png';
        }
        $lunas = $data['riwayat']['tarif']['dataMember'][$data['riwayat']['id_member']]['detailJamaah']->member[0]->lunas;
        if ($lunas == 0) {
            $data['logoLunas'] = 'belum_dp_stamp.png';
        } else if ($lunas == 2) {
            $data['logoLunas'] = 'sudah_cicil_stamp.png';
        } else {
            $data['logoLunas'] = 'lunas_stamp.png';
        }
        foreach ($data['riwayat']['tarif']['dataMember'] as $key => $dm) {
        $data['potongan'] = [];
        $data['extraFee'] = [];
            foreach ($dm['extraFee'] as $fee) {
                if (!empty($fee)) {
                    //ambil extrafee
                    if ($fee->nominal > 0 ) {
                        $data['extraFee'][] = $fee;
                    }
                    //ambil potongan
                    if ($fee->nominal < 0 ) {
                        $data['potongan'][] = $fee;
                    }
                }
            }
            $data['riwayat']['tarif']['dataMember'][$key]['potongan'] = $data['potongan'];
            $data['riwayat']['tarif']['dataMember'][$key]['biayaExtra'] = $data['extraFee'];
        }
        $id_paket = $data['riwayat']['tarif']['dataMember'][$data['riwayat']['id_member']]['detailJamaah']->member[0]->id_paket;
        $this->db->where('id_paket', $id_paket);
        $this->db->order_by('id_member', 'asc');
        $query = $this->db->get('program_member');
        $result = $query->result();
        if (empty($result)) {
            return false;
        }
        $daftar = [];
        foreach ($result as $key => $r) {
            foreach ($data['riwayat']['tarif']['dataMember'] as $idMember => $dm) {
                if ($r->id_member == $idMember) {
                    $daftar[] = $key + 1;
                }
            }
        }
        $data['registNumber'] = implode(", ", $daftar);

        //cek infant
        foreach ($data['riwayat']['tarif']['dataMember'] as $key => $d) {
            $this->load->library('calculate');
            $age = $this->calculate->ageDiff($d['detailJamaah']->tanggal_lahir, $d['detailJamaah']->member[0]->paket_info->tanggal_berangkat);
            if ($age !== null) {
                if ($age < 2) {
                    $kategori = 'Infant';
                }
                else if ($age >= 2 && $age <= 6 && $d['detailJamaah']->member[0]->sharing_bed == 1) {
                    $kategori = "Sharing Bed";
                }
                else {
                    $kategori = '';
                }
            } else {
                $kategori = '';
            }
            $data['riwayat']['tarif']['dataMember'][$key]['detailJamaah']->member[0]->kategori = $kategori;
        }
        $data['id'] = $_GET['id'];
        // echo '<pre>';
        // print_r($data);
        // exit();
        // $this->load->view('staff/kuitansi_html_view', $data);
        $data['html'] = $this->load->view('staff/kuitansi_html_view', $data, true);
        $this->load->view('staff/kuitansi_view', $data);
    }

    public function invoiceBelumDp() {
        $this->load->model('tarif');
        $this->load->model('registrasi');

        $id_member = $_GET['id'];
        $member = $this->registrasi->getMember($id_member);
        $member = $member[0];
        $jamaah = $this->registrasi->getJamaah($member->id_jamaah);
        $riwayat = $this->tarif->getRiwayatBayar($member->id_member);

        // get pendaftar
        if ($member->parent_id != null ) {
            $groupArr = $this->registrasi->getGroupMembers($member->parent_id);
        } else {
            $groupArr[$member->id_member] = new stdClass() ;
            $groupArr[$member->id_member]->jamaahData = $jamaah;
            $groupArr[$member->id_member]->memberData = $member;
        }
        $this->db->where('id_paket', $member->id_paket);
        $this->db->order_by('id_member', 'asc');
        $query = $this->db->get('program_member');
        $result = $query->result();
        if (empty($result)) {
            return false;
        }
        $daftar = [];
        foreach ($result as $key => $r) {
            foreach ($groupArr as $idMember => $dm) {
                if ($r->id_member == $idMember) {
                    $daftar[] = $key + 1;
                }
            }
        }
        // end get pendaftar
        
        $tanggal = new DateTime($member->paket_info->tanggal_berangkat);
        $tanggal->modify('-45 days');
        $h_45 = $tanggal->format("j F Y");

        $data = array(
            'nama' => $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name,
            'tanggal_cetak' => $this->date->convert('j F Y', date('Y-m-d')),
            'nama_paket' => $member->paket_info->nama_paket . ' ' . $this->date->convert("j F Y", $member->paket_info->tanggal_berangkat),
            'h_45' => $h_45,
            'agen' => isset($member->agen->nama_agen) ? $member->agen->nama_agen : '',
            'agenTelp' => isset($member->agen->no_wa) ? $member->agen->no_wa : '',
            'riwayat' => $riwayat,
        );

        $strpos = strpos(strtolower($data['nama_paket']), ' ');
        $firstWord= substr($data['nama_paket'], 0, $strpos);
        $data['jenisPaket'] = false;
        $data['logo'] = 'asset/login/images/LOGO-VENTOUR.png';
        if (strtolower($firstWord) == "low" || strtolower($firstWord) == "lcu") {
            $data['jenisPaket'] = true;
            $data['logo'] = 'asset/login/images/LOGO-LCU.png';
        }
        $lunas = $member->lunas;
        if ($lunas == 0) {
            $data['logoLunas'] = 'belum_dp_stamp.png';
        } else if ($lunas == 2) {
            $data['logoLunas'] = 'sudah_cicil_stamp.png';
        } else {
            $data['logoLunas'] = 'lunas_stamp.png';
        }

        $dp = $this->tarif->calcTariff($member->id_member);
        $data['totalDp'] = $dp['dp_display'];
        // $result = $this->tarif->calcTariff($_GET['idm']);
        $data['id'] = $_GET['id'];
        $data['registNumber'] = implode(", ", $daftar);
        $data['html'] = $this->load->view('staff/kuitansi_html_view', $data, true);
        $this->load->view('staff/kuitansi_view', $data);
    }
}